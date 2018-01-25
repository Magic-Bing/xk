<?php
namespace Common\Model;


/**
 * 收藏视图
 *
 * @create 2016-12-06
 * @author zlw
 */
class CollectionsViewModel extends BaseViewModel 
{
	
	/**
	 * 视图配置
	 *
	 * @create 2016-12-06
	 * @author zlw
	 */
	public $viewFields = array(
		'Cst2rooms' => array(
			'id' 		=> 'id', 
			'cst_id'	=> 'customer_id', 
			'room_id'	=> 'room_id', 
			'sctime'	=> 'collection_time', 
			
			'_type' => 'LEFT'
		),
		'Room' => array(
			'id' 	=> 'room_id',
			'room' 	=> 'room_name',
			'floor' => 'room_floor',
			'unit' 	=> 'room_unit',
			'bld_id' 	=> 'room_build_id',
			'pc_id' 	=> 'room_batch_id',
			'proj_id' 	=> 'room_project_id',
			'cp_id' 	=> 'room_company_id',
			
			'hx' 		=> 'room_hx',
			'area' 		=> 'room_area',
			'tnarea' 	=> 'room_tnarea',
			'price' 	=> 'room_price',
			'tnprice' 	=> 'room_tnprice',
			'total' 	=> 'room_total_price',
			'is_xf' 	=> 'room_is_xf',
			'xftime' 	=> 'room_xftime',
			
			'_on' 	=> 'Cst2rooms.room_id = Room.id',
			
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
			
			'_on' 	=> 'Room.proj_id = Project.id',
			
			'_type' => 'LEFT'
		),
		'Kppc' => array(
			'id' 		 => 'batch_id',
			'proj_id' 	 => 'batch_project_id',
			'name' 		 => 'batch_name',
			'kptime' 	 => 'batch_open_time',
			'roomscount' => 'batch_rooms_count',
			'is_yx' 	 => 'batch_is_yx',
			'is_dq' 	 => 'batch_is_dq',
			
			'_on' 	=> 'Project.id = Kppc.proj_id',
			
			'_type' => 'LEFT'
		),
		'Company' => array(
			'id' 	=> 'company_id',
			'name' 	=> 'company_name',
			
			'_on' 	=> 'Room.cp_id = Company.id'
		),
	);
	
} 

