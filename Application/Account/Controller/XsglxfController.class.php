<?php
namespace Account\Controller;

/**
 * 快速选房
 *
 * @create 2017-04-17
 * @author jxw
 */
class XsglxfController extends BaseController {

    /**
     * 系统构造函数
     *
     * @create 2017-04-17
     * @author jxw
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '销售管理');
        //设置当前方法
        $this->set_current_action('xsgl_xf', 'xsgl');
    }

    public function index() {
                $user_where['userid'] = $this->get_user_id(); 
                $Model = new \Think\Model();
                $usertype=$Model ->query("select * from xk_user where id='" . $user_where['userid'] . "' ");
                if (empty($usertype) || $usertype[0]['type']<2)
                   // $this->error('用户登录信息异常，请重新登录', U('login/index'));
                    redirect(U('login/index'), 0);
                
                $this->assign('usertype', $usertype[0]['type']);
		$user_project_list = D("Station")->getpProjectListByUserId($user_where['userid']);
		
		$project_ids = array();
		foreach ($user_project_list as $user_project_list_value) {
			$project_ids[] = $user_project_list_value['proj_id'];
		}
		
		//项目列表
		if (!empty($project_ids)) {
			$Project = D('Common/Project');
			$where11['status'] = 1;
			$where11['id'] = array('in', $project_ids);
			$project_list = $Project->getProjectList($where11, 'id DESC');
		} else {
			$project_list = array();
		}
		$this->assign('project', $project_list);

		//获取搜索条件
		//$search_info = "p1b1u5n1701";
		$search_info = I('info', '', 'trim');
		$search_project_id = get_search_id_by($search_info, 'p', $project_list[0]['id']);
		$search_build_id = get_search_id_by($search_info, 'b');
		$search_unit_id = get_search_id_by($search_info, 'u');
		$search_room_no_id = get_search_id_by($search_info, 'n');
		
		$search = array(
			'search_project_id' => $search_project_id,
			'search_build_id' 	=> $search_build_id,
			'search_unit_id' 	=> $search_unit_id,
			'search_room_no_id' => $search_room_no_id,
		);
		$this->assign($search);
		
		//房间信息
		$Room = D('Common/Room');
		$Roomview = D('Common/Roomview');
		$where['proj_id'] = $search_project_id;
		$group_room_build = $Roomview->getRoomListGroupBy('bld_id', 'bld_id', 'id DESC', $where);
		$group_room_unit = $Roomview->getRoomListGroupBy('bld_id, unit', 'bld_id, unit', 'cast(unit as SIGNED), id DESC', $where);
		$group_room_floor = $Roomview->getRoomListGroupBy('bld_id, unit, floor', 'bld_id, unit, floor', 'id DESC', $where);
		//$group_room_no = $Room->getRoomListGroupBy('id, bld_id, unit, floor, no, is_xf', 'bld_id, unit, floor, no', 'id DESC', $where);
		$group_room_no = $Roomview->getRoomList($where, 'no ASC', '*, FROM_UNIXTIME(xftime,"%Y-%m-%d  %H:%i") as xftime1 ');
		
		//数据格式化
		foreach ($group_room_unit as $group_room_unit_key => $group_room_unit_value) {
			$group_room_unit[$group_room_unit_value['bld_id']][] = $group_room_unit_value;
		}
		foreach ($group_room_floor as $group_room_floor_key => $group_room_floor_value) {
			$group_room_floor[$group_room_floor_value['bld_id'].'_'.$group_room_floor_value['unit']][] = $group_room_floor_value;
		}
		foreach ($group_room_no as $group_room_no_key => $group_room_no_value) {
			$group_room_no[$group_room_no_value['bld_id'].'_'.$group_room_no_value['unit'].'_'.$group_room_no_value['floor']][] = $group_room_no_value;
		}
		
		//楼栋每层房间数量
		$group_room_floor_no = $Roomview->getRoomListGroupBy('bld_id, unit, floor, no, room', 'bld_id, unit, no', 'no ASC', $where);
		$build_unit_room_list = array();
		foreach ($group_room_floor_no as $group_room_floor_no_key => $group_room_floor_no_value) {
			$build_unit_room_list[$group_room_floor_no_value['bld_id'].'_'.$group_room_floor_no_value['unit']][$group_room_floor_no_value['no']] = $group_room_floor_no_value;
		}
		$this->assign('build_unit_room_list', $build_unit_room_list);
		
		//每栋有的楼层
		$build_room_floor = $Roomview->getRoomListGroupBy('bld_id, floor', 'bld_id, floor', 'cast(floor as SIGNED) DESC', $where);
		$build_room_floor_list = array();
		foreach ($build_room_floor as $build_room_floor_key => $build_room_floor_value) {
			$build_room_floor_list[$build_room_floor_value['bld_id']][$build_room_floor_value['floor']] = $build_room_floor_value;
		}
		$this->assign('build_room_floor_list', $build_room_floor_list);
		
		//获取相关楼栋
		$build_ids = array();
		foreach ($group_room_build as $group_room_build_k => $group_room_build_v) {
			$build_ids[] = $group_room_build_v['bld_id'];
		}
		
		if (!empty($build_ids)) {
			$Build = D('Common/Build');
			$where['id'] = array('in', $build_ids);
			$build_list = $Build->getBuildList($where, 'cast(buildcode as SIGNED) asc,buildname, id DESC');
		} else {
			$build_list = array();
		}
		
		$build_new_list = array();
		foreach ($build_list as $key => $build) {
			$build_new_list[$build['id']] = $build;
		}
		$this->assign('builds', $build_new_list);
		
		//获取房间数据
		$room_list = array();
		foreach ($build_list as $group_room_build_key => $group_room_build_value) {
			$build_id = $group_room_build_value['id'];
			
			$units = array();
			if (isset($group_room_unit[$build_id])) {
				$units = $group_room_unit[$build_id];
			}
			
			foreach ($units as $units_key => $units_value) {
				$unit_id = $units_value['unit'];
				
				$floors = array();
				if (isset($group_room_floor[$build_id.'_'.$unit_id])) {
					$floors = $group_room_floor[$build_id.'_'.$unit_id];
				}
				
				foreach ($floors as $floors_key => $floors_value) {
					$floor_id = $floors_value['floor'];
					
					$build_floors = $build_room_floor_list[$build_id];
					$unit_rooms = $build_unit_room_list[$build_id.'_'.$unit_id];
					
					$rooms = array();
					if (isset($group_room_no[$build_id.'_'.$unit_id.'_'.$floor_id])) {
						$old_rooms = $group_room_no[$build_id.'_'.$unit_id.'_'.$floor_id];
						if (!empty($old_rooms)) {
							foreach ($old_rooms as $old_room) {
								$rooms[$old_room['no']] = $old_room;
							}
						}
						
						$room_list[$build_id]['build_id'] = $build_id;
						$room_list[$build_id]['data'][$unit_id]['unit_id'] = $unit_id;
						$room_list[$build_id]['data'][$unit_id]['floors'] = $build_floors;
						$room_list[$build_id]['data'][$unit_id]['floor_rooms'] = $unit_rooms;
						$room_list[$build_id]['data'][$unit_id]['data'][$floor_id]['floor_id'] = $floor_id;
						$room_list[$build_id]['data'][$unit_id]['data'][$floor_id]['data'] = $rooms;
					}
				}
			}
		}
	$this->assign('rooms', $room_list);
        $this->set_seo_title("快速选房");
        $this->display();
    }
        /**
	 * 房间详情
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
	public function room_info()
	{
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('xsglxf/index'));
		}
		
		/*
		$ext = __EXT__;
		if (strtolower($ext) != 'json') {
			$this->error('请求方法错误，请确认后重试！', U('xsglxf/index'));
		}
		*/
		
