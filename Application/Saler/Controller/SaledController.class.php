<?php

namespace Saler\Controller;


/**
 * 项目数据统计
 *
 * @create 2016-9-14
 * @author zlw
 */
class SaledController extends BaseController 
{
	
	/**
	 * 初始化
	 *
	 * @create 2016-9-23
	 * @author zlw
	 */
    public function _initialize() 
	{	
		$project_id = I('project_id', 0, 'intval');
		if (intval($project_id) == 0) {
			$this->error('项目可能不存在，请确认后重试！', U('statistics/index'));
		}
	}
	
	
	/**
	 * 首页
	 *
	 * @create 2016-9-14
	 * @author zlw
	 */
    public function index() 
	{	
		//项目ID
		$project_id = I('project_id', 1, 'intval');
		$this->assign('project_id', $project_id);
		
		$Room = D("Common/room");
		
		//售出总计
		unset($where, $field);
		$where['is_xf'] = 1;
		$where['proj_id'] = $project_id;
		$field = 'count(1) as num';
		$total_saled = $Room->getOne($where, $field);
		$this->assign('total_saled', $total_saled['num']);
		
		//总价格
		unset($where, $field);
		$where['is_xf'] = 1;
		$where['proj_id'] = $project_id;
		$field = 'round(sum(total)/10000,2) as price';
		$total_price = $Room->getOne($where, $field);
		$this->assign('total_price', $total_price['price']);
		
		//户型列表
		unset($where, $field);
		$where['proj_id'] = $project_id;
		$field = 'hx, count(1) as total, count(case when is_xf = 1 then 1 end ) as sold';
		$groupBy = 'hx';
		$orderBy = 'hx ASC';
		$hx_list = $Room->getListByGroup($where, $field, $groupBy, $orderBy);
		$this->assign('hx_list', $hx_list);
		
		//售出户型列表
		unset($where, $field);
		$where['is_xf'] = 1;
		$where['proj_id'] = $project_id;
		$field = 'hx, count(1) as total';
		$groupBy = 'hx';
		$orderBy = 'hx ASC';
		$saled_list = $Room->getListByGroup($where, $field, $groupBy, $orderBy);
		
		$saled = array();
		$percent_no_last = 0;
		$saled_list_count = count($saled_list);
		if (!empty($saled_list)) {
			foreach ($saled_list as $saled_key => $saled_value) {
				if ($saled_key < $saled_list_count - 1) {
					$percent = round(($saled_value['total'] / $total_saled['num']) * 100);
					
					$saled[] = array(
						'unit' 		=> $saled_value['hx'],
						'percent' 	=> $percent . '%',
						'data' 		=> $percent,
					);
				
					$percent_no_last += $percent;
				} else {
					$percent = (100 - $percent_no_last);
					
					$saled[] = array(
						'unit' 		=> $saled_value['hx'],
						'percent' 	=> $percent . '%',
						'data' 		=> $percent,
					);
				}
			}
		}
		$saled = list_sort_by($saled, 'data', 'desc');
		$this->assign('saled', $saled);
		
		$json_saled = json_encode($saled);		
		$this->assign('json_saled', $json_saled);
		
		//销售统计
		$this->sell($project_id);

        $this->display();
    }
	

	/**
	 * 按户型金额
	 *
	 * @create 2016-9-14
	 * @author zlw
	 */
    public function price() 
	{	
		//项目ID
		$project_id = I('project_id', 1, 'intval');
		$this->assign('project_id', $project_id);		
		
		//售出户型列表
		$where['is_xf'] = 1;
		$where['proj_id'] = $project_id;
		$field = 'hx, count(1) as sets, round(sum(total)/10000, 2) as price, sum(area) as area';
		$groupBy = 'hx';
		
		//排序
		$sort = I('sort', '', 'trim');
		switch ($sort) {
			case 'sets':
				$orderBy = 'sets DESC';
				$sort = 'sets';
				$title = '已售占比排名(按套数)';
				break;				
			case 'area':
				$orderBy = 'area DESC';
				$sort = 'area';
				$title = '已售占比排名(按面积)';
				break;
			case 'price':
			default: 
				$orderBy = 'price DESC';
				$sort = 'price';
				$title = '已售占比排名(按金额)';
				break;
		}
		$this->assign('title', $title);
		$this->assign('sort', $sort);
		
		$prices = D("Common/room")->getListByGroup($where, $field, $groupBy, $orderBy);
		$prices = list_sort_by($prices, 'price', 'desc');
		$this->assign('prices', $prices);

        $this->display();
    }
	

