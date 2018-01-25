<?php

namespace User\Controller;

use Think\Cache\Driver\Redis;
use \Redis as OriginRedis;

/**
 * 我的收藏
 *
 * @create 2016-9-6
 * @author zlw
 */
class CollectionController extends BaseController {

    /**
     * 首页
     *
     * @create 2016-9-6
     * @author zlw
     */
    public function index() {
        $proj_id = I('pid', '', 'intval');

        //客户ID
        $customer_id = $this->get_customer_id();
        $this->assign('customer_id', $customer_id);

        //收藏的房间ID
        unset($where);
        $where['cst_id'] = $this->get_customer_id();
        $where['proj_id'] = $proj_id;
        $where['is_dq'] = 1;
        $room_collection = D('Common/Collectionview')->getList($where);

        $collection_room_ids = array();
        foreach ($room_collection as $room_collection_key => $room_collection_value) {
            $collection_room_ids[] = $room_collection_value['room_id'];
        }

        //房间列表
        if (!empty($collection_room_ids)) {
            unset($where);
            $where['id'] = array('in', $collection_room_ids);
            $rooms = D("Common/Room")->getRoomList($where, "bld_id ASC, unit ASC, floor ASC, no ASC");
        } else {
            $rooms = array();
        }

        //获取相关信息
        if (!empty($rooms)) {
            foreach ($rooms as $key => $room) {
                //楼栋信息
                $bld_id = $room['bld_id'];
                $build = D("Common/Build")->getBuildById($bld_id);

                //判断时间
                if (date('d', $room['xftime']) == date('d')) {
                    $time = date('H:i', $room['xftime']);
                } elseif (!empty($room['xftime'])) {
                    $time = date('Y-m-d H:i', $room['xftime']);
                } else {
                    $time = '';
                }
                $data = array(
                    'room_id' => $room['id'],
                    'room_name' => $build['buildname'] . '栋' . $room['unit'] . '单元',
                    'room_floor' => $room['floor'] . 'F',
                    'room_number' => $room['room'],
                    'room_hx' => $room['hx'],
                    'room_area' => $room['area'],
                    'room_total' => $room['total'],
                    'room_is_xf' => $room['is_xf'],
                    'xftime' => $time
                );

                $rooms[$key] = array_merge($room, $data);
            }
        }
        $this->assign('rooms', $rooms);

        $this->set_seo_title("我的收藏");
        $this->display();
    }

    /**
     * 添加收藏
     *
     * @create 2016-9-6
     * @author zlw
     */
    public function add() {
        if (!IS_AJAX) {
            $this->error('提交失败，请稍后重试！');
        }

        $room_id = I('room_id', 0, 'intval');
        $pd = I('pd', 0, 'intval');
        $eventId = I('eventId');
        
        if ($eventId && !is_numeric($eventId)) {
            $eventId = geturl($eventId, getUrlkey())["eventId"];
        }
        if (!$eventId) {
            $this->error('系统错误，请稍后重试！');
        }

        //$where['cst_id'] 	= $this->get_customer_id();
        if ($pd == 1) {
            $where['cst_id'] = session("user_id");
            if (!$where['cst_id']) {
                $where['cst_id'] = cookie("user_id");
            }
        } else {
            $where['cst_id'] = session("chooseuid");
        }

        $where['room_id'] = intval($room_id);
        $collection = D("Common/Collection")->getOne($where);
        if (!empty($collection)) {
            $this->error('你已经收藏过了！', U('index/index'));
        }
        //微信认购需要控制备选房源数量
        if (!empty($eventId)) {
            unset($where);
            /*
              $where['cst_id'] = session("chooseuid");
              $where['eventId'] =$eventId;
              $where[] ='3=3';
              $allcollection=D("Common/Collection")->where($where)->select();
             */
            $allcollection = M()->query("SELECT a.*,c.bldtype FROM xk_cst2rooms a inner join xk_room b on a.room_id=b.id inner join xk_build c on b.bld_id=c.id WHERE a.cst_id=" . session("chooseuid") . " and a.eventId= " . $eventId . "  and c.bldtype=0 and 333=333 ");
            $redis = new OriginRedis();
            $redis->connect(C('REDIS_HOST'));
            $event = $redis->hGetAll("event_order_house_{$eventId}");
            if (count($allcollection) == $event['maxcount']) {
                $this->error('本次活动只允许添加' . $event['maxcount'] . '个备选房源！');
            }
        }

        $room = D('Common/Room')->getRoomById(intval($room_id));

        //$data['cst_id'] 	= $this->get_customer_id();

        if ($pd == 1) {
            $data['cst_id'] = session("user_id");
            if (!$data['cst_id']) {
                $data['cst_id'] = cookie("user_id");
            }
        } else {
            $data['cst_id'] = session("chooseuid");
        }
        $data['room_id'] = intval($room_id);
        $data['sctime'] = time();
        $data['proj_id'] = $room['proj_id'];
        if (!empty($eventId)) {
            $data['eventId'] = $eventId;
        }
        $px = D('Collection')->field("max(px) mpx")->where("proj_id={$data['proj_id']}  AND cst_id={$data['cst_id']}")->select();
//		echo json_encode(M()->getLastSql());
//exit;
        if ($px[0]['mpx'] == null) {
            $data['px'] = 1;
        } else {
            $data['px'] = $px[0]['mpx'] + 1;
        }
        $check_has_add = D('Collection')->addOne($data);
        if (false === $check_has_add) {
            $this->error('收藏失败，请重试！', U('index/index'));
        }

        if (!empty($eventId))
            if ($pd == 2) {
                D("Common/EventOrderHouse")->IncrementRoomScoreByEventIdRoomId($eventId, $room_id);
            }
        //添加收藏次数
        D("Common/Roomattribute")->incSccountByRoomId(1, $room_id);

        $this->success('收藏成功！', U('collection/index'));
    }

