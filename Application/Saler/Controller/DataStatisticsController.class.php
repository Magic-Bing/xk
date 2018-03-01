<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/8 0008
 * Time: 11:01
 */

namespace Saler\Controller;

/**
 * 项目数据统计列表
 * @create 2018-1-8
 * @author qzb
 */
class DataStatisticsController extends Base1Controller
{

    /*
     * 微信开盘首页
     * qzb*/
    public function index()
    {
        //项目ID
        $uid = $this->get_user_id();
        $Model = new \Think\Model();
        $userinfo=$Model->table("xk_user")->where("id=$uid")->find();
        if (empty($userinfo) || count($userinfo)<1)
            $this->error('用户登录信息异常，请重新登录！', U('logging/index'));
        $search_info = I('info', '', 'trim');
        $search_hd_id = get_search_id_by($search_info, 'p');
        $hd_id=$search_hd_id;
        $projinfo=M("project p")->join("xk_event_order_house e ON e.project_id = p.id")->where("e.id=".$hd_id)->field("p.id,p.name pname,e.name ename,e.batch_id")->find();
//        echo json_encode($projinfo);exit;
        
        if(empty($projinfo))
        {
            session("USER_ID",null);
            $this->error('系统异常，请重新登录！', U('logging/index'));
        }
        $this->assign('project_id', $hd_id);
        
        //保存活动名称
        if(empty(cookie("hdname")))
        {
            cookie("hdname",$projinfo['pname']."-微信选房");
        }
        else
        {
            if(cookie("hdname")<> $projinfo['pname']."-微信选房")
            {
                 cookie("hdname",$projinfo['pname']."-微信选房");
            }
        }
        
        //户型销售计算
        $where['proj_id'] = $projinfo['id'];
        $where['pc_id'] = $projinfo['batch_id'];
        $field = 'hx, 
			count(1) as zgs, 
			count(case when is_xf = 1 then 1 end ) as sold,
			round(sum(total)/10000,2) as tatol_price, 
			sum(area) as zmj,
			round(sum(case when is_xf = 1 then total else 0 end )/10000,2) as sold_price
		';
        $orderBy = 'hx ASC';
        $hx = M()->table("xk_roomlist")->field($field)->where($where)->order($orderBy)->find();

        //户型
        $household['percent'] 	 = round(($hx['sold'] / $hx['zgs']) * 100,2);
        $household['selt'] 		 = $hx['sold'];
        $household['zgs'] 	 = $hx['zgs'];
        $household['zmj'] 	 = $hx['zmj'];
        $this->assign('household', $household);

        //已售占比排名(按户型金额)
        $saled_hx['tatol_price'] = $hx['tatol_price'];
        $saled_hx['sold_price']  = $hx['sold_price'];
        $saled_hx['percent'] 	 = round(($hx['sold_price'] / $hx['tatol_price']) * 100,2);
        $this->assign('saled_hx', $saled_hx);

        //客户选房情况
        //先查询权限情况
        $pd_user=M()->table("xk_station2user su")->join("xk_fun_station fs ON fs.station_id=su.station_id")->where("userid=$uid AND fs.fun_id=101")->find();
        if($pd_user){//当$pd_user不为空的时候查看所有客户
            $user_xf=M()->table("xk_choose c")->field("count(1) zrs,SUM(CASE WHEN oh.id IS NULL THEN 0 ELSE 1 END) ydl,SUM(CASE WHEN oh.id IS NULL THEN 1 ELSE 0 END) wdl,SUM(CASE WHEN oh.id IS  NOT NULL AND r.id IS NOT NULL THEN 1 ELSE 0 END) yxf,SUM(CASE WHEN oh.id IS  NOT NULL AND r.id IS NULL THEN 1 ELSE 0 END) wxf")->join('LEFT JOIN xk_room r ON r.cstid=c.id')->join("LEFT JOIN ( select * from xk_order_house_phone_login  where event_id={$search_hd_id} group by phone)  oh ON oh.phone=c.customer_phone")->where("c.project_id={$projinfo['id']} AND c.batch_id={$projinfo['batch_id']}")->find();
        }else{
            $user_xf=M()->table("xk_choose c")->field("count(1) zrs,SUM(CASE WHEN oh.id IS NULL THEN 0 ELSE 1 END) ydl,SUM(CASE WHEN oh.id IS NULL THEN 1 ELSE 0 END) wdl,SUM(CASE WHEN oh.id IS  NOT NULL AND r.id IS NOT NULL THEN 1 ELSE 0 END) yxf,SUM(CASE WHEN oh.id IS  NOT NULL AND r.id IS NULL THEN 1 ELSE 0 END) wxf")->join('LEFT JOIN xk_room r ON r.cstid=c.id')->join("LEFT JOIN ( select * from xk_order_house_phone_login where event_id={$search_hd_id} group by phone) oh ON oh.phone=c.customer_phone")->where("c.project_id={$projinfo['id']} AND c.batch_id={$projinfo['batch_id']} AND c.ywy='{$userinfo['name']}'")->find();
        }
        $this->assign('user_xf', $user_xf);
        unset( $field, $orderBy);
        //户型排名
        $field = 'hx, 
                count(1) as total, 
                count(case when is_xf = 1 then 1 end ) as saled_total,
                round(sum(case when is_xf = 1 then total else 0 end )/10000,2) as saled_price,
                count(case when is_xf = 0 then 1 end ) as nosaled_total,
                round(sum(case when is_xf = 0 then total else 0 end )/10000,2) as nosaled_price
		';
        $groupBy = 'hx';
        $orderBy = 'count(case when is_xf = 1 then 1 end ) desc,sum(case when is_xf = 1 then total else 0 end ) desc ,count(case when is_xf = 1 then 1 end )/ count(1) desc,hx ASC';
        $hx_list = M()->table("xk_roomlist")->field($field)->where($where)->order($orderBy)->group($groupBy)->select();

        $rates = array();
        if (!empty($hx_list)) {
            foreach ($hx_list as $hx) {
                if ($hx['saled_total'] != 0) {
                    $hx['percent'] = round(($hx['saled_total']/$hx['total'])*100);
                }
                else
                {
                     $hx['percent']=0;
                }
                $rates[] = $hx; 
            }
        }

        //$rates = list_sort_by($rates, 'percent', 'desc');
        $this->assign('rates', $rates);

        //置业顾问排名
        $pd_user=M()->table("xk_station2user su")->join("xk_fun_station fs ON fs.station_id=su.station_id")->where("userid=$uid AND fs.fun_id=102")->find();
        if($pd_user){
            $res=$Model->query("select count(1) cou,round(sum(total)/10000,2) mon,concat(a.ywy,'(',a.ywyphone,')' ) as czusername FROM xk_choose a inner join xk_room b on a.id=b.cstid where b.is_xf=1 and a.project_id={$projinfo['id']} AND a.batch_id={$projinfo['batch_id']} group by a.ywy order by count(1) desc");
            $count=0;
            for($i=0;$i<count($res);$i++){
                $count+=(int)$res[$i]['cou'];
            }
            $this->assign("ct",$count);
            $this->assign("res",$res);
        }else{
            $this->assign("ct",null);
            $this->assign("res",null);
        }
        $this->assign('projinfo', $projinfo);
        $this->assign('project_id', $projinfo['id']);
        $this->assign('search_hd_id', $search_hd_id);
        $this->set_seo_title(cookie("hdname"));
        $this->display();
    }

