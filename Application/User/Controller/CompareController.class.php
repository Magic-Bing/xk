<?php

namespace User\Controller;

/**
 * 房源对比
 *
 * @create 2016-9-1
 * @author zlw
 */
class CompareController extends BaseController 
{

	
	/**
	 * 首页
	 *
	 * @create 2016-9-1
	 * @author zlw
	 */
    public function index() 
	{
		$this->error('方法不存在！');
	}

	
	/**
	 * 房间比对
	 *
	 * @create 2016-8-30
	 * @author zlw
	 */
    public function room() 
	{
		$ids = I('ids', '', 'trim');
		if (empty($ids)) {
                  //  $this->error("房间选择不能为空，请重试！");
		}
                $orderHouse=new OrderHouseController();
                $eventId=$orderHouse->getEventId();

		$ids = explode(',', $ids);
		$where['id'] = array('in', $ids);
		
		//获取房间列表
		//$rooms = D("Common/Room")->getRoomList($where, 'no ASC');
                $rooms = D("Common/Room")->getRoomListJoinhx($where, 'no ASC');
		if (empty($rooms)) {
			$this->error("房间信息不存在，请重试！", U("User/OrderHouse/index/info/" . encrypt_url("eventId/{$eventId}", getUrlkey()) .""));
		}
		$this->assign('rooms', $rooms);
		
		//房间个数
		$rooms_count = count($rooms);
		$this->assign('rooms_count', $rooms_count);
		
		//获取房间属性列表
                $where1['room_id'] = array('in', $ids);
		$room_old_attributes = D("Common/Roomattribute")->getAttributeList($where1, 'room_id ASC');
		$room_attributes = array();
		foreach ($room_old_attributes as $room_attributes_key => $room_attribute) {
			$room_attribute['hot_num'] = $this->roomrlzs($room_attribute, $rooms[0]['proj_id']);
			$room_attributes[$room_attribute['room_id']] = $room_attribute;
		}
		$this->assign('room_attributes', $room_attributes);
		
		//更改比对数据
		foreach ($ids as $ids_key => $ids_value) {
			D("Common/Roomattribute")->editAttributeCompareByRoomId(1, $ids_value);
		}
		
		//项目
		$old_project_list = D('Common/Project')->getProjectList(array(
			'status' => 1
		), 'id ASC');
		
		$project_list = array();
		foreach ($old_project_list as $project_key => $project) {
			$project_list[$project['id']] = $project;
		}
		$this->assign('projects', $project_list);
		
		//楼栋
		$old_build_list = D('Common/Build')->getBuildList(array(), 'buildname, id DESC');
		
		$build_list = array();
		foreach ($old_build_list as $build_key => $build) {
			$build_list[$build['id']] = $build;
		}
		$this->assign('builds', $build_list);
		
		//收藏的房间ID
                unset($where);
		$where['cst_id'] 	= session("chooseuid");
		$where['room_id'] 	= array('in', $ids);
		$room_collection = D('Common/Collection')->getList($where);
		
		$collection_room_ids = array();
		foreach ($room_collection as $room_collection_key => $room_collection_value) {
			$collection_room_ids[] = $room_collection_value['room_id'];
		}  
		$this->assign('collection_room_ids', $collection_room_ids);

		$this->assign('eventId',$eventId);
                  
                $eventOrderHouseModel = D('Common/EventOrderHouse');
                $event = $eventOrderHouseModel->getEventByEventId($eventId);//redis获取
                //用户收藏
                $this->get_customer_id();
                $where = array('cst_id'=>session("chooseuid"),'proj_id'=>$event['project_id']);
                $roomCollectionModel = D('Common/Collection');
                $roomCollected = $roomCollectionModel->getList($where);
                //整理用户收藏
                foreach ($roomCollected as $key=>$item) {
                    $room = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$eventId}_room_{$item['room_id']}");
                    if (empty($room))
                    {
                        unset($roomCollected[$key]);
                    }
                    else
                    {
                        $roomCollected[$key] = $room;
                    }
                }

                //用户已预定的房间
                $orderHouseOrderModel = D('OrderHouseOrder');

