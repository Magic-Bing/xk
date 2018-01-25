<?php

namespace Common\Model;


/**
 * 代金券提醒视图
 *
 * @create 2016-12-13
 * @author zlw
 */
class VouchertipViewModel extends BaseViewModel 
{
	
	/**
	 * 视图配置
	 *
	 * @create 2016-12-13
	 * @author zlw
	 */
	public $viewFields = array(
		'VoucherTip' => array(
			'id' 			=> 'id',
			'project_id' 	=> 'project_id',
			'batch_id' 		=> 'batch_id',
			'activity_id' 	=> 'activity_id',
			'customer_id' 	=> 'customer_id',
			'is_tip' 		=> 'is_tip',
			'add_time' 		=> 'add_time',
			'add_ip' 		=> 'add_ip',
			
			'_type' => 'LEFT'
		),
		'Project' => array(
			'id' 		=> 'project_id',
			'name' 		=> 'project_name',
			'cp_id' 	=> 'project_cp_id',
			'address' 	=> 'project_address',
			'mobile' 	=> 'project_mobile',
			'projfzr' 	=> 'project_projfzr',
			'createdate' 	=> 'project_createdate',
			'status' 	=> 'project_status',
			
			'_on' 	=> 'VoucherTip.project_id = Project.id',
			
			'_type' => 'LEFT'
		),
		'Kppc' => array(
			'id' 		 => 'batch_id',
			'proj_id' 	 => 'batch_project_id',
			'name' 		 => 'batch_name',
			'kptime' 	 => 'batch_open_time',
			'roomscount' => 'batch_rooms_count',
			
			'_on' 	=> 'VoucherTip.batch_id = kppc.id',
			
			'_type' => 'LEFT'
		),
		'VoucherActivity' => array(
			'id' 			=> 'activity_id',
			'name' 			=> 'activity_name',
			'description' 	=> 'activity_description',
			'project_id' 	=> 'activity_project_id',
			'batch_id' 		=> 'activity_batch_id',
			'start_time' 	=> 'activity_start_time',
			'end_time' 		=> 'activity_end_time',
			'attr_count' 	=> 'activity_attr_count',
			'remark' 		=> 'activity_remark',
			'status' 		=> 'activity_status',
			'add_time' 		=> 'activity_add_time',
			'add_ip' 		=> 'activity_add_ip',
			
			'_on' 	=> 'VoucherTip.activity_id = VoucherActivity.id',
			
			'_type' => 'LEFT'
		),
		'Customer' => array(
			'name' 		 => 'customer_name',
			'mobile' 	 => 'customer_mobile',
			'sex' 		 => 'customer_sex',
			'openid' 	 => 'customer_openid',
			'login_time' => 'customer_login_time',
			'login_ip' 	 => 'customer_login_ip',
			
			'_on' 	=> 'VoucherTip.customer_id = Customer.id',
			
			'_type' => 'LEFT'
		),
	);
	
} 

