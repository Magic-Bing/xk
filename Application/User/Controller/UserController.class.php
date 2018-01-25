<?php
namespace User\Controller;


/**
 * 个人中心
 *
 * @create 2016-9-1
 * @author zlw
 */
class UserController extends BaseController 
{
	public function index() 
	{		
		//分析
		$search_info = I('info', '', 'trim');
		$search_project_id = get_search_id_by($search_info, 'p');
		if( !empty($search_project_id)&& $search_project_id>0)
		{
			 $model = new \Think\Model();
			 $pclst=$model->query("select * from xk_kppc a where a.proj_id='". $search_project_id ."' and is_dq=1 order by id desc limit 1 ");
			 cookie('pc_id',$pclst[0]['id']);
			 cookie('proj_id',$pclst[0]['proj_id']);
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

		//分析
		$search_build_id = get_search_id_by($search_info, 'b', $group_room_build[0]['bld_id']);
		$search_unit_id = get_search_id_by($search_info, 'u', $new_group_room_unit[$search_build_id][0]['unit']);

		//获取楼层
		unset($where);
		$where['proj_id'] = $search_project_id;
		$where['bld_id'] = $search_build_id;
		$where['unit'] = $search_unit_id;
		$group_room_floor = $Room->getRoomListGroupBy('floor', 'floor DESC', 'id DESC', $where);
		$this->assign('floors', $group_room_floor);

		//设置当前搜索
		$search = array(
			'search_project_id' => $search_project_id,
			'search_build_id' 	=> $search_build_id,
			'search_unit_id' 	=> $search_unit_id,
		);
		$this->assign($search);

		//户型
		//$Room = D('Common/Room');
		$Roomview = D('Common/Roomview');
		$hx_list = $Roomview->getRoomListGroupBy('hx, proj_id', 'hx', 'hx ASC', array('proj_id' => $search_project_id));
		$this->assign('hx_list', $hx_list);

		//项目
		$Project = D('Common/Project');
		
		//获取项目
		$project_info = $Project->getProjectById($search_project_id);
		$this->assign('project', $project_info);

		//获取相关楼栋
		$build_ids = array();
		foreach ($group_room_build as $group_room_build_k => $group_room_build_v) {
			$build_ids[] = $group_room_build_v['bld_id'];
		}

		if (!empty($build_ids)) {
			$Build = D('Common/Build');
			$where['id'] = array('in', $build_ids);
			$build_list = $Build->getBuildList($where, 'cast(buildname as SIGNED), id DESC');
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
		$where['proj_id'] = $search_project_id;
		$where['bld_id'] = $search_build_id;
		$where['unit'] = $search_unit_id;
		$room_list = D("Common/Room")->getRoomListJoinAttribute($where, 'floor DESC, no ASC');
                
		$new_room_list = array();
		$room_ids = array();
		foreach ($room_list as $room_list_key => $room_list_value) {
			$new_room_list[$room_list_value['floor']][] = $room_list_value;
			$room_ids[] = $room_list_value['id'];
		}
		$this->assign('rooms', $new_room_list);

		//收藏
		unset($where);
		$collection_room_ids = array();
		if (count($room_list)>1)
		{
			$where['cst_id'] 	= $this->get_customer_id();
			$where['room_id'] 	= array('in', $room_ids);
			$room_collection = D('Common/Collection')->getList($where);
			foreach ($room_collection as $room_collection_key => $room_collection_value) {
				$collection_room_ids[] = $room_collection_value['room_id'];
			}
		}		
		$this->assign('collection_room_ids', $collection_room_ids);

		$this->set_seo_title($project_info['name']);
        $this->display();
    }

}
?>