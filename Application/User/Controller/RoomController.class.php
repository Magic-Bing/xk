<?php

namespace User\Controller;
use Think\Cache\Driver\Redis;
use \Redis as OriginRedis;
/**
 * 房间详情
 *
 * @create 2016-9-1
 * @author zlw
 */
class RoomController extends BaseController 
{
        
        /**
        * 构造方法
        *
        * @create 2016-11-16
        * @author zlw
	*/
	public function _initialize()
	{
            //校验活动实际用户状态是否正常
            $redisDriver = new Redis();
            $eid = geturl(cookie('eventId'), getUrlkey())["eventId"];
            $cphone = rsa_decode(cookie('phone'),getChoosekey());//解密
            if($eid && $cphone){
                $event = $redisDriver->hGetAll("event_order_house_{$eid}");
                if($event)
                {
                    if($event['states']==0)
                    {
                        $this->logout();
                    }
                    $chooselog = $redisDriver->hGetAll("dlsx_order_house_{$eid}_{$cphone}");
                    if(!$chooselog || !$chooselog['sid']){//登录已失效
                        $this->logout();
                    }
                    else {
                        if (session_id()<> $chooselog['sid'])//同一手机号只能一台手机登录
                        {
                            $this->logout();
                        }
                    }
                    if(!$chooselog||$chooselog['status']==0){//用户已禁用
                        $this->logout();
                    }
                }
                else
                {
                    $dqev =D("EventOrderHouse")->where("id={$eid}")->find();
                    if($dqev['states']==0)
                    {
                        $this->logout();
                    }
                }
            }
            else
            {
                $this->logout();
            }
            parent::_initialize();
	}
    
    
    
	/**
        * 首页
        *
        * @create 2016-8-25
        * @author zlw
	*/
        public function index() 
	{
            $id = I('id', '', 'intval');
            //$eventId = I('eventId', 0, 'intval');
           
            $this->assign("id",$id);
            //$this->assign('eventId', $eventId);
        
		if (empty($id) || $id == 0) {
			$this->error("ID不能为空，请访问其他房间！", U("saler/project/index"));
		}
		
		$room = D("Common/Roomview")->getOneById($id);//
		if (empty($room)) {
			$this->error("房间信息不存在，请访问其他房间！", U("saler/project/index"));
		}
		$this->assign('room', $room);
		
		$build_id = $room['bld_id'];
		$project_id = $room['proj_id'];
		$this->assign("project_id",$project_id);
                
                $count=$this->get_bx_count($project_id);
                $this->assign("cou",$count);
                
		//项目
		$project = D("Common/Project")->getProjectById($project_id);
		$this->assign('project', $project);
		
		//楼栋
		$build = D("Common/Build")->getBuildById($build_id);
		$this->assign('build', $build);
		
		//房间属性
		$room_attribute = D("Common/Roomattribute")->getAttributeListByRoomId($id);
		$this->assign('room_attribute', $room_attribute);
		
		//热力指数
                $hot_num = $this -> roomrlzs($room_attribute,$project_id);
		$this->assign('hot_num', $hot_num);
		
		//用户ID
		$cst_id = $this->get_customer_id();

        //户型信息
        $hxwhere = [
            'fields' => '*'
            , 'where' => [
                'project_id' => $room['proj_id']
                , 'batch_id' => $room['pc_id']
                , 'hx' => $room['hx']
                , '2=2'
            ]
        ];

        $hxinfo = D('hxset')->find($hxwhere);
        $this->assign('hxinfo', $hxinfo);
//                echo json_encode($hxinfo);exit;
		//收藏
		$collection = D("Common/Collection")->getOneByRoomIdAndCstId($id, $cst_id);
		$this->assign('collection', $collection);
		
		//更改点击
		D("Common/Roomattribute")->incAttributeDjcountByRoomId(1, $id);
		
		$this->set_seo_title($room['buildname']."-".$room['unit']."-".$room['room']);
        $this->display();		
	}

