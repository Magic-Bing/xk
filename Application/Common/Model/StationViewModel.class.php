<?php

namespace Common\Model;


/**
 * 权限视图
 *
 * @create 2016-12-21
 * @author zlw
 */
class StationViewModel extends BaseViewModel 
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
		'Project' => array(
			'id' 		=> 'project_id',
			'name' 		=> 'project_name',
			'cp_id' 	=> 'project_cp_id',
			'address' 	=> 'project_address',
			'mobile' 	=> 'project_mobile',
			'projfzr' 	=> 'project_projfzr',
			'createdate' 	=> 'project_createdate',
			'status' 	=> 'project_status',
			
			'_on' 	=> 'Station.proj_id = Project.id',
			
			'_type' => 'LEFT'
		),
		'Company' => array(
			'id' 	=> 'company_id',
			'name' 	=> 'company_name',
			
			'_on' 	=> 'Station.cp_id = Company.id'
		),
	);
	
	
} 








