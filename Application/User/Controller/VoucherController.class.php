<?php

namespace User\Controller;

use Lookey\Lottery\Rander as Lottery;
use Lookey\Http\Http as LookeyHttp;


/**
 * 代金券
 *
 * @create 2016-12-07
 * @author zlw
 */
class VoucherController extends BaseController
{
	
	/**
	 * 构造方法
	 *
	 * @create 2016-12-07
	 * @author zlw
	 */
	public function _initialize()
	{
		parent::_initialize();
		
		//当前方法
		$this->assign('action_name', strtolower(ACTION_NAME));
	}
	
	/**
	 * 首页
	 *
	 * @create 2016-12-07
	 * @author zlw
	 */
    public function index()
	{		
		$project_id = D("Weixin", "Logic")->getProjectId();
		if (empty($project_id) || $project_id == 0) {
			$this->error("访问错误，请访问其他页面！");
		}
		$this->assign('project_id', $project_id);
		
		//批次
		$batch_where['proj_id'] = $project_id;
		$batch_where['is_dq'] = 1;
		$batch = D("Batch")->getOne($batch_where);
		
		//批次ID
		$batch_id = $batch['id'];
		
		//项目
		$project_where['id'] = $project_id;
		$project_where['status'] = 1;
		$project = D("Project")->getOne($project_where);
		if (empty($project)) {
			$this->error("项目不存在，请确认后重试！");
		}
		$this->assign('project', $project);
		
		//活动
		$activity_where['project_id'] = $project_id;
		$activity_where['batch_id'] = $batch_id;
		$activity_where['start_time'] = array('elt', time());
		$activity_where['end_time'] = array('egt', time());
		$activity_where['status'] = 1;
                $activity_where['cyfs'] = 1;
		$activity = D("VoucherActivity")->getOne($activity_where);
		$this->assign('activity', $activity);
		
		//当前用户
		$customer_id = $this->get_customer_id();
		
		//设置为空集
		if (empty($activity)) {
			$project_id = '-999';
		}
		
		//代金券视图
		$VoucherView = D("VoucherView");
		$where['project_id'] = $project_id;
		$where['batch_id'] = $batch_id;
		$where['type'] = 'directional';
		$where['status'] = 1;
		
		//活动总数
		$count = $VoucherView->where($where)->count();
	
		//分页
		$Page = $this->mpage($count, 5);
		$page_show  = $Page->show();	
		$this->assign('page_show', $page_show); 
		
		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
		
		//活动列表
		$vouchers = $VoucherView->getList(
			$where, 
			'*', 
			'end_time DESC, directional_type DESC, id DESC', 
			$limit
		);
		$this->assign('vouchers', $vouchers);
		
		//我的代金券
		$my_vouchers_where['activity_id'] = $activity['id'];
		$my_vouchers_where['batch_id'] = $batch_id;
		$my_vouchers_where['customer_id'] = $customer_id;
		$my_vouchers = D("VoucherLog")->getList($my_vouchers_where);
		
		//我的代金券id列表
		$my_voucher_ids = array();
		if (!empty($my_vouchers)) {
			foreach ($my_vouchers as $my_voucher) {
				$my_voucher_ids[] = $my_voucher['voucher_id'];
			}
		}
		$this->assign('my_voucher_ids', $my_voucher_ids);

		$this->set_seo_title('领取代金券');
		$this->display();
    }
	
