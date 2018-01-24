<?php

namespace Saler\Controller;


/**
 * 项目数据统计
 *
 * @create 2016-9-13
 * @author zlw
 */
class StatisticsController extends Base1Controller 
{
	
	/**
	 * 首页
	 *
	 * @create 2016-9-13
	 * @author zlw
	 */
    public function index() 
	{	
		//项目ID
                $uid = $this->get_user_id();
                $Model = new \Think\Model();
                $userinfo=$Model->query("SELECT * FROM xk_user WHERE id=". $uid ." limit 1" );
                if (empty($userinfo) || count($userinfo)<1)
                    $this->error('用户登录信息异常，请重新登录！', U('logging/index'));
                if ($userinfo[0]['type']<3)
                    $this->error('你无权查看此信息！', U('logging/index'));

		$search_info = I('info', '', 'trim');
		$search_project_id = get_search_id_by($search_info, 'p', $project_list[0]['id']);
                $project_id=$search_project_id;
                
                $projinfo=M("project")->where("id=".$project_id)->find();
                if(empty($projinfo))
                {
                    $this->error('系统异常，请重新登录！', U('logging/index'));
                }
                
		$this->assign('project_id', $project_id);
		
		$Room = D("Common/room");

		//户型销售计算
		$where['proj_id'] = $project_id;
		$field = 'hx, 
			count(1) as zgs, 
			count(case when is_xf = 1 then 1 end ) as sold,
			round(sum(total)/10000,2) as tatol_price, 
			round(sum(case when is_xf = 1 then total else 0 end )/10000,2) as sold_price
		';
		$orderBy = 'hx ASC';
		$hx = $Room->getOne($where, $field, $orderBy);
		
		//户型
		$household['percent'] 	 = round(($hx['sold'] / $hx['zgs']) * 100,2);
		$household['selt'] 		 = $hx['sold'];
		$household['zgs'] 	 = $hx['zgs'];
		$this->assign('household', $household);
		
		//已售占比排名(按户型金额)
		$saled_hx['tatol_price'] = $hx['tatol_price'];
		$saled_hx['sold_price']  = $hx['sold_price'];
		$saled_hx['percent'] 	 = round(($hx['sold_price'] / $hx['tatol_price']) * 100,2);
		$this->assign('saled_hx', $saled_hx);
		
		//热门房源
		unset($where, $field, $orderBy);
		$where['proj_id'] = $project_id;
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
		$where['proj_id'] = $project_id;
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
		$url['saled_index'] = U('saled/index', array('project_id' => $project_id)); 
		$url['saled_price'] = U('saled/price', array('project_id' => $project_id));
		$url['hot'] 		= U('hot/index', array(
			'info' => set_search_ids(array('p' => $project_id)))
		);
		$url['saled_rate'] 	= U('saled/rate', array('project_id' => $project_id));
		$url['saled_opened'] = U('saled/opened', array('project_id' => $project_id));
		$url['saled_prizes'] = U('saled/prizes', array('project_id' => $project_id));
		$url['search'] = U('search/index', array(
			'info' => set_search_ids(array('p' => $project_id)))
		);
                $url['project'] = U('project/index', array(
			'info' => set_search_ids(array('p' => $project_id)))
		);
                
		$this->assign('url', $url);
		
                $this->assign('projinfo', $projinfo);
                $this->assign('project_id', $project_id);
		$this->set_seo_title("项目数据统计");
        $this->display();
    }
	
	
}


