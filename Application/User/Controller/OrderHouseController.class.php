<?php

namespace User\Controller;

use Common\Logic\Alisms;
use Think\Cache\Driver\Redis;
use \Redis as OriginRedis;

/**
 * 首页
 *
 * @create 2016-8-22
 * @author zlw
 */
class OrderHouseController extends BaseController {

    private $_eventId = 0;

    /**
     * 构造方法
     *
     * @create 2016-11-16
     * @author zlw
     */
    public function _initialize() {
        parent::_initialize();
        
        $privilege = session("privilege");

        if(empty($privilege))//未登录
        {
            $info = I('info', 0, 'trim');
            if(in_array(ACTION_NAME, array('privilege', 'send_sms_code', 'check')))//当前页面为登录页面
            {
                if(!empty($info) && !in_array(ACTION_NAME, array('send_sms_code', 'check')))
                {
                    $einfo = geturl($info, getUrlkey());
                    $eventId = $einfo['eventId'];
                    if (!empty($eventId) && $eventId > 0) {
                        cookie('eventId', encrypt_url("eventId/" . $eventId, getUrlkey()),60 * 60*6);
                    }

                }
            }
            else
            {
                if(!empty($info))
                {
                    $einfo = geturl($info, getUrlkey());
                    $eventId = $einfo['eventId'];
                    if (!empty($eventId) && $eventId > 0) {
                        cookie('eventId', encrypt_url("eventId/" . $eventId, getUrlkey()),60 * 60*6);
                    }
                }
                $this->logout();
            }
        }
        else//已登录
        {
            $info = I('info', 0, 'trim');
            //校验活动状态和用户状态是否正常
            $redisDriver = new Redis();
            if(empty(cookie('eventId')))
            {
                $einfo = geturl($info, getUrlkey());
                $eventId = $einfo['eventId'];
                if($eventId && in_array(ACTION_NAME, array('privilege', 'send_sms_code', 'check')))//当前页面为登录页面
                {
                     cookie('eventId', encrypt_url("eventId/" . $eventId, getUrlkey()),60 * 60*6);
                }
            }
            $eid = geturl(cookie('eventId'), getUrlkey())["eventId"];
            
            $cphone = rsa_decode(cookie('phone'),getChoosekey());//解密
            if ($eid && $cphone) {
                $event = $redisDriver->hGetAll("event_order_house_{$eid}");
                if ($event) {
                    if ($event['states'] == 0) {
                        $this->logout();
                    }
                    $chooselog = $redisDriver->hGetAll("dlsx_order_house_{$eid}_{$cphone}");
                    if (!$chooselog || !$chooselog['sid']) {//登录已失效
                        $this->logout();
                    } else {
                        if (session_id() <> $chooselog['sid']) {//同一手机号只能一台手机登录
                            $this->logout();
                        }
                    }
                    if(!$chooselog||$chooselog['status']==0){//用户已禁用
                        $this->logout();
                    }
                }
            }
            
            if(!empty($info) && !empty(cookie('eventId')))//判断用户打开的活动页面是否有效
            {
                $einfo = geturl($info, getUrlkey());
                $einfo1 = geturl(cookie('eventId'), getUrlkey());
                if($einfo['eventId']<>$einfo1['eventId'])
                {
                    cookie('eventId', encrypt_url("eventId/" . $einfo['eventId'], getUrlkey()),60 * 60*6);
                    $this->logout();
                }
            }
            
            if(in_array(ACTION_NAME, array('privilege', 'send_sms_code', 'check')))//当前页面为登录页面
            {
                $this->redirect('index', [info => cookie('eventId')]);
            }
         }

        $einfo = geturl(cookie('eventId'), getUrlkey());
        $this->_eventId =$einfo["eventId"];
    }

    public function getEventId() {
        return $this->_eventId;
    }

    /**
     * 微信认购
     *
     * @create 2017-04-25
     * @author jxw
     */
    public function index() {
        
        $id=$this->getEventId();
        if(empty($id))
        {
            $this->logout();
        }
        $eventOrderHouseModel = D('Common/EventOrderHouse');
        $event = $eventOrderHouseModel->getEventByEventId($id);

        //所有栋
        $buildings = array();
        //冗余 搜索使用
        $rdd_building = array();
        foreach ($event['building_hash'] as $building) {
            $building[] = explode('_', $building[0])[5];
            $buildings[] = $building;
            $rdd_building[$building[0]] = $building[1];
        }
        //所有单元
        $units = array();
        foreach ($buildings as $building) {
            $tempUnits = $eventOrderHouseModel->getUnitsBelongToBuildingByRedisId($building[0]);

            $units[] = $tempUnits;
        }

        //所有房间
        $rooms = $eventOrderHouseModel->getRoomsBelongToUnitByRedisId($units[0][0][0]);
        
        //所有户型
        $hxs = $event['allhx'];
        /* $hxs = [$rooms[0]['hx']];
          for ($i=0;$i<count($rooms);$i++){
          if ( !in_array($rooms[$i]['hx'],$hxs) ){
          $hxs[] = $rooms[$i]['hx'];
          }
          } */

        //项目
        $project = D("Common/Project")->getProjectById($rooms[0]["project_id"]);

        //用户收藏
        $this->get_customer_id();
        $where = array('cst_id' => session("chooseuid"), 'proj_id' => $event['project_id'], 'eventId' => $id, '88=88');
        $roomCollectionModel = D('Common/Collection');
        $roomCollected = $roomCollectionModel->getList($where);

        //整理用户收藏
        foreach ($roomCollected as $key => $item) {
            $room = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$id}_room_{$item['room_id']}");
            if (empty($room)) {
                unset($roomCollected[$key]);
            } else {
                $roomCollected[$key] = $room;
                $roomCollected[$key]['building_name'] = $rdd_building["event_order_house_{$id}_build_{$room['build_id']}"];
            }
        }

        //用户已预定的房间
        $orderHouseOrderModel = D('OrderHouseOrder');

        $orderedRoom = $orderHouseOrderModel->find(array(
            'where' => array('event_id' => $id, 'belong_phone' => rsa_decode(session('phone'),  getChoosekey()))
        ));
        //收藏排名
        $collectionSort = $eventOrderHouseModel->getRoomCollectionSort($id);

        //所有被预购的房间
        $orderedRooms = $eventOrderHouseModel->getAllOrderedRoomInRedis($id);

        $dqhm = $this->getMillisecond();
        $time = 0;
        if ($dqhm < $event['start_time'] * 1000) {//活动未开始时，返回活动开始倒计时time和整个活动时长time1
            $time = $event['start_time'] * 1000 - $dqhm;
            $time1 = $event['end_time'] * 1000 - $event['start_time'] * 1000;
            $this->assign('iswks', 1);
            $this->assign('time1', $time1);
        } else {//活动已开始，返回的time和time1一样
            $time = $event['end_time'] * 1000 - $dqhm;
            if ($dqhm > $event['end_time'] * 1000) {
                $this->assign('iswks', -1); //活动已结束
                $time = 0;
            } else {
                $this->assign('iswks', 0);
            }
            $this->assign('time1', $time);
        }
        //活动倒计时
        $this->assign('time', $time);

        //活动ID
        $this->assign('eventId', cookie("eventId"));
        //$this->assign('jmevent', cookie("eventid"));

        //所有栋
        $this->assign('buildings', $buildings);
        //所有单元
        $this->assign('units', $units);

        //默认为 budings[0] unit[0] 下属单元 默认加载
        $this->assign('rooms', json_encode($rooms ? $rooms : array()));

        //用户收藏的房间
        $this->assign('roomCollected', json_encode($roomCollected));

        //用户已经预定的房间
        $this->assign('orderedRoom', json_encode($orderedRoom ? $orderedRoom : array()));
        //$this->assign('orderedRoom',$orderedRoom);
        //所有已被预定的房间
        $this->assign('orderedRooms', json_encode($orderedRooms ? $orderedRooms : array()));

        //用户收藏房间排序
        $this->assign('collectionSort', json_encode($collectionSort ? $collectionSort : array()));

