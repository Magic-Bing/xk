<?php
namespace Common\Model;

use Think\Model;

/**
 * 模型基类
 *
 * @create 2016-11-24
 * @author zlw
 */
class OrderHouseOrderModel extends Model
{

	/**
	 * 获取单个
	 *
	 * @create 2016-11-24
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
	 * @create 2016-11-24
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
	 * 分组获取单个
	 *
	 * @create 2016-11-24
	 * @author zlw
	 */
	public function getOneByGroup(
		$where, 
		$field = '*', 
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
	 * @create 2016-11-24
	 * @author zlw
	 */
	public function getList(
		$where, 
		$field = '*', 
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
	 * 分组获取列表
	 *
	 * @create 2016-11-24
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
	 * @create 2016-11-24
	 * @author zlw
	 */
	public function addOne($data)
	{
		return $this->data($data)->add();
	}
	
	/**
	 * 更改
	 *
	 * @create 2016-11-24
	 * @author zlw
	 */
	public function editOne($where = array(), $data)
	{
		return $this->where($where)->data($data)->save();
	}
	
	/**
	 * 根据ID更改单个
	 *
	 * @create 2016-11-24
	 * @author zlw
	 */
	public function editOneById($id, $data)
	{
		$where['id'] = $id;
		return $this->where($where)->data($data)->save();
	}
	
	/**
	 * 删除
	 *
	 * @create 2016-11-24
	 * @author zlw
	 */
	public function deleteOne($where)
	{
		return $this->where($where)->delete();
	}
	
	/**
	 * 根据ID删除单个
	 *
	 * @create 2016-11-24
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
	 * 根据ID添加次数等
	 *
	 * @create 2016-12-01
	 * @author zlw
	 */
	public function setIncById($id, $name, $num = 1)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->setInc($name, $num);
	}
	
	/**
	 * 根据ID减少次数等
	 *
	 * @create 2016-12-01
	 * @author zlw
	 */
	public function setDecById($id, $name, $num = 1)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->setDec($name, $num);
	}

	public function getOrderedHouseByEventId($eventId){
        $where = [
            'event_id'=>$eventId
        ];

        return $this->where($where)->field('room_id')->select();

    }

    public function getOrderedRoomsByEventId($eventId){
        return $this
            ->field([
                'belong_real_name'
                ,'log_time'
                ,'room_id'
                ,belong_phone
            ])
            ->where([
                'event_id'=>$eventId
            ])
            ->select();
    }

}
