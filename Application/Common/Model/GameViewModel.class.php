<?php
namespace Common\Model;

use Think\Model\ViewModel;


/**
 * 活动视图表
 *
 * @create 2016-10-21
 * @author zlw
 */
class GameViewModel extends ViewModel 
{
	
	/**
	 * 视图配置
	 *
	 * @create 2016-10-21
	 * @author zlw
	 */
	public $viewFields = array(
		'Game' => array(
			'id', 'title', 
			'start_time', 'end_time',
			'allow_num', 'use_num',
			'time_length', 'content',
			'create_time', 'create_user_id', 
			'is_open', 'is_end',
			
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
			
			'_on' 	=> 'Game.room_id = Room.id',
		),
                'Build' => array(
			'buildname' 	=> 'buildname',
			
			'_on' 	=> 'Room.bld_id = Build.id',
		),
                 'Project' => array(
			'name' 	=> 'projname',
			
			'_on' 	=> 'Room.proj_id = Project.id',
		)
	);
	
	
	/**
	 * 获取列表
	 *
	 * @create 2016-10-21
	 * @author zlw
	 */
	public function getList(
		array $where = array(), 
		$orderBy = 'id DESC',
		$limit = '50'
	) {		
		return $this->where($where)
				->order($orderBy)
				->limit($limit)
				->select();
	}
	
}
