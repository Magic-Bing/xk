<?php

namespace User\Service;

use User\Controller\BaseController as UserBaseController;
use Lookey\Lottery\Rander as Lottery;


/**
 * 代金券
 *
 * @create 2016-12-05
 * @author zlw
 */
class VoucherService extends UserBaseController
{
	
	/**
	 * 系统构造方法
	 *
	 * @create 2016-12-05
	 * @author zlw
	 */
	public function _initialize()
	{
            parent::_initialize();
	}
	
	/**
	 * 提示
	 *
	 * @create 2016-12-05
	 * @author zlw
	 */
    public function tip($data = array())
	{
		$customer_id = $this->get_customer_id();
		
		//项目ID
		$project_id = D("Weixin", "Logic")->getProjectId();
		if (is_null($project_id)) {
                    return false;
		}
		
		//批次ID
		$batch_id = D("Weixin", "Logic")->getBatchId();
		
		//活动
		$activity_where['project_id'] = $project_id;
		$activity_where['batch_id'] = $batch_id;
		$activity_where['start_time'] = array('elt', time());
		$activity_where['end_time'] = array('egt', time());
                $activity_where['cyfs'] = 1;
		$activity_where['status'] = 1;
		$activity = D("VoucherActivity")->getOne($activity_where);
		if (empty($activity)) {
                    return false;
		}
		
		//活动ID
		$activity_id = $activity['id'];
		
		$VoucherTip = D("VoucherTip");
		
		$where['project_id'] = $project_id;
		$where['batch_id'] = $batch_id;
		//$where['activity_id'] = $activity_id;
		$where['customer_id'] = $customer_id;
		$where['is_tip'] = 1;
		$tip = $VoucherTip->getOne($where);
		
		if (empty($tip)) {
                    $data['project_id'] = $project_id;
                    $data['batch_id'] = $batch_id;
                    $data['activity_id'] = $activity_id;
                    $data['customer_id'] = $customer_id;
                    $data['is_tip'] = 1;
                    $data['add_time'] = time();		
                    $data['add_ip'] = get_client_ip(0, true);		

                    D("VoucherTip")->addOne($data);

                    $html = $this->fetch("VoucherService/tip");
                    echo $html;
		}
    }
	
	/**
	 * 满减
	 *
	 * @create 2016-12-05
	 * @author zlw
	 */
    public function gift()
	{
		//当前用户ID
		$customer_id = $this->get_customer_id();
		
		//项目ID
		$project_id = D("Weixin", "Logic")->getProjectId();
		
		//批次ID
		$batch_id = D("Weixin", "Logic")->getBatchId();
		
		if (empty($customer_id)) {
                    return false;
		}
		
		//活动信息
		$voucher_activity_where['project_id'] = $project_id;
		$voucher_activity_where['batch_id'] = $batch_id;
		$voucher_activity_where['start_time'] = array('elt', time());
		$voucher_activity_where['end_time'] = array('egt', time());
                $voucher_activity_where['cyfs'] = 2;
		$voucher_activity_where['status'] = 1;
                $voucher_activity[] = "3333=3333";
		$activity = D("VoucherActivity")->getOne($voucher_activity_where);
		if (empty($activity)) {
                    return false;
		}
		
		$activity_id = $activity['id'];
  
		//收藏的房间的最大总价
		$where['customer_id'] = $customer_id;
		$where['project_id'] = $project_id;
		$where['batch_id'] = $batch_id;
		$where['batch_is_dq'] = 1;
		$room_collection_price_max = D('CollectionsView')->getOne(
                    $where, 
                    '*', 
                    'room_total_price DESC, id DESC'
		);
		if (empty($room_collection_price_max)) {
                    return false;
		}
		
		$room_total_price = $room_collection_price_max['room_total_price'];
		
		//活动选择的代金券
		$VoucheractivityattrView = D("VoucheractivityattrView");
		
		$voucher_attr_where['voucher_type'] = 'gift';
		$voucher_attr_where['voucher_min_money'] = array('gt', $room_total_price);
		$voucher_attr_where['voucher_end_time'] = array('egt', time());
		$voucher_attr_where['activity_project_id'] = $project_id;
		$voucher_attr_where['activity_batch_id'] = $batch_id;
		$voucher_attr_where['activity_start_time'] = array('elt', time());
		$voucher_attr_where['activity_end_time'] = array('egt', time());
                $voucher_attr_where['activity_cyfs'] = 2;
		$voucher_attr_where['activity_status'] = 1;
                $voucher_attr_where[] = "3333=3333";
		$voucher_attr_where[] = "(VoucherActivityAttr.quantity > VoucherActivityAttr.use_quantity) AND (Voucher.open_quantity > Voucher.use_quantity)";
		
		//推荐代金券
		$recommend_voucher = $VoucheractivityattrView->getOne(
                    $voucher_attr_where, 
                    '*', 
                    'voucher_min_money ASC'
		);
		if (empty($recommend_voucher)) {
                    return false;
		}
		
		//当前中奖代金券ID
		$recommend_voucher_id = $recommend_voucher['voucher_id'];
		
		//判断是否已经获取过该代金券
		$voucher_log_where['customer_id'] = $customer_id;
		$voucher_log_where['activity_id'] = $activity_id;
		$voucher_log_where['batch_id'] = $batch_id;
		$voucher_log_where['voucher_id'] = $recommend_voucher_id;
		$voucher_log = D("VoucherLog")->getOne($voucher_log_where);
		if (!empty($voucher_log)) {
                    return false;
		}		
		
		//中奖代金券
		$voucher = $recommend_voucher;
		
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
                    return false;
		}
		
