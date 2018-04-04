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
        //$base = A('Account/Base');
        // $user_where['userid'] = $this->get_user_id();
        $search_project_id = I("pid", 0, "intval");
        $search_batch_id = I("bid", 0, "intval");
        $this->assign('search_project_id', $search_project_id);
        $uid = $this->get_user_id();
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
        $all_auth = M()->table("xk_user")->where("id=$uid")->find();
        $this->assign('user_info', $all_auth);
        if ($all_auth['is_all'] == 1) {
            $this->assign('reset', '1');
        } else {
            $reset = M()->table("xk_station2user s")->join('xk_fun_station f ON f.station_id=s.station_id')->where("s.userid=$uid AND f.fun_id=34")->find();
            $this->assign('reset', $reset ? '1' : '2');
        }

        //付款方式权限
        $pay_auth = M()->table("xk_pzcsvalue")->field("id")->where("project_id =$search_project_id AND batch_id=$search_batch_id AND pzcs_id=6 AND cs_value=-1")->find();
        //诚意金编号权限
        $num_auth = M()->table("xk_pzcsvalue")->field("id")->where("project_id =$search_project_id AND batch_id=$search_batch_id AND pzcs_id=9 AND cs_value=-1")->find();
//        $info_auth=explode(";",$info_auth);
        $this->assign('pay_auth', $pay_auth['id']);
        $this->assign('num_auth', $num_auth['id']);

        //当前用户出售
        $user_id = $this->get_user_id_acc();
        /*$user_count = M()->table("xk_roomList r")->field("r.id")->
        join("xk_roomczlog l ON l.room_id=r.id")->
        where("r.proj_id=$search_project_id AND r.is_xf=1 AND is_dq=1 AND l.czuser=$user_id AND l.cztype='选房'")->group("l.room_id")->select();
        */
        $user_count = M()->table("xk_room r")->field("count(1) zc,sum(case when l.room_id is not null then 1 else 0 end) uc")->
        join("LEFT JOIN (select room_id from xk_roomczlog a join (select max(id) as mid from xk_roomczlog  where cztype='选房' group by room_id) b on a.id=b.mid where czuser=$user_id ) l ON l.room_id=r.id")->
        where("r.proj_id=$search_project_id AND r.is_xf=1 ")->select();
        
        //一共出售，
        /*$yg_count = M()->table("xk_roomList")->where("proj_id=$search_project_id AND is_xf=1 and is_dq=1")->count();*/
        
        $this->assign("yg_count", $user_count[0]['zc']);
       
        $this->assign("user_count",  $user_count[0]['uc']);
        
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
            $group_room_floor[$group_room_floor_value['bld_id'] . '_' . $group_room_floor_value['unit']][] = $group_room_floor_value;
        }
        foreach ($group_room_no as $group_room_no_key => $group_room_no_value) {
            $group_room_no[$group_room_no_value['bld_id'] . '_' . $group_room_no_value['unit'] . '_' . $group_room_no_value['floor']][] = $group_room_no_value;
        }

        //楼栋每层房间数量
        $group_room_floor_no = $Roomview->getRoomListGroupBy('bld_id, unit, floor, no, room', 'bld_id, unit, no', 'no ASC', $where);
        $build_unit_room_list = array();
        foreach ($group_room_floor_no as $group_room_floor_no_key => $group_room_floor_no_value) {
            $build_unit_room_list[$group_room_floor_no_value['bld_id'] . '_' . $group_room_floor_no_value['unit']][$group_room_floor_no_value['no']] = $group_room_floor_no_value;
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
                if (isset($group_room_floor[$build_id . '_' . $unit_id])) {
                    $floors = $group_room_floor[$build_id . '_' . $unit_id];
                }

                foreach ($floors as $floors_key => $floors_value) {
                    $floor_id = $floors_value['floor'];

                    $build_floors = $build_room_floor_list[$build_id];
                    $unit_rooms = $build_unit_room_list[$build_id . '_' . $unit_id];

                    $rooms = array();
                    if (isset($group_room_no[$build_id . '_' . $unit_id . '_' . $floor_id])) {
                        $old_rooms = $group_room_no[$build_id . '_' . $unit_id . '_' . $floor_id];
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
            'room_name' => $build['buildname'] . '-' . $room['unit'] . '-' . $room['floor'] . $room['no'],
            'room_number' => $build['buildname'] . '-' . $room['unit'] . '-' . $room['floor'] . $room['no'],
            'room_no' => $room['floor'] . $room['no'],
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
        $room['xftime'] = $time;
        $room['phone'] = rsa_decode($room['phone'], getChoosekey());
        $room['cardno'] = rsa_decode($room['cardno'], getChoosekey());
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
        $is_havexf = 0;
        $is_xfzg = 0;//选房资格控制
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
            $is_havexf = 1;
        }

        $Model = new \Think\Model();
        $csthaveroom = $Model->query("SELECT a.*,b.id rid,y.id yid FROM xk_choose a LEFT JOIN  xk_room  b  ON  b.cstid=a.id  LEFT JOIN  xk_yaohresult  y  ON  y.cstid=a.id WHERE a.id= " . $cstid );
        if (!empty($csthaveroom[0]['rid'])) {
            $this->error('此客户已经购买其它房源！', U('room/index'));
        }
        $project_id=$csthaveroom[0]['project_id'];
        $batch_id=$csthaveroom[0]['batch_id'];
        $pd = M()->table("xk_pzcsvalue")->field("cs_value")->where('project_id=' . $project_id . ' and batch_id=' . $batch_id . ' and pzcs_id=12')->find();
        if ($pd['cs_value'] == 3) {
            if ($csthaveroom[0]['is_admission'] == 0) {
                $is_xfzg=4;
            }
        } else if ($pd['cs_value'] == 2) {
            $ms = M()->table("xk_pzcsvalue")->field("cs_value")->where('project_id=' . $project_id . ' and batch_id=' . $batch_id . ' and pzcs_id=11')->find();
            if ($ms) {
                if ($ms['cs_value'] == 1 && empty($csthaveroom[0]['yid'])) {
                    $is_xfzg=1;
                } else if ($ms['cs_value'] == 2 && empty($csthaveroom[0]['cyjno'])) {
                    $is_xfzg=2;
                } else if ($ms['cs_value'] == 3 && $csthaveroom[0]['is_sign'] == 0) {
                    $is_xfzg=3;
                }
            } else {
                if (empty($csthaveroom[0]['yid'])) {
                    $is_xfzg=1;
                }
            }
        }
        $data = array(
            'status' => '选房',
            'is_xf' => 1,
            'xftime' => time(),
            'cstid' => $cstid,
            'cstname' => $cstname,
            'is_qxxf' => 0,
        );
        $cjtotal="";
        if ($pay == '') {
            $cjtotal = $room['total'];
        } else if ($pay == '一次性') {
            $cjtotal = $room['ycx_price'];
        } else if ($pay == '分期') {
            $cjtotal = $room['fq_price'];
        } else if ($pay == '按揭') {
            $cjtotal = $room['aj_price'];
        } else if ($pay == '公积金') {
            $cjtotal = $room['gjj_price'];
        }

        if ($is_havexf === 0 && $is_xfzg === 0) {
            $user_id = $this->get_user_id_acc();
            $user = D("User")->getOneById($user_id);
            $roominfo = D('Room');
            
             //交易表
            $obj = array(
              'yw_id' => $room['id']
            , 'room_id' => $room['id']
            , 'cst_id' => $cstid
            , 'source' => '快速选房'
            , 'status' => '选房'
            , 'isyx' => 1
            , 'tradetime' => time()
            , 'ywy' => ''
            , 'xfuserid' => $user_id
            , 'xfuser' => $user['name']
            , 'createdbyid' => $user_id
            , 'createdby' => $user['name']
            , 'pay' => $pay
            , 'cjtotal' => $cjtotal
            ,'ip' =>get_client_ip(0, true)        
            );
            
            //事物操作保证数据一致性
            $roominfo->startTrans();
            try{
            //房间表
                $check_has_edit = $roominfo->editRoomById($data, $id);
                D("Trade")->add($obj);
                //房间操作日志表
                D("RoomLog")->choose($room['id'], $user_id, $user['name'], $cstid);
                $roominfo->commit();
            }catch (\Exception $e){
                $roominfo->rollback();
                $this->error('选房失败，请稍候重试！');
            }
            $res = M()->table("xk_room r")->field("p.name pname,b.buildname bname,r.unit,r.floor,r.room,p.id as project_id,b.pc_id as batch_id")->join("xk_project p ON r.proj_id=p.id")->join("xk_build b ON b.id=r.bld_id")->where('r.id=' . $room['id'])->find();
            //是否打印小票
            $pzcs=M("pzcsvalue")->where("pzcs_id = 14  and project_id={$res['project_id']} and batch_id={$res['batch_id']}")->find();
            if(empty($pzcs) || $pzcs['cs_value']==1)
            {
                //打印小票
                //$userinfo=M("user")->where("id={$user['id']}")->find();
                if(!empty($user['machine_code']))
                {
                    $chooseinfo=M()->table("xk_choose")->field("customer_name,customer_phone,cardno,cyjno")->where("id=".$cstid)->find();
                    $res['customer_name'] = $chooseinfo['customer_name'];
                    $res['cyjno'] = $chooseinfo['cyjno'];
                    $res['cardno'] =  $chooseinfo['cardno'];  
                    $res['customer_phone'] =  $chooseinfo['customer_phone'];  
                    $res['czy']=$user['name'];
                    $res['tm']=date("Y-m-d H:i:s",time());

                    $printer[0]=$user['machine_code'];
                    $printer[1]=$user['mkey'];
                    $this->cloudPrint($res,$printer);
                }
            }
        }

        //获取当天选房的最新记录
        $dqtime = date('Y-m-d');
        $rooms = $Model->query("SELECT a.*, FROM_UNIXTIME(a.xftime,'%Y-%m-%d  %H:%i') AS xftime1  FROM xk_roomlist a WHERE a.proj_id=" . $project_id . " AND ((a.is_xf=1 AND FROM_UNIXTIME(a.xftime,'%Y-%m-%d')='" . $dqtime . "') OR a.is_qxxf=1 ) AND 666=666 ORDER BY a.xftime DESC,a.bld_id,a.unit,a.floor DESC,a.no,a.id ASC ");
        $user_id = $this->get_user_id_acc();
        $user_count = M()->table("xk_room r")->field("count(1) zc,sum(case when l.room_id is not null then 1 else 0 end) uc")->
        join("LEFT JOIN (select room_id from xk_roomczlog a join (select max(id) as mid from xk_roomczlog  where cztype='选房' group by room_id) b on a.id=b.mid where czuser=$user_id ) l ON l.room_id=r.id")->
        where("r.proj_id=$project_id AND r.is_xf=1 ")->select();
        $data = array();
        $data[0] = $is_havexf;
        $data[1] = $rooms;
        $data[2] = $user_count;
        $data[3] = date("Y-m-d H:i", time());
        $data[4] = $is_xfzg;
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

        D("RoomLog")->choose($room_id, $user_id, $user_name, $cstid);
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
        //获取ID
        $id = I('id', 0, 'intval');
        $is_first = I('is_first', 0, 'intval');
        $uid = $this->get_user_id();
        if(empty($is_first) || $is_first==0)
        {
            //取消选房权限
            $all_auth = M()->table("xk_user")->where("id=$uid")->find();
            if ($all_auth['is_all'] != 1) {
                $reset = M()->table("xk_station2user s")->join('xk_fun_station f ON f.station_id=s.station_id')->where("s.userid=$uid AND f.fun_id=34")->find();
                if (!$reset) {
                    $this->error('你没有权限取消房间，请刷新后重试！', U('room/index'));
                }
            }
        }
        
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
            'status' => '待售',
            'is_xf' => 0,
            'xftime' => '',
            'cstname' => '',
            'cstid' => 0,
            'is_qxxf' => 1,
            'qxxftime' => time(),
        );

        $user_id = $this->get_user_id_acc();
        $user = D("User")->getOneById($user_id);
        $czuser = M()->table("xk_roomczlog")->field("czuser")->where("room_id=$id AND cztype='选房'")->order("id desc")->find();
        if ($czuser['czuser'] == $user_id) {
            $a = 1;
        } else {
            $a = 2;
        }
        //获取交易状态
        $trade=M()->table("xk_trade")->where("room_id = {$room['id']} and isyx=1")->find();
        $roominfo = D('Room');
        //事物操作保证数据一致性
        $roominfo->startTrans();
        try{
            //房间表
            $check_has_edit = $roominfo->editRoomById($data, $id);
            //删除交易记录
            if($trade){
                if($trade['status']=='认购' || $trade['status']=='签约')
                {
                    M()->table("xk_trade")->where("id={$trade['id']} and isyx=1")->save(["isyx" => 0,'closereason'=>'取消选房']);
                }
                else
                {
                     D("Trade")->where("id={$trade['id']}")->delete();
                }
            }
            //房间操作日志表
            D("RoomLog")->notChoose($room['id'], $user_id, $user['name']);
            $roominfo->commit();
            $this->success($a);
        }catch (\Exception $e){
             $roominfo->rollback();
             $this->error('取消选房失败，请稍候重试！');
        }
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
                    'room_name' => $build['buildname'] . '-' . $room['unit'] . '-' . $room['room'],
                    'room_number' => $build['buildname'] . '-' . $room['unit'] . '-' . $room['room'],
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
    public function search_room_name()
    {
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试！', U('room/index'));
        }

        $search_info = I('custname', '', 'trim');
        if (empty($search_info)) {
            $this->error('搜索条件为空，请确认后重试！', U('room/index'));
        }
        $model = M();
        $uid = $model->table("xk_choose")->field("id")->where("customer_name like '%{$search_info}%'")->select();
        if (!$uid) {
            echo "false1";
            exit;
        }
        $arr = [];
        for ($i = 0; $i < count($uid); $i++) {
            $arr[] = $uid[$i]['id'];
        }
        $arr_string = implode(",", $arr);
        $bh = $uid = $model->table("xk_room")->field("id,room")->where("cstid in ({$arr_string})")->select();
        if ($bh) {
            echo json_encode($bh);
            exit;
        } else {
            echo "false1";
            exit;
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
        $search_info = I('info', '', 'trim');
        $type = I('stype', '', 'trim');
        $project_id = I('project_id', '', 'trim');
        $room_id = I('room_id', '', 'trim');
        $where['id'] = $room_id;
        $where[] = "1=1";
        $room = D("Roomview")->getOne($where);
        $batch_id = $room['pc_id'];
        $this->assign('search_info', $search_info);
        unset($where);
        if ($type == 0) {
            $where['choose.cyjno'] = $search_info;
        } else if ($type == 1) {
            $where['choose.customer_name'] = $search_info;
        } else if ($type == 2) {
            $where['like_p'] = strencode($search_info);
        } else if ($type == 3) {
            $like_where['like_c'] = array('like', '%' . strencode($search_info) . '%');
            $ike_where['_logic'] = 'or';
            $where['_complex'] = $like_where;
        }
        $pd = M()->table("xk_pzcsvalue")->field("cs_value")->where('project_id=' . $project_id . ' and batch_id=' . $batch_id . ' and pzcs_id=12')->find();
        $where['choose.project_id'] = $project_id;
        $where['choose.batch_id'] = $batch_id;
        $where['choose.status'] = 1;
//                $where["rm1.id"] = array('exp', 'is null');
        /*$ChooseView = D('Common/ChooseView');
        $csts = $ChooseView->getList($where, "*","id");*/
        $csts =  M("choose choose")
                ->join(" left join xk_Project Project ON Choose.project_id = Project.id ")
                ->join(" left join xk_kppc Kppc ON Choose.batch_id = Kppc.id  ")
                ->join(" left join xk_roomlist rm1 ON rm1.cstid = Choose.id ")
                ->join(" left join xk_roomlist rm2 ON rm2.id = Choose.room ")
                ->join(" LEFT JOIN xk_user us ON us.mobile = Choose.ywyphone and us.cp_id=Project.cp_id ")
                ->join(" LEFT JOIN xk_yaohresult y ON y.cstid = Choose.id and y.is_yx=1 ")
                ->field("Choose.id AS id,Choose.project_id AS project_id,Choose.batch_id AS batch_id,Choose.customer_name AS customer_name,Choose.customer_phone AS customer_phone,Choose.cardno AS cardno,Choose.cyjno AS cyjno,Choose.row_number AS row_number,Choose.money AS money,Choose.area AS area,Choose.price AS price,Choose.house_type AS house_type,Choose.floor AS floor,Choose.room AS room,Choose.password AS password,Choose.status AS status,Choose.add_time AS add_time,Choose.add_ip AS add_ip,Choose.ywy AS ywy,Choose.ywyphone AS ywyphone,Choose.like_c AS like_c,Choose.like_p AS like_p,Choose.is_admission AS is_admission,Choose.is_sign AS is_sign,Project.id AS project_id,Project.name AS project_name,Project.cp_id AS project_cp_id,Project.address AS project_address,Project.mobile AS project_mobile,Project.projfzr AS project_projfzr,Project.createdate AS project_createdate,Project.status AS project_status,Kppc.id AS batch_id,Kppc.proj_id AS batch_project_id,Kppc.name AS batch_name,Kppc.kptime AS batch_open_time,Kppc.roomscount AS batch_rooms_count,rm1.id AS room_id,rm1.buildname AS buildname,rm1.unit AS unit,rm1.floor AS floor,rm1.room AS rm,rm2.buildname AS buildname_one,rm2.unit AS unit_one,rm2.floor AS floor_one,rm2.room AS rm_one,us.id AS us_id,y.id AS yid ")
                ->where($where)
                ->order("CONVERT(Choose.cyjno,SIGNED) ASC,Choose.id ASC")->select();
        
        if (count($csts) > 0) {
            if (count($csts) === 1) {
                if ($pd['cs_value'] == 3) {
                    if ($csts[0]['is_admission'] == 0) {
                        $this->error("入场后才能进行选房！");
                    }
                } else if ($pd['cs_value'] == 2) {
                    $ms = M()->table("xk_pzcsvalue")->field("cs_value")->where('project_id=' . $project_id . ' and batch_id=' . $batch_id . ' and pzcs_id=11')->find();
                    if ($ms) {
                        if ($ms['cs_value'] == 1 && empty($csts[0]['yid'])) {
                            $this->error("摇号后才能进行选房！");
                        } else if ($ms['cs_value'] == 2 && empty($csts[0]['cyjno'])) {
                            $this->error("有诚意金排号才能进行选房！");
                        } else if ($ms['cs_value'] == 3 && $csts[0]['is_sign'] == 0) {
                            $this->error("签到后才能进行选房！");
                        }
                    } else {
                        if (empty($csts[0]['yid'])) {
                            $this->error("摇号后才能进行选房！");
                        }
                    }
                }
                $csts[0]['customer_phone'] = rsa_decode($csts[0]['customer_phone'], getChoosekey());
                $csts[0]['cardno'] = rsa_decode($csts[0]['cardno'], getChoosekey());
            } else {
                $ms = M()->table("xk_pzcsvalue")->field("cs_value")->where('project_id=' . $project_id . ' and batch_id=' . $batch_id . ' and pzcs_id=11')->find();
                for ($i = 0; $i < count($csts); $i++) {
                    if ($pd['cs_value'] == 3) {
                        if ($csts[$i]['is_admission'] == 0) {
                            $csts[$i]['pd'] = 4;
                        }
                    } else if ($pd['cs_value'] == 2) {
                        if ($ms) {
                            if ($ms['cs_value'] == 1 && empty($csts[$i]['yid'])) {
                                $csts[$i]['pd'] = 1;
                            } else if ($ms['cs_value'] == 2 && empty($csts[$i]['cyjno'])) {
                                $csts[$i]['pd'] = 2;
                            } else if ($ms['cs_value'] == 3 && $csts[$i]['is_sign'] == 0) {
                                $csts[$i]['pd'] = 3;
                            }
                        } else {
                            if (empty($csts[$i]['yid'])) {
                                $csts[$i]['pd'] = 1;
                            }
                        }
                    }
                    $csts[$i]['customer_phone'] = rsa_decode($csts[$i]['customer_phone'], getChoosekey());
                    $csts[$i]['cardno'] = rsa_decode($csts[$i]['cardno'], getChoosekey());
                }
            }

        }
        //获取相关信息
        $this->success($csts, U('room/index'));
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
        $dqtime = date('Y-m-d');
        $rooms = $Model->query("SELECT a.*, FROM_UNIXTIME(a.xftime,'%Y-%m-%d  %H:%i') AS xftime1  FROM xk_roomlist a WHERE a.proj_id=" . $projid . " AND a.is_xf=1 AND FROM_UNIXTIME(a.xftime,'%Y-%m-%d')='" . $dqtime . "' AND 666=666 ORDER BY a.xftime DESC,a.bld_id,a.unit,a.floor DESC,a.no,a.id ASC ");
        // }
        $this->success($rooms);
    }

    /**
     * 打印选房小票
     *
     * @create 2018-03-22
     * @author qzb
     */
    public function print_xp()
    {
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试！', U('room/index'));
        }
        $id = I('id', 0, 'intval');
        $cstname = I('cstname', '', 'trim');
        $cyjno = I('cyjno', '', 'trim');
        $cardno = I('cardno', '', 'trim');
        $phone = I('phone', '', 'trim');
        $res = M()->table("xk_room r")->field("p.name pname,b.buildname bname,r.unit,r.floor,r.room,t.tradetime tm,p.id as project_id,b.pc_id as batch_id")->join("xk_project p ON r.proj_id=p.id")->join("xk_build b ON b.id=r.bld_id")->join("xk_trade t ON t.room_id=r.id")->where('r.id=' . $id)->find();
        if (!$res) {
            $this->error("数据异常，请重试！");
        }
        
        //是否打印小票
        $pzcs=M("pzcsvalue")->where("pzcs_id = 14  and project_id={$res['project_id']} and batch_id={$res['batch_id']}")->find();
        if(empty($pzcs) || $pzcs['cs_value']==1)
        {
            $uid=$this->get_user_id();
            //打印小票
            $user=M("user")->where("id={$uid}")->find();
            if(!empty($user['machine_code']))
            {
                //$chooseinfo=M()->table("xk_choose")->field("customer_name,customer_phone,cardno,cyjno")->where("id=".$cstid)->find();
                $res['customer_name'] = $cstname;
                $res['cyjno'] = $cyjno;
                $res['cardno'] =  rsa_encode($cardno,getChoosekey());  
                $res['customer_phone'] =  rsa_encode($phone,getChoosekey());  
                $res['czy']=$user['name'];
                $res['tm']=date("Y-m-d H:i:s",$res['tm']);
                $printer[0]=$user['machine_code'];
                $printer[1]=$user['mkey'];
                $this->cloudPrint($res,$printer);
            }
        }
        $this->success("打印中，请稍后...");
    }

    function liansuo_post($url, $data)
    { // 模拟提交数据函数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检测
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:')); //解决数据包大不能提交
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_COOKIEFILE, $GLOBALS['cookie_file']); // 读取上面所储存的Cookie信息
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回

        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl);
        }
        curl_close($curl); // 关键CURL会话
        return $tmpInfo; // 返回数据
    }

    function generateSign($params, $apiKey, $msign)
    {
        //所有请求参数按照字母先后顺序排
        ksort($params);
        //定义字符串开始所包括的字符串
        $stringToBeSigned = $apiKey;
        //把所有参数名和参数值串在一起
        foreach ($params as $k => $v) {
            $stringToBeSigned .= urldecode($k . $v);
        }
        unset($k, $v);
        //定义字符串结尾所包括的字符串
        $stringToBeSigned .= $msign;
        //使用MD5进行加密，再转化成大写
        return strtoupper(md5($stringToBeSigned));
    }

