<?php
namespace Common\Model;


/**
 * 竞价选房活动视图
 *
 * @create 2016-12-19
 * @author zlw
 */
class ChooseactivityViewModel extends BaseViewModel 
{
	
	/**
	 * 视图配置
	 *
     * @create 2016-12-19
	 * @author zlw
	 */
	public $viewFields = array(
		'ChooseActivity' => array(
			'id' 		=> 'id',
			'sort' 		=> 'sort',
			'name' 		=> 'name',
			'description' 	=> 'description',
			'project_id' 	=> 'project_id',
			'batch_id' 	=> 'batch_id',
			'person_count' 	=> 'person_count',
			'long_time' 	=> 'long_time',
			'start_time' 	=> 'start_time',
			'end_time' 	=> 'end_time',
			'type' 		=> 'type',
			'remark' 	=> 'remark',
			'status' 	=> 'status',
			'add_user_id' 	=> 'add_user_id',
			'add_time' 	=> 'add_time',
			'add_ip' 	=> 'add_ip',
			
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
			
			'_on' 	=> 'ChooseActivity.project_id = Project.id',
			
			'_type' => 'LEFT'
		),
		'Kppc' => array(
			'id' 		 => 'batch_id',
			'proj_id' 	 => 'batch_project_id',
			'name' 		 => 'batch_name',
			'kptime' 	 => 'batch_open_time',
			'roomscount' => 'batch_rooms_count',
			
			'_on' 	=> 'ChooseActivity.batch_id = kppc.id',
			
			'_type' => 'LEFT'
		),
		'Admin' => array(
			'id' 		=> 'admin_id',
			'code' 		=> 'admin_code',
			'name' 		=> 'admin_name',
			'mobile' 	=> 'admin_mobile',
			'cp_id' 	=> 'admin_cp_id',
			'is_qy' 	=> 'admin_is_qy',
			
			'_on' 	=> 'ChooseActivity.add_user_id = admin.id',
		)
	);
	
} 