	/**
	 * 领取代金券
	 *
	 * @create 2016-12-09
	 * @author zlw
	 */
    public function buy()
	{
		if (!IS_POST) {
			$this->error('领取失败，请稍后重试！');
		}
		
		$id = I('id', 0, 'intval');
		if (empty($id) || $id == 0) {
			$this->error("领取失败，请稍后重试！");
		}
		
		//当前用户
		$customer_id = $this->get_customer_id();		
		if (empty($customer_id) || $customer_id == 0) {
			$this->error("领取失败，请稍后重试！");
		}
	
		//项目ID
		$project_id = D("Weixin", "Logic")->getProjectId();
		
		//项目
		$project_where['project_id'] = $project_id;
		$project_where['status'] = 1;
		$project = D("Project")->getOne($project_where);
		if (empty($project)) {
			$this->error("项目已结束，请选择其他项目！");
		}
		
		//批次ID
		$batch_id = D("Weixin", "Logic")->getBatchId();
		
		//活动
		$activity_where['project_id'] = $project_id;
		$activity_where['start_time'] = array('elt', time());
		$activity_where['end_time'] = array('egt', time());
		$activity_where['status'] = 1;
                $activity_where['cyfs']=1;
                $activity_where[] = "999=999 ";
		$activity = D("VoucherActivity")->getOne($activity_where);
		if (empty($activity)) {
			$this->error("活动已结束，请选择其他活动！");
		}
		
		//代金券视图
		$voucher_where['id'] = $id;
		$voucher_where['project_id'] = $project_id;
		$voucher_where['end_time'] = array('egt', time());
		$voucher_where['type'] = 'directional';
		$voucher_where['status'] = 1;
		$voucher = D("VoucherView")->getOne($voucher_where);
		if (empty($voucher)) {
			$this->error("代金券不存在，请确认后重试！");
		}
		
		//当前活动代金券
		$activity_voucher_where['activity_id'] = $activity['id'];
		$activity_voucher_where['voucher_id'] = $id;
		$activity_voucher_where[] = "quantity > use_quantity";
		$activity_voucher = D("VoucherActivityAttr")->getOne($activity_voucher_where);
		if (empty($activity_voucher)) {
                    $this->error("代金券已领完，请选择其他代金券！");
		}
		
		//判断是否已经领取过该代金券
		$voucher_log_where['customer_id'] = $customer_id;
		$voucher_log_where['activity_id'] = $activity['id'];
		$voucher_log_where['voucher_id'] = $id;
		$voucher_log = D("VoucherLog")->getOne($voucher_log_where);
		if (!empty($voucher_log)) {
			$this->error("你已经领取过了！");
		}		
		
		//添加中奖记录
		$log_data['customer_id'] = $customer_id;
		$log_data['voucher_id'] = $id;
		$log_data['activity_id'] = $activity['id'];
		$log_data['batch_id'] = $batch_id;
		$log_data['is_use'] = 0;
		$log_data['add_time'] = time();		
		$log_data['add_ip'] = get_client_ip(0, true);		
		$check_has_add = D("VoucherLog")->addOne($log_data);
		if ($check_has_add === false) {
			$this->error("领取代金券失败，请确认后重试！");
		}
		
		//更改当前使用的代金券的使用数量
		$activity_attr_where['activity_id'] = $activity['id'];
		$activity_attr_where['voucher_id'] = $id;
		D("VoucherActivityAttr")->where($activity_attr_where)->setInc('use_quantity', 1);
		
		//更改代金券的使用数量
		$voucher_where['id'] = $id;
		D("Voucher")->where($voucher_where)->setInc('use_quantity', 1);
		
		$this->success("领取代金券成功！");
	}
	
