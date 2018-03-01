<?php

namespace Saler\Controller;


/**
 * 置业顾问 - 项目
 *
 * @create 2016-8-26
 * @author zlw
 */
class ProjectController extends Base1Controller 
{

	
	/**
	 * 微信开盘首页
	 *
	 * @create 2016-8-25
	 * @author zlw
	 */
    public function index() 
	{
		//项目
		$Project = D('Common/Project');
		$project_list = $Project->getProjectList(array(
			'status' => 1
		), 'name ASC, id ASC');
		$this->assign('projects', $project_list);
		
		//格式化楼栋
		$new_project_list = array();
		foreach ($project_list as $project_list_key => $project_list_value) {
			$new_project_list[$project_list_value['id']][] = $project_list_value;
		}
		$this->assign('new_projects', $new_project_list);
		
                $isws=I("isws",0,"intval");
                $this->assign('isws', $isws);
                
		//分析
		$search_info = I('info', '', 'trim');
        $search_hd_id = get_search_id_by($search_info, 'p', $project_list[0]['id']);
        $this->assign('search_hd_id', $search_hd_id);
        $projinfo=M("project p")->join("xk_event_order_house e ON e.project_id = p.id")->where("e.id=".$search_hd_id)->field("p.id,p.name pname,e.name ename,e.batch_id")->find();
//        echo json_encode($projinfo);exit;
        if(empty($projinfo))
        {
            session("USER_ID",null);
            $this->error('系统异常，请重新登录！', U('logging/index'));
        }
        $search_project_id=$projinfo['id'];
		$user_where['userid'] = $this->get_user_id();
		$user_where['projid'] = $search_project_id;
		$user_project_list = D("Station")->getpProjectListByUserId($user_where['userid'], $user_where['projid']);
		if (empty($user_project_list)) {
			$this->error('你没有查看该项目的权限！', U('index/index'));
		}

		//归类
		$Room = D('Common/Room');
		$Roomview = D('Common/Roomview');
		$where['proj_id'] = $search_project_id;
		$where['pc_id'] = $projinfo['batch_id'];
                if(!empty($isws) && $isws>0)
                {
                    $where['is_xf']=0;
                }
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
                $where['pc_id'] = $projinfo['batch_id'];
                if(!empty($isws) && $isws>0)
                {
                    $where['is_xf']=0;
                }
		$group_room_floor = $Roomview->getRoomListGroupBy('floor', 'floor DESC', 'cast(floor as SIGNED) DESC', $where);
		$this->assign('floors', $group_room_floor);
		
		//设置当前搜索
		$search = array(
			'search_project_id' => $search_project_id,
			'search_build_id' 	=> $search_build_id,
			'search_unit_id' 	=> $search_unit_id,
		);
		$this->assign($search);
		
		//条件
		$search_info = array(
			'p' => $search_project_id,
			'b' => $search_build_id,
			'u' => $search_unit_id,
		);
		$this->assign('search_info', $search_info);
		
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
		$where['proj_id'] = $search_project_id;
		$where['bld_id'] = $search_build_id;
		$where['unit'] = $search_unit_id;
                
                if(!empty($isws) && $isws>0)
                {
                    $where['is_xf']=0;
                }
                
//		$where['px_id'] = $projinfo['batch_id'];
		//$room_list = D("Common/Room")->getRoomList($where, 'floor DESC, no ASC');
		$room_list = D("Common/Room")->getRoomListJoinAttribute($where, 'floor DESC, no ASC');
		
		$new_room_list = array();
		foreach ($room_list as $room_list_key => $room_list_value) {
			$new_room_list[$room_list_value['floor']][] = $room_list_value;
		}
        $b_name=M()->table("xk_build")->field("buildname")->where("id=$search_build_id")->find();
		$this->assign('rooms', $new_room_list);
		$this->assign("b_name",$b_name);
		$this->assign("projinfo",$projinfo);
		if (IS_AJAX) {
			$room_list = $this->fetch('room');
			$this->success($room_list, U('index/index'));
		} else {
			$this->display();
		}
    }

    /**
     * 电子盘首页
     *
     * @create 2018-3-1
     * @author qzb
     */
    public function dz_index()
    {
        //项目
        $Project = D('Common/Project');
        $uid=$this->get_user_id();
        $isws=I("isws",0,"intval");
        $this->assign('isws', $isws);
        $search_info = I('info', '', 'trim');
        $pid = I('p', 0, 'intval');
        $bid = I('b', 0, 'trim');
        $this->assign('pid', $pid);
        $this->assign('bid', $bid);
        $projinfo=M()->table("xk_kppc k")->field("k.*,p.name pname")->join("xk_project p ON p.id=k.proj_id")->where("k.proj_id=".$pid." AND k.id=".$bid)->find();
//        echo $pid."-".$bid;exit;
        if(empty($projinfo))
        {
            session("USER_ID",null);
            $this->error('系统异常，请重新登录！', U('logging/index'));
        }
        $pd_pro=M()->table("xk_station2user su")->join("xk_station2pc sp ON sp.station_id=su.station_id")->where("su.userid=$uid AND sp.proj_id=$pid AND sp.pc_id=$bid")->find();
        if (empty($pd_pro)) {
            $this->error('你没有查看该项目的权限！', U('index/index'));
        }

        //归类
        $Roomview = D('Common/Roomview');
        $where['proj_id'] = $pid;
        $where['pc_id'] = $bid;
        if(!empty($isws) && $isws>0)
        {
            $where['is_xf']=0;
        }
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
        $where['proj_id'] = $pid;
        $where['bld_id'] = $search_build_id;
        $where['unit'] = $search_unit_id;
        $where['pc_id'] = $bid;
        if(!empty($isws) && $isws>0)
        {
            $where['is_xf']=0;
        }
        $group_room_floor = $Roomview->getRoomListGroupBy('floor', 'floor DESC', 'cast(floor as SIGNED) DESC', $where);
        $this->assign('floors', $group_room_floor);

        //设置当前搜索
        $search = array(
            'pid' => $pid,
            'search_build_id' 	=> $search_build_id,
            'search_unit_id' 	=> $search_unit_id,
        );
        $this->assign($search);

        //条件
        $search_info = array(
            'p' => $pid,
            'b' => $search_build_id,
            'u' => $search_unit_id,
        );
        $this->assign('search_info', $search_info);

        //获取项目
        $project_info = $Project->getProjectById($pid);
        $this->assign('project', $project_info);

        //获取相关楼栋
        $build_ids = array();
        foreach ($group_room_build as $group_room_build_k => $group_room_build_v) {
            $build_ids[] = $group_room_build_v['bld_id'];
        }

        if (!empty($build_ids)) {
            $Build = D('Common/Build');
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
        $where['proj_id'] = $pid;
        $where['bld_id'] = $search_build_id;
        $where['unit'] = $search_unit_id;
        if(!empty($isws) && $isws>0)
        {
            $where['is_xf']=0;
        }


        $room_list = D("Common/Room")->getRoomListJoinAttribute($where, 'floor DESC, no ASC');

        $new_room_list = array();
        foreach ($room_list as $room_list_key => $room_list_value) {
            $new_room_list[$room_list_value['floor']][] = $room_list_value;
        }
        $b_name=M()->table("xk_build")->field("buildname")->where("id=$search_build_id")->find();
        $this->assign('rooms', $new_room_list);
        $this->assign("b_name",$b_name);
        $this->assign("projinfo",$projinfo);
        if (IS_AJAX) {
            $room_list = $this->fetch('room');
            $this->success($room_list, U('index/index'));
        } else {
            $this->display();
        }
    }
}



















