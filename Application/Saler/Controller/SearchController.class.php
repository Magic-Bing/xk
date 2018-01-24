<?php

namespace Saler\Controller;


/**
 * 搜索
 *
 * @create 2016-9-2
 * @author zlw
 */
class SearchController extends BaseController 
{

	/**
	 * 首页
	 *
	 * @create 2016-9-2
	 * @author zlw
	 */
    public function index() 
	{
		//分析
		$search_info = I('info', '', 'trim');
        $search_hd_id = get_search_id_by($search_info, 'p');
        $this->assign('search_hd_id', $search_hd_id);
        $projinfo=M("project p")->join("xk_event_order_house e ON e.project_id = p.id")->where("e.id=".$search_hd_id)->field("p.id,p.name pname,e.name ename,e.batch_id")->find();
        if(empty($projinfo))
        {
            session("USER_ID",null);
            $this->error('系统异常，请重新登录！', U('logging/index'));
        }
        $search_project_id=$projinfo['id'];
		$this->assign('project_id',$search_project_id );
		
		$where['proj_id'] = $search_project_id;
		$where['pc_id'] = $projinfo['batch_id'];

		//楼栋
		$Buildview = D('Common/Buildview');
		$build_list = $Buildview->getBuildList($where, 'buildname ASC');
		$this->assign('build_list', $build_list);		
		
		//户型
		$Roomview = D('Common/Roomview');
		$hx_list = $Roomview->getRoomListGroupBy('hx, proj_id', 'hx', 'hx ASC', $where);
		$this->assign('hx_list', $hx_list);
        $this->display();		
	}
	
	
	/**
	 * 搜索房间并返回信息
	 *
	 * @create 2016-9-2
	 * @author zlw
	 */
	public function room()
	{
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('room/index'));
		}
		
		//条件
		$search_info = I('info', '', 'trim');
		$type = I('type', '', 'trim');
		if (empty($search_info) && $type=="ptss") {
			$this->error('搜索条件不能为空，请确认后重试！', U('room/index'));
		}
		$this->assign('search_info', $search_info);
	
		if (!empty($search_info) && $search_info<>"") 
		{
			//当前房间
			$map['room'] 	= array('like', '%' . $search_info . '%');
			$map['hx']  	= array('like', '%' . $search_info . '%');
			$map['floor']  	= array('like', '%' . $search_info . '%');
			$map['_logic']  = 'or';
			$where['_complex'] = $map;
		}
		
		//项目
		$project_id = I('project_id', '', 'intval');
		if (empty($project_id) || $project_id == 0) {
			$this->error("项目不存在，请重试！", U('search/index'));
		}
		$where['proj_id'] = $project_id;
		
		//是否购买
		$is_xf = I('is_xf', '', 'trim');
		if (strtolower($is_xf) != 'all') {
			if (intval($is_xf) == 1) {
				$where['is_xf'] = 1;
			} else {
				$where['is_xf'] = 0;
			}
		}
		
		//楼栋
		$build_ids = I('build_ids', '', 'trim');
		if (!empty($build_ids)) {
			$where['bld_id'] = array('in', explode(',', $build_ids));
		}
        //房间
        $room_start = I('room_start', '', 'trim');
        if (!empty($room_start)) {
            $where['room'][] = array('egt', intval($room_start));
        }else{
            $where['room'][] = array('egt', 1);
        }
        $room_end = I('room_end', '', 'trim');
        if (!empty($room_end)) {
            $where['room'][] = array('elt', intval($room_end));
        }else{
            $where['room'][] = array('elt', 99999);
        }
		//楼层
		$floor_start = I('floor_start', '', 'trim');
		if (!empty($floor_start)) {
			$where['floor'][] = array('egt', intval($floor_start));
		}else{
			$where['floor'][] = array('egt', -2);
		}
		$floor_end = I('floor_end', '', 'trim');
		if (!empty($floor_end)) {
			$where['floor'][] = array('elt', intval($floor_end));
		}else{
			$where['floor'][] = array('elt', 999);
		}

		//面积
		$area_start = I('area_start', '', 'trim');
		if (!empty($area_start)) {
			$where['area'][] = array('egt', intval($area_start));
		}else{
			$where['area'][] = array('egt', 1);
		}  
		$area_end = I('area_end', '', 'trim');
		if (!empty($area_end)) {
			$where['area'][] = array('elt', intval($area_end));
		}else{
			$where['area'][] = array('elt', 99999);
		}
		
		//价格
		$price_start = I('price_start', '', 'trim');
		if (!empty($price_start)) {
			$where['price'][] = array('egt', intval($price_start));
		}else{
			$where['price'][] = array('egt', 1);
		}
		$price_end = I('price_end', '', 'trim');
		if (!empty($price_end)) {
			$where['price'][] = array('elt', intval($price_end));
		}else{
			$where['price'][] = array('elt', 999999999);
		}

		//户型
		$hx_ids = I('hx_ids', '', 'trim');
		if (!empty($hx_ids)) {
			$where['hx'] = array('in', explode(',', $hx_ids));
		}
                
		//$rooms = D("Room")->getRoomList($where, "bld_id ASC, unit ASC, no ASC");
		$rooms = D("Roomview")->getRoomList($where, "cast(buildcode as SIGNED) ASC, cast(unit as SIGNED) ASC, cast(floor as SIGNED) DESC, cast(room as SIGNED) ASC");
		
		//获取相关信息
		if (!empty($rooms)) {
			foreach ($rooms as $key => $room) {
				//楼栋信息
				$bld_id = $room['bld_id'];
				$build = D("Build")->getBuildById($bld_id);
				
				//判断时间
				if (date('d', $room['xftime']) == date('d')) {
					$time = date('H:i', $room['xftime']);
				} elseif (!empty($room['xftime'])) {
					$time = date('Y-m-d H:i', $room['xftime']);
				} else {
					$time = '';
				}
				$data = array(
					'room_id' 		=> $room['id'],
					'room_name' 	=> $build['buildname'].$room['unit'].'单元',
					'room_floor' 	=> $room['floor'].'F',
					'room_number' 	=> $room['room'],
					'room_hx' 		=> $room['hx'],
					'room_area' 	=> $room['area'],
					'room_total' 	=> $room['total'],
					'room_is_xf' 	=> $room['is_xf'],
					'xftime' 		=> $time
				);
				$rooms[$key] = array_merge($room, $data);
			}
		}
		$this->assign('rooms', $rooms);
		
		//获取内容
		$room_list = $this->fetch();
		
		$this->success($room_list, U('search/index'));
	}

	
}

