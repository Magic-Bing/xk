<?php
namespace Common\Model;


/**
 * 代金券视图
 *
 * @create 2016-11-24
 * @author zlw
 */
class VoucherViewModel extends BaseViewModel 
{
	
	/**
	 * 视图配置
	 *
	 * @create 2016-11-24
	 * @author zlw
	 */
	public $viewFields = array(
		'Voucher' => array(
			'id', 
			'name', 
			'description', 
			'project_id', 
			'batch_id', 
			'type', 
			'money',
			'quantity',
			'open_quantity',
			'use_quantity',
			'end_time',
			'min_money',
			'directional_type',
			'house_type',
			'room_id',
			'status',
			'add_user_id',
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
			
			'_on' 	=> 'Voucher.project_id = Project.id',
			
			'_type' => 'LEFT'
		),
		'Kppc' => array(
			'id' 		 => 'batch_id',
			'proj_id' 	 => 'batch_project_id',
			'name' 		 => 'batch_name',
			'kptime' 	 => 'batch_open_time',
			'roomscount' => 'batch_rooms_count',
			
			'_on' 	=> 'Voucher.batch_id = Kppc.id',
			
			'_type' => 'LEFT'
		),
		'Room' => array(
			'id' 	=> 'room_id',
			'room' 	=> 'room_name',
			'floor' => 'room_floor',
			'unit' 	=> 'room_unit',
			'bld_id' 	=> 'room_bld_id',
			'pc_id' 	=> 'room_pc_id',
			'proj_id' 	=> 'room_proj_id',
			'cp_id' 	=> 'room_cp_id',
			'is_xf' 	=> 'room_is_xf',
			
			'_on' 	=> 'Voucher.room_id = Room.id',
			
			'_type' => 'LEFT'
		),
		'Build' => array(
			'id' 		=> 'build_id',
			'pc_id' 	=> 'build_batch_id',
			'proj_id' 	=> 'build_project_id',
			'buildname' => 'build_name',
			'buildcode' => 'build_code',
			
			'_on' 	=> 'Build.id = Room.bld_id',
			
			'_type' => 'LEFT'
		),
		'Admin' => array(
			'id' 		=> 'admin_id',
			'code' 		=> 'admin_code',
			'name' 		=> 'admin_name',
			'mobile' 	=> 'admin_mobile',
			'cp_id' 	=> 'admin_cp_id',
			'is_qy' 	=> 'admin_is_qy',
			
			'_on' 	=> 'Voucher.add_user_id = Admin.id',
		)
	);
	
} 

