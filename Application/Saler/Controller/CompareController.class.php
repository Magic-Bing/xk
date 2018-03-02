<?php

namespace Saler\Controller;


/**
 * 房源对比
 *
 * @create 2016-9-1
 * @author zlw
 */
class CompareController extends Base1Controller 
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
			$this->error("房间选择不能为空，请重试！", U("saler/project/index"));
		}
        $this->assign("search_project_id",I("pid",0,"intval"));
		$ids = explode(',', $ids);
		$where['id'] = array('in', $ids);
		
		//获取房间列表
		$rooms = D("Common/Room")->getRoomList($where, 'no ASC');
		if (empty($rooms)) {
			$this->error("房间信息不存在，请重试！", U("saler/project/index"));
		}
		$this->assign('rooms', $rooms);

		$user_where['userid'] = $this->get_user_id();
		$user_where['projid'] = $rooms[0]['proj_id'];
		$user_project_list = D("Station")->getpProjectListByUserId($user_where['userid'], $user_where['projid']);
		if (empty($user_project_list)) {
			$this->error('你没有该项目，请选择其他项目！', U('index/index'));
		}
		
		//房间个数
		$rooms_count = count($rooms);
		$this->assign('rooms_count', $rooms_count);
		
		//获取房间属性列表
                $where1['room_id'] = array('in', $ids);
		$room_old_attributes = D("Common/Roomattribute")->getAttributeList($where1, 'room_id ASC');
		$room_attributes = array();
		foreach ($room_old_attributes as $room_attributes_key => $room_attribute) {
                        $room_attribute['hot_num']=$this->roomrlzs($room_attribute, $rooms[0]['proj_id']);  
                        $room_attributes[$room_attribute['room_id']] = $room_attribute;
                        $first_count=M()->table('xk_cst2rooms cr')->where("cr.room_id=". $room_attribute['room_id'] ." and px=1")->group("cr.room_id")->count();
                        $room_attributes[$room_attribute['room_id']]['first_count'] = $first_count;
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
                $this->assign('type', session("type"));
		
//		$this->set_seo_title($project_list[$rooms[0]['proj_id']]['name']);
        $this->display();
	}

    /**
     * 电子开盘房间比对
     *
     * @create 2018-3-2
     * @author qzb
     */
    public function dz_room()
    {
        $ids = I('ids', '', 'trim');
        if (empty($ids)) {
            $this->error("房间选择不能为空，请重试！", U("saler/project/index"));
        }
        $this->assign("pid",I("p",0,"intval"));
        $this->assign("bid",I("b",0,"intval"));
        $ids = explode(',', $ids);
        $where['id'] = array('in', $ids);

        //获取房间列表
        $rooms = D("Common/Room")->getRoomList($where, 'no ASC');
        if (empty($rooms)) {
            $this->error("房间信息不存在，请重试！", U("saler/project/index"));
        }
        $this->assign('rooms', $rooms);

        $user_where['userid'] = $this->get_user_id();
        $user_where['projid'] = $rooms[0]['proj_id'];
        $user_project_list = D("Station")->getpProjectListByUserId($user_where['userid'], $user_where['projid']);
        if (empty($user_project_list)) {
            $this->error('你没有该项目，请选择其他项目！', U('index/index'));
        }

        //房间个数
        $rooms_count = count($rooms);
        $this->assign('rooms_count', $rooms_count);

        //获取房间属性列表
        $where1['room_id'] = array('in', $ids);
        $room_old_attributes = D("Common/Roomattribute")->getAttributeList($where1, 'room_id ASC');
        $room_attributes = array();
        foreach ($room_old_attributes as $room_attributes_key => $room_attribute) {
            $room_attribute['hot_num']=$this->roomrlzs($room_attribute, $rooms[0]['proj_id']);
            $room_attributes[$room_attribute['room_id']] = $room_attribute;
            $first_count=M()->table('xk_cst2rooms cr')->where("cr.room_id=". $room_attribute['room_id'] ." and px=1")->group("cr.room_id")->count();
            $room_attributes[$room_attribute['room_id']]['first_count'] = $first_count;
        }

        $this->assign('room_attributes', $room_attributes);

        //更改比对数据
        foreach ($ids as $ids_key => $ids_value) {
            D("Common/Roomattribute")->editAttributeCompareByRoomId(1, $ids_value);
        }



        //楼栋
        $old_build_list = D('Common/Build')->getBuildList(array(), 'buildname, id DESC');

        $build_list = array();
        foreach ($old_build_list as $build_key => $build) {
            $build_list[$build['id']] = $build;
        }
        $this->assign('builds', $build_list);
        $this->display();
    }
}
