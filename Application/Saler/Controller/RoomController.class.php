<?php

namespace Saler\Controller;
use Think\Cache\Driver\Redis;


/**
 * 房间详情
 *
 * @create 2016-9-1
 * @author zlw
 */
class RoomController extends BaseController 
{

	
	/**
	 * 首页
	 *
	 * @create 2016-8-25
	 * @author zlw
	 */
    public function index() 
	{
	    //权限查询
        //先查询权限情况
        $uid=$this->get_user_id();
        $on_xk=M()->table("xk_station2user su")->join("xk_fun_station fs ON fs.station_id=su.station_id")->where("userid=$uid AND fs.fun_id=104")->find();
        $reset_xk=M()->table("xk_station2user su")->join("xk_fun_station fs ON fs.station_id=su.station_id")->where("userid=$uid AND fs.fun_id=105")->find();
        $this->assign("on_xk",$on_xk);
        $this->assign("reset_xk",$reset_xk);
		$id = I('id', '', 'intval');
		$hid = I('hid', '', 'intval');
		$this->assign("search_hd_id",$hid);
		if (empty($id) || $id == 0) {
			$this->error("ID不能为空，请访问其他房间！", U("saler/project/index"));
		}
		
		//$room = D("Common/Room")->getRoomById($id);
                $Model = new \Think\Model();
                $room = D("Common/Roomview")->getOneById($id);//
		if (empty($room)) {
			$this->error("房间信息不存在，请访问其他房间！", U("saler/project/index"));
		}
		$this->assign('room', $room);
		$this->assign('room_id', $id);

		$build_id = $room['bld_id'];
		$project_id = $room['proj_id'];
        $this->assign("search_project_id",$project_id);
		$user_where['userid'] = $this->get_user_id();
		$user_where['projid'] = $project_id;
		$user_project_list = D("Station")->getpProjectListByUserId($user_where['userid'], $user_where['projid']);
		if (empty($user_project_list)) {
			$this->error('你没有该项目，请选择其他项目！', U('index/index'));
		}
		
		//项目
		$project = D("Common/Project")->getProjectById($project_id);
		$this->assign('project', $project);
		
		//楼栋
		$build = D("Common/Build")->getBuildById($build_id);
		$this->assign('build', $build);
		
		//房间属性
		$room_attribute = D("Common/Roomattribute")->getAttributeListByRoomId($id);
		$this->assign('room_attribute', $room_attribute);
                
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
                
                //是否有相关的微信认购记录
                $orderwx=D(OrderHouseOrder)->getOne(" room_id=".$id);
                if($orderwx)
                {
                    $this->assign('iswx', 1);
                    print_r(1);
                }
                else
                {
                    $this->assign('iswx', 0);
                    print_r(0);
                }
		
		//热力指数
		$hot_num = $this -> roomrlzs($room_attribute,$project_id);
		$this->assign('hot_num', $hot_num);
		$this->assign('type', session("type"));
                
                //第一意向
                $first_count=M()->table('xk_cst2rooms cr')->where("cr.room_id=$id")->group("cr.room_id")->count();
                $this->assign('first_count', $first_count);

		//更改点击
		D("Common/Roomattribute")->incAttributeDjcountByRoomId(2, $id);

        $this->display();		
	}

