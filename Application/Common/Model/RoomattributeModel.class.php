<?php
namespace Common\Model;

use Think\Model;

/**
 * 房间属性表
 *
 * @create 2018-8-30
 * @author zlw
 */
class RoomattributeModel extends Model 
{
	
	/**
	 * 数据表
	 *
	 * @create 2016-8-30
	 * @author zlw
	 */
	protected $tableName = 'roomattribute'; 
	
	
	/**
	 * 单个获取
	 *
	 * @create 2016-8-30
	 * @author zlw
	 */
	public function getAttributeListByRoomId($room_id)
	{
		$where = array(
			'room_id' => $room_id
		);
		return $this->where($where)->field('room_id,sccount,round(djcount/2,0) as djcount,round(sscount,0) as sscount,mock_djcount,mock_sccount,mock_sscount')->find();
	}
	
	
	/**
	 * 获取列表
	 *
	 * @create 2018-8-30
	 * @author zlw
	 */
	public function getAttributeList(
		array $where = array(), 
		$orderBy = 'id DESC',
		$field = 'room_id,sccount,round(djcount/2,0) as djcount,round(sscount,0) as sscount,mock_djcount,mock_sccount,mock_sscount',
		$limit = '100'
	) {		
		return $this->field($field)
				->where($where)
				->order($orderBy)
				->limit($limit)
				->select();
	}
	
	
	/**
	 * 根据room表获取列表
	 *
	 * @create 2018-8-30
	 * @author zlw
	 */
	public function getAttributeListJoinRoom(
		array $where = array(), 
		$orderBy = 'id DESC',
		$field = '*',
		$limit = '100'
	) {		
		return $this->field($field)
				->where($where)
				->join('LEFT JOIN __ROOMLIST__ ON __ROOMATTRIBUTE__.room_id = __ROOMLIST__.id')
				->order($orderBy)
				->limit($limit)
				->select();
	}
	
	
	/**
	 * 条件更改
	 *
	 * @create 2016-8-31
	 * @author zlw
	 */
	public function editAttribute($data, $where)
	{
		return $this->where($where)->data($data)->save();
	}
	
	/**
	 * 所有条件更改
	 *
	 * @create 2016-10-8
	 * @author zlw
	 */
	public function editAllAttr($data, $where)
	{
		$attr = $this->where($where)->find();
		if (empty($attr)) {
			$data['room_id'] = $where['room_id'];
			$data['djcount'] = 0;
			$data['sccount'] = 0;
			$data['sscount'] = 0;
			return $this->data($data)->add();
		} else {
			return $this->where($where)->data($data)->save();
		}
	}

	
	/**
	 * 条件更改
	 *
	 * @create 2016-8-31
	 * @author zlw
	 */
	public function editAttributeCompareByRoomId($num, $room_id)
	{
		$where = array(
			'room_id' => $room_id
		);
		$attr = $this->where($where)->find();
		if (empty($attr)) {
			$data['room_id'] = $room_id;
			$data['djcount'] = 0;
			$data['sccount'] = 0;
			$data['sscount'] = $num;
			return $this->data($data)->add();
		} else {
			return $this->where($where)->setInc("sscount", $num);;
		}
	}
	
	
	/**
	 * 更改点击
	 *
	 * @create 2016-9-1
	 * @author zlw
	 */
	public function incAttributeDjcountByRoomId($num, $room_id)
	{
		$where = array(
			'room_id' => $room_id
		);
		$attr = $this->where($where)->find();
		if (empty($attr)) {
			$data['room_id'] = $room_id;
			$data['djcount'] = $num;
			$data['sccount'] = 0;
			$data['sscount'] = 0;
			return $this->data($data)->add();
		} else {
			return $this->where($where)->setInc("djcount", $num);;
		}
	}
	
	
	/**
	 * 增加收藏数
	 *
	 * @create 2016-9-7
	 * @author zlw
	 */
	public function incSccountByRoomId($num, $room_id)
	{
		$where = array(
			'room_id' => $room_id
		);
		$attr = $this->where($where)->find();
		if (empty($attr)) {
			$data['room_id'] = $room_id;
			$data['djcount'] = 0;
			$data['sccount'] = $num;
			$data['sscount'] = 0;
			return $this->data($data)->add();
		} else {
			return $this->where($where)->setInc("sccount", $num);;
		}
	}
	
	
	/**
	 * 减少收藏数
	 *
	 * @create 2016-9-7
	 * @author zlw
	 */
	public function decSccountByRoomId($num, $room_id)
	{
		$where = array(
			'room_id' => $room_id
		);
		$attr = $this->where($where)->find();
		if (empty($attr)) {
			return false;
		}
		
		if ($attr['sccount'] <= 0) {
			return false;
		}
		
		if ($attr['sccount'] < $num) {
			$data['sccount'] = 0;
			return $this->where($where)->data($data)->save();
		} else {
			return $this->where($where)->setDec("sccount", $num);;
		}
		
	}
	/**
	 * 获取一个
	 *
	 * @create 2018-9-23
	 * @author zlw
	 */
	public function getOneByJoinRoom(
		array $where = array(), 
		$orderBy = 'id DESC',
		$field = '*'
	) {		
		return $this->field($field)
				->where($where)
				->join('LEFT JOIN __ROOM__ ON __ROOMATTRIBUTE__.room_id = __ROOM__.id')
				->order($orderBy)
				->find();
	}
	
} 








