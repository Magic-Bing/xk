<?php
namespace Common\Model;


/**
 * 代金券日志视图
 *
 * @create 2016-11-30
 * @author zlw
 */
class VoucherlogViewModel extends BaseViewModel 
{
	
	/**
	 * 视图配置
	 *
	 * @create 2016-11-30
	 * @author zlw
	 */
	public $viewFields = array(
		'VoucherLog' => array(
			'id' 			=> 'id',
			'customer_id' 	=> 'customer_id',
			'voucher_id' 	=> 'voucher_id',
			'activity_id' 	=> 'activity_id',
			'batch_id' 		=> 'batch_id',
			'is_use' 		=> 'is_use',
			'status' 		=> 'status',
			'add_time' 		=> 'add_time',
			'add_ip' 		=> 'add_ip',
			
			'_type' => 'LEFT'
		),
		'Voucher' => array(
			'id' => 'voucher_id', 
			'name' => 'voucher_name', 
			'description' => 'voucher_description',  
			'project_id' => 'voucher_project_id',  
			'batch_id' => 'voucher_batch_id', 
			'type' => 'voucher_type', 
			'money' => 'voucher_money', 
			'quantity' => 'voucher_quantity', 
			'open_quantity' => 'voucher_open_quantity', 
			'use_quantity' => 'voucher_use_quantity', 
			'end_time' => 'voucher_end_time', 
			'min_money' => 'voucher_min_money', 
			'directional_type' => 'voucher_directional_type', 
			'house_type' => 'voucher_house_type', 
			'room_id' => 'voucher_room_id', 
			'status' => 'voucher_status', 
			'add_user_id' => 'voucher_add_user_id', 
			'add_time' => 'voucher_add_time', 
			'add_ip' => 'voucher_add_ip', 
			
			'_on' 	=> 'VoucherLog.voucher_id = Voucher.id',
			
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
			
			'_on' 	=> 'VoucherLog.activity_id = VoucherActivity.id',
			
			'_type' => 'LEFT'
		),
		'Customer' => array(
			'name' 		 => 'customer_name',
			'mobile' 	 => 'customer_mobile',
			'sex' 		 => 'customer_sex',
			'openid' 	 => 'customer_openid',
			'login_time' => 'customer_login_time',
			'login_ip' 	 => 'customer_login_ip',
			
			'_on' 	=> 'VoucherLog.customer_id = Customer.id',
			
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
			
			'_on' 	=> 'Voucher.project_id = Project.id',
			
			'_type' => 'LEFT'
		),
		'Kppc' => array(
			'id' 		 => 'batch_id',
			'proj_id' 	 => 'batch_project_id',
			'name' 		 => 'batch_name',
			'kptime' 	 => 'batch_open_time',
			'roomscount' => 'batch_rooms_count',
			
			'_on' 	=> 'VoucherLog.batch_id = kppc.id',
		),
	);
	
} 

