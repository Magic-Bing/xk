<?php
namespace Common\Model;

use Think\Model\ViewModel;


/**
 * 奖励日志视图表 - 关系
 *
 * @create 2016-11-16
 * @author zlw
 */
class RewardusersViewModel extends ViewModel 
{
	
	/**
	 * 视图配置
	 *
	 * @create 2016-11-16
	 * @author zlw
	 */
	public $viewFields = array(
		'RewardUsers' => array(
			'id', 'pid', 'customer_id', 
			'project_id', 'code',
			'qrcode_path', 'qrcode_last_time', 
			'qrcode_url', 'wxopenid', 
			'add_time', 'add_ip',
			
			'_type' => 'LEFT',
		),
		'Customer' => array(
			'name' 		 => 'customer_name',
			'mobile' 	 => 'customer_mobile',
			'sex' 		 => 'customer_sex',
			'openid' 	 => 'customer_openid',
			'login_time' => 'customer_login_time',
			'login_ip' 	 => 'customer_login_ip',
			
			'_on' 	=> 'RewardUsers.customer_id = Customer.id',
			
			'_type' => 'LEFT',
		),
		'ParentCustomer' => array(
			'_table'	 => "__CUSTOMER__",
			
			'name' 		 => 'parent_customer_name',
			'mobile' 	 => 'parent_customer_mobile',
			'sex' 		 => 'parent_customer_sex',
			'openid' 	 => 'parent_customer_openid',
			'login_time' => 'parent_customer_login_time',
			'login_ip' 	 => 'parent_customer_login_ip',
			
			'_on' 	=> 'RewardUsers.pid = ParentCustomer.id',
			
			'_type' => 'LEFT',
		),
		'Project' => array(
			'name' 		=> 'project_name',
			'mobile' 	=> 'project_mobile',
			'address' 	=> 'project_address',
			'projfzr' 	=> 'project_projfzr',
			
			'_on' 	=> 'RewardUsers.project_id = Project.id',
		),
		'RewardMoney' => array(
			'reward' 		=> 'money_reward',
			'use_reward' 	=> 'money_use_reward',
			'code' 			=> 'money_code',
			'code_time' 	=> 'money_code_time',
			'is_notice' 	=> 'money_is_notice',
			'add_time' 		=> 'money_add_time',
			'add_ip' 		=> 'money_add_ip',
			
			'_on' 	=> 'RewardMoney.project_id = RewardUsers.project_id AND RewardMoney.customer_id = RewardUsers.customer_id',
		),
	);
	
	
	/**
	 * 获取列表
	 *
	 * @create 2016-11-16
	 * @author zlw
	 */
	public function getList(
		array $where = array(), 
		$field = '*',
		$orderBy = 'id DESC',
		$limit = '50'
	) {		
		return $this->where($where)
				->field($field)
				->order($orderBy)
				->limit($limit)
				->select();
	}
	
} 