	/**
	 * 我的
	 *
	 * @create 2016-12-08
	 * @author zlw
	 */
    public function mine()
	{		
		$project_id = D("Weixin", "Logic")->getProjectId();
		if (empty($project_id) || $project_id == 0) {
			$this->error("访问错误，请访问其他页面！");
		}
		$this->assign('project_id', $project_id);
		
		//项目
		$project_where['id'] = $project_id;
		$project_where['status'] = 1;
		$project = D("Project")->getOne($project_where);
		if (empty($project)) {
			$this->error("项目不存在，请确认后重试！");
		}
		$this->assign('project', $project);
		
		//批次ID
		$batch_id = D("Weixin", "Logic")->getBatchId();
		
		//活动
		$activity_where['project_id'] = $project_id;
		$activity_where['batch_id'] = $batch_id;
		//$activity_where['start_time'] = array('elt', time());
		//$activity_where['end_time'] = array('egt', time());
		$activity_where['status'] = 1;
		$activity = D("VoucherActivity")->getOne($activity_where);
		$this->assign('activity', $activity);
		
		//判断活动情况
		if ($activity['start_time'] < time()) {
			$activity_is_start = false;
		} else {
			$activity_is_start = true;
		}
		$this->assign('activity_is_start', $activity_is_start);
		
		if ($activity['end_time'] > time()) {
			$activity_is_end = false;
		} else {
			$activity_is_end = true;
		}
		$this->assign('activity_is_end', $activity_is_end);
		
		//当前用户
		$customer_id = $this->get_customer_id();
		
		//我的代金券
		//$my_vouchers_where['activity_id'] = $activity['id'];
                
                $my_vouchers_where['batch_id'] =$batch_id;
		$my_vouchers_where['customer_id'] = $customer_id;
		$my_vouchers = D("VoucherLog")->getList($my_vouchers_where);
		
		//我的代金券id列表
		$my_voucher_ids = array();
		$my_voucher_used_ids = array();
		$my_voucher_list = array();
		if (!empty($my_vouchers)) {
			foreach ($my_vouchers as $my_voucher) {
				$my_voucher_ids[] = $my_voucher['voucher_id'];
				
				if ($my_voucher['is_use'] == 1) {
					$my_voucher_used_ids[] = $my_voucher['voucher_id'];
				}
				
				$my_voucher_list[$my_voucher['voucher_id']] = $my_voucher;
			}
		}
		$this->assign('my_voucher_used_ids', $my_voucher_used_ids);
		$this->assign('my_voucher_list', $my_voucher_list);
		
		if (empty($my_voucher_ids)) {
			$my_voucher_ids = array('-1');
		}
		
		//代金券视图
		$VoucherView = D("VoucherView");
		$where['project_id'] = $project_id;
		$where['id'] = array("in", $my_voucher_ids);
		$where['status'] = 1;
		
		//活动总数
		$count = $VoucherView->where($where)->count();
	
		//分页
		$Page 		= $this->mpage($count, 5);
		$page_show  = $Page->show();	
		$this->assign('page_show', $page_show); 
		
		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
		
		//活动列表
		$vouchers = $VoucherView->getList(
			$where, 
			'*', 
			'end_time DESC, directional_type DESC, id DESC', 
			$limit
		);
		$this->assign('vouchers', $vouchers);
		
		$this->set_seo_title('我的代金券');
		$this->display();
    }
	