//打印示例
    function cloudPrint($data,$printer)
    {
        $machine_code = $printer[0];//打印机终端号
        $mKey= $printer[1];//打印机秘钥
        $no = $data['bname'] . '-' . $data['unit'] . '单元-' .$data['room'];
        //打印内容
        $msg = "";
        $data['customer_phone']=rsa_decode($data['customer_phone'],getChoosekey());
        $data['cardno']=rsa_decode($data['cardno'],getChoosekey());
        $nolist=$pieces = explode(";", $data['cardno']);
        
        $msg .='@@2        【天誉珑城】\n';
        $msg .='@@2         房源确认单\n\n';
        $msg .="@@2选房顺序号: 《 {$data['cyjno']} 》 \n";
        $msg .="@@2客户姓名:{$data['customer_name']}\n";
       
        foreach($nolist as $k => $v)
        {
            if($k==0)
            {
                $msg .="身份证号:{$v}\n";
            }else
            {
                 $msg .="         {$v}\n";
            }
        }
        $msg .= "认购时间:{$data['tm']}\n";
        $msg .= "@@2认购房间:{$no}\n";
        //$msg .= "@@2 {$no}\n";
        $msg .= "操作员:{$data['czy']}\n\n\n\n";
        $msg .= "说明:请在15分钟内到指定区域打印认购书，否则我司有权将此房屋另售他人，不再另行通知!";
  
        $partner= C("PANTNER_ID");
        $apiKey= C("PANTNER_KEY");
        
        $ti = time();
        $params = array(
            'partner' => $partner,
            'machine_code' => $machine_code,
            'time' => $ti
        );
        $sign = $this->generateSign($params, $apiKey, $mKey);
        $params['sign'] = $sign;
        $params['content'] = $msg;
        $url = 'http://open.10ss.net:8888';//打印接口端点
        $p = '';
        foreach ($params as $k => $v) {
            $p .= $k . '=' . $v . '&';
        }
        $data = rtrim($p, '&');
        $isprint = $this->liansuo_post($url, $data);
    }
}