                $orderedRoom = $orderHouseOrderModel->find(array(
                    'where'=>array('event_id'=>$eventId,'belong_phone'=>session('phone'))
                ));
                if (!$orderedRoom)
                {
                    $orderedRoom=array();
                }
                 //用户收藏的房间
                $this->assign('roomCollected',json_encode($roomCollected));

                //用户已经预定的房间
                $this->assign('orderedRoom',$orderedRoom);

		$this->set_seo_title("房源对比");
                $this->display();
	}

	//房间对比，无缓存
    public function room2()
    {
        $ids = I('ids', '', 'trim');
        if (empty($ids)) {
            $this->error("房间选择不能为空，请重试！", U("saler/project/index"));
        }

        $eventId = I('get.eventId',0,'intval');
        $count=$this->get_bx_count($eventId);
        $this->assign("cou",$count);
        $ids = explode(',', $ids);
        $where['id'] = array('in', $ids);

        //获取房间列表
        //$rooms = D("Common/Room")->getRoomList($where, 'no ASC');
        $rooms = D("Common/Room")->getRoomListJoinhx($where, 'no ASC');
        if (empty($rooms)) {
            $this->error("房间信息不存在，请重试！", U("User/index/index/info/p" .$eventId .".html"));
        }
        $this->assign('rooms', $rooms);

        //房间个数
        $rooms_count = count($rooms);
        $this->assign('rooms_count', $rooms_count);

        //获取房间属性列表
        $room_old_attributes = D("Common/Roomattribute")->getAttributeList($where, 'room_id ASC');
        $room_attributes = array();
        foreach ($room_old_attributes as $room_attributes_key => $room_attribute) {
            $room_attribute['hot_num'] = $this->roomrlzs($room_attribute, $rooms[0]['proj_id']);
            $room_attributes[$room_attribute['room_id']] = $room_attribute;
        }
        $this->assign('room_attributes', $room_attributes);

        //更改比对数据
        foreach ($ids as $ids_key => $ids_value) {
            D("Common/Roomattribute")->editAttributeCompareByRoomId(1, $ids_value);
        }

        //项目
        $old_project_list = D('Common/Project')->getProjectList(array(
            'status' => 1
        ), 'id ASC');

        $project_list = array();
        foreach ($old_project_list as $project_key => $project) {
            $project_list[$project['id']] = $project;
        }
        $this->assign('projects', $project_list);

        //楼栋
        $old_build_list = D('Common/Build')->getBuildList(array(), 'buildname, id DESC');

        $build_list = array();
        foreach ($old_build_list as $build_key => $build) {
            $build_list[$build['id']] = $build;
        }
        $this->assign('builds', $build_list);

        //收藏的房间ID
        unset($where);
        $where['cst_id'] 	= session("user_id");
        if(!$where['cst_id']){
            $where['cst_id'] 	= cookie("user_id");
        }
        $where['room_id'] 	= array('in', $ids);
        $room_collection = D('Common/Collection')->getList($where);

        $collection_room_ids = array();
        foreach ($room_collection as $room_collection_key => $room_collection_value) {
            $collection_room_ids[] = $room_collection_value['room_id'];
        }
        $this->assign('collection_room_ids', $collection_room_ids);

        $this->assign('eventId',$eventId);

        //用户收藏
        $this->get_customer_id();
        $where = array('cst_id'=>session("chooseuid"),'proj_id'=>$eventId);
        $roomCollectionModel = D('Common/Collection');
        $roomCollected = $roomCollectionModel->getList($where);

        //用户已预定的房间
        $orderHouseOrderModel = D('OrderHouseOrder');

        $orderedRoom = $orderHouseOrderModel->find(array(
            'where'=>array('event_id'=>$eventId,'belong_phone'=>session('phone'))
        ));
        if (!$orderedRoom)
        {
            $orderedRoom=array();
        }
        //用户收藏的房间
        $this->assign('roomCollected',json_encode($roomCollected));

        //用户已经预定的房间
        $this->assign('orderedRoom',$orderedRoom);

        $this->set_seo_title("房源对比");
        $this->display();
    }


}
