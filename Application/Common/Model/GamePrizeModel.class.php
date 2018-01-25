<?php
namespace Common\Model;

use Think\Model;


/**
 * 抢房活动 - 中奖信息
 *
 * @create 2016-10-26
 * @author zlw
 */
class GamePrizeModel extends Model 
{
	
	/**
	 * 表名
	 *
	 * @create 2016-10-26
	 * @author zlw
	 */
	protected $tableName = 'game_prize';
	
	/**
	 * 获取单个
	 *
	 * @create 2016-10-26
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
	 * @create 2016-10-26
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
	 * @create 2016-10-26
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
	 * @create 2016-10-26
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
	 * @create 2016-10-26
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
	 * @create 2016-10-26
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
	 * @create 2016-10-26
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
	 * @create 2016-10-26
	 * @author zlw
	 */
	public function editOne($where = array(), $data)
	{
		return $this->where($where)->data($data)->save();
	}
	
	/**
	 * 根据ID更改单个
	 *
	 * @create 2016-10-26
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
	 * @create 2016-10-26
	 * @author zlw
	 */
	public function deleteOne($where)
	{
		return $this->where($where)->delete();
	}
	
	/**
	 * 根据ID删除单个
	 *
	 * @create 2016-10-26
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
	 * @create 2016-10-26
	 * @author zlw
	 */
	public function deleteOneByRoomId($room_id)
	{
		$where = array(
			'room_id' => $room_id
		);
		return $this->where($where)->delete();
	}

	
} 