        //所有户型
        $this->assign('hxs', $hxs);
        $this->set_seo_title($project["name"]);
        $this->display();
    }

    //我的订单列表
    public function myorder() {
        $id=$this->getEventId();
        if(empty($id))
        {
            $this->logout();
        }

        //$id = I('id', 0, 'trim');
        $eventOrderHouseModel = D('Common/EventOrderHouse');
        $event = $eventOrderHouseModel->getEventByEventId($id);

        //用户信息
        $chooseModel = M('choose');

        $cuserinfo = $chooseModel->find(array(
            'where' => array('id' => session("chooseuid"), 'customer_phone' => session('phone'))
        ));
        $cuserinfo['customer_phone']=rsa_decode(session('phone'),getChoosekey());
        $cuserinfo['cardno']=rsa_decode($cuserinfo['cardno'],getChoosekey());
        $this->assign('userinfo', $cuserinfo);

        //用户收藏
        $this->get_customer_id();
        $where = array('cst_id' => session("chooseuid"), 'proj_id' => $event['project_id'], 'eventId' => $id, '88=88');
        $roomCollectionModel = D('Common/Collection');
        $roomCollected = $roomCollectionModel->getList($where);

        //整理用户收藏
        foreach ($roomCollected as $key => $item) {
            $room = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$id}_room_{$item['room_id']}");
            if (empty($room)) {
                unset($roomCollected[$key]);
            } else {
                $roomCollected[$key] = $room;
                $roomCollected[$key]['building_name'] = $rdd_building["event_order_house_{$id}_build_{$room['build_id']}"];
            }
        }
        //活动ID
        $this->assign('eventId', cookie("eventId"));
        //$this->assign('eventId', $id);
        
        //用户收藏的房间
        $this->assign('roomCollected', json_encode($roomCollected));

        //用户已预定的房间
        $orderHouseOrderModel = D('OrderHouseOrder');
        $orderedRooms = $orderHouseOrderModel->select(array(
            'where' => array('event_id' => $id, 'belong_phone' => rsa_decode(session('phone'),getChoosekey()))
        ));
        if (!$orderedRooms) {
            $orderedRooms = array();
        }
        $redis = new \Redis();
        $redis->connect(C('REDIS_HOST'));
        if (count($orderedRooms) > 0) {
            foreach ($orderedRooms as $key => $orderedRoom) {
                $room = $redis->hGetAll("event_order_house_{$id}_room_{$orderedRoom['room_id']}");
                if ($room) {
                    $orderedRooms[$key]['total'] = $room['total'];
                }
            }
        }
        $this->assign('orderedRooms', $orderedRooms);

        $this->set_seo_title("我的订单");
        $this->display();
    }

    public function ordershow() {
        //$code=encrypt_url("eventId/2/oid/16",getUrlkey());
        //print_r($code);

        $info = I('info', 0, 'trim');
        $einfo = geturl($info, getUrlkey());
        $id = $einfo['eventId'];
        $oid = $einfo['oid'];


        $eventOrderHouseModel = D('Common/EventOrderHouse');
        $event = $eventOrderHouseModel->getEventByEventId($id);
        if (!$event['project_id']) {
            $event = $eventOrderHouseModel->getOneById($id);
        }

        //用户信息
        $chooseModel = M('choose');

        $cuserinfo = $chooseModel->find(array(
            'where' => array('id' => session("chooseuid"), 'customer_phone' => session('phone'))
        ));
        $cuserinfo['customer_phone']=rsa_decode(session('phone'),getChoosekey());
        $cuserinfo['cardno']=rsa_decode($cuserinfo['cardno'],getChoosekey());
        $this->assign('userinfo', $cuserinfo);

        //用户收藏
        $this->get_customer_id();
        $where = array('cst_id' => session("chooseuid"), 'proj_id' => $event['project_id'], 'eventId' => $id, '88=88');
        $roomCollectionModel = D('Common/Collection');
        $roomCollected = $roomCollectionModel->getList($where);

        //整理用户收藏
        foreach ($roomCollected as $key => $item) {
            $room = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$id}_room_{$item['room_id']}");
            if (empty($room)) {
                unset($roomCollected[$key]);
            } else {
                $roomCollected[$key] = $room;
                $roomCollected[$key]['building_name'] = $rdd_building["event_order_house_{$id}_build_{$room['build_id']}"];
            }
        }

        //用户已预定的房间
        $orderHouseOrderModel = D('OrderHouseOrder');

        $orderedRoom = $orderHouseOrderModel->find(array(
            'where' => array('event_id' => $id, 'id' => $oid)
        ));
        if (!$orderedRoom) {
            $orderedRoom = array();
        }
        //活动ID
        $this->assign('eventId', cookie("eventId"));
        $this->assign('event', $event);

        //用户收藏的房间
        $this->assign('roomCollected', json_encode($roomCollected));

        //用户已经预定的房间
        $this->assign('orderedRoom', $orderedRoom);

        $redis = new \Redis();
        $redis->connect(C('REDIS_HOST'));
        //房间详情
        $room = $redis->hGetAll("event_order_house_{$id}_room_{$orderedRoom['room_id']}");
        if (!($room) && $orderedRoom['room_id'] > 0) {
            $room = M(roomlist)->where("id=" . $orderedRoom['room_id'])->find();
            $room['project_name'] = $room['projname'];
            $room['project_id'] = $room['proj_id'];
            $room['batch_id'] = $room['pc_id'];
        }
        $this->assign('room', $room);

        //项目信息
        if ($room) {
            $projinfo = M(project)->where("id=" . $room['project_id'])->find();
            $this->assign('projinfo', $projinfo);
        }
        //户型信息
        $hxwhere = [
            'fields' => '*'
            , 'where' => [
                'project_id' => $room['project_id']
                , 'batch_id' => $room['batch_id']
                , 'hx' => $room['hx']
                , '2=2'
            ]
        ];

        $hxinfo = D('hxset')->find($hxwhere);
        $this->assign('hxinfo', $hxinfo);

        $this->set_seo_title("订单详情");
        $this->display();
    }

    //备选房源(收藏列表)
    public function collectedroom() {
        //$info = I('info', 0, 'trim');
        //$einfo = geturl($info, getUrlkey());
        //$id = $einfo['id'];
        
        $id=$this->getEventId();
        if(empty($id))
        {
            $this->logout();
        }

        $eventOrderHouseModel = D('Common/EventOrderHouse');
        $event = $eventOrderHouseModel->getEventByEventId($id);

        //所有栋
        $buildings = array();
        //冗余 搜索使用
        $rdd_building = array();
        foreach ($event['building_hash'] as $building) {
            $building[] = explode('_', $building[0])[5];
            $buildings[] = $building;
            $rdd_building[$building[0]] = $building[1];
        }
        //所有单元
        $units = array();
        foreach ($buildings as $building) {
            $tempUnits = $eventOrderHouseModel->getUnitsBelongToBuildingByRedisId($building[0]);

            $units[] = $tempUnits;
        }

        //用户信息
        $chooseModel = M('choose');

        $cuserinfo = $chooseModel->find(array(
            'where' => array('id' => session("chooseuid"), 'customer_phone' => session('phone'))
        ));
        $cuserinfo['customer_phone']=rsa_decode(session('phone'),getChoosekey());
        $cuserinfo['cardno']=rsa_decode($cuserinfo['cardno'],getChoosekey());
        $this->assign('userinfo', $cuserinfo);

        $cphone = rsa_decode(session('phone'),getChoosekey());
        
        //用户已认购的房间
        $orderHouseOrderModel = D('OrderHouseOrder');
        $orderedRoom = $orderHouseOrderModel->select(array(
            'where' => array('event_id' => $id, 'belong_phone' => $cphone)
        ));
        //项目信息
        if ($event['project_id']) {
            $projinfo = M(project)->where("id=" . $event['project_id'])->find();
            $this->assign('projinfo', $projinfo);
        }
        //用户收藏
        $this->get_customer_id();
        $where = array('cst_id' => session("chooseuid"), 'proj_id' => $event['project_id'], 'eventId' => $id, '88=88');
        $roomCollectionModel = D('Common/Collection');
        $orderby = "px asc";
        $roomCollected = $roomCollectionModel->getList($where, $orderby);

        //整理用户收藏
        foreach ($roomCollected as $key => $item) {
            $room = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$id}_room_{$item['room_id']}");
            if (empty($room)) {
                unset($roomCollected[$key]);
            } else {
                
                $roomCollected[$key] = $room;
                $roomCollected[$key]['px']=$item['px'];
                $roomCollected[$key]['cid']=$item['id'];
                $roomCollected[$key]['building_name'] = $rdd_building["event_order_house_{$id}_build_{$room['build_id']}"];
                //$roomCollected[$key]['building_name']  = $item['buildname'];
                $roomCollected[$key]['orderid'] = 0;
                $roomCollected[$key]['qycode'] = '';
                if (count($orderedRoom) > 0) {
                    foreach ($orderedRoom as $ordered1) {
                        if ($item['room_id'] === $ordered1['room_id']) {
                            $roomCollected[$key]['qycode'] = $ordered1['code'];
                            $roomCollected[$key]['orderid'] = $ordered1['id'];
                            $roomCollected[$key]['oinfo'] = encrypt_url("eventId/{$id}/oid/{$ordered1['id']}", getUrlkey());
                            break;
                        }
                    }
                }
                //房间有对应的手机预留且缓存中存在此手机号已认购，但是数据库中的认购表中为空
                //则表示其他人抢购过此房间，需要修复状态，保证预留人可以选房
                if ($cphone == $room['schedule_phone'] && $roomCollected[$key]['orderid'] == 0) {
                    $roomCollected[$key]['status'] = 0;
                    $roomCollected[$key]['isyx'] = 1;
                }
            }
        }

        //所有被认购的房间
        $orderedRooms = $eventOrderHouseModel->getAllOrderedRoomInRedis($id);

        $dqhm = $this->getMillisecond();
        $time = 0;
        if ($dqhm < $event['start_time'] * 1000) {//活动未开始时，返回活动开始倒计时time和整个活动时长time1
            $time = $event['start_time'] * 1000 - $dqhm;
            $time1 = $event['end_time'] * 1000 - $event['start_time'] * 1000;
            $this->assign('iswks', 1);
            $this->assign('time1', $time1);
        } else {//活动已开始，返回的time和time1一样
            $time = $event['end_time'] * 1000 - $dqhm;
            if ($dqhm > $event['end_time'] * 1000) {
                $this->assign('iswks', -1); //活动已结束
                $time = 0;
            } else {
                $this->assign('iswks', 0);
            }
            $this->assign('time1', $time);
        }
        //活动倒计时
        $this->assign('time', $time);

        //活动ID
        //$this->assign('eventId', $id);
        $this->assign('eventId', cookie("eventId"));
        
        $this->assign('desc', $event['desc']);
        
        $this->assign('event', $event);

        //用户收藏的房间
        $this->assign('roomCollected', json_encode(array_values($roomCollected)));

        //用户已经预定的房间
        $this->assign('orderedRoom', json_encode($orderedRoom ? $orderedRoom : array()));

        //所有已被预定的房间
        $this->assign('orderedRooms', json_encode($orderedRooms ? $orderedRooms : array()));
        $this->set_seo_title("备选房源");
        $this->display();
    }

    /**
     * 房间列表
     *
     * @create 2016-9-6
     * @author zlw
     */
    public function room() {
        if (!IS_AJAX)
            $this->error('请求错误，请确认后重试！');

        $condition = I('post.condition');

        //获取该单元所有房间
        $eventOrderHouseModel = D('Common/EventOrderHouse');
        $einfo = geturl($condition['event_id'], getUrlkey());
        $eventId=$einfo["eventId"];
        
        $unitKey = "event_order_house_{$eventId}_build_{$condition['build_id']}_unit_{$condition['unit_id']}";
        $rooms = $eventOrderHouseModel->getRoomsBelongToUnitByRedisId($unitKey);
        $roomsCount = count($rooms);
        for ($i = 0; $i < $roomsCount; $i++) {

            if ($condition['level'][0] > $rooms[$i]['floor']) {
                unset($rooms[$i]);
            }

            if (!empty($condition['level'][1]) && $condition['level'][1] < $rooms[$i]['floor']) {
                unset($rooms[$i]);
            }

            if ($condition['area'][0] > $rooms[$i]['area']) {
                unset($rooms[$i]);
            }

            if (!empty($condition['area'][1]) && $condition['area'][1] < $rooms[$i]['area']) {
                unset($rooms[$i]);
            }

            if ($condition['total'][0] * 10000 > $rooms[$i]['total']) {
                unset($rooms[$i]);
            }

            if (!empty($condition['total'][1]) && $condition['total'][1] * 10000 < $rooms[$i]['total']) {
                unset($rooms[$i]);
            }

            if ($condition['room'][0] > $rooms[$i]['room']) {
                unset($rooms[$i]);
            }

            if (!empty($condition['room'][1]) && $condition['room'][1] < $rooms[$i]['room']) {
                unset($rooms[$i]);
            }

            if (!empty($condition['hx'])) {
                if (!in_array($rooms[$i]['hx'], $condition['hx']))
                    unset($rooms[$i]);
            }

            if ($rooms[$i]['status'] == 1 && $condition['ds'] == 1)
                unset($rooms[$i]);
        }

        //$this->show(json_encode( array_values($rooms) ));
        $this->success(['成功', array_values($rooms)]);
    }

    /**
     * 微信认购
     *
     * @create 2017-04-26
     * @author jxw
     */
    public function order() {
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试!');
        }
        //$eventId = I('eventId', 0, 'intval');
        $eventId=$this->getEventId();
        if (empty($eventId)) {
            $this->error('活动信息错误，请确认后重试!');
        }

        $redis = new OriginRedis();
        $redis->connect(C('REDIS_HOST'));

        $event = $redis->hGetAll("event_order_house_{$eventId}");

        if (empty($event))
            $this->error('无活动');

        if (time() < $event['start_time'])
            $this->error('活动未开始');

        if (time() > $event['end_time'])
            $this->error('活动已结束');

        $phone = rsa_decode(session('phone'),getChoosekey());

        if (empty($phone))
            $this->error('手机号码不正确');

        $eventOrderHouseModel = D('Common/EventOrderHouse');

        //查看活动是否存在
        $event = $eventOrderHouseModel->getEventByEventId($eventId);

        $expire_time = $event['end_time'] - time();

        if (empty($event)) {
            $this->error('活动没有开始');
        }

        //获取房间ID
        $ids = I('room_id', 0, 'intval');

        $orderHouseOrderModel = D('OrderHouseOrder');
        //用户预购房间
        //$userygroom;
        $evrnt_isyks = $redis->get($event['isyks']);
        //优先处理预购房间
        if ($evrnt_isyks == 0) {
            $ygrooms = $redis->hGetAll("event_order_house_{$eventId}_room_order_member");

            if (count($ygrooms) > 0) {
                foreach ($ygrooms as $ygroom) {
                    //$oldroom=$redis->hGetAll("event_order_house_{$eventId}_room_{$ygroom}");

                    $redis->hSet("event_order_house_{$eventId}_room_{$ygroom}", 'status', 1);
                    $redis->set("event_order_house_{$eventId}_room_{$ygroom}_locked", 1, $expire_time);
                    $redis->sAdd("event_order_house_{$eventId}_room_ordered", $ygroom);
                    //$redis->sAdd("event_order_house_{$eventId}_room_order_phone",$oldroom['schedule_phone']);
                }
            }
            $redis->hSet("event_order_house_{$eventId}", 'isyks', 1);
        }
        if ($event['isdx'] == 0) {//同一账号不允许购买多套 
            $id = $ids;
            if (empty($id) || $id == 0) {
                $this->error('房间ID不能为空，请确认后重试!');
            }
            //获取房间信息
            $room = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$eventId}_room_{$id}");
            if (empty($room)) {
                $this->error('该房间没有参加活动!');
            }
            //房间是否已出售
            $isRoomOrdered = $redis->sIsMember("event_order_house_{$eventId}_room_ordered", $id);
            if ($isRoomOrdered) {
                if (empty($room['schedule_phone'])) {
                    $this->error('房间已被认购!');
                } else {
                    if ($room['schedule_phone'] != $phone)
                        $this->error('房间已被认购!');
                }
            }
            //用户只能购买一套  
            $isMemberOrdered = $redis->sIsMember("event_order_house_{$eventId}_room_order_phone", $phone);
            if ($isMemberOrdered) {
                $this->error('每人最多购买一套!');
            }
            $ygrooms = $redis->hGetAll("event_order_house_{$eventId}_room_order_member");
            if (count($ygrooms) > 0) {
                foreach ($ygrooms as $ygroom) {
                    $oldroom = $redis->hGetAll("event_order_house_{$eventId}_room_{$ygroom}");
                    if ($oldroom['schedule_phone'] == $phone) {
                        if ($room['id'] != $oldroom['id']) {
                            $roomname = $oldroom['buildname'] . "-" . $oldroom['unit'] . "单元-" . $oldroom['floor'] . "层-" . $oldroom['room'];
                            //$this->error('请选择预定房源：'.$roomname);
                            $this->error('抢购失败，请选择其他房源！');
                        }
                    }
                }
            }

            /*
              $orderedCount = $orderHouseOrderModel->find(array(
              'where'=>array('event_id'=>$eventId,'belong_phone'=>session('phone'))
              ,'field'=>array('count(1) as count,room_id')
              ));
              if ($orderedCount['count']){
              //修复
              $redis->hSet("event_order_house_{$eventId}_room_{$orderedCount['room_id']}",'status',1);
              $redis->sAdd("event_order_house_{$eventId}_room_ordered",$orderedCount['room_id']);
              $redis->sAdd("event_order_house_{$eventId}_room_order_phone",session('phone'));
              $redis->set("event_order_house_{$eventId}_room_{$orderedCount['room_id']}_locked",1,$expire_time);

              $this->error('每人最多认购一套!');
              }
             */

            //如果status 1 返回错误 设置set锁
            if ($room['status'] === 1) {
                if (empty($room['schedule_phone'])) {
                    $redis->set("event_order_house_{$eventId}_room_{$id}_locked", 1, $expire_time);
                    $this->error('房间已被认购!');
                } else {
                    if ($room['schedule_phone'] != $phone) {
                        $redis->set("event_order_house_{$eventId}_room_{$id}_locked", 1, $expire_time);
                        $this->error('房间已被认购!');
                    }
                }
            }

            $getLock = 0;
            //如果status 0 就行修改
            if (empty($room['status'])) {
                $getLock = $redis->setnx("event_order_house_{$eventId}_room_{$id}_locked", 1);
            } else {
                if (!empty($room['schedule_phone']) && $room['schedule_phone'] == $phone)
                {
                     $redis->setnx("event_order_house_{$eventId}_room_{$id}_locked", 1);
                     $getLock=1;
                }
            }

            //setnx 进行锁定 10s 没有 获得锁 返回错误
            if ($getLock) {
                $redis->expire("event_order_house_{$eventId}_room_{$id}_locked", 10);
            } else {
                $this->error('请稍后重试22！');
            }

            $maxcode = $redis->get("event_order_house_{$eventId}_maxcode") + 1;
            if ($maxcode < 1000)
                $newmaxcode = '0' . $maxcode;
            if ($maxcode < 100)
                $newmaxcode = '00' . $maxcode;
            if ($maxcode < 10)
                $newmaxcode = '000' . $maxcode;

            $order_id = time() + rand(1000, 9999);
            if ($eventId < 10)
                $hdcode = substr('0' . $eventId, -2);
            else
                $hdcode = substr($eventId, -2);

            $obj = null;
            //写入mysql try catch
            if ($getLock) {
                $obj = array(
                    'event_id' => $eventId
                    , 'event_name' => $event['name']
                    , 'company_id' => $room['company_id']
                    , 'project_id' => $room['project_id']
                    , 'project_name' => $room['project_name']
                    , 'batch_id' => $room['batch_id']
                    , 'batch_name' => $room['batch_name']
                    , 'build_id' => $room['build_id']
                    , 'build_name' => $room['buildname']
                    , 'unit_no' => $room['unit']
                    , 'floor_no' => $room['floor']
                    , 'room_id' => $id
                    , 'room_no' => $room['no']
                    , 'room_room' => $room['room']
                    , 'belong_openid' => $this->get_wx_open_id()
                    , 'belong_real_name' => session("realName")
                    //,'belong_gender'=> $user_info['sex']
                    , 'belong_phone' => $phone
                    , 'belong_uid' => session("chooseuid")
                    //,'code'=> sprintf('%02s',$room['build_id']).sprintf('%02s',$room['unit']).sprintf('%02s',$room['floor']).$room['no'].sprintf('%06s',rand(0,999999))
                    //,'code'=> date("mdh",time()).$eventId.$id
                    , 'code' => $newmaxcode
                    , 'log_time' => time()
                    , 'is_checked' => 0
                    , 'order_id' => date('Ymd') . $hdcode . $order_id
                );
                $orderHouseOrderModel = D('OrderHouseOrder');
                try {
                    $redis->set("event_order_house_{$eventId}_room_{$id}_locked", 1, $expire_time);
                    $redis->hSet("event_order_house_{$eventId}_room_{$id}", 'status', 1);
                    //添加已认购的房间
                    $redis->sAdd("event_order_house_{$eventId}_room_ordered", $id);
                    //添加已经购买的人员
                    $redis->sAdd("event_order_house_{$eventId}_room_order_phone", $phone);
                    $redis->set("event_order_house_{$eventId}_maxcode", $maxcode);
                    $redis->hSet("dlsx_order_house_{$eventId}_{$cphone}", 'yrgcount', $yrgcount + 1);
                    $orderHouseOrderModel->startTrans();
                    $oid = $orderHouseOrderModel->add($obj);
                    $roomd = D('Room');
                    $datar["is_xf"] = 1;
                    $datar["cstid"] = session("chooseuid");
                    $datar["xftime"] = time();
                    $datar["cstname"] = $obj['belong_real_name'];
                    $roomd->where('id=' . $id)->save($datar);
                    $orderHouseOrderModel->commit();
                } catch (\Exception $e) {
                    $redis->del("event_order_house_{$eventId}_room_{$id}_locked");
                    $redis->hSet("event_order_house_{$eventId}_room_{$id}", 'status', 0);
                    $redis->sRem("event_order_house_{$eventId}_room_ordered", $id);
                    $redis->sRem("event_order_house_{$eventId}_room_order_phone", $phone);
                    $redis->hSet("dlsx_order_house_{$eventId}_{$cphone}", 'yrgcount', $yrgcount);
                    $orderHouseOrderModel->rollback();
                    $this->error('请稍后重试！');
                }
            }

            $orderedRooms = $eventOrderHouseModel->getAllOrderedRoomInRedis($eventId);
            $orderedRooms = empty($orderedRooms) ? [] : $orderedRooms;
            $this->success(['预购成功', $obj['code'], $orderedRooms,   encrypt_url("eventId/{$eventId}/oid/{$oid}", getUrlkey())]);
            
        } else {//允许购买多套
            if (empty($ids) || $ids == 0) {
                $this->error('房间ID不能为空，请确认后重试!');
            }
            $rids = explode(',', $ids);
            $allcount = count($rids);
            //客户购买套数控制  
            $cphone = session('phone');
            $yrgcount = 0;
            $chooselog = $redis->hGetAll("dlsx_order_house_{$eventId}_{$cphone}");
            if ($chooselog) {
                $yrgcount = $chooselog['yrgcount'];
                if ($chooselog['maxcount'] < $chooselog['yrgcount'] + $allcount) {
                    $this->error('你只能购买' . $chooselog['maxcount'] . '套!');
                }
            }
            foreach ($rids as $k => $id) {
                //获取房间信息
                $room = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$eventId}_room_{$id}");
                if (empty($room)) {
                    unset($rids[$k]);
                    continue;
                }
                //房间是否已出售
                $isRoomOrdered = $redis->sIsMember("event_order_house_{$eventId}_room_ordered", $id);
                if ($isRoomOrdered) {
                    if (empty($room['schedule_phone'])) {
                        unset($rids[$k]);
                        continue;
                    } else {
                        if ($room['schedule_phone'] != session('phone')) {
                            unset($rids[$k]);
                            continue;
                        }
                    }
                }
                //如果status 1 返回错误 设置set锁
                if ($room['status'] === 1) {
                    if (empty($room['schedule_phone'])) {
                        $redis->set("event_order_house_{$eventId}_room_{$id}_locked", 1, $expire_time);
                        unset($rids[$k]);
                        continue;
                    } else {
                        if ($room['schedule_phone'] != session('phone')) {
                            $redis->set("event_order_house_{$eventId}_room_{$id}_locked", 1, $expire_time);
                            unset($rids[$k]);
                            continue;
                        }
                    }
                }
                $getLock = 0;
                //如果status 0 就行修改
                if (empty($room['status'])) {
                    $getLock = $redis->setnx("event_order_house_{$eventId}_room_{$id}_locked", 1);
                } else {
                    if (!empty($room['schedule_phone']) && $room['schedule_phone'] == session('phone'))
                        $getLock = $redis->setnx("event_order_house_{$eventId}_room_{$id}_locked", 1);
                }
                //setnx 进行锁定 10s 没有 获得锁 返回错误
                if ($getLock) {
                    $redis->expire("event_order_house_{$eventId}_room_{$id}_locked", 10);
                } else {
                    $this->error('请稍后重试！');
                }
                $maxcode = $redis->get("event_order_house_{$eventId}_maxcode") + 1;
                if ($maxcode < 1000)
                    $newmaxcode = '0' . $maxcode;
                if ($maxcode < 100)
                    $newmaxcode = '00' . $maxcode;
                if ($maxcode < 10)
                    $newmaxcode = '000' . $maxcode;
                $order_id = time() + rand(1000, 9999);
                if ($eventId < 10)
                    $hdcode = substr('0' . $eventId, -2);
                else
                    $hdcode = substr($eventId, -2);
                $obj = null;
                //写入mysql try catch
                if ($getLock) {
                    $obj = array(
                        'event_id' => $eventId
                        , 'event_name' => $event['name']
                        , 'company_id' => $room['company_id']
                        , 'project_id' => $room['project_id']
                        , 'project_name' => $room['project_name']
                        , 'batch_id' => $room['batch_id']
                        , 'batch_name' => $room['batch_name']
                        , 'build_id' => $room['build_id']
                        , 'build_name' => $room['buildname']
                        , 'unit_no' => $room['unit']
                        , 'floor_no' => $room['floor']
                        , 'room_id' => $id
                        , 'room_no' => $room['no']
                        , 'room_room' => $room['room']
                        , 'belong_openid' => $this->get_wx_open_id()
                        , 'belong_real_name' => session("realName")
                        , 'belong_phone' => session("phone")
                        , 'belong_uid' => session("chooseuid")
                        , 'code' => $newmaxcode
                        , 'log_time' => time()
                        , 'is_checked' => 0
                        , 'order_id' => date('Ymd') . $hdcode . $order_id
                    );
                    $orderHouseOrderModel = D('OrderHouseOrder');
                    try {
                        $redis->set("event_order_house_{$eventId}_room_{$id}_locked", 1, $expire_time);
                        $redis->hSet("event_order_house_{$eventId}_room_{$id}", 'status', 1);
                        //添加已认购的房间
                        $redis->sAdd("event_order_house_{$eventId}_room_ordered", $id);
                        //添加已经购买的人员
                        $redis->sAdd("event_order_house_{$eventId}_room_order_phone", session('phone'));
                        $redis->set("event_order_house_{$eventId}_maxcode", $maxcode);
                        $redis->hSet("dlsx_order_house_{$eventId}_{$cphone}", 'yrgcount', $yrgcount + 1);
                        $orderHouseOrderModel->startTrans();
                        $oid = $orderHouseOrderModel->add($obj);
                        $roomd = D('Room');
                        $datar["is_xf"] = 1;
                        $datar["cstid"] = session("chooseuid");
                        $datar["xftime"] = time();
                        $datar["cstname"] = $obj['belong_real_name'];
                        $roomd->where('id=' . $id)->save($datar);
                        $orderHouseOrderModel->commit();
                    } catch (\Exception $e) {
                        $redis->del("event_order_house_{$eventId}_room_{$id}_locked");
                        $redis->hSet("event_order_house_{$eventId}_room_{$id}", 'status', 0);
                        $redis->sRem("event_order_house_{$eventId}_room_ordered", $id);
                        $redis->sRem("event_order_house_{$eventId}_room_order_phone", session('phone'));
                        $redis->hSet("dlsx_order_house_{$eventId}_{$cphone}", 'yrgcount', $yrgcount);
                        $orderHouseOrderModel->rollback();
                        $this->error('请稍后重试！');
                    }
                }
            }
            //重置数组索引
            $rids = array_values($rids);
            if ($rids && count($rids)) {
                $orderedRooms = $eventOrderHouseModel->getAllOrderedRoomInRedis($eventId);
                $orderedRooms = empty($orderedRooms) ? [] : $orderedRooms;
                $this->success(['选房成功', $obj['code'], $orderedRooms, $oid]);
            } else {
                $this->error('所选房源全部已售，抢购失败!');
            }
        }
    }

    /*
     * 获取所有已购买房间的ID
     */

    public function getAllOrderedRooms() {
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试！');
        }

        $eventId = I('eventId', 0, 'intval');
        if (empty($eventId)) {
            $this->error('活动ID不能为空，请确认后重试！');
        }

        $redis = new OriginRedis();
        $redis->connect(C('REDIS_HOST'));

        $event = $redis->hGetAll("event_order_house_{$eventId}");

        if (empty($event))
            $this->error('无活动');

        if (time() < $event['start_time'])
            $this->error('活动未开始');

        if (time() > $event['end_time'])
            $this->error('活动已结束');

        $phone = session('phone');

        /* if (empty($phone) || strlen($phone)!=11)
          $this->error('手机号码11位不正确');
         */
        $eventOrderHouseModel = D('Common/EventOrderHouse');

        //查看活动是否存在
        $event = $eventOrderHouseModel->getEventByEventId($eventId);

        if (empty($event)) {
            $this->error('活动没有开始');
        }

        $orderedRooms = $eventOrderHouseModel->getAllOrderedRoomInRedis($eventId);

        $orderedRooms = empty($orderedRooms) ? [] : $orderedRooms;

        //$this->show(json_encode($orderedRooms));
        $this->success(['成功', $orderedRooms]);
    }

    /**
     * 测试脚本
     *
     * @create 2017-04-26
     * @author jxw
     */
    /* public function test()
      {
      $users = [
      ['测试客户6','12342678911'],['测试客户4','12345678911'],['滕娇燕','13032868660'],['李晓寒','13084406910'],['测试2','13111111192'],['测试3','13111111193'],['测试4','13111111194'],['测试5','13111111195'],['孙恒','13215100000'],['刘翔宇','13258250066'],['韩飞逸','13308011262'],['王毅','13308066913'],['李安平','13308192955'],['杜秦曲','13348858100'],['罗璇','13348921733'],['曹良波','13350080588'],['龚晋','13350287555'],['卢怡','13378120729'],['赖成兴','13508067021'],['唐永忠','13510174700'],['赵丹','13541117881'],['陈兴常','13541324033'],['钱兵','13558888786'],['洛呷','13568683888'],['马俊波','13608081568'],['王巧丽','13632280808'],['张梦雪','13648061900'],['薛雨飞','13658197212'],['张柯','13666121193'],['黄茜','13668266698'],['陈小林','13671716927'],['汪娟','13679099026'],['李金雨','13689031567'],['测试1','13693425865'],['冉晓荷','13699455117'],['潘世斌','13708011662'],['王宇','13708226668'],['李剑','13708267258'],['白为','13709018714'],['李菠','13730851890'],['周生亮','13778208004'],['李进军','13783379357'],['李四君','13808015872'],['张文琳','13808018901'],['高飞','13808036938'],['苟玉清','13808067776'],['杨杰','13808189117'],['陶奎','13808190295'],['秦正军','13808208715'],['叶蕾','13808209625'],['李睿野','13808219992'],['李睿哲','13880034768'],['郑颖','13880060531'],['谭晓华','13880161099'],['高涛','13880184576'],['闫晨','13880268077'],['袁姝','13880344179'],['武戈','13880461850'],['张红梅','13880505448'],['陈家琨','13880858219'],['张恩露','13880872799'],['刘洪斌','13881398377'],['卓春','13881888388'],['张丽红','13882857082'],['吴掌印','13889086666'],['白晓龙','13908001103'],['陈波','13908002989'],['陈碧蓉','13908050904'],['曹自荐','13908171186'],['田炜','13908179960'],['李溢晨','13908217058'],['王宁','13909032125'],['刘辉','13909973196'],['肖荣','13911092838'],['翁扎','13951918118'],['周怡','13980028616'],['张岳炜','13980077644'],['王艺璇','13980196301'],['丁云迪','13980481337'],['吴皓琳','13980823961'],['边宇','13980878600'],['徐正秋','13980908659'],['张健','13981733966'],['王云川','13981949993'],['郭臻','13982032277'],['孟鹭','13982055273'],['郭晓明','13982059806'],['张成莉','13982161999'],['朱葛','13982233390'],['欧丽华','13982269727'],['李雯曦','13982278887'],['王天祥','13982281088'],['曹英','13982861855'],['李芬芳','13982865858'],['田维军','13983817077'],['陈向阳','13989197889'],['严仕海','13989991072'],['康琼','13990508072'],['蒋一心','13990930006'],['商利','13990951956'],['张力文','15082024000'],['张向楠','15328185203'],['赵彬伍','15378689688'],['马燕','15609008999'],['侯臣','15680669099'],['刘春阳','15681898899'],['邹宇峰','15882177747'],['李桂英','15882590333'],['鲁朝兰','15884416692'],['刘丽','15928603399'],['刘玉成','15928686185'],['张辉','15984788888'],['测试客户3','17345678911'],['冯海洋','17761227776'],['高延','18030508888'],['徐娟娟','18109072329'],['测试客户4','18217867621'],['测试客户6','18245367891'],['测试客户1','18256713251'],['文件','18267525165'],['仲杰','18281730000'],['杨涵笑','18302865926'],['预留','18333333333'],['测试客户5','18345678911'],['孙一铭','18582521030'],['高菲','18602819623'],['鄢玲英','18602867566'],['王熊','18608055755'],['谢梦霜','18608107838'],['赵倩','18611568707'],['胥素萍','18628058177'],['刘冉','18628066767'],['罗娟','18628082722'],['王长虹','18628113822'],['钟敏','18628140792'],['罗利英','18628164812'],['江显勇','18628393616'],['张萍','18628920066'],['杜芳','18681257729'],['周芸','18683683626'],['张爽','18683723388'],['孙慧','18696506800'],['测试客户1','18728157815'],['徐源','18980680566'],['陈姝江','18981200703'],['周琬玥','18982000048'],['姜鹏','18990832299']
      ];

      $user = rand(0,count($users));
      $phone = intval($user[1]);
      $realName = $user[0];

      unset($users);
      unset($user);

      //获取ID
      $roomIds = [2589,2590,2591,2592,2593,2594,2595,2596,2597,2598,2599,2600,2601,2602,2603,2604,2605,2606,2607,2608,2609,2610,2611,2612,2613,2614,2615,2616,2617,2618,2619,2620,2621,2622,2623,2624,2625,2626,2627,2628,2629,2630,2631,2632,2633,2634,2635,2636,2637,2638,2639,2640,2641,2642,2643,2644,2645,2646,2647,2648,2649,2650,2651,2652,2653,2654,2655,2656,2657,2658,2659,2660,2661,2662,2663,2664,2665,2666,2667,2668,2669,2670,2671,2672,2673,2674,2675,2676,2677,2678,2679,2680,2681,2682,2683,2684,2685,2686,2687,2688,2689,2690,2691,2692,2693,2694,2695,2696,2697,2698,2699,2700,2701,2702,2703,2704,2891,2706,2707,2708,2709,2710,2711,2712,2713,2714,2715,2716,2717,2718,2719,2720,2721,2722,2723,2724,2725,2726,2727,2728,2729,2730,2731,2732,2733,2734,2735,2736,2737,2738,2739,2740,2741,2742,2743,2744,2745,2746,2747,2748,2749,2750,2751,2752,2753,2754,2755,2756,2757,2758,2759,2760,2761,2762,2763,2764,2765,2766,2767,2768,2769,2770,2771,2772,2773,2774,2775,2776,2777,2778,2779,2780,2781,2782,2783,2784,2785,2786,2787,2788,2789,2790,2791,2792,2793,2794,2795,2796,2797,2798,2799,2800,2801,2802,2803,2804,2805,2806,2807,2808,2809,2810,2811,2812,2813,2814,2815,2816,2817,2818,2819,2820,2821,2822,2823,2824,2825,2826,2827,2828,2829,2830,2831,2832,2833,2834,2835,2836,2837,2838,2839,2840,2841,2842,2843,2844,2845,2846,2847,2848,2849,2850,2851,2852,2853,2854,2855,2856,2857,2858,2859,2860,2861,2862,2863,2864,2865,2866,2867,2868,2869,2870,2871,2872,2873,2874,2875,2876,2877,2878,2879,2880,2881,2882,2883,2884,2885,2886,2887,2888,2889,2890,5555,2892,2893,2894,2895,2896,2897,2898,2899,2900,2901,2902,2903,2904,2905,2906,2907,2908,2909,2910,2911,2912,2913,2914,2915,2916,2917,2918,2919,2920,2921,2922,2923,2924,2925,2926,2927,2928,2929,2930,2931,2932,2933,2934,2935,2936,2937,2938,2939,2940,2941,2942,2943,2944,2945,2946,2947,2948,2949,2950,2951,2952,2953,2954,2955,2956,2957,2958,2959,2960,2961,2962,2963,2964,2965,2966,2967,2968,2969,2970,2971,2972,2973,2974,2975,2976,2977,2978,2979,2980,2981,2982,2983,2984,2985,2986,2987,2988,2989,2990,2991,2992,2993,2994,2995,2996,2997,2998,2999,3000,3001,3002,3003,3004,3005,3006,3007,3008,3009,3010,3011,3012,3013,3014,3015,3016,3017,3018,3019,3020,3021,3022,3023,3024,3025,3026,3027,3028,3029,3030,3031,3032,3033,3034,3035,5556,5557,5558,5559,5560,5561,5562,5563,5564,5565,5566,5567,5568,5569,5570,5571,5572,5573,5574,5575,5576,5577,5578,5579,5580,5581,5582,5583,5584,5585,5586,5587,5588,5589,5590,5591,5592,5593,5594,5595,5596,5597,5598,5599,5600,5601,5602,5603,5604,5605,5606,5607,5608,5609,5610,5611,5612,5613,5614,5615,5616,5617,5618,5619,5620,5621,5622,5623,5624,5625,5626,5627,5628,5629,5630,5631,5632,5633,5634,5635,5636,5637,5638,5639,5640,5641,5642,5643,5644,5645,5646,5647,5648,5649,5650,5651,5652,5653,5654,5655,5656,5657,5658,5659,5660,5661,5662,5663,5664,5665,5666,5667,5668,5669,5670,5671,5672,5673,5674,5675,5676,5677,5678,5679,5680,5681,5682,5683,5684,5685,5686,5687,5688,5689,5690,5691,5692,5693,5694,5695,5696,5697,5698,5699,5700,5701,5702,5703,5704,5705,5706,5707,5708,5709,5710,5711,5712,5713,5714,5715,5716,5717,5718,5719,5720,5721,5722,5723,5724,5725,5726,5727,5728,5729,5730,5731,5732,5733,5734,5735,5736,5737,5738,5739,5740,5741,5742,5743,5744,5745,5746,5747,5748,5749,5750,5751,5752,5753,5754,5755,5756,5757,5758,5759,5760,5761,5762,5763,5764,5765,5766,5767,5768,5769,5770,5771,5772,5773,5774,5775,5776,5777,5778,5779,5780,5781,5782,5783,5784,5785,5786,5787,5788,5789,5790,5791,5792,5793,5794,5795,5796,5797,5798,5799,5800,5801,5802,5803,5804,5805,5806,5807,5808,5809,5810,5811,5812,5813,5814,5815,5816,5817,5818,5819,5820,5821,5822,5823,5824,5825,5826,5827,5828,5829,5830,5831,5832,5833,5834,5835,5836,5837,5838,5839,5840,5841,5842,5843,5844,5845,5846,5847,5848,5849,5850,5851,5852,5853,5854,5855,5856,5857,5858,5859,5860,5861,5862,5863,5864,5865,5866,5867,5868,5869,5870,5871,5872,5873,5874,5875,5876,5877,5878,5879,5880,5881,5882,5883,5884,5885,5886,5887,5888,5889,5890,5891,5892,5893,5894,5895,5896,5897,5898,5899,5900,5901,5902,5903,5904,5905,5906,5907,5908,5909,5910,5911,5912,5913,5914,5915,5916,5917,5918,5919,5920,5921,5922,5923,5924,5925,5926,5927,5928,5929,5930,5931,5932,5933,5934,5935,5936,5937,5938,5939,5940,5941,5942,5943,5944,5945,5946,5947,5948,5949,5950,5951,5952,5953,5954,5955,5956,5957,5958,5959,5960,5961,5962,5963,5964,5965];

      $id = $roomIds[rand(0,count($roomIds))];

      unset($roomIds);

      print_r($id);
      print_r($phone);
      print_r($realName);
      exit;

      $eventId = 3;

      $redis = new OriginRedis();
      $redis->connect(C('REDIS_HOST'));

      $event = $redis->hGetAll("event_order_house_{$eventId}");

      if (empty($event))
      $this->error('无活动');

      if (time()<$event['start_time'])
      $this->error('活动未开始');

      if (time()>$event['end_time'])
      $this->error('活动已结束');

      $phone = intval($phone);

      if (empty($phone) || strlen($phone)!=11)
      $this->error('手机号码11位不正确');

      $eventOrderHouseModel = D('Common/EventOrderHouse');

      //查看活动是否存在
      $event = $eventOrderHouseModel->getEventByEventId($eventId);

      $expire_time = $event['end_time'] - time();

      if (empty($event)){
      $this->error('活动没有进行中');
      }

      $orderHouseOrderModel = D('OrderHouseOrder');

      //房间是否已出售
      $isRoomOrdered = $redis->sIsMember("event_order_house_{$eventId}_room_ordered",$id);
      if ($isRoomOrdered)
      $this->error('房间已被预定');

      //用户是否已购买
      $isMemberOrdered = $redis->sIsMember("event_order_house_{$eventId}_room_order_phone",$phone);
      if ($isMemberOrdered)
      $this->error('每人最多购置一套');

      $orderedCount = $orderHouseOrderModel->find(array(
      'where'=>array('event_id'=>$eventId,'belong_phone'=>$phone)
      ,'field'=>array('count(1) as count,room_id')
      ));

      if ($orderedCount['count']){
      //修复
      $redis->hSet("event_order_house_{$eventId}_room_{$orderedCount['room_id']}",'status',1);
      $redis->sAdd("event_order_house_{$eventId}_room_ordered",$orderedCount['room_id']);
      $redis->sAdd("event_order_house_{$eventId}_room_order_phone",$phone);
      $redis->set("event_order_house_{$eventId}_room_{$orderedCount['room_id']}_locked",1,$expire_time);

      $this->error('每人最多购置一套');
      }

      //获取房间信息，查看status
      $room = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$eventId}_room_{$id}");
      if (empty($room)){
      $this->error('该房间没有参加活动');
      }

      if (!empty($room['schedule_phone']) && $room['schedule_phone']!=$phone)
      $this->error('请稍后重试！');


      //如果status 1 返回错误 设置set锁
      if ($room['status']===1){
      $redis->set("event_order_house_{$eventId}_room_{$id}_locked",1,$expire_time);
      $this->error('房间已被预购。');
      }

      $getLock = 0;
      //如果status 0 就行修改
      if (empty($room['status'])){
      $getLock = $redis->setnx("event_order_house_{$eventId}_room_{$id}_locked",1);
      }

      //setnx 进行锁定 10s 没有 获得锁 返回错误
      if ($getLock){
      $redis->expire("event_order_house_{$eventId}_room_{$id}_locked",10);
      }else{
      $this->error('请稍后重试！');
      }

      $customer = D('Common/Customer');
      $user_info = $customer->getOneByOpenId($this->get_wx_open_id());

      if (empty($user_info)){
      $this->error('请关注后重试');
      }

      //写入mysql try catch
      if ($getLock){
      $obj = array(
      'event_id'=> $eventId
      ,'event_name'=> $event['name']
      ,'company_id'=> $room['company_id']
      ,'project_id'=> $room['project_id']
      ,'project_name'=> $room['project_name']
      ,'batch_id'=> $room['batch_id']
      ,'batch_name' => $room['batch_name']
      ,'build_id'=> $room['build_id']
      ,'build_name' => $room['buildname']
      ,'unit_no' => $room['unit']
      ,'floor_no' => $room['floor']
      ,'room_id'=> $id
      ,'room_no' => $room['no']
      ,'belong_openid'=> $this->get_wx_open_id()
      ,'belong_real_name' => $realName
      ,'belong_gender'=> $user_info['sex']
      ,'belong_phone'=>  $phone
      ,'code'=> sprintf('%02s',$room['build_id']).sprintf('%02s',$room['unit']).sprintf('%02s',$room['floor']).$room['no'].sprintf('%06s',rand(0,999999))
      ,'log_time'=> time()
      ,'is_checked'=> 0
      );

      $orderHouseOrderModel = D('OrderHouseOrder');

      try{
      $redis->set("event_order_house_{$eventId}_room_{$id}_locked",1,$expire_time);
      $redis->hSet("event_order_house_{$eventId}_room_{$id}",'status',1);
      //添加已经预定的房间
      $redis->sAdd("event_order_house_{$eventId}_room_ordered",$id);
      //添加已经购买的人员
      $redis->sAdd("event_order_house_{$eventId}_room_order_phone",$phone);

      $orderHouseOrderModel->add($obj);

      }catch (\Exception $e){
      $redis->del("event_order_house_{$eventId}_room_{$id}_locked");
      $redis->hSet("event_order_house_{$eventId}_room_{$id}",'status',0);
      $redis->sRem("event_order_house_{$eventId}_room_ordered",$id);
      $redis->sRem("event_order_house_{$eventId}_room_order_phone",$phone);
      $this->error('请稍后重试！');
      }

      }

      $this->success('预购成功');
      } */

    /**
     * 微信认购登录页面
     */
    public function privilege() {
        $eventId = $this->getEventId();
  
        $eventOrderHouseModel = D('Common/EventOrderHouse');
        $event = $eventOrderHouseModel->getOneById($eventId);
        $where = [
            'fields' => '*'
            , 'where' => [
                'id' => $event['project_id']
                , '2=2'
            ]
        ];

        $project = M('project');
        $proj = $project->find($where);
        $this->assign('projname', $proj['name']);
        $this->assign('event', $event);

        unset($where);
        $where = [
            'fields' => '*'
            , 'where' => [
                'id' => $eventId
                , '3=3'
            ]
        ];
        $eventinfo = M('event_order_house')->find($where);
        $this->assign('desc', $eventinfo['desc']);
        $this->display();
    }

    /**
     * 微信认购 短信发送页面
     */
    public function send_sms_code() {
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试');
        }

        $phone = I("post.phone", 0);
        
        $eventId = $this->getEventId();
        
        if (empty($eventId)) {
            $this->error('系统错误!');
        }
        if (empty($phone)) {
            $this->error('请填写手机号码');
        }
        if (empty($phone) || strlen($phone) != 11) {
            $this->error('请填写正确的手机号码');
        }
        $event = D('Common/EventOrderHouse')->getOneById($eventId);
        if ($event['states'] < 1) {
            $this->error('活动准备中，请稍后');
        }
        $jmphone=rsa_encode($phone,getChoosekey());//加密
        $where = ['project_id' => $event['project_id'], 'batch_id' => $event['batch_id'], 'customer_phone' => $jmphone];

        $chooseinfo = D('Common/choose')->field('customer_name,id,status,ys_time')->where($where)->find();

        if (empty($chooseinfo['customer_name'])) {
            $this->error('你还未参与此活动');
        }
        if ($event['isysdl'] == 1) {//是否启用延时登录验证
            if ($chooseinfo['status'] < 1 || $event['start_time'] + (int) ($chooseinfo['ys_time']) * 60 > time()) {
                $this->error('你暂时无权参与此活动');
            }
        } else {
            if ($chooseinfo['status'] < 1) {
                $this->error('你暂时无权参与此活动');
            }
        }
        $realName = $chooseinfo['customer_name'];

        $redisDriver = new Redis();

        if ($redisDriver->get("dlsx_order_house_{$eventId}_{$phone}_code") && cookie('order_house_code')) {
            $this->error('5分钟内不用重复获取');
        }

        $code = sprintf("%6s", rand(100000, 999999));

        /*
          //ali大鱼
          require "taobaoauto/TopSdk.php";
          require "taobaoauto/top/TopClient.php";
          $c = new \TopClient();
          $c->appkey = '23313605';
          $c->secretKey = '7c7e8044e251fa21fe3503c610bc6b1e';
          $req = new \AlibabaAliqinFcSmsNumSendRequest();
          $req->setExtend("123456");
          $req->setSmsType("normal");
          $req->setSmsFreeSignName("链商科技");
          $req->setSmsParam("{\"password\":\"$code\"}");
          $req->setRecNum($phone);
          $req->setSmsTemplateCode("SMS_45440004");
          //$resp = $c->execute($req);
          //$arr = $this->objectArray($resp);
         */

        //阿里短信服务
        //$sms = new Alisms();
        //$status1 = $sms->send_verify($phone, $code);
        $status1 = true;
        if ($status1) {
            cookie("order_house_code", $code);
            cookie('phone', $jmphone);
            cookie("realName", $realName);
            cookie("chooseuid", $chooseinfo['id']);
            $redisDriver->set("dlsx_order_house_{$eventId}_{$phone}_code", 1, 300 * 1);

            $redisDriver->hSet("dlsx_order_house_{$eventId}_{$phone}", 'sid', session_id());
            //客户购买房源个数控制
            //$redisDriver->hSet("dlsx_order_house_{$eventId}_{$phone}",'maxcount',$chooseinfo['maxcount']);
            $redisDriver->hSet("dlsx_order_house_{$eventId}_{$phone}", 'maxcount', 3);
            $redisDriver->expire("dlsx_order_house_{$eventId}_{$phone}", 60 * 60 * 6);

            $this->success($code);
            //$this->success('验证码发送中，请稍等...');
        } else {
            $this->error($sms->error);
        }
    }

    /**
     * 微信认购 检查权限页面
     */
    public function check() {
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试！');
        }
        $phone = I('post.phone', 0);
        $code = I('post.code', 0);
        $eventId=$this->getEventId();
        if (empty($eventId)) {
            $this->error('系统错误');
        }
        $event = D('Common/EventOrderHouse')->getOneById($eventId);
        if ($event['states'] < 1) {
            $this->error('活动准备中，请稍后');
        }
        if (empty($phone)) {
            $this->error('请填写手机号码');
        }
        if (strlen($phone) != 11) {
            $this->error('请填写正确的手机号码');
        }
        $jmphone=rsa_encode($phone,getChoosekey());//加密
        if (cookie('phone') != $jmphone || empty(cookie('order_house_code'))) {
            $this->error('请先获取验证码');
        }
        if (empty($code)) {
            $this->error('请填写验证码');
        }
        $redisDriver = new Redis();
        $loginerror = $redisDriver->get("order_house_{$phone}_loginerror");

        if (!$loginerror) {
            $loginerror = 0;
        }

        if ($loginerror >= 5) {
            //$event = D('Common/EventOrderHouse')->getOneById($eventId);
            $data1["status"] = 0;
            D("Choose")->where("customer_phone=" . $jmphone . " and project_id=" . $event['project_id'] . " and batch_id=" . $event['batch_id'])->save($data1);
            $this->error('账号锁定，6小时内不能登录');
        }
        if ($code != cookie('order_house_code') && cookie('phone') == $jmphone) {
            $loginerror = $loginerror + 1;
            $redisDriver->set("order_house_{$phone}_loginerror", $loginerror, 60 * 60 * 6);
            $this->error('请填写正确的验证码');
        }

        $orderHousePhoneModel = D('Common/OrderHousePhoneLogin');
        $data = [
            'event_id' => $eventId
            , 'phone' => $jmphone
            , 'customer_id' => $this->get_customer_id()
            , 'logintime' =>time()
            , 'logip'=>$this->getIP()
        ];

        $orderHousePhoneModel->add($data);

        session('privilege', 1);
        //session("order_house_code",cookie("order_house_code"));
        session("phone", cookie('phone'));
        session("realName", cookie("realName"));
        session("chooseuid", cookie("chooseuid"));

        $redisDriver->del("order_house_{$phone}_loginerror");
        cookie('order_house_code', NULL);

        //客户购买房源个数控制
        $where = array('belong_phone' => cookie('phone'), 'project_id' => $event['project_id'], 'batch_id' => $event['batch_id'], 'eventId' => $eventId, '888=888');
        $ygmroom = D('OrderHouseOrder')->getList($where);
        if ($ygmroom) {
            $yrgcount = count($ygmroom);
        } else {
            $yrgcount = 0;
        }
        $redisDriver->hSet("dlsx_order_house_{$eventId}_{$phone}", 'yrgcount', $yrgcount);
        
        $redisDriver->hSet("dlsx_order_house_{$eventId}_{$phone}", 'status', 1);
        $this->success("验证成功",__CONTROLLER__."/index/info/".cookie('eventId'));
    }

    public function logout() {
        $eid=cookie('eventId');
        if (empty($eid))
        {
            $eid = I('info', 0, 'trim');
        }
        $jmphone= cookie('phone');
        //$redisDriver = new Redis();
        //$eid=cookie('eventId');
        //$cphone=cookie('phone');
        //$redisDriver->del("event_order_house_{$eid}_{$cphone}_dlsx");
        session_unset();
        session_destroy();
        cookie('order_house_code', NULL);
        cookie('phone', NULL);
        cookie('realName', NULL);
        cookie('chooseuid', NULL);
        cookie('eventId', NULL);
        cookie('first_vist', NULL);
        cookie('user_id', NULL);
        
        
        $orderHousePhoneModel = D('Common/OrderHousePhoneLogin');
        $eventId=  geturl($eid, getUrlkey())["eventId"];
        if(!$eventId) $eventId=0;
        if(!$jmphone) $jmphone=0;
        $onelog=$orderHousePhoneModel->where('event_id='.$eventId ." and phone='". $jmphone ."'")->order("id desc")->find();
        if($onelog)
        {
            $data["logouttime"]=time();
            $orderHousePhoneModel->where('id='.$onelog['id'])->save($data);
        }

        $this->redirect("privilege", ['info' => $eid]);
        
        
    }

    //当前时间戳(包含毫秒)
    public function getMillisecond() {
        list($s1, $s2) = explode(' ', microtime());
        return (float) sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }

    //单独获取活动倒计时(包含毫秒)
    public function geteventdjs() {
        if (!IS_AJAX)
            $this->error('请求错误，请确认后重试！');

        $id = I('id', 0, 'intval');
        $eventOrderHouseModel = D('Common/EventOrderHouse');
        //$event = $eventOrderHouseModel->getEventByEventId(geturl($id, getUrlkey())["eventId"]);
        $event = $eventOrderHouseModel->getEventByEventId($this->getEventId());
        $dqhm = $this->getMillisecond();
        if ($dqhm < $event['start_time'] * 1000) {//活动未开始时，返回活动开始倒计时time和整个活动时长time1
            $time = $event['start_time'] * 1000 - $dqhm;
            $time1 = $event['end_time'] - $event['start_time'];
            $djsinfo['iswks'] = 1;
            $djsinfo['time1'] = $time1;
        } else {//活动已开始，返回的time和time1一样
            if ($dqhm > $event['end_time'] * 1000) {
                $time = 0;
            } else {
                $time = $event['end_time'] * 1000 - $dqhm;
            }
            $djsinfo['iswks'] = 0;
            $djsinfo['time1'] = $time;
        }
        $djsinfo['time'] = $time;
        $this->success(['成功', $djsinfo]);
    }
    
    //调整排序
    public function update_px(){
        $cid=I("post.cid");
        $apx=I("post.apx");
        $pd=I("post.pd");
        $eventId=$this->getEventId();
        $uid=session("chooseuid");
        if(!$uid){
            $uid=cookie('chooseuid');
        }
        if($pd=="sx"){//升序
            $p=M()->table("xk_cst2rooms")->where("cst_id=$uid AND eventId=$eventId AND px=($apx-1)")->save(['px'=>$apx]);
            if($p){
                M()->table("xk_cst2rooms")->where("id=$cid")->save(['px'=>($apx-1)]);
            }else{
                echo 'false';exit;
            }
        }else{//降序
            $p=M()->table("xk_cst2rooms")->where("cst_id=$uid AND eventId=$eventId AND px=($apx+1)")->save(['px'=>$apx]);
            if($p){
                M()->table("xk_cst2rooms")->where("id=$cid")->save(['px'=>($apx+1)]);
            }else{
                echo 'false';exit;
            }
        }
    }
}
