<?php

namespace Common\Model;


/**
 * 权限关联视图
 *
 * @create 2016-12-21
 * @author zlw
 */
class StationrelevanceViewModel extends BaseViewModel 
{
	
	/**
	 * 视图配置
	 *
     * @create 2016-12-21
	 * @author zlw
	 */
	public $viewFields = array(
		'Station' => array(
			'id' 		=> 'id',
			'name' 		=> 'name',
			'code' 		=> 'code',
			'cp_id' 	=> 'company_id',
			'proj_id' 	=> 'project_id',
			
			'_type' => 'LEFT'
		),
		'Company' => array(
			'id' 			=> 'company_id',
			'name' 			=> 'company_name',
			'mobile' 		=> 'company_mobile',
			'createdate' 	=> 'company_create_time',
			
			'_on' 	=> 'Station.cp_id = Company.id',
			
			'_type' => 'LEFT'
		),
		'StationProject' => array(
			'_table'	 => "__PROJECT__",
			
			'id' 		=> 'station_project_id',
			'name' 		=> 'station_project_name',
			'cp_id' 	=> 'station_project_company_id',
			'address' 	=> 'station_project_address',
			'mobile' 	=> 'station_project_mobile',
			'projfzr' 	=> 'station_project_head_person',
			'createdate' 	=> 'station_project_create_time',
			'status' 	=> 'station_project_status',
			
			'_on' 	=> 'Station.proj_id = StationProject.id',
			
			'_type' => 'LEFT'
		),
		'Station2pc' => array(
			'id' 			=> 'station2pc_id',
			'station_id' 	=> 'station2pc_station_id',
			'pc_id' 		=> 'station2pc_batch_id',
			'proj_id' 		=> 'station2pc_project_id',
			
			'_on' 	=> 'Station.id = Station2pc.station_id',
			
			'_type' => 'LEFT'
		),
		'Kppc' => array(
			'id' 		 => 'batch_id',
			'proj_id' 	 => 'batch_project_id',
			'name' 		 => 'batch_name',
			'kptime' 	 => 'batch_open_time',
			'roomscount' => 'batch_rooms_count',
			
			'_on' 	=> 'Station2pc.pc_id = kppc.id',
			
			'_type' => 'LEFT'
		),
		'Station2proj' => array(
			'id' 			=> 'station2proj_id',
			'station_id' 	=> 'station2proj_station_id',
			'proj_id' 		=> 'station2proj_project_id',
			
			'_on' 	=> 'Station.id = Station2proj.station_id',
		),
		'Project' => array(
			'id' 		=> 'project_id',
			'name' 		=> 'project_name',
			'cp_id' 	=> 'project_company_id',
			'address' 	=> 'project_address',
			'mobile' 	=> 'project_mobile',
			'projfzr' 	=> 'project_head_person',
			'createdate' 	=> 'project_create_time',
			'status' 	=> 'project_status',
			
			'_on' 	=> 'Project.id = Station2proj.proj_id',
			
			'_type' => 'LEFT'
		),
		'Station2user' => array(
			'id' 			=> 'station2user_id',
			'station_id' 	=> 'station2user_station_id',
			'userid' 		=> 'station2user_user_id',
			
			'_on' 	=> 'Station.id = station2user.station_id',
		),
		'User' => array(
			'id' 		=> 'user_id',
			'code' 		=> 'user_code',
			'name' 		=> 'user_name',
			'mobile' 	=> 'user_mobile',
			'cp_id' 	=> 'user_company_id',
			'type' 		=> 'user_type',
			
			'_on' 	=> 'Station2user.userid = User.id',
		),
	);
	
	
} 