		//房间信息
		$id = I('id', 0, 'intval');
		if (empty($id) || $id == 0) {
			$this->error('房间ID不能为空，请确认后重试！', U('xsglxf/index'));
		}
		
		$room = D("Room")->getRoomById($id);
		if (empty($room)) {
			$this->error('房间信息不存在，请确认后重试！', U('xsglxf/index'));
		}
		
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
			'id' => $room['id'],
			'room_name' => $build['buildname'].'-'.$room['unit'].'-'.$room['floor'].$room['no'],
			'room_number' => $build['buildname'].'-'.$room['unit'].'-'.$room['floor'].$room['no'],
			'room_no' => $room['floor'].$room['no'],
			'hx' => $room['hx'],
			'area' => $room['area'],
			'tnarea' => $room['tnarea'],
			'price' => $room['price'],
			'tnprice' => $room['tnprice'],
			'total' => $room['total'],
			'cstname' => $room['cstname'],
			'is_xf' => $room['is_xf'],
			'xftime' => $time
		);
		
		$this->success($data, U('xsglxf/index'));
	}
        
        /**
	 * 确认选房
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
	public function choose_room()
	{
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('xsglxf/index'));
		}
		
		//获取ID
		$id = I('id', 0, 'intval');
		if (empty($id) || $id == 0) {
			$this->error('房间ID不能为空，请确认后重试！', U('xsglxf/index'));
		}
		
		$cstname = I('cstname', '', 'trim');
		if (empty($cstname)) {
			//$this->error('客户姓名不能为空，请确认后重试！', U('xsglxf/index'));
		}
		
		//当前房间
		$room = D("Room")->getRoomById($id);
		if (empty($room)) {
			$this->error('房间信息不存在，请确认后重试！', U('xsglxf/index'));
		}
		
		//判断是否选择
		if ($room['is_xf'] == 1) {
			$this->error('房间已经选择，请选择其他房间！', U('xsglxf/index'));
		}
		
		$data = array(
			'is_xf' => 1,
			'xftime' => time(),
			'cstname' => $cstname,
		);
		
		$check_has_edit = D("Room")->editRoomById($data, $id);
		if ($check_has_edit === false) {
			$this->error('选房失败，请确认后重试！', U('xsglxf/index'));
		}

		$Model = new \Think\Model();
		$projid=$room['proj_id'];
		$dqtime=date('Y-m-d');
		$rooms=$Model->query("SELECT a.*, FROM_UNIXTIME(a.xftime,'%Y-%m-%d  %H:%i') as xftime1  FROM xk_roomlist a WHERE a.proj_id=" .$projid." and a.is_xf=1 AND FROM_UNIXTIME(a.xftime,'%Y-%m-%d')='".$dqtime ."' and id<>".$id." and 666=666 ORDER BY a.xftime desc,a.bld_id,a.unit,a.floor desc,a.no,a.id ASC " );

		//日志
		$this->choose_room_log();
		
		$this->success($rooms);
	}
	
	
	/**
	 * 确认选房 - 后置操作方法
	 *
	 * @create 2016-10-14
	 * @author zlw
	 */
    public function choose_room_log()
	{
		$room_id = I('id', 0, 'intval');
		
		$user_id = $this->get_user_id();
		$user = D("User")->getOneById($user_id);
		if (!empty($user)) {
			$user_name = $user['name'];
		} else {
			$user_name = '';
		}
		
        D("RoomLog")->choose($room_id, $user_id, $user_name);
    }
	
	
	/**
	 * 取消选房
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
	public function not_choose_room()
	{
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('xsglxf/index'));
		}
		
		//获取ID
		$id = I('id', 0, 'intval');
		if (empty($id) || $id == 0) {
			$this->error('房间ID不能为空，请确认后重试！', U('xsglxf/index'));
		}
		
		//当前房间
		$room = D("Room")->getRoomById($id);
		if (empty($room)) {
			$this->error('房间信息不存在，请确认后重试！', U('xsglxf/index'));
		}
		
		//判断是否选择
		if ($room['is_xf'] == 0) {
			$this->error('房间已经取消，请选择其他房间！', U('xsglxf/index'));
		}
		
		$data = array(
			'is_xf' => 0,
			'xftime' => '',
			'cstname' => '',
			'is_qxxf' => 1,
                        'qxxftime' => time(),
		);
		
		//确认更改
		$check_has_edit = D("Room")->editRoomById($data, $id);
		if ($check_has_edit === false) {
			$this->error('取消选房失败，请稍候重试！', U('xsglxf/index'));
		}

		//日志
		$this->not_choose_room_log();
		
		$this->success('取消选房成功！', U('xsglxf/index'));
	}
	
	
	/**
	 * 取消选房 - 后置操作方法
	 *
	 * @create 2016-10-14
	 * @author zlw
	 */
    public function not_choose_room_log()
	{
		$room_id = I('id', 0, 'intval');
		
		$user_id = $this->get_user_id();
		$user = D("User")->getOneById($user_id);
		if (!empty($user)) {
			$user_name = $user['name'];
		} else {
			$user_name = '';
		}
		
        D("RoomLog")->notChoose($room_id, $user_id, $user_name);
    }
	
	
	/**
	 * 搜索房间并返回信息
	 *
	 * @create 2016-8-24
	 * @author zlw
	 */
	public function search_room()
	{
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('xsglxf/index'));
		}
		
		//条件
		$search_info = I('info', '', 'trim');
		if (empty($search_info)) {
			$this->error('搜索条件为空，请确认后重试！', U('xsglxf/index'));
		}
		$this->assign('search_info', $search_info);
		
		//当前房间
		$where['room'] = array('like', '%' . $search_info . '%');;
		$rooms = D("Room")->getRoomList($where, "bld_id ASC, cast(unit as SIGNED) ASC,cast(floor as SIGNED) ASC ,cast(no as SIGNED) ASC");
		
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
					'id' => $room['id'],
					'room_name' => $build['buildname'].'-'.$room['unit'].'-'.$room['room'],
					'room_number' => $build['buildname'].'-'.$room['unit'].'-'.$room['room'],
					'room_no' => $room['room'],
					'xftime' => $time
				);
				
				$rooms[$key] = array_merge($room, $data);
			}
		}
		
		$this->success($rooms, U('xsglxf/index'));
	}
        
        /**
	 * 搜索客户并返回信息
	 *
	 * @create 2017-05-15
	 * @author jxw
	 */
	public function search_cst()
	{
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('room/index'));
		}
		
		//条件
		$search_info = I('info', '', 'trim');
                $type = I('stype', '', 'trim');
                $project_id = I('project_id', '', 'trim');
                $room_id = I('room_id', '', 'trim');
                $where['id'] = $room_id;
                $where[] = "1=1";
                $room = D("Roomview")->getOne($where);
                $batch_id=$room['pc_id'];
		if (empty($search_info)) {
                    $this->error('搜索条件为空，请确认后重试！', U('room/index'));
		}
		$this->assign('search_info', $search_info);
		unset($where);
		//当前房间
                if ($type==0)
                {
                    $where['cyjno'] = $search_info;
                }else if ($type==1)
                {
                    $where['customer_name'] = $search_info;
                }else if ($type==2)
                {
                    $where['customer_phone'] = $search_info;
                }else if ($type==3)
                {
                    $where['cardno'] = $search_info;
                }
                $where['project_id'] = $project_id;
                $where['batch_id'] = $batch_id;
		$ChooseView = D('Common/ChooseView');
		$csts = $ChooseView->getList($where, "*");
		
		//获取相关信息
		$this->success($csts, U('room/index'));
	}
        
        public function get_gfrooms()
        {
            if (!IS_AJAX) {
                    $this->error('请求错误，请确认后重试！', U('led/index'));
            }
            $type = I('info', '', 'trim');
            $projid = I('projid', 0, 'trim');
            $Model = new \Think\Model(); 
            if ($type=='showzxrooms')
            {
                $dqtime=date('Y-m-d');
                $rooms=$Model->query("SELECT a.*, FROM_UNIXTIME(a.xftime,'%Y-%m-%d  %H:%i') as xftime1  FROM xk_roomlist a WHERE a.proj_id=" .$projid." and a.is_xf=1 AND FROM_UNIXTIME(a.xftime,'%Y-%m-%d')='".$dqtime ."' and 666=666 ORDER BY a.xftime desc,a.bld_id,a.unit,a.floor desc,a.no,a.id ASC " );
            }
            $this->success($rooms);
        } 
        
        
         public function pmtxf() {
            //$this->index();
      
            $user_where['userid'] = session("ACCOUNT_ID");
            $user_project_list = D("Station")->getpProjectListByUserId($user_where['userid']);
            $project_ids = array();
            foreach ($user_project_list as $user_project_list_value) {
                    $project_ids[] = $user_project_list_value['proj_id'];
            }

            //项目列表
            if (!empty($project_ids)) {
                    $Project = D('Common/Project');
                    $where11['status'] = 1;
                    $where11['id'] = array('in', $project_ids);
                    $project_list = $Project->getProjectList($where11, 'id DESC');
            } else {
                    $project_list = array();
            }
            $this->assign('project', $project_list);
                
            $Model = new \Think\Model(); 
            $sqltemp="select a.*,FROM_UNIXTIME(xftime,'%Y-%m-%d  %H:%i') as xftime1,c.leftpx,c.toppx from xk_roomlist a inner join
                        ( 
                                select a.id as bld_id,a.buildname,a.buildcode  from xk_build a left join xk_station2pc b on a.pc_id=b.pc_id left join xk_station2user c on b.station_id=c.station_id
                                left join xk_kppc d on a.pc_id=d.id 
                                where 1111=1111 and a.id= 31 and c.userid= " .$user_where['userid'] . " and a.proj_id= " . $project_list[0]['id'] . " and d.is_yx=1
                        ) b on a.bld_id=b.bld_id left join xk_room_pmtzb c on a.id=c.room_id order by floor,no";  
            $rooms=$Model ->query($sqltemp); 
            $this->assign('rooms', $rooms);
            $this->display();
         }
         
        public function savezb()
        {
            if (!IS_AJAX) {
                $this->error('请求错误，请确认后重试！', U('xsglxf/pmtxf'));
            }
            $room_id = I('id', 0, 'trim');
            $leftpx = I('leftpx', '', 'trim');
            $toppx = I('toppx', '', 'trim');
            if (empty($room_id))
            {
                $this->error('房间id不能为空', U('xsglxf/pmtxf'));
            }
            $Model = new \Think\Model();
            $room=$Model ->query("select * from xk_room_pmtzb where room_id='" .$room_id . "' ");
            if(empty($room))
            {
                $data['leftpx']=$leftpx;
                $data['toppx']=$toppx;
                $data['room_id']=$room_id;
                $model = M("room_pmtzb");  
                $model->add($data);
            }
            else
            {
                 $data1['leftpx']=$leftpx;
                 $data1['toppx']=$toppx;
                 $model = M("room_pmtzb");  
                 $model->where('room_id='.$room_id)->save($data1);
            }
             $this->success("保存成功");
        } 
        
        public function pmtxf2() {
            //$this->index();
            $user_where['userid'] = session("ACCOUNT_ID");
            $user_project_list = D("Station")->getpProjectListByUserId($user_where['userid']);
            $project_ids = array();
            foreach ($user_project_list as $user_project_list_value) {
                    $project_ids[] = $user_project_list_value['proj_id'];
            }

            //项目列表
            if (!empty($project_ids)) {
                    $Project = D('Common/Project');
                    $where11['status'] = 1;
                    $where11['id'] = array('in', $project_ids);
                    $project_list = $Project->getProjectList($where11, 'id DESC');
            } else {
                    $project_list = array();
            }
            $this->assign('project', $project_list);
                
            $Model = new \Think\Model(); 
            $sqltemp="select a.*,FROM_UNIXTIME(xftime,'%Y-%m-%d  %H:%i') as xftime1,c.leftpx,c.toppx from xk_roomlist a inner join
                        ( 
                                select a.id as bld_id,a.buildname,a.buildcode  from xk_build a left join xk_station2pc b on a.pc_id=b.pc_id left join xk_station2user c on b.station_id=c.station_id
                                left join xk_kppc d on a.pc_id=d.id 
                                where 1111=1111 and a.id= 32 and c.userid= " .$user_where['userid'] . " and a.proj_id= " . $project_list[0]['id'] . " and d.is_yx=1
                        ) b on a.bld_id=b.bld_id left join xk_room_pmtzb c on a.id=c.room_id order by floor,no";  
            $rooms=$Model ->query($sqltemp); 
            $this->assign('rooms', $rooms);
            $this->display();
         }
}