		//更改当前使用的代金券的使用数量
		$activity_attr_where['activity_id'] = $voucher['activity_id'];
		$activity_attr_where['voucher_id'] = $voucher['voucher_id'];
		D("VoucherActivityAttr")->where($activity_attr_where)->setInc('use_quantity', 1);
		
		//更改代金券的使用数量
		$voucher_where['id'] = $voucher['voucher_id'];
		D("Voucher")->where($voucher_where)->setInc('use_quantity', 1);

		//显示中奖信息
		$this->assign('voucher', $voucher);
		$html = $this->fetch("VoucherService/gift");
		echo $html;
    }
	
	/**
	 * 随机获取满减卷
	 *
	 * @create 2016-12-05
	 * @author zlw
	 */
    public function rand_gift()
	{
		$customer_id = $this->get_customer_id();
		
		//项目ID
		$project_id = D("Weixin", "Logic")->getProjectId();
		
		//批次ID
		$batch_id = D("Weixin", "Logic")->getBatchId();
		
		if (empty($customer_id)) {
                    return false;
		}
		
		//活动信息
		$voucher_activity_where['project_id'] = $project_id;
		$voucher_activity_where['batch_id'] = $batch_id;
		$voucher_activity_where['start_time'] = array('elt', time());
		$voucher_activity_where['end_time'] = array('egt', time());
		$voucher_activity_where['status'] = 1;
                $voucher_activity_where['cyfs'] = 2;
                $voucher_activity_where[] = "4444=4444";
		$activity = D("VoucherActivity")->getOne($voucher_activity_where);
		if (empty($activity)) {
                    return false;
		}
		
		$activity_id = $activity['id'];
		
		//判断是否已经获取过代金券
		$voucher_log_where['customer_id'] = $customer_id;
		$voucher_log_where['activity_id'] = $activity_id;
		$voucher_log_where['batch_id'] = $batch_id;
		$voucher_log = D("VoucherLog")->getOne($voucher_log_where);
		if (!empty($voucher_log)) {
                    return false;
		}
  
		//收藏的房间的最大总价
		$where['customer_id'] = $customer_id;
		$where['project_id'] = $project_id;
		$where['batch_is_dq'] = 1;
		$room_collection_price_max = D('CollectionsView')->getOne(
                    $where, 
                    '*', 
                    'room_total_price DESC, id DESC'
		);
		if (empty($room_collection_price_max)) {
                    return false;
		}
		
		$room_total_price = $room_collection_price_max['room_total_price'];
		
		//活动选择的代金券
		$VoucheractivityattrView = D("VoucheractivityattrView");
		
		$voucher_attr_where['activity_project_id'] = $project_id;
		$voucher_attr_where['voucher_type'] = 'gift';
		$voucher_attr_where['voucher_min_money'] = array('gt', $room_total_price);
		$voucher_attr_where['voucher_end_time'] = array('egt', time());
		$voucher_attr_where['activity_start_time'] = array('elt', time());
		$voucher_attr_where['activity_end_time'] = array('egt', time());
		$voucher_attr_where['activity_status'] = 1;
                $voucher_attr_where['activity_cyfs'] = 2;
                $voucher_attr_where[] = "4444=4444";
		$voucher_attr_where[] = "(quantity > use_quantity) AND (Voucher.voucher_open_quantity > Voucher.voucher_use_quantity)";
		
		//获取中奖代金券
		$voucher_list = $VoucheractivityattrView->getList($voucher_attr_where, '*', 'rand()');
		if (empty($voucher_list)) {
                    return false;
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
                    'v' => 1,
                    'type' => '-1',
		);
		
		//获取中奖信息
        $prize = Lottery::roll($voucher_lottery);

		//当前奖项
		$now_prize = $prize['yes'];

		//没有数据
		if (empty($now_prize)) {
                    return false;
		}
		
		if ($now_prize['type'] == '-1') {
                    return false;
		}
		
		//当前中奖ID
		$now_prize_voucher_id = $now_prize['id'];
		
		//中奖代金券
		$voucher = $voucher_new_list[$now_prize_voucher_id];
		
		//添加中奖记录
		$log_data['customer_id'] = $customer_id;
		$log_data['voucher_id'] = $voucher['voucher_id'];
		$log_data['activity_id'] = $voucher['activity_id'];
		$log_data['is_use'] = 0;
		$log_data['add_time'] = time();		
		$log_data['add_ip'] = get_client_ip(0, true);		
		$check_has_add = D("VoucherLog")->addOne($log_data);
		if ($check_has_add === false) {
                    return false;
		}
		
		//更改当前使用的代金券的使用数量
		$activity_attr_where['activity_id'] = $voucher['activity_id'];
		$activity_attr_where['voucher_id'] = $voucher['voucher_id'];
		D("VoucherActivityAttr")->where($activity_attr_where)->setInc('use_quantity', 1);
		
		//更改代金券的使用数量
		$voucher_where['id'] = $voucher['voucher_id'];
		D("Voucher")->where($voucher_where)->setInc('use_quantity', 1);

		//显示中奖信息
		$this->assign('voucher', $voucher);
		$html = $this->fetch("VoucherService/gift");
		echo $html;
    }
	
}
