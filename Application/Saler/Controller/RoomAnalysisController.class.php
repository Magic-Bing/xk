<?php
/**
 * Created by PhpStorm.
 * User: qzb
 * Date: 2018/1/12 0012
 * Time: 17:12
 * content: 装户分析
 */

namespace Saler\Controller;


class RoomAnalysisController extends Base1Controller
{
    //装户分析
    public  function index(){


        //分析
        $search_info = I('info', '', 'trim');
        $is_fx = I('is_fx', 0, 'intval');
        $search_hd_id = get_search_id_by($search_info, 'p');
        $projinfo=M("project p")->join("xk_event_order_house e ON e.project_id = p.id")->where("e.id=".$search_hd_id)->field("p.id,p.name pname,e.name ename,e.batch_id")->find();
//        echo json_encode($projinfo);exit;
        if(empty($projinfo))
        {
            session('USER_ID',null);
            $this->error('系统异常，请重新登录！', U('logging/index'));
        }
        if($is_fx === 0 ){
            $search_project_id=$projinfo['id'];
            $bid=$projinfo['batch_id'];
            $user_where['userid'] = $this->get_user_id();
            $user_where['projid'] = $search_project_id;


            //归类楼栋和单元
            $Room = D('Common/Room');
            $Roomview = D('Common/Roomview');
            $where['proj_id'] = $search_project_id;
            $where['pc_id'] = $projinfo['batch_id'];
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

            //条件
            $search_info = array(
                'p' => $search_project_id,
                'b' => $search_build_id,
                'u' => $search_unit_id,
            );
            $this->assign('search_info', $search_info);

            //获取项目
            $project_info = D('Common/Project')->getProjectById($search_project_id);
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
            $room_list=M()->table("xk_roomlist r")->field('SUM(CASE WHEN cr.px=1 THEN 1 ELSE 0 END) first_count,SUM(CASE WHEN cr.id IS NOT NULL  THEN 1 ELSE 0 END) sc_count,r.room,r.floor')->join("LEFT JOIN xk_cst2rooms cr ON cr.room_id=r.id")->where("r.proj_id=$search_project_id AND pc_id=$bid AND r.bld_id=$search_build_id AND r.unit=$search_unit_id")->order("floor DESC, no ASC")->group('r.id')->select();
//        echo json_encode($room_list);exit;
            $new_room_list = array();
            foreach ($room_list as $room_list_key => $room_list_value) {
                $new_room_list[$room_list_value['floor']][] = $room_list_value;
            }
//        $b_name=M()->table("xk_build")->field("buildname")->where("id=$search_build_id")->find();
            $this->assign('rooms', $new_room_list);

//        $this->assign("b_name",$b_name);



        }else{
            $projinfo=M("project p")->join("xk_event_order_house e ON e.project_id = p.id")->where("e.id=".$projinfo['id'])->field("p.id,p.name pname,e.name ename,e.batch_id")->find();
//        echo json_encode($projinfo);exit;
            if(empty($projinfo))
            {
                session('USER_ID',null);
                $this->error('系统异常，请重新登录！', U('logging/index'));
            }
            $pid=$projinfo['id'];
            $bid=$projinfo['batch_id'];
            //楼栋套数和收长次数数据
            $bld_list=M()->table("xk_roomlist r")->field('r.bld_id bid,r.buildname name,SUM(CASE WHEN cr.id IS NOT NULL  THEN 1 ELSE 0 END) sc_count,count(r.id) all_count')->join("LEFT JOIN xk_cst2rooms cr ON cr.room_id=r.id")->where("r.proj_id=$pid AND r.pc_id=$bid")->order("r.buildcode ASC")->group('r.bld_id')->select();
            $arr_name=[];
            $arr_room_count=[];
            $arr_sc_count=[];
            for($i=0;$i<count($bld_list);$i++){
                $arr_name[]=$bld_list[$i]['name'];
                $arr_room_count[]=(int)$bld_list[$i]['all_count'];
                $arr_sc_count[]=(int)$bld_list[$i]['sc_count'];
            }
            $this->assign("arr_name",$arr_name);
            $this->assign("arr_room_count",$arr_room_count);
            $this->assign("arr_sc_count",$arr_sc_count);
            //户型分组柱状图
            //户型下拉框的值
            $Roomview = D('Common/Roomview');
            $where['proj_id'] = $pid;
            $where['pc_id'] = $bid;
            $group_room_build = $Roomview->getRoomListGroupBy('bld_id,buildname', 'bld_id', 'bld_id, id', $where);
            $group_room_unit = $Roomview->getRoomListGroupBy('bld_id, unit', 'bld_id, unit', 'bld_id, unit, id', $where);
            //数据格式化
//            echo json_encode($group_room_build);exit;
            $this->assign('new_units', $group_room_unit);
            $this->assign('group_room_build', $group_room_build);

            $hx_list=M()->table("xk_roomlist r")->field('r.hx,SUM(CASE WHEN cr.id IS NOT NULL  THEN 1 ELSE 0 END) sc_count,count(r.id) all_count')->join("LEFT JOIN xk_cst2rooms cr ON cr.room_id=r.id")->where("r.proj_id=$pid AND r.pc_id=$bid")->order("r.hx ASC")->group('r.hx')->select();
            $hx_name=[];
            $hx_room_count=[];
            $hx_sc_count=[];
            for($i=0;$i<count($hx_list);$i++){
                $hx_name[]="户型:".$hx_list[$i]['hx'];
                $hx_room_count[]=(int)$hx_list[$i]['all_count'];
                $hx_sc_count[]=(int)$hx_list[$i]['sc_count'];
            }
            $this->assign("hx_name",$hx_name);
            $this->assign("hx_room_count",$hx_room_count);
            $this->assign("hx_sc_count",$hx_sc_count);
            //房源热度饼图数据
            $room_list=M()->table("xk_roomlist r")->field('SUM(CASE WHEN cr.px=1 THEN 1 ELSE 0 END) first_count,SUM(CASE WHEN cr.id IS NOT NULL  THEN 1 ELSE 0 END) sc_count,r.id')->join("LEFT JOIN xk_cst2rooms cr ON cr.room_id=r.id")->where("r.proj_id=$pid AND r.pc_id=$bid")->group('r.id')->select();
            $all_count=count($room_list);
            $hot_count=[];
            $hot_count['hot_one']['num']=0;
            $hot_count['hot_two']['num']=0;
            $hot_count['hot_three']['num']=0;
            $hot_count['hot_four']['num']=0;
            $hot_count['hot_five']['num']=0;
            for($i=0;$i<$all_count;$i++){
                if($room_list[$i]['first_count'] > 3){
                    $hot_count['hot_one']['num']+=1;
                }elseif ($room_list[$i]['first_count'] == 2){
                    $hot_count['hot_two']['num']+=1;
                }elseif ($room_list[$i]['first_count'] == 1){
                    $hot_count['hot_three']['num']+=1;
                }elseif ($room_list[$i]['first_count'] == 0 && $room_list[$i]['sc_count'] > 3){
                    $hot_count['hot_four']['num']+=1;
                }else{
                    $hot_count['hot_five']['num']+=1;
                }
            }
            $hot_count['hot_one']['zb']=round($hot_count['hot_one']['num']/$all_count*100,2);
            $hot_count['hot_two']['zb']=round($hot_count['hot_two']['num']/$all_count*100,2);;
            $hot_count['hot_three']['zb']=round($hot_count['hot_three']['num']/$all_count*100,2);;
            $hot_count['hot_four']['zb']=round($hot_count['hot_four']['num']/$all_count*100,2);;
            $hot_count['hot_five']['zb']=round($hot_count['hot_five']['num']/$all_count*100,2);;
            $this->assign("hot_count",$hot_count);

        }
        $this->assign('is_fx',$is_fx);
        $this->assign("project_id",$search_hd_id);
        $this->assign('projinfo', $projinfo);
//        echo $is_fx;exit;
        $this->display();
    }

