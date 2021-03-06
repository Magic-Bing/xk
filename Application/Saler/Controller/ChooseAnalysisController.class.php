<?php
/**
 * Created by PhpStorm.
 * User: qzb
 * Date: 2018/1/11 0011
 * Time: 9:43
 * content: 客户分析类
 */

namespace Saler\Controller;


class ChooseAnalysisController extends Base1Controller
{
    //显示客户分析页面
    public function index(){
        $status=I("status",1,"intval");
        $search=I("search",'',"trim");
        $uid=$this->get_user_id();
        $userinfo=M()->table("xk_user")->where("id=$uid")->find();
        if (empty($userinfo) || count($userinfo)<1)
            $this->error('用户登录信息异常，请重新登录！', U('logging/index'));
        $pd_user=M()->table("xk_station2user su")->join("xk_fun_station fs ON fs.station_id=su.station_id")->where("userid=$uid AND fs.fun_id=101")->find();
        $search_info = I('info', '', 'trim');
//        echo $search_info."-".$status;exit;
        $search_hd_id = get_search_id_by($search_info, 'p');
        $projinfo=M("project p")->join("xk_event_order_house e ON e.project_id = p.id")->where("e.id=".$search_hd_id)->field("p.id,p.name pname,e.name ename,e.batch_id")->find();
     /*   if($pd_user){//当$pd_user不为空的时候查看所有客户
            $user_xf=M()->table("xk_choose c")->field("count(1) zrs,SUM(CASE WHEN oh.id IS NULL THEN 0 ELSE 1 END) ydl,SUM(CASE WHEN oh.id IS NULL THEN 1 ELSE 0 END) wdl,SUM(CASE WHEN oh.id IS  NOT NULL AND r.id IS NOT NULL THEN 1 ELSE 0 END) yxf,SUM(CASE WHEN oh.id IS  NOT NULL AND r.id IS NULL THEN 1 ELSE 0 END) wxf")->join('LEFT JOIN xk_room r ON r.cstid=c.id')->join("LEFT JOIN xk_order_house_phone_login oh ON oh.phone=c.customer_phone")->where("c.project_id={$projinfo['id']} AND c.batch_id={$projinfo['batch_id']}")->find();
        }else{
            $user_xf=M()->table("xk_choose c")->field("count(1) zrs,SUM(CASE WHEN oh.id IS NULL THEN 0 ELSE 1 END) ydl,SUM(CASE WHEN oh.id IS NULL THEN 1 ELSE 0 END) wdl,SUM(CASE WHEN oh.id IS  NOT NULL AND r.id IS NOT NULL THEN 1 ELSE 0 END) yxf,SUM(CASE WHEN oh.id IS  NOT NULL AND r.id IS NULL THEN 1 ELSE 0 END) wxf")->join('LEFT JOIN xk_room r ON r.cstid=c.id')->join("LEFT JOIN xk_order_house_phone_login oh ON oh.phone=c.customer_phone")->where("c.project_id={$projinfo['id']} AND c.batch_id={$projinfo['batch_id']} AND c.ywy='{$userinfo['name']}'")->find();
        }*/
        if(!empty($search)){
            $s="AND (c.customer_name like '%{$search}%' OR c.like_p like '%".strencode($search)."%')";
        }else{
            $s="";
        }
        if($pd_user){
            $p="";
        }else{
             $p=" AND c.ywyphone='{$userinfo['mobile']}'";
        }
        $user_xf="";
        if(empty($status)){
            $this->error('数据异常，请重新登录！', U('logging/index'));
        }else{
            if($status===1){
                $user_xf=M()->table("xk_choose c")->
                field("c.id,r.id rid,oh.id oid,c.customer_name,c.customer_phone")->
                join('LEFT JOIN xk_room r ON r.cstid=c.id')->
                join("LEFT JOIN ( select * from xk_order_house_phone_login  where event_id={$search_hd_id} group by phone) oh ON oh.phone=c.customer_phone")->
                where("c.project_id={$projinfo['id']} AND c.batch_id={$projinfo['batch_id']} AND c.status=1 $p $s")->
                order("case when oid is null then 0 else 1 end ,case when rid is null then 0 else 1 end ,c.cyjno,c.id")->
                select();
            }elseif($status===2){
                $user_xf=M()->table("xk_choose c")->
                field("c.id,r.id rid,oh.id oid,c.customer_name,c.customer_phone")->
                join('LEFT JOIN xk_room r ON r.cstid=c.id')->
                join("LEFT JOIN ( select * from xk_order_house_phone_login  where event_id={$search_hd_id} group by phone) oh ON oh.phone=c.customer_phone")->
                where("c.project_id={$projinfo['id']} AND c.batch_id={$projinfo['batch_id']} AND c.status=1 AND oh.id IS NULL $p $s")->
                order("case when oid is null then 0 else 1 end ,case when rid is null then 0 else 1 end ,c.cyjno,c.id")->
                select();
            }elseif($status===3){
                $user_xf=M()->table("xk_choose c")->
                field("c.id,r.id rid,oh.id oid,c.customer_name,c.customer_phone")->
                join('LEFT JOIN xk_room r ON r.cstid=c.id')->
                join("( select * from xk_order_house_phone_login  where event_id={$search_hd_id} group by phone) oh ON oh.phone=c.customer_phone")->
                where("c.project_id={$projinfo['id']} AND c.batch_id={$projinfo['batch_id']} AND c.status=1 $p $s")->
                order("case when oid is null then 0 else 1 end ,case when rid is null then 0 else 1 end ,c.cyjno,c.id")->
                select();
            }elseif($status===4){
                $user_xf=M()->table("xk_choose c")->
                field("c.id,r.id rid,oh.id oid,c.customer_name,c.customer_phone")->
                join('LEFT JOIN xk_room r ON r.cstid=c.id')->
                join("( select * from xk_order_house_phone_login  where event_id={$search_hd_id} group by phone) oh ON oh.phone=c.customer_phone")->
                where("c.project_id={$projinfo['id']} AND c.batch_id={$projinfo['batch_id']} AND c.status=1 AND r.id IS NULL $p $s")->
                order("case when oid is null then 0 else 1 end ,case when rid is null then 0 else 1 end ,c.cyjno,c.id")->
                select();
            } else{
                $user_xf=M()->table("xk_choose c")->
                field("c.id,r.id rid,oh.id oid,c.customer_name,c.customer_phone")->
                join('xk_room r ON r.cstid=c.id')->
                join("( select * from xk_order_house_phone_login  where event_id={$search_hd_id} group by phone) oh ON oh.phone=c.customer_phone")->
                where("c.project_id={$projinfo['id']} AND c.batch_id={$projinfo['batch_id']} AND c.status=1  $p $s")->
                order("c.cyjno,c.id")->
                select();
            }
        }
        $tylelist=array( 1 => '全部客户',2 => '未登录',3 => '已登录',4 => '已登录未选',5 => '已登录已选');
        $this->assign("tylelist",$tylelist);
        $this->assign("status",$status);
        $this->assign("user_xf",$user_xf);
        $this->assign('projinfo', $projinfo);
        $this->assign("search_info",$search_info);
        $this->assign("project_id",$search_hd_id);//此为活动id，不是项目id
        if(IS_AJAX){
            echo $this->fetch("ChooseAnalysis/user_list");
        }else{
            $this->display();
        }

    }
    /*
     * 显示客户分析页面
     * qzb
     * 2018-3-2*/
    public function dz_index(){
        $status=I("status",1,"intval");
        $search=I("search",'',"trim");
        $uid=$this->get_user_id();
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
        $userinfo = M()->table("xk_user")->where("id=$uid")->find();
        $pd_user=M()->table("xk_station2user su")->join("xk_fun_station fs ON fs.station_id=su.station_id")->where("userid=$uid AND fs.fun_id=101")->find();
        if(!empty($search)){
            $s="AND (c.customer_name like '%{$search}%' OR c.like_p like '%".strencode($search)."%')";
        }else{
            $s="";
        }
        if($pd_user){
            $p="";
        }else{
            $p=" AND c.ywyphone='{$userinfo['mobile']}'";
        }
        $user_xf="";
        if(empty($status)){
            $this->error('数据异常，请重新登录！', U('logging/index'));
        }else{
            if($status===1){
                $user_xf=M()->table("xk_choose c")->
                field("c.id,r.id rid,c.customer_name,c.customer_phone,c.is_sign")->
                join('LEFT JOIN xk_room r ON r.cstid=c.id')->
                where("c.project_id=$pid AND c.batch_id=$bid AND c.status=1 $p $s ")->
                order("case when c.is_sign=0 then 0 else 1 end ,case when rid is null then 0 else 1 end ,c.cyjno,c.id")->
                select();
            }elseif($status===2){
                $user_xf=M()->table("xk_choose c")->
                field("c.id,r.id rid,c.customer_name,c.customer_phone,c.is_sign")->
                join('LEFT JOIN xk_room r ON r.cstid=c.id')->
                where("c.project_id=$pid AND c.batch_id=$bid AND c.status=1 AND c.is_sign=0 $p $s")->
                order("case when c.is_sign=0 then 0 else 1 end ,case when rid is null then 0 else 1 end ,c.cyjno,c.id")->
                select();
            }elseif($status===3){
                $user_xf=M()->table("xk_choose c")->
                field("c.id,r.id rid,c.customer_name,c.customer_phone,c.is_sign")->
                join('LEFT JOIN xk_room r ON r.cstid=c.id')->
                where("c.project_id=$pid AND c.batch_id=$bid AND c.status=1 AND c.is_sign=1 $p $s")->
                order("case when c.is_sign=0 then 0 else 1 end ,case when rid is null then 0 else 1 end ,c.cyjno,c.id")->
                select();
            }elseif($status===4){
                $user_xf=M()->table("xk_choose c")->
                field("c.id,r.id rid,c.customer_name,c.customer_phone,c.is_sign")->
                join('LEFT JOIN xk_room r ON r.cstid=c.id')->
                where("c.project_id=$pid AND c.batch_id=$bid AND c.status=1 AND c.is_sign=1 AND r.id IS NULL $p $s")->
                order("case when c.is_sign=0 then 0 else 1 end ,case when rid is null then 0 else 1 end ,c.cyjno,c.id")->
                select();
            }elseif($status===5){
                $user_xf=M()->table("xk_choose c")->
                field("c.id,r.id rid,c.customer_name,c.customer_phone,c.is_sign")->
                join('xk_room r ON r.cstid=c.id')->
                where("c.project_id=$pid AND c.batch_id=$bid AND c.is_sign=1 AND c.status=1 $p $s")->
                order("c.cyjno,c.id")->
                select();
            }elseif($status===6){
                $user_xf=M()->table("xk_choose c")->
                field("c.id,r.id rid,c.customer_name,c.customer_phone")->
                join('LEFT JOIN xk_room r ON r.cstid=c.id')->
                join('xk_yaohresult y ON y.cstid=c.id and y.is_yx=1')->
                where("c.project_id=$pid AND c.batch_id=$bid  AND c.status=1 $p $s")->
                order("c.cyjno,c.id")->
                select();
            }elseif($status===7){
                $user_xf=M()->table("xk_choose c")->
                field("c.id,r.id rid,c.customer_name,c.customer_phone")->
                join('LEFT JOIN xk_room r ON r.cstid=c.id')->
                where("c.project_id=$pid AND c.batch_id=$bid AND c.is_admission=1  AND c.status=1 $p $s")->
                order("c.cyjno,c.id")->
                select();
            }elseif($status===8){
                $user_xf=M()->table("xk_choose c")->
                field("c.id,r.id rid,c.customer_name,c.customer_phone")->
                join('xk_room r ON r.cstid=c.id')->
                where("c.project_id=$pid AND c.batch_id=$bid  AND c.status=1 and r.status in('认购','签约') $p $s")->
                order("c.cyjno,c.id")->
                select();
            } elseif($status===9){
                $cs_res=M()->table("xk_pzcsvalue")->field("cs_value")->where('pzcs_id=16 and project_id='.$pid.' and batch_id='.$bid)->find();//查询超时时间
                if($cs_res){
                    $cs_time=(int)$cs_res['cs_value'];
                }else{
                    $cs_time=30;
                }
                $user_xf=M()->table("xk_choose c")->
                field("c.id,r.id rid,c.customer_name,c.customer_phone")->
                join('xk_room r ON r.cstid=c.id')->
                join('xk_trade  t ON t.room_id=r.id and t.isyx=1')->
                where("c.project_id=$pid AND c.batch_id=$bid  AND c.status=1 AND TIMESTAMPDIFF(MINUTE, FROM_UNIXTIME( t.tradetime,'%Y-%m-%d  %H:%i:%s'),now() ) >$cs_time $p $s")->
                order("c.cyjno,c.id")->
                select();
            }
        }
        $tylelist=array( 1 => '全部客户',2 => '未签到',3 => '已签到',4 => '已签到未选',5 => '已签到已选',6 => '已摇号',7 => '已入场',8 => '已认购',9 => '超时未认购');
        $this->assign("tylelist",$tylelist);
        $this->assign("status",$status);
        $this->assign("user_xf",$user_xf);
        $this->assign('projinfo', $projinfo);
        if(IS_AJAX){
            echo $this->fetch("ChooseAnalysis/dz_user_list");
        }else{
            $this->display();
        }

    }
    //客户详情页面
    public function user_detail(){
        //if(!IS_POST)
        //$this->error("非法操作",U("index/index"));
        $cid=I("cid",0,"intval");
        $project=I("project",0,"intval");//此为活动id，不是项目id
        //用户信息及房间选定，及选房时间，登录时间
        $user_info=M()->table("xk_choose c")->
        field("c.customer_name cname,c.customer_phone cphone,c.cardno,c.ywy,c.cyjno,b.buildname bname,r.unit,r.room,r.hx,r.area,r.total,r.id rid,o.id oid,o.logintime,oho.log_time,oho.code,oho.id oho_id")->
        join("LEFT JOIN xk_room r ON r.cstid=c.id")->
        join("LEFT JOIN xk_build b ON b.id=r.bld_id")->
        join("LEFT JOIN xk_order_house_phone_login o ON o.phone=c.customer_phone and o.event_id={$project}")->
        join("LEFT JOIN xk_order_house_order oho ON oho.belong_uid=c.id")->
        where("c.id=$cid")->find();
        //房间收藏信息
        $sc_room=M()->table('xk_cst2rooms cr')->
        field("b.buildname bname,r.id,r.unit,r.room,r.area,r.total,h.hxmx,count(crs.id) sc_count,SUM(CASE WHEN crs.px=1 THEN 1 ELSE 0 END) first_count")->
        join("xk_cst2rooms crs ON cr.room_id=crs.room_id ")->
        join("xk_room r ON r.id=cr.room_id")->
        join("xk_build b ON b.id=r.bld_id")->
        join("xk_hxset h ON h.hx=r.hx")->where("cr.cst_id=$cid")->order("cr.px")->group("cr.id")->select();
//        echo json_encode($sc_room);exit;
        $this->assign('sc_room',$sc_room);
        $this->assign('project_id',$project);
        $this->assign('user_info',$user_info);
        $this->display();
    }
    /*
     * 客户详情页面
     * qzb
     * 2018-3-2*/
    public function dz_user_detail(){
        //if(!IS_POST)
        //$this->error("非法操作",U("index/index"));
        $cid=I("cid",0,"intval");
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
        //用户信息及房间选定，及选房时间，登录时间
        $user_info=M()->table("xk_choose c")->
        field("c.customer_name cname,c.customer_phone cphone,c.cardno,c.ywy,c.cyjno,c.is_sign,c.sign_time,b.buildname bname,r.unit,r.room,r.hx,r.area,r.total,r.id rid,rl.czusername,rl.cztime")->
        join("LEFT JOIN xk_room r ON r.cstid=c.id")->
        join("LEFT JOIN (select Max(id) id,czusername,room_id,cztime from xk_roomczlog where cztype='选房' group by room_id) rl ON r.id=rl.room_id")->
        join("LEFT JOIN xk_build b ON b.id=r.bld_id")->
        where("c.id=$cid")->find();
        $this->assign('user_info',$user_info);
        $this->display();
    }
}