	/**
	 * 抢购
	 *
	 * @create 2016-12-08
	 * @author zlw
	 */
    public function grab()
	{
		if (IS_AJAX && IS_POST) {			
			$customer_id = $this->get_customer_id();
			
			//项目ID
			$project_id = D("Weixin", "Logic")->getProjectId();
			
			//批次ID
			$batch_id = D("Weixin", "Logic")->getBatchId();
			
			if (empty($customer_id)) {
				$this->error("很遗憾，没有抢到，请再接再厉！");
			}
			
			//活动信息
			$voucher_activity_where['project_id'] = $project_id;
			$voucher_activity_where['start_time'] = array('elt', time());
			$voucher_activity_where['end_time'] = array('egt', time());
                        $voucher_activity_where['cyfs'] = 0;
                        $voucher_activity_where[] = "666=666 ";
			$activity = D("VoucherActivity")->getOne($voucher_activity_where);
			if (empty($activity)) {
				$this->error("活动未开始或已结束，请确认后重试！");
			}
			
			$activity_id = $activity['id'];
			
			//判断是否已经获取过代金券
			$voucher_log_where['customer_id'] = $customer_id;
			$voucher_log_where['activity_id'] = $activity_id;
			$voucher_log_where['voucher_type'] = 'common';
			$voucher_log = D("VoucherlogView")->getOne($voucher_log_where);
			if (!empty($voucher_log)) {
				$this->error("抱歉，没有更多了，请下次再来！");
			}
			
			//活动选择的代金券
			$VoucheractivityattrView = D("VoucheractivityattrView");
			
			$voucher_attr_where['activity_project_id'] = $project_id;
			$voucher_attr_where['voucher_type'] = 'common';
			$voucher_attr_where['voucher_end_time'] = array('egt', time());
			$voucher_attr_where['activity_start_time'] = array('elt', time());
			$voucher_attr_where['activity_end_time'] = array('egt', time());
			$voucher_attr_where['activity_status'] = 1;
                        $voucher_attr_where['activity_cyfs'] = 0;
			$voucher_attr_where[] = "(VoucherActivityAttr.quantity > VoucherActivityAttr.use_quantity) AND (Voucher.open_quantity > Voucher.use_quantity)";
			$voucher_attr_where[] = "888=888 ";
			//获取中奖代金券
			$voucher_list = $VoucheractivityattrView->getList($voucher_attr_where, '*', 'rand()');
			if (empty($voucher_list)) {
				$this->error("很遗憾，没有抢到，请再接再厉！1");
			}
			
			$voucher_lottery = array();
			$voucher_new_list = array();
			foreach ($voucher_list as $voucher_list_key => $voucher_list_value) {
				$voucher_lottery[] = array(
					'id' => $voucher_list_value['id'],
					'v' => $voucher_list_value['quantity'] - $voucher_list_value['use_quantity'],
					'type' => '1',
				);
				$voucher_new_list[$voucher_list_value['id']] = $voucher_list_value;
			}
			//未中奖信息
			$voucher_lottery[] = array(
				'id' => 0,
				'v' => 10,
				'type' => '-1',
			);
			
			//获取中奖信息
			$prize = Lottery::roll($voucher_lottery);

			//当前奖项
			$now_prize = $prize['yes'];

			//没有数据
			if (empty($now_prize)) {
				$this->error("很遗憾，没有抢到，请再接再厉！2");
			}
			
			if ($now_prize['type'] == '-1') {
				$this->error("很遗憾，没有抢到，请再接再厉！3");
			}
			
			//当前中奖ID
			$now_prize_voucher_id = $now_prize['id'];
			
			//中奖代金券
			$voucher = $voucher_new_list[$now_prize_voucher_id];
			$this->assign('voucher', $voucher);
			
			//添加中奖记录
			$log_data['customer_id'] = $customer_id;
			$log_data['voucher_id'] = $voucher['voucher_id'];
			$log_data['activity_id'] = $voucher['activity_id'];
			$log_data['batch_id'] = $batch_id;
			$log_data['is_use'] = 0;
			$log_data['add_time'] = time();		
			$log_data['add_ip'] = get_client_ip(0, true);		
			$check_has_add = D("VoucherLog")->addOne($log_data);
			if ($check_has_add === false) {
				$this->error("很遗憾，没有抢到，请再接再厉！4");
			}
			
			//更改活动代金券的使用数量
			$activity_attr_where['activity_id'] = $voucher['activity_id'];
			$activity_attr_where['voucher_id'] = $voucher['voucher_id'];
			D("VoucherActivityAttr")->where($activity_attr_where)->setInc('use_quantity', 1);
			
			//更改代金券的使用数量
			$voucher_where['id'] = $voucher['voucher_id'];
			D("Voucher")->where($voucher_where)->setInc('use_quantity', 1);
			
			$html = $this->fetch("grab_success");
			
			$data = array(
				'msg' => "恭喜，获得一张代金卷！",
				'html' => $html,
			);
			$this->success($data);
		} else {
			$project_id = D("Weixin", "Logic")->getProjectId();
			if (empty($project_id) || $project_id == 0) {
				$this->error("访问错误，请访问其他页面！");
			}
			$this->assign('project_id', $project_id);
			
			//当前用户
			$customer_id = $this->get_customer_id();
			if (empty($customer_id) || $customer_id == 0) {
				$this->error("访问失败，请稍后重试！");
			}
			
			//项目
			$project_where['id'] = $project_id;
			$project_where['status'] = 1;
			$project = D("Project")->getOne($project_where);
			if (empty($project)) {
				$this->error("项目已结束，请选择其他项目！");
			}
			$this->assign('project', $project);
                        
                        //批次ID
			$batch_id = D("Weixin", "Logic")->getBatchId();
                        
                        //已过得的代金卷
                        $my_vou_where =" a.batch_id = ".$batch_id;
                        $my_vou_where .= " and a.customer_id = ".$customer_id;
                        $Model = new \Think\Model(); 
                        $my_vouchers=$Model->query("select count(1) as gs ,sum(b.money)as money  from xk_voucher_log a left join xk_voucher b on a.voucher_id=b.id where " . $my_vou_where . " group by a.batch_id,a.customer_id" );
			$this->assign('my_voucher', $my_vouchers[0]);
                        
			//活动
			$activity_where['project_id'] = $project_id;
			$activity_where['end_time'] = array('egt', time());
			$activity_where['status'] = 1;
                        $activity_where['cyfs'] = 0;
                        $activity_where['']="5555=5555";
			$activity = D("VoucherActivity")->getOne($activity_where);
			$this->assign('activity', $activity);
			
			$this->set_seo_title('抢代金券');
			$this->display();
		}
    }
	
}