    /*
     * 电子开盘首页
     * qzb
     * 2018-2-28*/
    public function dz_index(){
        //项目ID
        $uid = $this->get_user_id();
        $Model = new \Think\Model();
        $userinfo=$Model->table("xk_user")->where("id=$uid")->find();
        if (empty($userinfo) || count($userinfo)<1)
            $this->error('用户登录信息异常，请重新登录！', U('logging/index'));
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


        //保存活动名称
        if(empty(cookie("hdname")))
        {
            cookie("hdname",$projinfo['pname']."-电子开盘");
        }
        else
        {
            if(cookie("hdname")<> $projinfo['pname']."-电子开盘")
            {
                cookie("hdname",$projinfo['pname']."-电子开盘");
            }
        }

        //户型销售计算
        $where['proj_id'] = $pid;
        $where['pc_id'] = $bid;
        $field = '
			count(1) as all_count, 
			SUM(case when is_xf=1 then 1 else 0 end ) as sold,
			round(sum(total)/10000,2) as total_price, 
			sum(area) as total_area,
			round(sum(case when is_xf=1 then total else 0 end )/10000,2) as sold_price
		';
        $hx = M()->table("xk_roomlist")->field($field)->
        where($where)->find();

        //总销售占总数的的统计
        $household['percent'] 	 = round(($hx['sold'] / $hx['all_count']) * 100,2);
        $household['selt'] 		 = $hx['sold'];
        $household['zgs'] 	 = $hx['all_count'];
        $household['zmj'] 	 = $hx['total_area'];
        $this->assign('household', $household);

        //已售占比排名(按户型金额)
        $saled_hx['tatol_price'] = $hx['total_price'];
        $saled_hx['sold_price']  = $hx['sold_price'];
        $saled_hx['percent'] 	 = round(($hx['sold_price'] / $hx['tatol_price']) * 100,2);
        $this->assign('saled_hx', $saled_hx);

        //客户签到和选房情况
        //先查询权限情况
        $pd_user=M()->table("xk_station2user su")->join("xk_fun_station fs ON fs.station_id=su.station_id")->where("userid=$uid AND fs.fun_id=101")->find();
        if($pd_user){//当$pd_user不为空的时候查看所有客户
            $user_xf=M()->table("xk_choose c")->field("count(1) zrs,SUM(CASE WHEN c.is_sign=0 THEN 1 ELSE 0 END) no_sign,SUM(CASE WHEN c.is_sign=1 THEN 1 ELSE 0 END) yes_sign,SUM(CASE WHEN c.is_sign=1 AND r.id IS NOT NULL THEN 1 ELSE 0 END) sign_selected,SUM(CASE WHEN c.is_sign=1 AND r.id IS NULL THEN 1 ELSE 0 END) sign_select")->join('LEFT JOIN xk_room r ON r.cstid=c.id')->where("c.project_id=$pid AND c.batch_id=$bid")->find();
        }else{
            $user_xf=M()->table("xk_choose c")->field("count(1) zrs,SUM(CASE WHEN c.is_sign=0 THEN 1 ELSE 0 END) no_sign,SUM(CASE WHEN c.is_sign=1 THEN 1 ELSE 0 END) yes_sign,SUM(CASE WHEN c.is_sign=1 AND r.id IS NOT NULL THEN 1 ELSE 0 END) sign_selected,SUM(CASE WHEN c.is_sign=1 AND r.id IS NULL THEN 1 ELSE 0 END) sign_select")->join('LEFT JOIN xk_room r ON r.cstid=c.id')->where("c.project_id=$pid AND c.batch_id=$bid AND c.ywy='{$userinfo['name']}'")->find();
        }
        $this->assign('user_xf', $user_xf);
        unset( $field, $orderBy);
        //户型排名
        $field = 'hx, 
                count(1) as total, 
                count(case when is_xf = 1 then 1 end ) as saled_total,
                round(sum(case when is_xf = 1 then total else 0 end )/10000,2) as saled_price,
                count(case when is_xf = 0 then 1 end ) as nosaled_total,
                round(sum(case when is_xf = 0 then total else 0 end )/10000,2) as nosaled_price
		';
        $groupBy = 'hx';
        $orderBy = 'count(case when is_xf = 1 then 1 end ) desc,sum(case when is_xf = 1 then total else 0 end ) desc ,count(case when is_xf = 1 then 1 end )/ count(1) desc,hx ASC';
        $hx_list = M()->table("xk_roomlist")->field($field)->where($where)->order($orderBy)->group($groupBy)->select();

        $rates = array();
        if (!empty($hx_list)) {
            foreach ($hx_list as $hx) {
                if ($hx['saled_total'] != 0) {
                    $hx['percent'] = round(($hx['saled_total']/$hx['total'])*100);
                }
                else
                {
                    $hx['percent']=0;
                }
                $rates[] = $hx;
            }
        }

        //$rates = list_sort_by($rates, 'percent', 'desc');
        $this->assign('rates', $rates);

        //置业顾问排名
        $pd_user=M()->table("xk_station2user su")->join("xk_fun_station fs ON fs.station_id=su.station_id")->where("userid=$uid AND fs.fun_id=102")->find();
        if($pd_user){
            $res=$Model->query("select count(1) cou,round(sum(total)/10000,2) mon,concat(a.ywy,'(',a.ywyphone,')' ) as czusername FROM xk_choose a inner join xk_room b on a.id=b.cstid where b.is_xf=1 and a.project_id=$pid AND a.batch_id=$bid group by a.ywy order by count(1) desc");
            $count=0;
            for($i=0;$i<count($res);$i++){
                $count+=(int)$res[$i]['cou'];
            }
            $this->assign("ct",$count);
            $this->assign("res",$res);
        }else{
            $this->assign("ct",null);
            $this->assign("res",null);
        }
//        $this->assign('search_hd_id', $search_hd_id);
        $this->set_seo_title(cookie("hdname"));
        $this->display();
    }
}