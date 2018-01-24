<?php

namespace Common\Model;


/**
 * 代金券活动所选代金券视图
 *
 * @create 2016-11-24
 * @author zlw
 */
class VoucheractivityattrViewModel extends BaseViewModel 
{
	
	/**
	 * 视图配置
	 *
	 * @create 2016-11-24
	 * @author zlw
	 */
	public $viewFields = array(
		'VoucherActivityAttr' => array(
			'id', 
			'activity_id', 
			'voucher_id', 
			'quantity', 
			'use_quantity', 
			'add_user_id',
			'add_time',
			'add_ip',
			
			'_type' => 'LEFT'
		),
		'VoucherActivity' => array(
			'id' 		 => 'activity_id',
			'name' 		 => 'activity_name',
			'description' 	=> 'activity_description',
			'project_id' 	=> 'activity_project_id',
			'batch_id' 	 => 'activity_batch_id',
			'start_time' => 'activity_start_time',
			'end_time' 	 => 'activity_end_time',
			'attr_count' => 'activity_attr_count',
			'remark' 	 => 'activity_remark',
			'status' 	 => 'activity_status',
			'add_time' 	 => 'activity_add_time',
                        'cyfs' 	 => 'activity_cyfs',
			
			'_on' 	=> 'VoucherActivityAttr.activity_id = VoucherActivity.id',
			
			'_type' => 'LEFT'
		),
		'Voucher' => array(
			'id' 		 	 => 'voucher_id',
			'name' 		 	 => 'voucher_name',
			'description' 	 => 'voucher_description',
			'project_id' 	 => 'voucher_project_id',
			'batch_id' 		 => 'voucher_batch_id',
			'type' 		 	 => 'voucher_type',
			'money' 		 => 'voucher_money',
			'quantity' 		 => 'voucher_quantity',
			'open_quantity'  => 'voucher_open_quantity',
			'use_quantity' 	 => 'voucher_use_quantity',
			'end_time' 		 => 'voucher_end_time',
			'min_money' 	 => 'voucher_min_money',
			'house_type' 	 => 'voucher_house_type',
			'room_id' 		 => 'voucher_room_id',
			'add_user_id' 	 => 'voucher_add_user_id',
			'add_time' 		 => 'voucher_add_time',
			'add_ip' 		 => 'voucher_add_ip',
			
			'_on' 	=> 'VoucherActivityAttr.voucher_id = Voucher.id',
			
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
			
			'_on' 	=> 'Voucher.room_id = Room.id',
			
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