	/**
	 * 户型去化率排名
	 *
	 * @create 2016-9-18
	 * @author zlw
	 */
    public function rate() 
	{	
		//项目ID
		$project_id = I('project_id', 1, 'intval');
		$this->assign('project_id', $project_id);
		
		//户型列表
		$where['proj_id'] = $project_id;
		//$where['is_xf'] = 1;
		$field = 'hx, 
			count(1) as total, 
			count(case when is_xf = 1 then 1 end ) as saled_total,
			round(sum(case when is_xf = 1 then total else 0 end )/10000,2) as saled_price,
			count(case when is_xf = 0 then 1 end ) as nosaled_total,
			round(sum(case when is_xf = 0 then total else 0 end )/10000,2) as nosaled_price
		';
		$groupBy = 'hx';
		$orderBy = 'hx ASC';
		$hx_list = D("Common/room")->getListByGroup($where, $field, $groupBy, $orderBy);
		
		$rates = array();
		if (!empty($hx_list)) {
			foreach ($hx_list as $hx) {
				if ($hx['saled_total'] != 0) {
				$hx['percent'] = round(($hx['saled_total']/$hx['total'])*100);
					$rates[] = $hx;
				}
			}
		}
		
		$rates = list_sort_by($rates, 'percent', 'desc');
		
		$this->assign('rates', $rates);

        $this->display();
    }
	

	/**
	 * 开盘情况走势(每30分钟)
	 *
	 * @create 2016-9-18
	 * @author zlw
	 */
    public function opened() 
	{	
		//项目ID
		$project_id = I('project_id', 1, 'intval');
		$this->assign('project_id', $project_id);
		
		$where['proj_id'] = $project_id;
		$where['is_xf'] = 1;
		$where[] = "TO_DAYS(date_format(FROM_UNIXTIME(xftime), '%Y-%m-%d')) = TO_DAYS(NOW())";	
		$field = "
			concat(hour(date_format(FROM_UNIXTIME(xftime), '%Y-%m-%d %H:%i:%s')),':',case when minute(date_format(FROM_UNIXTIME(xftime), '%Y-%m-%d %H:%i:%s')) between 0 and 30 then '00' else '30' end) as minute_time,
			count(1) as total, 
			round(sum(total)/10000,0) as price,
			xftime
		";
		$groupBy = 'minute_time';
		$orderBy = 'xftime ASC';
		$room_list = D("Common/room")->getRoomListGroupBy($field, $groupBy, $orderBy, $where);		
        date_default_timezone_set("prc");
		$data = array();
		if (!empty($room_list)) {
			for($i=0;$i<count($room_list);$i++){
			    if($i==0){
                    $data[] = array(
                        'time' => $room_list[$i]['minute_time'],
                        'quantity' => 0,
                        'price' => 0,
                    );
                }else{
                    $data[] = array(
                        'time' => $room_list[$i]['minute_time'],
                        'quantity' => $room_list[$i-1]['total'],
                        'price' => $room_list[$i-1]['price'],
                    );
                    if($i==(count($room_list)-1)){
                        $add_time=explode(":",$room_list[$i]['minute_time']);
                       if($add_time[1]=='30'){
                           $new_time=((int)$add_time[0]+1).":00";
                           $pd=((int)$add_time[0]+1)."00";
                       }else{
                           $new_time=$add_time[0].":30";
                           $pd=$add_time[0]."30";
                       }
                       $now_time=date("Hi",time());
                      if((int)$now_time>(int)$pd){
                          $data[] = array(
                              'time' => $new_time,
                              'quantity' => $room_list[$i]['total'],
                              'price' => $room_list[$i]['price'],
                          );
                      }

                    }
                }

            }
		}

		$json_data = json_encode($data);
//		echo $json_data;exit;
		$this->assign('json_data', $json_data);
		
		$this->assign('data', $data);
		
		//销售统计
		$this->sell($project_id);
//		echo rand(1,10000);exit;
        $this->display();
    }
	

