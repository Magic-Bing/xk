<?php

namespace Home\Controller;

use Common\Lookey\Room\Log as RoomLog;


/**
 * 房间显示
 *
 * @create 2016-8-22
 * @author zlw
 */
class RoomController extends BaseController 
{


	/**
	 * 首页
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
    public function index() 
	{

//        $base = A('Account/Base');
               // $user_where['userid'] = $this->get_user_id();
        $search_project_id=I("pid",0,"intval");
        $search_batch_id=I("bid",0,"intval");
        $this->assign('search_project_id', $search_project_id);
        $uid=$this->get_user_id();
		//项目列表
			$Project = D('Common/Project');
			$where11['status'] = 1;
			$where11['id'] = $search_project_id;
			$where11[] = '999=999';
			$project_list = $Project->getProjectList($where11, 'id DESC');
		$this->assign('project', $project_list);
        //当前用户的项目
        $user_project_ids = $this->get_user_project_ids();
        if (!in_array($search_project_id, $user_project_ids)) {
            $this->error("你没有权限访问该项目的信息！", U('Account/index'));
        }
        $user_batch_ids = $this->get_user_batch_ids();
        if (!in_array($search_batch_id, $user_batch_ids)) {
            $this->error("你没有权限访问该批次的信息！", U('Account/index'));
        }
//        echo $uid;exit;
        //查询参数权限
        //取消选房权限
        $all_auth=M()->table("xk_user")->where("id=$uid")->find();
        if($all_auth['is_all'] == 1){
            $this->assign('reset','1');
        }else{
            $reset= M()->table("xk_station2user s")->join('xk_fun_station f ON f.station_id=s.station_id')->where("s.userid=$uid AND f.fun_id=34")->find();
            $this->assign('reset',$reset?'1':'2');
        }

        //付款方式权限
        $pay_auth=M()->table("xk_pzcsvalue")->field("id")->where("project_id =$search_project_id AND batch_id=$search_batch_id AND pzcs_id=7 AND cs_value=-1")->find();
        //诚意金编号权限
        $num_auth=M()->table("xk_pzcsvalue")->field("id")->where("project_id =$search_project_id AND batch_id=$search_batch_id AND pzcs_id=9 AND cs_value=-1")->find();
//        $info_auth=explode(";",$info_auth);
        $this->assign('pay_auth', $pay_auth['id']);
        $this->assign('num_auth', $num_auth['id']);

		//一共出售，
        $yg_count=M()->table("xk_roomList")->where("proj_id=$search_project_id AND is_xf=1 and is_dq=1")->count();
        $this->assign("yg_count",$yg_count);
        //当前用户出售
        $user_id=$this->get_user_id_acc();
        $user_count=M()->table("xk_roomList r")->field("r.id")->
        join("xk_roomczlog l ON l.room_id=r.id")->
        where("r.proj_id=$search_project_id AND r.is_xf=1 AND is_dq=1 AND l.czuser=$user_id AND l.cztype='选房'")->group("l.room_id")->select();

        $this->assign("user_count",count($user_count));
		//房间信息
		$Roomview = D('Common/Roomview');
		$where['proj_id'] = $search_project_id;
		$where['pc_id'] = $search_batch_id;
//        $where['is_dq'] = 1;
		$group_room_build = $Roomview->getRoomListGroupBy('bld_id', 'bld_id', 'id DESC', $where);
		$group_room_unit = $Roomview->getRoomListGroupBy('bld_id, unit', 'bld_id, unit', 'cast(unit as SIGNED), id DESC', $where);
		$group_room_floor = $Roomview->getRoomListGroupBy('bld_id, unit, floor', 'bld_id, unit, floor', 'id DESC', $where);
		//$group_room_no = $Room->getRoomListGroupBy('id, bld_id, unit, floor, no, is_xf', 'bld_id, unit, floor, no', 'id DESC', $where);
		$group_room_no = $Roomview->getRoomList($where, 'bld_id,cast(unit as SIGNED) ASC,cast(floor as SIGNED) ASC ,cast(no as SIGNED) ASC', '*, FROM_UNIXTIME(xftime,"%Y-%m-%d  %H:%i") as xftime1 ');
		
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
		
		//seo设置
		$this->set_seo_title('快速选房');
		$this->set_seo_keywords('快速选房');
		$this->set_seo_description('快速选房');
		
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
			$this->error('请求错误，请确认后重试！', U('room/index'));
		}
		//房间信息
		$id = I('id', 0, 'intval');
		if (empty($id) || $id == 0) {
			$this->error('房间ID不能为空，请确认后重试！', U('room/index'));
		}
		
		$room = D("Room")->getRoomById($id);
		if (empty($room)) {
			$this->error('房间信息不存在，请确认后重试！', U('room/index'));
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
			'xftime' => $time,
                        'cstname' => $room['cstname'],
                        'cyjno' => $room['cyjno'],
                        'phone' => $room['phone'],
                        'cardno' => $room['cardno']
		);
		
		$this->success($data, U('room/index'));
	}
	
        public function get_oneroom()
	{
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('room/index'));
		}
		$id = I('id', 0, 'intval');
		if (empty($id) || $id == 0) {
			$this->error('房间ID不能为空，请确认后重试！', U('room/index'));
		}
		
		$room = D("Roomview")->getOneById($id);
		if (empty($room)) {
			$this->error('房间信息不存在，请确认后重试！', U('room/index'));
		}
        if (!empty($room['xftime'])) {
			$time = date('Y-m-d H:i', $room['xftime']);
		} else {
			$time = '';
		}
        $room['xftime']=$time;
		$room['phone']=rsa_decode($room['phone'],getChoosekey());
		$room['cardno']=rsa_decode($room['cardno'],getChoosekey());
		//获取相关信息
		$this->success($room, U('room/index'));
	}

	/**
	 * 确认选房
	 * @create 2016-8-22
	 * @author zlw
	 */
	public function choose_room()
	{
                
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('room/index'));
		}
		$is_havexf=0;
		//获取ID
		$id = I('id', 0, 'intval');
		if (empty($id) || $id == 0) {
			$this->error('房间ID不能为空，请确认后重试！', U('room/index'));
		}
		
		$cstname = I('cstname', '', 'trim');
        $cstid = I('cstid', '', 'trim');
        $pay = I('pay', '', 'trim');

		//当前房间
		$room = D("Room")->getRoomById($id);
		if (empty($room)) {
			$this->error('房间信息不存在，请确认后重试！', U('room/index'));
		}
                
		//判断房间是否选择
		if ($room['is_xf'] == 1) {
		    //$this->error('房间已经售出，请选择其他房间！', U('room/index'));
                    $is_havexf=1;
		}
                $projid=$room['proj_id'];
                
                $Model = new \Think\Model();
                $csthaveroom=$Model->query("SELECT a.*  FROM xk_room a inner join (select * from xk_choose where cyjno<>999) b  on  a.cstid=b.id WHERE a.proj_id=" .$projid." and a.cstid= ".$cstid ." and 999=999" );
                if (count($csthaveroom)>0) {
			$this->error('此客户已经购买其它房源！', U('room/index'));
		}
                
		$data = array(
			'is_xf' => 1,
			'xftime' => time(),
                        'cstid' => $cstid,
			'cstname' => $cstname,
                        'is_qxxf' => 0,
		);
                
		if ($is_havexf==0)
                {
                    $user_id = $this->get_user_id_acc();
                    $user = D("User")->getOneById($user_id);
                    $roominfo = D('Room');
                    //事物操作保证数据一致性
                    $roominfo->startTrans();
                    //房间表
                    $check_has_edit=$roominfo->editRoomById($data, $id);
                    //交易表
                     $obj = array(
                        'yw_id'=> $room['id']
                        ,'room_id'=> $room['id']
                        ,'cst_id'=> $cstid
                        ,'source'=> '快速选房'
                        ,'status'=> '选房'
                        ,'isyx'=> 1
                        ,'tradetime'=>time()
                        ,'ywy'=> ''
                        ,'createdbyid'=> $user_id
                        ,'createdby'=> $user['name']
                        ,'pay'=> $pay
                    );
                    D("Trade")->add($obj);
                    //房间操作日志表
                    D("RoomLog")->choose($room['id'], $user_id, $user['name'],$cstid);
                     
                    $roominfo->commit();
                    
                    //if ($check_has_edit === false) {
                    //        $this->error('选房失败，请确认后重试！', U('room/index'));
                    //}
                }
		
		$dqtime=date('Y-m-d');
		$rooms=$Model->query("SELECT a.*, FROM_UNIXTIME(a.xftime,'%Y-%m-%d  %H:%i') as xftime1  FROM xk_roomlist a WHERE a.proj_id=" .$projid." and ((a.is_xf=1 AND FROM_UNIXTIME(a.xftime,'%Y-%m-%d')='".$dqtime ."') or a.is_qxxf=1 ) and 666=666 ORDER BY a.xftime desc,a.bld_id,a.unit,a.floor desc,a.no,a.id ASC " );
        $user_id=$this->get_user_id_acc();
        $user_count=M()->table("xk_room r")->field("count(1) zc,sum(case when l.room_id is not null then 1 else 0 end) uc")->
        join("LEFT JOIN (select room_id from xk_roomczlog where czuser=$user_id AND cztype='选房' group by room_id) l ON l.room_id=r.id")->
        where("r.proj_id=$projid AND r.is_xf=1 ")->select();
                $data=array();
                $data[0]=$is_havexf;
                $data[1]=$rooms;
                $data[2]=$user_count;
                $data[3]=date("Y-m-d H:i",time());
		//日志
		//$this->choose_room_log($cstid);
		$this->success($data);
	}
	
	
	/**
	 * 确认选房 - 后置操作方法
	 * @create 2016-10-14
	 * @author zlw
	 */
    public function choose_room_log($cstid)
	{
		$room_id = I('id', 0, 'intval');
		
		$user_id = $this->get_user_id_acc();
		$user = D("User")->getOneById($user_id);
		if (!empty($user)) {
			$user_name = $user['name'];
		} else {
			$user_name = '';
		}
		
        D("RoomLog")->choose($room_id, $user_id, $user_name,$cstid);
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
			$this->error('请求错误，请确认后重试！', U('room/index'));
		}
		$uid=$this->get_user_id();
        //取消选房权限
        $all_auth=M()->table("xk_user")->where("id=$uid")->find();
        if($all_auth['is_all'] != 1){
            $reset= M()->table("xk_station2user s")->join('xk_fun_station f ON f.station_id=s.station_id')->where("s.userid=$uid AND f.fun_id=34")->find();
            if(!$reset){
                $this->error('你没有权限取消房间，请刷新后重试！', U('room/index'));
            }
        }
		//获取ID
		$id = I('id', 0, 'intval');
		if (empty($id) || $id == 0) {
			$this->error('房间ID不能为空，请确认后重试！', U('room/index'));
		}
		
		//当前房间
		$room = D("Room")->getRoomById($id);
		if (empty($room)) {
			$this->error('房间信息不存在，请确认后重试！', U('room/index'));
		}
		
		//判断是否选择
		if ($room['is_xf'] == 0) {
			$this->error('房间已经取消，请选择其他房间！', U('room/index'));
		}

		$data = array(
			'is_xf' => 0,
			'xftime' => '',
			'cstname' => '',
                        'cstid' => 0,
			'is_qxxf' => 1,
                        'qxxftime' => time(),
		);
                
                $user_id = $this->get_user_id_acc();
                $user = D("User")->getOneById($user_id);
                $czuser=M()->table("xk_roomczlog")->field("czuser")->where("room_id=$id AND cztype='选房'")->order("id desc")->find();
                if($czuser['czuser']==$user_id){
                    $a=1;
                }else{
                    $a=2;
                }
                $roominfo = D('Room');
                //事物操作保证数据一致性
                $roominfo->startTrans();
                //房间表
                $check_has_edit=$roominfo->editRoomById($data, $id);
                //删除交易表
                D("Trade")->where("room_id=".$room['id'])->delete();
                //房间操作日志表
                D("RoomLog")->notChoose($room['id'], $user_id, $user['name']);

                $roominfo->commit();

		//if ($check_has_edit === false) {
		//	$this->error('取消选房失败，请稍候重试！', U('room/index'));
		//}
		//日志
		//$this->not_choose_room_log();
		$this->success($a);
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
		
		$user_id = $this->get_user_id_acc();
		$user = D("User")->getOneById($user_id);
		if (!empty($user)) {
			$user_name = $user['name'];
		} else {
			$user_name = '';
		}
		
        D("RoomLog")->notChoose($room_id, $user_id, $user_name);
    }
	
	
	/**
	 * 搜索房间并返回信息,按编号搜索
	 *
	 * @create 2016-8-24
	 * @author zlw
	 */
	public function search_room()
	{
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('room/index'));
		}
		
		//条件
		$search_info = I('info', '', 'trim');
		if (empty($search_info)) {
			$this->error('搜索条件为空，请确认后重试！', U('room/index'));
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
		
		$this->success($rooms, U('room/index'));
	}

    /**
     * 搜索房间并返回信息,按客户名称搜索
     *
     * @create 2016-8-24
     * @author zlw
     */
    public function search_room_name(){
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试！', U('room/index'));
        }

        $search_info = I('custname', '', 'trim');
        if (empty($search_info)) {
            $this->error('搜索条件为空，请确认后重试！', U('room/index'));
        }
        $model=M();
        $uid=$model->table("xk_choose")->field("id")->where("customer_name like '%{$search_info}%'")->select();
        if(!$uid){
            echo "false1";exit;
        }
        $arr=[];
        for($i=0;$i<count($uid);$i++){
            $arr[]=$uid[$i]['id'];
        }
        $arr_string=implode(",",$arr);
        $bh=$uid=$model->table("xk_room")->field("id,room")->where("cstid in ({$arr_string})")->select();
        if($bh){
            echo json_encode($bh);exit;
        }else{
            echo "false1";exit;
        }

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
		$search_info = I('info','', 'trim');
                $type = I('stype', '', 'trim');
                $project_id = I('project_id', '', 'trim');
                $room_id = I('room_id', '', 'trim');
                $where['id'] = $room_id;
                $where[] = "1=1";
                $room = D("Roomview")->getOne($where);
                $batch_id=$room['pc_id'];
		if (empty($search_info)) {
                    //$this->error('搜索条件为空，请确认后重试！', U('room/index'));
		}
		$this->assign('search_info', $search_info);
		unset($where);
		
                if ($type==0)
                {
                    $where['cyjno'] = $search_info;
                }else if ($type==1)
                {
                    $where['customer_name'] = $search_info;
                }else if ($type==2)
                {
                    $where['like_p'] = strencode($search_info);
                }else if ($type==3)
                {
                    $where['like_c'] = strencode($search_info);
                }
                $where['project_id'] = $project_id;
                $where['batch_id'] = $batch_id;
		$ChooseView = D('Common/ChooseView');
		$csts = $ChooseView->getList($where, "*");
		if(count($csts) >0){
		    if(count($csts) ==1){
                $csts[0]['customer_phone']=rsa_decode($csts[0]['customer_phone'],getChoosekey());
                $csts[0]['cardno']=rsa_decode($csts[0]['cardno'],getChoosekey());
            }else{
                for($i=0;$i<count($csts);$i++){
                    $csts[$i]['customer_phone']=rsa_decode($csts[$i]['customer_phone'],getChoosekey());
                    $csts[$i]['cardno']=rsa_decode($csts[$i]['cardno'],getChoosekey());
                }
            }
        }
                $data=array();
                if ( !empty($csts[0]['room_id'])&&$csts[0]['room_id']>0)
                {
                    $data[0]=1;
                }
                else
                {
                     $data[0]=0;
                }
                $data[1]=$csts;
		
		//获取相关信息

		$this->success($data, U('room/index'));
	}
        
        public function get_gfrooms()
        {
            if (!IS_AJAX) {
                    $this->error('请求错误，请确认后重试！', U('room/index'));
            }
            $type = I('info', '', 'trim');
            $projid = I('projid', 0, 'trim');
            $Model = new \Think\Model(); 
            //if ($type=='showzxrooms')
            //{
                $dqtime=date('Y-m-d');
                $rooms=$Model->query("SELECT a.*, FROM_UNIXTIME(a.xftime,'%Y-%m-%d  %H:%i') as xftime1  FROM xk_roomlist a WHERE a.proj_id=" .$projid." and a.is_xf=1 AND FROM_UNIXTIME(a.xftime,'%Y-%m-%d')='".$dqtime ."' and 666=666 ORDER BY a.xftime desc,a.bld_id,a.unit,a.floor desc,a.no,a.id ASC " );
           // }
            $this->success($rooms);
        } 
	
}