    /**
     * 显示房间
     *
     * @create 2017-04-25
     * @author jxw
     */
    public function showroom() {
        /*$id = I('id', '', 'intval');
        $eventId = I('eventId', 0, 'intval');*/
        
        $info = I('info', 0, 'trim');
        $einfo = geturl($info, getUrlkey());
        $eventId = $einfo['eventId'];
        $id = $einfo['rid'];
 
        if (empty($id) || $id == 0) {
            $this->error("ID不能为空，请访问其他房间！");
        }
        if (empty($eventId) || $eventId == 0) {
            $this->error("活动ID不能为空！");
        }

        $redis = new \Redis();
        $redis->connect(C('REDIS_HOST'));

        $room = $redis->hGetAll("event_order_house_{$eventId}_room_{$id}");
        if (empty($room))
        {
            $room=M(roomlist)->where("id=".$id)->find();
            $room["jminfo"]=$info;
        }
        $isRoomOrdered = $redis->sIsMember("event_order_house_{$eventId}_room_ordered",$id);//房间是否已出售
        $cphone = rsa_decode(session('phone'),getChoosekey());
        if (empty($room)) {
            $this->error("房间信息不存在，请访问其他房间！", U("saler/project/index"));
        }
        if ( ($isRoomOrdered || $room['status']>0) && $cphone !=$room['schedule_phone'])
            $room["is_xf"]=1;
        
        $this->assign('room', $room);
        $room_attribute = D("Common/Roomattribute")->getAttributeListByRoomId($id);
        $this->assign('room_attribute', $room_attribute);

        //热力指数
        $hot_num = $this->roomrlzs($room_attribute, $room['project_id']);
        $this->assign('hot_num', $hot_num);

        //用户ID
        //$cst_id = $this->get_customer_id();
        $cst_id = session("chooseuid");
        
         //用户信息
        $chooseModel = M('choose');
        $cuserinfo = $chooseModel->find(array(
            'where'=>array('id'=>session("chooseuid"),'customer_phone'=>session('phone'))
        ));
        $cuserinfo['customer_phone']=rsa_decode(session('phone'),getChoosekey());
        $cuserinfo['cardno']=rsa_decode($cuserinfo['cardno'],getChoosekey());
        $this->assign('userinfo',$cuserinfo);
        

        //收藏
        $collection = D("Common/Collection")->getOneByRoomIdAndEventid($id, $cst_id,$eventId);
        $this->assign('collection', $collection);
        
        //用户所有收藏
        $eventOrderHouseModel = D('Common/EventOrderHouse');
        $event = $eventOrderHouseModel->getEventByEventId($eventId);
        $where = array('cst_id'=>$cst_id,'proj_id'=>$event['project_id']);
        $roomCollectionModel = D('Common/Collection');
        $roomCollected = $roomCollectionModel->getList($where);
        //整理用户收藏
        foreach ($roomCollected as $key=>$item) {
            $rooma = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$eventId}_room_{$item['room_id']}");
            if (empty($rooma))
            {
                unset($roomCollected[$key]);
            }
            else
            {
                $roomCollected[$key] = $rooma;
            }
        }
        $this->assign('roomCollected' ,json_encode($roomCollected));

        $is_cgrg = 0;
        $options = [
            'fields' => 'count(1) as count,code,id'
            , 'where' => [
                'event_id' => $eventId
                , 'belong_phone' => $cphone
                , 'room_id' => $id
                , '1=1'
            ]
        ];
        $cgroom = D('OrderHouseOrder')->find($options);
        if (!empty($cgroom)) {
            $is_cgrg = 1;
            $cgroom["oinfo"]=encrypt_url("eventId/{$eventId}/oid/{$cgroom['id']}", getUrlkey());
        }
        $this->assign('cgroom', $cgroom);
        
        //用户已认购的房间
        $orderHouseOrderModel = D('OrderHouseOrder');

        $orderedRooms = $orderHouseOrderModel->find(array(
            'where'=>array('event_id'=>$eventId,'belong_phone'=>$cphone)
        ));
        $this->assign('orderedRooms', $orderedRooms);
        
        $dqhm=$this->getMillisecond();
        $time = 0;
        if ($dqhm<$event['start_time']*1000)//活动未开始时，返回活动开始倒计时time和整个活动时长time1
        {
            $time=$event['start_time']*1000-$dqhm;
            $time1=$event['end_time']*1000-$event['start_time']*1000;
            $this->assign('iswks',1);
            $this->assign('time1',$time1);
        }
        else {//活动已开始，返回的time和time1一样
           $time = $event['end_time']*1000-$dqhm;
           if($dqhm>$event['end_time']*1000){
               $this->assign('iswks',-1);//活动已结束
               $time=0;
           }
           else
           {
               $this->assign('iswks',0);
           }
           $this->assign('time1',$time);
        }
        //活动倒计时
        $this->assign('time',$time);
        
        //项目信息
        if($room)
        {
            $projinfo=M(project)->where("id=".(empty($room['project_id']) ? $room['proj_id'] : $room['project_id']))->find();
            $this->assign('projinfo',$projinfo);
        }
        
        //户型信息
         $hxwhere = [
            'fields' => '*'
            , 'where' => [
                'project_id' => (empty($room['project_id']) ? $room['proj_id'] : $room['project_id'])
                , 'batch_id' => (empty($room['batch_id']) ? $room['pc_id'] : $room['batch_id'])
                , 'hx' => $room['hx']
                , '222=222'
            ]
        ];
        $hxinfo = D('hxset')->find($hxwhere);
        $this->assign('hxinfo', $hxinfo);
        //项目平面图
        $kppcinfo=D('kppc')->find("{$room['batch_id']} and proj_id={$room['project_id']}");
        $this->assign('kppcinfo', $kppcinfo);
        
        //更改点击
        D("Common/Roomattribute")->incAttributeDjcountByRoomId(1, $id);

        $this->assign('eventId', cookie("eventId"));
        $this->assign('event',$event);

        $this->set_seo_title("房间明细");
        $this->display();
    }
    
    //当前时间戳(包含毫秒)
    public function getMillisecond() { 
        list($s1, $s2) = explode(' ', microtime()); 
        return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000); 
    }
    
    public function logout(){
        $eid=cookie('eventId');
        //$redisDriver = new Redis();
        //$eid=cookie('eventId');
        //$cphone=cookie('phone');
        //$redisDriver->del("event_order_house_{$eid}_{$cphone}_dlsx");
        session_unset();
        session_destroy();
        cookie('order_house_code',NULL);
        cookie('phone',NULL);
        cookie('realName',NULL);
        cookie('chooseuid',NULL);
        cookie('eventId',NULL);
        cookie('first_vist', NULL);
        cookie('user_id', NULL);
        $this->redirect("OrderHouse/privilege", ['info' => $eid]);
    }

}