	/**
	 * 奖品分布明细
	 *
	 * @create 2016-9-21
	 * @author zlw
	 */
    public function prizes1()
    {
        //项目ID
        $project_id = I('project_id', 1, 'intval');
        $this->assign('project_id', $project_id);
        $Model = new \Think\Model();
        $kppc = $Model->query("SELECT * FROM xk_kppc WHERE proj_id=". $project_id ." and is_dq=1 order by id limit 1" );
        $prizes = $Model->query("SELECT *,zgs-sygs as send FROM xk_prizes WHERE proj_id=". $project_id ." and pc_id=".$kppc[0]['id'] ." order by id" );
        $this->assign('prizes', $prizes);
        $this->display();
    }


    /**
     * 人员销售明细
     *
     * @create 2017-9-20
     * @author zlw
     */
    public function prizes() 
	{	
		//项目ID
		$project_id = I('project_id', 1, 'intval');
		$this->assign('project_id', $project_id);
		$Model = new \Think\Model();
        //$res=$Model->query("SELECT count(1) cou,round(sum(total)/10000,2) mon,rz.czusername FROM xk_room rm INNER JOIN (SELECT max(l.id) cid,l.room_id FROM xk_room r INNER JOIN xk_roomczlog l ON r.id=l.room_id  WHERE r.is_xf=1 AND R.proj_id=$project_id GROUP BY l.room_id) zm ON zm.room_id=rm.id INNER JOIN xk_roomczlog rz ON rz.id =zm.cid group by rz.czusername ORDER BY cou DESC ");
                
        $res=$Model->query("select count(1) cou,round(sum(total)/10000,2) mon,concat(a.ywy,'(',a.ywyphone,')' ) as czusername FROM xk_choose a inner join xk_room b on a.id=b.cstid where b.is_xf=1 and a.project_id=".$project_id ." group by a.ywy order by count(1) desc");
                
        $count=0;
        for($i=0;$i<count($res);$i++){
            $count+=(int)$res[$i]['cou'];
        }
        $this->assign("ct",$count);
        $this->assign("res",$res);
        $this->display();
    }

	
	/**
	 * 销售统计，用于index和opened方法
	 *
	 * @create 2016-9-22
	 * @author zlw
	 */
    private function sell($project_id) 
	{	
		//设定时间,“小时“为单位
		$time = 1;

                
		//4小时之前
		$before_time = date("Y-m-d H:i:s", time() - $time*60*60);
		$before_time = strtotime($before_time);
		
		//2小时之前
		$before_2hours_time = date("Y-m-d H:i:s", time() - ($time/2)*60*60);
		$before_2hours_time = strtotime($before_2hours_time);

		$where['proj_id'] = $project_id;
		/*$where['xftime'] = array(
			array('egt', $before_time),
			array('elt', time()),
			'and'
		);*/
                $where[] = "99=99";
		$field = 'count(1) as total, 
                        max(xftime) as maxtime, 
                        min(case when is_xf = 1 then xftime else  unix_timestamp(now()) end) as mintime,
			sum(total) as price, 
			
			count(case when is_xf = 1 then 1 end ) as saled_total,
			sum(case when is_xf = 1 then total else 0 end ) as saled_price,
			
			count(case when xftime >= '.$before_time.' and xftime <= '.$before_2hours_time.' then 1 end ) as half_total
		';
		$orderBy = 'id';
		$room = D("Common/room")->getOne($where, $field, $orderBy);		
		
		//累计销售
		$sell_accumulate['time']  = $time; 
		$sell_accumulate['saled'] = $room['saled_total']; 
		$sell_accumulate['price'] = round($room['saled_price']/10000.0); 
		$this->assign('sell_accumulate', $sell_accumulate);
		 //获取第一套房间的销售时间和最后一套房间的销售时间差
                 $time=round(($room['maxtime']-$room['mintime'])/60,0);
                 if ($time<0)
                     $time= 1;   
                 print_r($time);
		//每套、每分钟
		if ($room['saled_total'] > 0) {
			$sell_one['suit'] = ($time) / $room['saled_total'];
			$sell_one['minute'] = $room['saled_total'] / ($time);
		} else {
			$sell_one['suit'] = 0;
			$sell_one['minute'] = 0;
		}
		$this->assign('sell_one', $sell_one);
		
		//前半段销售
		$sell_sale['first_half'] = $room['half_total'];
		if ($room['total'] > 0) {
			$sell_sale['first_half_percent'] = round(($room['half_total'] / $room['total']) * 100);
		} else {
			$sell_sale['first_half_percent'] = 0;
		}
		$this->assign('sell_sale', $sell_sale);
	}
	
	
}