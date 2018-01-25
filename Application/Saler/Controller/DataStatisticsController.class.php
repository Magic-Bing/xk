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
            $user_xf=M()->table("xk_choose c")->field("count(1) zrs,SUM(CASE WHEN oh.id IS NULL THEN 0 ELSE 1 END) ydl,SUM(CASE WHEN oh.id IS NULL THEN 1 ELSE 0 END) wdl,SUM(CASE WHEN oh.id IS  NOT NULL AND r.id IS NOT NULL THEN 1 ELSE 0 END) yxf,SUM(CASE WHEN oh.id IS  NOT NULL AND r.id IS NULL THEN 1 ELSE 0 END) wxf")->join('LEFT JOIN xk_room r ON r.cstid=c.id')->join("LEFT JOIN ( select * from xk_order_house_phone_login group by phone)  oh ON oh.phone=c.customer_phone")->where("c.project_id={$projinfo['id']} AND c.batch_id={$projinfo['batch_id']}")->find();
        }else{
            $user_xf=M()->table("xk_choose c")->field("count(1) zrs,SUM(CASE WHEN oh.id IS NULL THEN 0 ELSE 1 END) ydl,SUM(CASE WHEN oh.id IS NULL THEN 1 ELSE 0 END) wdl,SUM(CASE WHEN oh.id IS  NOT NULL AND r.id IS NOT NULL THEN 1 ELSE 0 END) yxf,SUM(CASE WHEN oh.id IS  NOT NULL AND r.id IS NULL THEN 1 ELSE 0 END) wxf")->join('LEFT JOIN xk_room r ON r.cstid=c.id')->join("LEFT JOIN ( select * from xk_order_house_phone_login group by phone) oh ON oh.phone=c.customer_phone")->where("c.project_id={$projinfo['id']} AND c.batch_id={$projinfo['batch_id']} AND c.ywy='{$userinfo['name']}'")->find();
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
                    $rates[] = $hx;
                }
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
        
        //热门房源
        /* unset($where, $field, $orderBy);
        $where['proj_id'] = $projinfo['id'];
        $field = 'sum(round(djcount/2,0)) as follow_count,
			sum(sccount) as collection_count,
			sum(round(sscount/2,0)) as comparison_count
		';
        $orderBy = 'room_id ASC';
        $hot_room = D("Common/Roomattribute")->getOneByJoinRoom($where, $orderBy, $field);

        //房源热度
        $room_hot['collection']  = $hot_room['collection_count'];
        $room_hot['comparison']  = $hot_room['comparison_count'];
        $room_hot['follow'] 	 = $hot_room['follow_count'];
        $this->assign('room_hot', $room_hot);

        //户型列表
        unset($where, $field, $orderBy);
        $where['proj_id'] = $projinfo['id'];
        //$where['is_xf'] = 1;
        $field = 'hx,
			count(1) as total,
			count(case when is_xf = 1 then 1 end ) as saled_total,
			sum(case when is_xf = 1 then total else 0 end ) as saled_price,
			count(case when is_xf = 0 then 1 end ) as nosaled_total,
			sum(case when is_xf = 0 then total else 0 end ) as nosaled_price
		';
        $groupBy = 'hx';
        $orderBy = 'hx ASC';
        $hx_list = D("Common/room")->getListByGroup($where, $field, $groupBy, $orderBy);

        $rates = array();
        if (!empty($hx_list)) {
            foreach ($hx_list as $hx) {
                $hx['percent'] = round(($hx['saled_total']/$hx['total'])*100,2);
                $rates[] = $hx;
            }
        }
        $rates = list_sort_by($rates, 'percent', 'desc');

        //户型TOP1
        $hx_top['name'] 	= $rates[0]['hx'];
        $hx_top['percent'] 	= $rates[0]['percent'];
        $this->assign('hx_top', $hx_top);

        //链接
        $url['saled_index'] = U('saled/index', array('project_id' => $projinfo['id']));
        $url['saled_price'] = U('saled/price', array('project_id' => $projinfo['id']));
        $url['hot'] 		= U('hot/index', array(
                'info' => set_search_ids(array('p' => $projinfo['id'])))
        );
        $url['saled_rate'] 	= U('saled/rate', array('project_id' => $projinfo['id']));
        $url['saled_opened'] = U('saled/opened', array('project_id' => $projinfo['id']));
        $url['saled_prizes'] = U('saled/prizes', array('project_id' => $projinfo['id']));
        $url['search'] = U('search/index', array(
                'info' => set_search_ids(array('p' => $projinfo['id'])))
        );
        $url['project'] = U('project/index', array(
                'info' => set_search_ids(array('p' => $projinfo['id'])))
        );*/

//        $this->assign('url', $url);
        $this->assign('projinfo', $projinfo);
        $this->assign('project_id', $projinfo['id']);
        $this->assign('search_hd_id', $search_hd_id);
        $this->display();
    }
}