<?php

namespace Admin\Controller;


/**
 * 房间管理
 *
 * @create 2016-9-30
 * @author zlw
 */
class RoomController extends BaseController 
{
	
	
	/**
	 * 房间列表
	 *
	 * @create 2016-9-30
	 * @author zlw
	 */
    public function index()
    {
		//分析
		$search_project_id = I('get.project_id', '', 'intval');
		if ($search_project_id == 0 || empty($search_project_id)) {
			//$this->error("项目不存在，请访问其他项目！", U("index/room"));
			$search_project_id = 3;
		}

		//归类
		$Room = D('Common/Room');
		$Roomview = D('Common/Roomview');
		$where['proj_id'] = $search_project_id;
		$where['is_dq'] = 1;
		$group_room_build = $Roomview->getRoomListGroupBy('bld_id', 'bld_id', 'bld_id, id', $where);
		$group_room_unit = $Roomview->getRoomListGroupBy('bld_id, unit', 'bld_id, unit', 'bld_id, unit, id', $where);

		//数据格式化
		$new_group_room_unit = array();
		foreach ($group_room_unit as $group_room_unit_key => $group_room_unit_value) {
			$new_group_room_unit[$group_room_unit_value['bld_id']][] = $group_room_unit_value;
		}
		$this->assign('new_units', $new_group_room_unit);

		//设置当前搜索
		$search = array(
			'search_project_id' => $search_project_id,
		);
		$this->assign($search);

		//项目
		$Project = D('Common/Project');
		
		//获取项目
		$project_info = $Project->getProjectById($search_project_id);
		$this->assign('project', $project_info);
		
		//获取公司信息
		$company_id = $project_info['cp_id'];
		$company = D('Common/Company')->getOneById($company_id);
		$this->assign('company', $company);
		
		//获取项目列表
		$project_where['status'] = 1;
		$project_list = D('Common/ProjectView')->getList($project_where, 'company_id ASC, id ASC', '50');
		$this->assign('project_list', $project_list);

		//获取相关楼栋
		$build_ids = array();
		foreach ($group_room_build as $group_room_build_k => $group_room_build_v) {
			$build_ids[] = $group_room_build_v['bld_id'];
		}

		if (!empty($build_ids)) {
			$Build = D('Common/Build');
			unset($where);
			$where['id'] = array('in', $build_ids);
			$build_list = $Build->getBuildList($where, 'buildname, id DESC');
		} else {
			$build_list = array();
		}

		$build_new_list = array();
		foreach ($build_list as $key => $build) {
			$build_new_list[$build['id']] = $build;
		}
		$this->assign('builds', $build_new_list);

		//房间
		unset($where);
		$Roomview = D("Common/Roomview");
		$where['proj_id'] = $search_project_id;
		
		$room_count = $Roomview->where($where)->count();
		
		$Page 		= $this->page($room_count, 20);
		$page_show  = $Page->show();
		
		$room_list = $Roomview->getListLimit(
			$where, 
			'buildname ASC, unit ASC, floor ASC, room ASC',
			"*",
			$Page->firstRow.','.$Page->listRows
		);
		
		$this->assign('page', $page_show);
		
		$room_ids = array();
		foreach ($room_list as $room_list_key => $room_list_value) {
			$room_ids[] = $room_list_value['id'];
		}
		$this->assign('rooms', $room_list);
		
		//房间收藏信息列表
		if (!empty($room_ids)) {
			unset($where);
			$where['room_id'] = array('in', $room_ids);
			$collection_list = D("Common/Roomattribute")->getAttributeList($where, "room_id DESC", "*", 20);
		} else {
			$collection_list = array();
		}
		
		$new_collection_list = array();
		foreach ($collection_list as $collection_list_key => $collection_list_value) {
			$new_collection_list[$collection_list_value['room_id']] = $collection_list_value;
		}
		$this->assign('collection_list', $new_collection_list);

		$this->set_seo_title($project_info['name']);
        $this->display();
    } 
	
	
	/**
	 * 保存修改
	 *
	 * @create 2016-9-30
	 * @author zlw
	 */
	public function save()
	{
		if (!IS_AJAX) {
			$this->error("访问错误，请确认后重试！", U('index/index'));
		}
		
		$collection = I('post.collection', '0', 'intval');
		$comparison = I('post.comparison', '0', 'intval');
		$follow = I('post.follow', '0', 'intval');
		
		$room_id = I('post.room_id', '0', 'intval');
		if ($room_id == 0 || empty($room_id)) {
			$this->error("房间不存在，请确认后重试！", '');
		}
		
		$where['room_id'] = $room_id;
		
		$data['mock_sccount'] = $collection;
		$data['mock_sscount'] = $comparison;
		$data['mock_djcount'] = $follow;
		
		$check_has_edit = D("Common/Roomattribute")->editAllAttr($data, $where);
		if (false === $check_has_edit) {
			$this->error("修改失败，请确认后重试！", '');
		} else {
			$this->success("恭喜你，更改成功！", '');
		}
	}
	
	
	/**
	 * 修改房间信息
	 *
	 * @create 2016-10-12
	 * @author zlw
	 */
	public function edit()
	{
		if (IS_AJAX) {			
			$id = I('id', 0, 'intval');
			
			$hx = I('hx', '', 'trim');
			
			$build = I('build', '', 'trim');
			$unit = I('unit', '', 'trim');
			$floor = I('floor', '', 'trim');
			$no = I('no', '', 'trim');
			$area = I('area', '', 'trim');
			$tnarea = I('tnarea', '', 'trim');
			$price = I('price', '', 'trim');
			$tnprice = I('tnprice', '', 'trim');
			$total = I('total', '', 'trim');
			
			if ($id == 0 
				|| empty($build)
				|| empty($unit)
				|| empty($floor)
				|| empty($no)
				|| empty($area)
				|| empty($tnarea)
				|| empty($price)
				|| empty($tnprice)
				|| empty($total)
			) {
				$this->error("房间信息不能为空，请确认后重试！");
			}
			
			$Room = D('Common/Room');
	
			$where['id'] = $id;
			
			$data['hx'] = $hx;		
			$data['bld_id'] = $build;		
			$data['unit'] = $unit;		
			$data['floor'] = $floor;		
			$data['no'] = $no;		
			$data['area'] = $area;		
			$data['tnarea'] = $tnarea;		
			$data['price'] = $price;		
			$data['tnprice'] = $tnprice;		
			$data['total'] = $total;
			
			$chech_has_edit = $Room->editRoom($data, $where);
			if (false === $chech_has_edit) {
				$this->error("更改失败，请稍后重试！");
			} else {
				$this->success("恭喜你，更改成功！", '');
			}			
		} else {
			$id = I('id', 0, 'intval');
			if ($id == 0) {
				$this->error("房间不存在，请确认后重试！");
			}
			
			$room = D('Roomview')->getOneById($id);
			if (empty($room)) {
				$this->error("房间不存在，请确认后重试！");
			}
			
			$this->assign('room', $room);
	
			//项目
			$Project = D('Common/Project');
			$project_list = $Project->getProjectList(array(
				'status' => 1
			), 'name ASC, id ASC');
			$this->assign('projects', $project_list);
	
			//楼栋
			$Buildview = D('Common/Buildview');
			$builds_list = $Buildview->getList('distinct buildname, id', array(
				'proj_id' => $room['proj_id']
			), 'buildname ASC, id ASC');
			$this->assign('builds', $builds_list);

			$this->set_seo_title('房间信息修改');
			$this->display();
		}
	}
	
	
}









