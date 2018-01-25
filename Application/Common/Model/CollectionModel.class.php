<?php
namespace Common\Model;

use Think\Model;

/**
 * 房间收藏
 *
 * @create 2016-9-6
 * @author zlw
 */
class CollectionModel extends Model 
{
	
	/**
	 * 表名
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	protected $tableName = 'cst2rooms';
	
	
	/**
	 * 添加单个
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	public function addOne($data)
	{
		return $this->data($data)->add();
	}
	
	
	/**
	 * 删除单个
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	public function deleteOne($where)
	{
		return $this->where($where)->delete();
	}
	
	
	/**
	 * 根据ID删除单个
	 *
	 * @create 2016-9-6
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
	 * 获取单个
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	public function getOne($where)
	{
		return $this->where($where)->find();
	}

	
	/**
	 * 获取单个根据ID
	 *
	 * @create 2016-9-6
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
	 * 获取单个根据房间ID
	 *
	 * @create 2016-9-6
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
	 * 获取单个根据房间ID
	 *
	 * @create 2016-10-8
	 * @author zlw
	 */
	public function getOneByRoomIdAndCstId($room_id, $cst_id)
	{
		$where = array(
			'room_id' => $room_id,
			'cst_id' => $cst_id
		);
		return $this->where($where)->find();
	}

	public function getOneByRoomIdAndEventid($room_id, $cst_id,$event_id)
	{
		$where = array(
			'room_id' => $room_id,
			'cst_id' => $cst_id,
                        'eventId' => $event_id
		);
		return $this->where($where)->find();
	}
        
        
	/**
	 * 获取列表
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	public function getList(
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
	 * 获取分组列表
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	public function getListGroupBy(
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
	 * 更改
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	public function editOne($data, $where)
	{
		return $this->where($where)->data($data)->save();
	}
	
	
	/**
	 * 根据ID更改
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
	public function editOneById($data, $id)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->data($data)->save();
	}

    public function getProjectCollectionByProjectId($projectId){
        $this->where(['proj_id'=>$projectId])->select();
    }
	
} 