    //装户统计图形页面，ajax返回页面
    public function imgPage(){
        if(!IS_AJAX){
            $this->error('非法操作！', U('index/index'));
        }
        $hd_id=I("hd_id",0,'intval');
        $projinfo=M("project p")->join("xk_event_order_house e ON e.project_id = p.id")->where("e.id=".$hd_id)->field("p.id,p.name pname,e.name ename,e.batch_id")->find();
//        echo json_encode($projinfo);exit;
        if(empty($projinfo))
        {
            session('USER_ID',null);
            $this->error('系统异常，请重新登录！', U('logging/index'));
        }
        $pid=$projinfo['id'];
        $bid=$projinfo['batch_id'];
        //楼栋套数和收长次数数据
        $bld_list=M()->table("xk_roomlist r")->field('r.bld_id bid,r.buildname name,SUM(CASE WHEN cr.id IS NOT NULL  THEN 1 ELSE 0 END) sc_count,count(r.id) all_count')->join("LEFT JOIN xk_cst2rooms cr ON cr.room_id=r.id")->where("r.proj_id=$pid AND r.pc_id=$bid")->order("r.buildcode ASC")->group('r.bld_id')->select();
        $arr_name=[];
        $arr_room_count=[];
        $arr_sc_count=[];
        for($i=0;$i<count($bld_list);$i++){
            $arr_name[]=$bld_list[$i]['name'];
            $arr_room_count[]=(int)$bld_list[$i]['all_count'];
            $arr_sc_count[]=(int)$bld_list[$i]['sc_count'];
        }
        $this->assign("arr_name",$arr_name);
        $this->assign("arr_room_count",$arr_room_count);
        $this->assign("arr_sc_count",$arr_sc_count);
        //户型分组柱状图
            //户型下拉框的值
            $Roomview = D('Common/Roomview');
            $where['proj_id'] = $pid;
            $where['pc_id'] = $bid;
            $group_room_build = $Roomview->getRoomListGroupBy('bld_id,buildname', 'bld_id', 'bld_id, id', $where);
            $group_room_unit = $Roomview->getRoomListGroupBy('bld_id, unit', 'bld_id, unit', 'bld_id, unit, id', $where);
            //数据格式化
//            echo json_encode($group_room_build);exit;
            $this->assign('new_units', $group_room_unit);
            $this->assign('group_room_build', $group_room_build);

        $hx_list=M()->table("xk_roomlist r")->field('r.hx,SUM(CASE WHEN cr.id IS NOT NULL  THEN 1 ELSE 0 END) sc_count,count(r.id) all_count')->join("LEFT JOIN xk_cst2rooms cr ON cr.room_id=r.id")->where("r.proj_id=$pid AND r.pc_id=$bid")->order("r.hx ASC")->group('r.hx')->select();
        $hx_name=[];
        $hx_room_count=[];
        $hx_sc_count=[];
        for($i=0;$i<count($hx_list);$i++){
            $hx_name[]="户型:".$hx_list[$i]['hx'];
            $hx_room_count[]=(int)$hx_list[$i]['all_count'];
            $hx_sc_count[]=(int)$hx_list[$i]['sc_count'];
        }
        $this->assign("hx_name",$hx_name);
        $this->assign("hx_room_count",$hx_room_count);
        $this->assign("hx_sc_count",$hx_sc_count);
        //房源热度饼图数据
        $room_list=M()->table("xk_roomlist r")->field('SUM(CASE WHEN cr.px=1 THEN 1 ELSE 0 END) first_count,SUM(CASE WHEN cr.id IS NOT NULL  THEN 1 ELSE 0 END) sc_count,r.id')->join("LEFT JOIN xk_cst2rooms cr ON cr.room_id=r.id")->where("r.proj_id=$pid AND r.pc_id=$bid")->group('r.id')->select();
        $all_count=count($room_list);
        $hot_count=[];
        $hot_count['hot_one']['num']=0;
        $hot_count['hot_two']['num']=0;
        $hot_count['hot_three']['num']=0;
        $hot_count['hot_four']['num']=0;
        $hot_count['hot_five']['num']=0;
        for($i=0;$i<$all_count;$i++){
            if($room_list[$i]['first_count'] > 3){
                $hot_count['hot_one']['num']+=1;
            }elseif ($room_list[$i]['first_count'] == 2){
                $hot_count['hot_two']['num']+=1;
            }elseif ($room_list[$i]['first_count'] == 1){
                $hot_count['hot_three']['num']+=1;
            }elseif ($room_list[$i]['first_count'] == 0 && $room_list[$i]['sc_count'] > 3){
                $hot_count['hot_four']['num']+=1;
            }else{
                $hot_count['hot_five']['num']+=1;
            }
        }
        $hot_count['hot_one']['zb']=round($hot_count['hot_one']['num']/$all_count*100,2);
        $hot_count['hot_two']['zb']=round($hot_count['hot_two']['num']/$all_count*100,2);;
        $hot_count['hot_three']['zb']=round($hot_count['hot_three']['num']/$all_count*100,2);;
        $hot_count['hot_four']['zb']=round($hot_count['hot_four']['num']/$all_count*100,2);;
        $hot_count['hot_five']['zb']=round($hot_count['hot_five']['num']/$all_count*100,2);;
        $this->assign("hot_count",$hot_count);
        echo $this->fetch();
    }

