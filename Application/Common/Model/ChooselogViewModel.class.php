<?php
namespace Common\Model;


/**
 * 竞价选房日志视图
 *
 * @create 2016-12-19
 * @author zlw
 */
class ChooselogViewModel extends BaseViewModel 
{
	
	/**
	 * 视图配置
	 *
     * @create 2016-12-19
	 * @author zlw
	 */
	public $viewFields = array(
		'ChooseLog' => array(
			'id' 			=> 'id',
			'choose_id' => 'choose_id',
			'activity_id' 	=> 'activity_id',
			'money' 		=> 'money',
			'status' 		=> 'status',
			'add_time' 		=> 'add_time',
			'add_ip' 		=> 'add_ip',
			
			'_type' => 'LEFT'
		),
		'ChooseActivity' => array(
			'id' 			=> 'activity_id',
			'sort' 			=> 'activity_sort',
			'name' 			=> 'activity_name',
			'description' 	=> 'activity_description',
			'project_id' 	=> 'activity_project_id',
			'batch_id' 		=> 'activity_batch_id',
			'person_count' 	=> 'activity_person_count',
			'long_time' 	=> 'activity_long_time',
			'start_time' 	=> 'activity_start_time',
			'end_time' 		=> 'activity_end_time',
			'type' 			=> 'activity_type',
			'remark' 		=> 'activity_remark',
			'status' 		=> 'activity_status',
			'add_user_id' 	=> 'activity_add_user_id',
			'add_time' 		=> 'activity_add_time',
			'add_ip' 		=> 'activity_add_ip',
			
			'_on' 	=> 'ChooseActivity.id = ChooseLog.activity_id',
			
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
	
    /**
     * 获取没有阅读的记录总数
     *
     * @create 2016-12-30
     * @author zlw
     */
	public function getNoreadLogCount($project_id = '', $batch_id = '')
	{
		$where = array();
		if (!empty($project_id)) {
			if (!is_array($project_id)) {
				$project_id = array($project_id);
			}
		
			$where['ChooseActivity.project_id'] = array('in', $project_id);
		}
		if (!empty($batch_id)) {
			if (!is_array($batch_id)) {
				$batch_id = array($batch_id);
			}
			$where['ChooseActivity.batch_id'] = array('in', $batch_id);
		}
		
		return $this->where($where)->count();
	}
	
    /**
     * 设置未读记录为已读
     *
     * @create 2016-12-30
     * @author zlw
     */
	public function editNoreadToRead($project_id = '', $batch_id = '')
	{
		$where = array();
		if (!empty($project_id)) {
			if (!is_array($project_id)) {
				$batch_id = array($project_id);
			}
			$where['ChooseActivity.project_id'] = array('in', $batch_id);
		}
		if (!empty($batch_id)) {
			if (!is_array($batch_id)) {
				$batch_id = array($batch_id);
			}
			$where['ChooseActivity.batch_id'] = array('in', $batch_id);
		}
		
		$data['is_read'] = 1;
		
		return $this->where($where)->data($data)->save();
	}
	
} 

