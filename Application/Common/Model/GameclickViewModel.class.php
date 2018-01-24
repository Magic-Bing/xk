<?php
namespace Common\Model;

use Think\Model\ViewModel;


/**
 * 抢购视图表
 *
 * @create 2016-10-31
 * @author zlw
 */
class GameclickViewModel extends ViewModel 
{
	
	/**
	 * 视图配置
	 *
	 * @create 2016-10-31
	 * @author zlw
	 */
	public $viewFields = array(
		'GameStatistics' => array(
			'id', 
			'game_id', 
			'customer_id', 
			'create_time',
			'click',
			
			'_type' => 'LEFT'
		),
		'Customer' => array(
			'id' 		=> 'customer_id',
			'name' 		=> 'customer_name',
			'mobile' 	=> 'customer_mobile',
			'sex' 		=> 'customer_sex',
			'openid' 	=> 'customer_openid',
			'login_time' 	=> 'customer_login_time',
			
			'_on' 	=> 'GameStatistics.customer_id = Customer.id',
		),

		'Game' => array(
			'id' 			=> 'game_id', 
			'title' 		=> 'game_title',
			'room_id' 		=> 'game_room_id',
			'start_time' 	=> 'game_start_time', 
			'end_time' 		=> 'game_end_time',
			'allow_num' 	=> 'game_allow_num', 
			'use_num' 		=> 'game_use_num',
			'time_length' 	=> 'game_time_length', 
			'content' 		=> 'game_content',
			'create_time' 	=> 'game_create_time',
			'create_user_id' => 'game_create_user_id',
			'is_open' 	=> 'game_is_open',
			'is_end' 	=> 'game_is_end',
			
			'_on' 	=> 'GameStatistics.game_id = Game.id',
			
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
	);
	
	
	/**
	 * 获取列表
	 *
	 * @create 2016-10-31
	 * @author zlw
	 */
	public function getList(
		$where = array(), 
		$orderBy = 'id DESC',
		$limit = '50'
	) {		
		return $this->where($where)
				->order($orderBy)
				->limit($limit)
				->select();
	}
	
} 








