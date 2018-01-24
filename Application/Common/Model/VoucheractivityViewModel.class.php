<?php
namespace Common\Model;


/**
 * 代金券活动视图
 *
 * @create 2016-11-24
 * @author zlw
 */
class VoucheractivityViewModel extends BaseViewModel 
{
	
	/**
	 * 视图配置
	 *
	 * @create 2016-11-24
	 * @author zlw
	 */
	public $viewFields = array(
		'VoucherActivity' => array(
			'id', 
			'name', 
			'description', 
			'project_id', 
			'batch_id', 
			'start_time', 
			'end_time', 
			'attr_count',
			'remark',
			'status',
			'add_time',
			'add_ip',
			
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
			
			'_on' 	=> 'VoucherActivity.project_id = Project.id',
			
			'_type' => 'LEFT'
		),
		'Kppc' => array(
			'id' 		 => 'batch_id',
			'proj_id' 	 => 'batch_project_id',
			'name' 		 => 'batch_name',
			'kptime' 	 => 'batch_open_time',
			'roomscount' => 'batch_rooms_count',
			
			'_on' 	=> 'VoucherActivity.batch_id = kppc.id',
			
			'_type' => 'LEFT'
		),
		'Admin' => array(
			'id' 		=> 'admin_id',
			'code' 		=> 'admin_code',
			'name' 		=> 'admin_name',
			'mobile' 	=> 'admin_mobile',
			'cp_id' 	=> 'admin_cp_id',
			'is_qy' 	=> 'admin_is_qy',
			
			'_on' 	=> 'VoucherActivity.add_user_id = admin.id',
		)
	);
	
} 

