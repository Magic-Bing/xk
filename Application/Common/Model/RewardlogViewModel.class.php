<?php
namespace Common\Model;

use Think\Model\ViewModel;


/**
 * 奖励日志视图表
 *
 * @create 2016-11-15
 * @author zlw
 */
class RewardlogViewModel extends ViewModel 
{
	
	/**
	 * 视图配置
	 *
	 * @create 2016-11-15
	 * @author zlw
	 */
	public $viewFields = array(
		'RewardLog' => array(
			'id', 'customer_id', 
			'reward_customer_id', 'project_id',
			'reward', 'is_read', 
			'action', 'status', 
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
			
			'_on' 	=> 'RewardLog.customer_id = Customer.id',
			
			'_type' => 'LEFT',
		),
		'RewardCustomer' => array(
			'_table'	 => "__CUSTOMER__",
			
			'name' 		 => 'reward_customer_name',
			'mobile' 	 => 'reward_customer_mobile',
			'sex' 		 => 'reward_customer_sex',
			'openid' 	 => 'reward_customer_openid',
			'login_time' => 'reward_customer_login_time',
			'login_ip' 	 => 'reward_customer_login_ip',
			
			'_on' 	=> 'RewardLog.reward_customer_id = RewardCustomer.id',
			
			'_type' => 'LEFT',
		),
		'Project' => array(
			'name' 		=> 'project_name',
			'mobile' 	=> 'project_mobile',
			'address' 	=> 'project_address',
			'projfzr' 	=> 'project_projfzr',
			
			'_on' 	=> 'RewardLog.project_id = Project.id',
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

