<?php
namespace Common\Model;

use Think\Model;


/**
 * 抢房活动
 *
 * @create 2016-10-20
 * @author zlw
 */
class GameModel extends Model 
{
	
	/**
	 * 表名
	 *
	 * @create 2016-10-20
	 * @author zlw
	 */
	protected $tableName = 'game';
	
	/**
	 * 获取单个
	 *
	 * @create 2016-10-24
	 * @author zlw
	 */
	public function getOne(
		$where, 
		$field = '*', 
		$orderBy = 'id DESC'
	) {
		return $this->field($field)
			->where($where)
			->order($orderBy)
			->find();
	}
	
	/**
	 * 根据ID获取单个
	 *
	 * @create 2016-10-20
	 * @author zlw
	 */
	public function getOneById($id)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->find();
	}
	
	/**
	 * 根据房间ID获取单个
	 *
	 * @create 2016-10-20
	 * @author zlw
	 */
	public function getOneByRoomId($room_id)
	{
		$where = array(
			'room_id' => $room_id
		);
		return $this->where($where)->find();
	}	
	
	/**
	 * 分组获取单个
	 *
	 * @create 2016-9-23
	 * @author zlw
	 */
	public function getOneByGroup(
		$where, 
		$field, 
		$groupBy = 'id',
		$orderBy = 'id DESC'
	) {
		return $this->field($field)
			->where($where)
			->group($groupBy)
			->order($orderBy)
			->find();
	}

	/**
	 * 获取列表
	 *
	 * @create 2016-10-20
	 * @author zlw
	 */
	public function getList(
		$where, 
		$field, 
		$orderBy = 'id DESC',
		$limit = ''
	) {
		return $this->field($field)
			->where($where)
			->order($orderBy)
			->limit($limit)
			->select();
	}
	
	/**
	 * 获取列表
	 *
	 * @create 2016-10-20
	 * @author zlw
	 */
	public function getListByGroup(
		$where, 
		$field, 
		$groupBy = 'id',
		$orderBy = 'id DESC',
		$limit = ''
	) {
		return $this->field($field)
			->where($where)
			->group($groupBy)
			->order($orderBy)
			->limit($limit)
			->select();
	}
	
	/**
	 * 添加单个
	 *
	 * @create 2016-10-20
	 * @author zlw
	 */
	public function addOne($data)
	{
		if (!isset($data['create_time'])) {
			$data['create_time'] = time();
		}
		return $this->data($data)->add();
	}
	
	/**
	 * 更改单个
	 *
	 * @create 2016-10-20
	 * @author zlw
	 */
	public function editOne($where = array(), $data)
	{
		return $this->where($where)->data($data)->save();
	}
	
	/**
	 * 根据ID更改单个
	 *
	 * @create 2016-10-20
	 * @author zlw
	 */
	public function editOneById($id, $data)
	{
		$where['id'] = $id;
		return $this->where($where)->data($data)->save();
	}
	
	/**
	 * 删除单个
	 *
	 * @create 2016-10-20
	 * @author zlw
	 */
	public function deleteOne($where)
	{
		return $this->where($where)->delete();
	}
	
	/**
	 * 根据ID删除单个
	 *
	 * @create 2016-10-20
	 * @author zlw
	 */
	public function deleteOneById($id)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->delete();
	}
	
	/**
	 * 根据房间ID删除单个
	 *
	 * @create 2016-10-20
	 * @author zlw
	 */
	public function deleteOneByRoomId($room_id)
	{
		$where = array(
			'room_id' => $room_id
		);
		return $this->where($where)->delete();
	}
	
	
	//**************************# 抢购统计 #**************************//
	
	
	/**
	 * 添加统计信息
	 *
	 * @create 2016-10-25
	 * @author zlw
	 */
	public function addStatistics($data, $num = 1)
	{
		$GameStatistics = M("game_statistics");
		
		$where['game_id'] = $data['game_id'];
		$where['customer_id'] = $data['customer_id'];
		$statistics = $GameStatistics->where($where)->find();
		
		$click = !isset($data['click']) ? $num : intval($data['click']);
		
		if (empty($statistics)) {
			if (!isset($data['create_time'])) {
				$data['create_time'] = time();
			}
			$status = $GameStatistics->data($data)->add();
		} else {
			unset($where);
			$where['game_id'] = $data['game_id'];
			$where['customer_id'] = $data['customer_id'];
			$status = $GameStatistics->where($where)->setInc("click", $click);
		}
		
		return $status;
	}
	
	
	/**
	 * 获取统计信息
	 *
	 * @create 2016-10-25
	 * @author zlw
	 */
	public function getStatisticsList(
		$where, 
		$field, 
		$orderBy = 'id DESC',
		$limit = ''
	) {
		$GameStatistics = M("game_statistics");
		
		return $GameStatistics->field($field)
			->where($where)
			->order($orderBy)
			->limit($limit)
			->select();
	}

	
        public function getStatisticsList1(
		$where, 
		$field, 
		$orderBy = 'id DESC,click DESC'
	) {
		$GameStatistics = M("game_statisticsView");
		
		return $GameStatistics->field($field)
			->where($where)
			->order($orderBy)
			->select();
	}
        
	
	/**
	 * 统计信息 - 删除
	 *
	 * @create 2016-10-31
	 * @author zlw
	 */
	public function deleteStatistics(
		$where
	) {
		$GameStatistics = M("game_statistics");
		
		return $GameStatistics->where($where)->delete();
	}

	
} 








