<?php

namespace Common\Model;


/**
 * 竞价选房登录用户视图
 *
 * @create 2016-12-19
 * @author zlw
 */
class ChooseuserViewModel extends BaseViewModel 
{
	
	/**
	 * 视图配置
	 *
     * @create 2016-12-19
	 * @author zlw
	 */
	public $viewFields = array(
		'ChooseUser' => array(
			'id' 			=> 'id',
			'project_id' 	=> 'project_id',
			'batch_id' 		=> 'batch_id',
			'customer_phone' => 'customer_phone',
			'password' 		=> 'password',
			'is_login' 		=> 'is_login',
			'login_time' 	=> 'login_time',
			'login_ip' 		=> 'login_ip',
			'status' 		=> 'status',
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
			
			'_on' 	=> 'ChooseUser.project_id = Project.id',
			
			'_type' => 'LEFT'
		),
		'Kppc' => array(
			'id' 		 => 'batch_id',
			'proj_id' 	 => 'batch_project_id',
			'name' 		 => 'batch_name',
			'kptime' 	 => 'batch_open_time',
			'roomscount' => 'batch_rooms_count',
			
			'_on' 	=> 'ChooseUser.batch_id = Kppc.id',
			
			'_type' => 'LEFT'
		),
		'Customer' => array(
			'id' 		=> 'customer_id',
			'name' 		=> 'customer_name',
			'sex' 		=> 'customer_sex',
			'mobile' 	=> 'customer_mobile',
			
			'_on' 	=> 'ChooseUser.customer_phone = Customer.mobile',
		)
	);
	
} 