    //户型柱状图，下拉框返回值
    public function getHxCount(){
        if(!IS_AJAX){
            $this->error('非法操作！', U('index/index'));
        }
        $vo=I("vo",'','trim');
        $hd_id=I('hd_id',0,"intval");
        $projinfo=M("project p")->join("xk_event_order_house e ON e.project_id = p.id")->where("e.id=".$hd_id)->field("p.id,p.name pname,e.name ename,e.batch_id")->find();
//        echo json_encode($projinfo);exit;
        if(empty($projinfo))
        {
            session('USER_ID',null);
            $this->error('系统异常，请重新登录！', U('logging/index'));
        }
        $pid=$projinfo['id'];
        $bid=$projinfo['batch_id'];
        if($vo==""){
            $b="";
        }else{
            $arr=explode("-",$vo);
            $b="AND r.bld_id={$arr[0]}";
        }
        $hx_list=M()->table("xk_roomlist r")->field('r.hx,SUM(CASE WHEN cr.id IS NOT NULL  THEN 1 ELSE 0 END) sc_count,count(r.id) all_count')->join("LEFT JOIN xk_cst2rooms cr ON cr.room_id=r.id")->where("r.proj_id=$pid AND r.pc_id=$bid $b")->order("r.hx ASC")->group('r.hx')->select();
        $hx_name=[];
        $hx_room_count=[];
        $hx_sc_count=[];
        for($i=0;$i<count($hx_list);$i++){
            $hx_name[]="户型:".$hx_list[$i]['hx'];
            $hx_room_count[]=(int)$hx_list[$i]['all_count'];
            $hx_sc_count[]=(int)$hx_list[$i]['sc_count'];
        }
        $data[]=$hx_name;
        $data[]=$hx_room_count;
        $data[]=$hx_sc_count;
        echo json_encode($data);exit;
    }
}