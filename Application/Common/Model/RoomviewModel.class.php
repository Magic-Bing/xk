<?php
namespace Common\Model;

use Think\Model;

/**
 * 房间表
 *
 * @create 2016-8-22
 * @author zlw
 */
class RoomviewModel extends Model 
{
	protected $tableName = 'roomlist';

	/**
	 * 获取房间列表
	 *
	 * @create 2016-9-18
	 * @author jxw
	 */
	public function getRoomListGroupBy(
		$field, 
		$groupBy, 
		$orderBy = 'id DESC',
		array $where = array()
	) {
		return $this->field($field)
			->where($where)
			->group($groupBy)
			->order($orderBy)
			->select();
	}
        
        /**
	 * 获取房间列表
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
	public function getRoomList(
		array $where = array(), 
		$orderBy = 'id DESC',
		$field = '*'
	) {
		return $this->field($field)
				->where($where)
				->order($orderBy)
				->select();
            
	}
        
	/**
	 * 获取房间列表
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
	public function getListLimit(
		array $where = array(), 
		$orderBy = 'id DESC',
		$field = '*',
		$limit = '100'
	) {
		return $this->field($field)
				->where($where)
				->order($orderBy)
				->limit($limit)
				->select();
            
	}

	
	/**
	 * 获取单个
	 *
	 * @create 2016-9-22
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
	 * 根据ID获取房间
	 *
	 * @create 2016-10-12
	 * @author zlw
	 */
	public function getOneById($id)
	{
		$where = array(
			'xk_roomlist.id' => $id
		);
		return $this->field("xk_roomlist.*,xk_hxset.hxmx")->join("LEFT JOIN xk_hxset ON xk_hxset.hx=xk_roomlist.hx")->where($where)->find();
	}
	
} 