    /**
     * 取消收藏
     *
     * @create 2016-9-7
     * @author zlw
     */
    public function delete() {
        if (!IS_AJAX) {
            $this->error('提交失败，请重试！', U('index/index'));
        }
        $room_id = I('room_id', 0, 'intval');
        $eventId = I('post.eventId');
        if ($eventId && !is_numeric($eventId)) {
            $eventId = geturl($eventId, getUrlkey())["eventId"];
        }
        if (!$eventId) {
            $this->error('系统错误，请稍后重试！');
        }
        
        $cstid = session("chooseuid");
        if (!$cstid) {
            $cstid = session("user_id");
            if (!$cstid) {
                $cstid = cookie("user_id");
            }
        }
        $where['cst_id'] = $cstid;
        $where['room_id'] = $room_id;
        if (!empty($eventId) && !empty(session('chooseuid')))
        {
            $where['eventId'] = $eventId;
            $where1=" cst_id= $cstid and eventId= $eventId ";
        }
        else
        {
            $where1=" cst_id= $cstid ";
        }
        $collection =D("Common/Collection");
        $onec = $collection->getOne($where);
        if (empty($onec)) {
            $this->error('你还没有收藏！');
        }
        
        $where1 = $where1 ." and px > ".$onec['px'];
        $clist=$collection->where($where1)->select();
        if(!empty($clist) && count($clist)>0)
        {
           foreach($clist as $item){
               $collection-> where(" id = ".$item['id'] ." and 9999=9999")->setDec("px", 1);
           }
        }   
        
        //删除数据
        $check_has_delete = D('Collection')->deleteOne($where);
        if (false === $check_has_delete) {
            $this->error('取消收藏失败，请重试！', U('index/index'));
        }

        if (!empty($eventId) && !empty(session('chooseuid')))
            D("Common/EventOrderHouse")->ReductionRoomScoreByEventIdRoomId($eventId, $room_id);

        //减少收藏次数
        D("Common/Roomattribute")->decSccountByRoomId(1, $room_id);

        $this->success('取消收藏成功！', U('collection/index'));
    }

    /**
     * 取消多条收藏
     *
     * @create 2016-9-7
     * @author zlw
     */
    public function delete_list() {
        if (!IS_AJAX) {
            $this->error('提交失败，请重试！', U('index/index'));
        }

        $room_ids = I('room_ids', '', 'trim');
        $new_room_ids = explode(',', $room_ids);

        foreach ($new_room_ids as $room_id) {
            //$where['cst_id'] 	= $this->get_customer_id();
            $where['cst_id'] = session("chooseuid");
            $where['room_id'] = intval($room_id);
            $collection = D("Common/Collection")->getOne($where);

            if (!empty($collection)) {
                $map['cst_id'] = $this->get_customer_id();
                $map['room_id'] = intval($room_id);
                $check_has_delete = D('Collection')->deleteOne($map);

                //减少收藏次数
                D("Common/Roomattribute")->decSccountByRoomId(1, $room_id);
            }
        }

        $this->success('取消收藏成功！', U('collection/index'));
    }

    /**
     * 首页
     *
     * @create 2016-9-6
     * @author zlw
     */
    public function bxfy() {
        $proj_id = I('pid', '', 'intval');

        //客户ID
        $customer_id = $this->get_customer_id();
        $this->assign('customer_id', $customer_id);

        //收藏的房间ID
        unset($where);
        $where['cst_id'] = $this->get_customer_id();
        $where['proj_id'] = $proj_id;
        $where['is_dq'] = 1;
        $room_collection = D('Common/Collectionview')->getList($where);

        $collection_room_ids = array();
        foreach ($room_collection as $room_collection_key => $room_collection_value) {
            $collection_room_ids[] = $room_collection_value['room_id'];
        }

        //房间列表
        if (!empty($collection_room_ids)) {
            unset($where);
            $where['id'] = array('in', $collection_room_ids);
            $rooms = D("Common/Room")->getRoomList($where, "bld_id ASC, unit ASC, floor ASC, no ASC");
        } else {
            $rooms = array();
        }

        //获取相关信息
        if (!empty($rooms)) {
            foreach ($rooms as $key => $room) {
                //楼栋信息
                $bld_id = $room['bld_id'];
                $build = D("Common/Build")->getBuildById($bld_id);

                //判断时间
                if (date('d', $room['xftime']) == date('d')) {
                    $time = date('H:i', $room['xftime']);
                } elseif (!empty($room['xftime'])) {
                    $time = date('Y-m-d H:i', $room['xftime']);
                } else {
                    $time = '';
                }
                $data = array(
                    'room_id' => $room['id'],
                    'room_name' => $build['buildname'] . '栋' . $room['unit'] . '单元',
                    'room_floor' => $room['floor'] . 'F',
                    'room_number' => $room['room'],
                    'room_hx' => $room['hx'],
                    'room_area' => $room['area'],
                    'room_total' => $room['total'],
                    'room_is_xf' => $room['is_xf'],
                    'xftime' => $time
                );

                $rooms[$key] = array_merge($room, $data);
            }
        }
        $this->assign('rooms', $rooms);

        $this->set_seo_title("备选房源");
        $this->display();
    }

}
