<?php

namespace Saler\Controller;


/**
 * 热销排行
 *
 * @create 2016-9-1
 * @author zlw
 */
class HotController extends BaseController 
{

	
	/**
	 * 首页
	 *
	 * @create 2016-9-1
	 * @author zlw
	 */
    public function index() 
	{
		//collection 收藏，comparison 对比，follow 关注
		$now_type = I('type', '', 'strtolower,trim');
		if (!in_array($now_type, array('collection', 'comparison', 'follow'))) {
			$now_type = 'collection';
		}
		$this->assign('now_type', $now_type);
                $this->assign('type', session("type"));
		
		//分析
		$search_info = I('info', '', 'trim');
		$search_project_id = get_search_id_by($search_info, 'p');
		if ($search_project_id == 0) {
			$this->error('项目不存在，请查看其他项目！', U('index/index'));
		}
		
		//设置当前搜索
		$search = array(
			'search_project_id' => $search_project_id,
		);
		$this->assign($search);
		
		//获取项目
		$Project = D('Common/Project');
		$project_info = $Project->getProjectById($search_project_id);
		$this->assign('project', $project_info);

		//判断是否该项目
		$user_where['userid'] = $this->get_user_id();
		$user_where['projid'] = $search_project_id;
		$user_project_list = D("Station")->getpProjectListByUserId($user_where['userid'], $user_where['projid']);
		if (empty($user_project_list)) {
			$this->error('你没有该项目，请选择其他项目！', U('index/index'));
		}
		
		//户型
		$Room = D('Common/Room');
                $Roomview = D('Common/Roomview');
		$hx_list = $Roomview->getRoomListGroupBy('hx', 'hx', 'hx ASC', array());
		$this->assign('hx_list', $hx_list);
		
		//户型列表
		$hxs = array();
		foreach ($hx_list as $hx_list_value) {
			$hxs[] = $hx_list_value;
		}
		
		//当前户型
		$now_hx = I('hx', '', 'strtolower,trim');
		$now_hxs = explode(',', $now_hx);
		$this->assign('now_hxs', $now_hxs);

		//当前查询key
		switch ($now_type) {
			case 'comparison':
				$now_attribute_key = 'sscount';
				$attribute_where['sscount'] = array('NEQ', 0);
				$attribute_order_by = 'sscount DESC';
				$sub_title = '对比次数';
				break;				
			case 'follow':
				$now_attribute_key = 'djcount';
				$attribute_where['djcount'] = array('NEQ', 0);
				$attribute_order_by = 'djcount DESC';	
				$sub_title = '关注次数';
				break;
			case 'collection':
			default: 
				$now_attribute_key = 'sccount';
				$attribute_where['sccount'] = array('NEQ', 0);
				$attribute_order_by = 'sccount DESC';				
				$sub_title = '收藏次数';
				break;
		}
		if (!empty($now_hxs[0])) {
			$attribute_where['hx'] = array('in', $now_hxs);
		}
		$attribute_where['proj_id'] = $search_project_id;
		
		//收藏
		$attribute_list = D("Common/Roomattribute")->getAttributeListJoinRoom(
			$attribute_where, 
			$attribute_order_by, 
			'room_id, round(djcount/2,0) as djcount, sccount, round(sscount/2,0) as sscount',
			10
		);
		
		$max_count = $attribute_list[0][$now_attribute_key];
		foreach ($attribute_list as $attribute_list_key => $attribute_list_value) {
			$attribute_list[$attribute_list_key]['precision'] = round(($attribute_list_value[$now_attribute_key]/$max_count)*100, 2).'%';
			$attribute_list[$attribute_list_key]['now_count'] = $attribute_list_value[$now_attribute_key];
		}
		$this->assign('attribute_list', $attribute_list);
		
		//房间ID列表
		$room_ids = array();
		foreach ($attribute_list as $attribute) {
			$room_ids[$attribute['room_id']] = $attribute['room_id'];
		}
		
		//获取房间列表
		if (!empty($room_ids)) {
			$where['id'] = array('in', $room_ids);
			if (!empty($now_hxs[0])) {
				$where['hx'] = array('in', $now_hxs);
			}
			$where['proj_id'] = $search_project_id;
			$room_list = D("Common/Room")->getRoomList($where);
		} else {
			$room_list = array();
		}
		
		$build_ids = array();
		$new_room_list = array();
		foreach ($room_list as $room_list_k => $room_list_v) {
			$build_ids[$room_list_v['bld_id']] = $room_list_v['bld_id'];
			$new_room_list[$room_list_v['id']] = $room_list_v;
		}
		
		$this->assign('room_list', $new_room_list);
		
		//获取相关楼栋
		if (!empty($build_ids)) {
			$Build = D('Common/Build');
			$where['id'] = array('in', $build_ids);
			$old_build_list = $Build->getBuildList($where, 'buildname, id DESC');
		} else {
			$old_build_list = array();
		}
		
		$build_list = array();
		foreach ($old_build_list as $key => $build) {
			$build_list[$build['id']] = $build;
		}
		$this->assign('build_list', $build_list);
		
		//二级标题
		$this->assign('sub_title', $sub_title);
		
		if (IS_AJAX) {
			$this->display('sale');
		} else {
            $this->set_seo_title($project_info['name']);
			$this->display();
		}
	}

	
}



