	/*
	 * 2017-10-13
	 * 销控房间
	 * qzb*/
    public function xk_room() {
        $pd = I("pd", 0, "intval");
        $uid = $this->get_user_id();
        $rid = I("rid", 0, "intval");
        $user = M()->table("xk_user")->field("name")->where("id=$uid")->find();
        $roominfo = M()->table("xk_roomlist")->where("id=$rid")->find();
        if(empty($roominfo))
        {
            echo "房间不存在!";
            exit;
        }
        $event=M()->table("xk_event_order_house")
                ->where("states=1 and project_id={$roominfo['proj_id']} and batch_id={$roominfo['pc_id']} and unix_timestamp(now())<= end_time and unix_timestamp(now())>=start_time")
                ->find();
        $data = [];
        if ($pd == 0) {
            if($event)
            {
                 //查看活动是否存在
                $eventOrderHouseModel = D('Common/EventOrderHouse');
                $event_r = $eventOrderHouseModel->getEventByEventId($event['id']);
                if($event_r){
                    $eventId=$event['id'];
                    $expire_time = $event['end_time'] - time();
                    $redis = new Redis();
                    $ygrooms=$redis->hGetAll("event_order_house_{$eventId}_room_order_member");
                    foreach ($ygrooms as $ygroom) {
                        if($ygroom==$rid)
                        {
                             echo "预定房间不能操作!";
                             exit;
                        }
                    }
                    $isRoomOrdered = $redis->sIsMember("event_order_house_{$eventId}_room_ordered",$rid);
                    if($isRoomOrdered)
                    {
                        echo "房间已售!";
                        exit;
                    }
                    
                    $getLock = 0;
                    $room = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$eventId}_room_{$rid}");
                    if ($room['status']===1){
                        echo "房间已售!";
                        exit;
                    }
                    else
                    {
                        $getLock = $redis->setnx("event_order_house_{$eventId}_room_{$rid}_locked",1);
                    }
                    if ($getLock){
                        $redis->expire("event_order_house_{$eventId}_room_{$rid}_locked",10);
                    }else{
                        echo "请稍后重试!";
                        exit;
                    }

                    try{
                        $redis->set("event_order_house_{$eventId}_room_{$rid}_locked",1,$expire_time);
                        $redis->hSet("event_order_house_{$eventId}_room_{$rid}",'status',1);
                        $redis->hSet($eventRedisKey,$eventField,$event[$eventField]);
                        //添加已认购的房间
                        $redis->sAdd("event_order_house_{$eventId}_room_ordered",$rid);
                    }catch (\Exception $e){
                        $redis->del("event_order_house_{$eventId}_room_{$rid}_locked");
                        $redis->hSet("event_order_house_{$eventId}_room_{$rid}",'status',0);
                        $redis->sRem("event_order_house_{$eventId}_room_ordered",$rid);
                        echo "请稍后重试1!";
                        exit;
                    }
                }
            }
            
            M()->table("xk_room")->where("id=$rid")->save(["is_xf" => 1, 'xftime' => time()]);
            $data['room_id'] = $rid;
            $data['cztype'] = '销控';
            $data['cztime'] = time();
            $data['czuser'] = $uid;
            $data['czusername'] = $user['name'];
            M()->table("xk_roomczlog")->add($data);
  
        } elseif ($pd == 1) {
            $order=M()->table("xk_order_house_order")->where("room_id = {$rid}")->find();
            if($order){
               echo "房间已售!";
               exit;
            }
            if($event)
            {
                 //查看活动是否存在
                $eventOrderHouseModel = D('Common/EventOrderHouse');
                $event_r = $eventOrderHouseModel->getEventByEventId($event['id']);
                if($event_r){
                    $eventId=$event['id'];
                    $expire_time = $event['end_time'] - time();
                    $redis = new Redis();
                    $ygrooms=$redis->hGetAll("event_order_house_{$eventId}_room_order_member");
                    foreach ($ygrooms as $ygroom) {
                        if($ygroom==$rid)
                        {
                             echo "预定房间不能操作!";
                             exit;
                        }
                    }
                    try{
                        $redis->del("event_order_house_{$eventId}_room_{$rid}_locked");
                        $redis->hSet("event_order_house_{$eventId}_room_{$rid}",'status',0);
                        $redis->sRem("event_order_house_{$eventId}_room_ordered",$rid);
                    }catch (\Exception $e){
                        $redis->set("event_order_house_{$eventId}_room_{$rid}_locked",1,$expire_time);
                        $redis->hSet("event_order_house_{$eventId}_room_{$rid}",'status',1);
                        $redis->sAdd("event_order_house_{$eventId}_room_ordered",$rid);
                        echo "请稍后重试!";
                        exit;
                    }
                }
            }
            
            M()->table("xk_room")->where("id=$rid")->save(["is_xf" => 0, "cstid" => 0]);
            $data['room_id'] = $rid;
            $data['cztype'] = '取消销控';
            $data['cztime'] = time();
            $data['czuser'] = $uid;
            $data['czusername'] = $user['name'];
            M()->table("xk_roomczlog")->add($data);
        } else {
            
            $order=M()->table("xk_order_house_order")->where("room_id = {$rid}")->find();
            if($order){
               echo "房间已售!";
               exit;
            }
            if($event)
            {
                 //查看活动是否存在
                $eventOrderHouseModel = D('Common/EventOrderHouse');
                $event_r = $eventOrderHouseModel->getEventByEventId($event['id']);
                if($event_r){
                    $eventId=$event['id'];
                    $expire_time = $event['end_time'] - time();
                    $redis = new Redis();
                    $ygrooms=$redis->hGetAll("event_order_house_{$eventId}_room_order_member");
                    foreach ($ygrooms as $ygroom) {
                        if($ygroom==$rid)
                        {
                             echo "预定房间不能操作!";
                             exit;
                        }
                    }
                    try{
                        $redis->del("event_order_house_{$eventId}_room_{$rid}_locked");
                        $redis->hSet("event_order_house_{$eventId}_room_{$rid}",'status',0);
                        $redis->sRem("event_order_house_{$eventId}_room_ordered",$rid);
                    }catch (\Exception $e){
                        $redis->set("event_order_house_{$eventId}_room_{$rid}_locked",1,$expire_time);
                        $redis->hSet("event_order_house_{$eventId}_room_{$rid}",'status',1);
                        $redis->sAdd("event_order_house_{$eventId}_room_ordered",$rid);
                        echo "请稍后重试!";
                        exit;
                    }
                }
            }
            
            M()->table("xk_room")->where("id=$rid")->save(["is_xf" => 0, "cstid" => 0]);
            $data['room_id'] = $rid;
            $data['cztype'] = '取消选房';
            $data['cztime'] = time();
            $data['czuser'] = $uid;
            $data['czusername'] = $user['name'];
            M()->table("xk_roomczlog")->add($data);
        }
        echo "true";
        exit;
    }

}

