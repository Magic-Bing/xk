<?php
namespace Common\Model;

use Think\Model;


/**
 * 选房日志
 *
 * @create 2016-10-14
 * @author zlw
 */
class RoomLogModel extends Model 
{
	
	/**
	 * 表名
	 *
	 * @create 2016-10-14
	 * @author zlw
	 */
	protected $tableName = 'roomczlog';

	
	/**
	 * 添加单个
	 *
	 * @create 2016-10-14
	 * @author zlw
	 */
	public function addOne($data) {
		return $this->data($data)->add();
	}

	
	/**
	 * 获取单个
	 *
	 * @create 2016-10-14
	 * @author zlw
	 */
	public function getOne(
		$where, 
		$field, 
		$orderBy = 'id DESC'
	) {
		return $this->field($field)
			->where($where)
			->order($orderBy)
			->find();
	}

	
	/**
	 * 根据I房间ID
	 *
	 * @create 2016-10-14
	 * @author zlw
	 */
	public function getOneByRoomId($roomId)
	{
		$where = array(
			'room_id' => $roomId
		);
		return $this->where($where)->find();
	}

	
	/**
	 * 分组获取单个
	 *
	 * @create 2016-10-14
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
	 * @create 2016-10-14
	 * @author zlw
	 */
	public function getList(
		$where, 
		$field, 
		$orderBy = 'id DESC'
	) {
		return $this->field($field)
			->where($where)
			->order($orderBy)
			->select();
	}

	
	/**
	 * 获取列表
	 *
	 * @create 2016-10-14
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
	
	
	//**==================== 选房日志记录 ========================**//
	
	
	/**
	 * 选房记录
	 *
	 * @create 2016-10-14
	 * @author zlw
	 */
	public function choose(
		$room_id, 
		$czuser, 
		$czusername,
        $cstid
	) {
		$RoomLog = D("RoomLog");
		
		$data['room_id'] 	= $room_id;
		$data['cztype'] 	= '选房';
		$data['czuser'] 	= $czuser;
		$data['czusername'] = $czusername;
		$data['cztime'] 	= time();
		$data['cstid'] 	= $cstid;

		if (empty($room_id)
			|| empty($czuser)
		) {
			
		}
		
		$checkHasAdd = $RoomLog->addOne($data);
		if (false === $checkHasAdd) {
			return false;
		}
		
		return true;
	}


	/**
	 * 取消选房记录
	 *
	 * @create 2016-10-14
	 * @author zlw
	 */
	public function notChoose(
		$room_id, 
		$czuser, 
		$czusername
	) {
		$RoomLog = D("RoomLog");
		$data['room_id'] 	= $room_id;
		$data['cztype'] 	= '取消选房';
		$data['czuser'] 	= $czuser;
		$data['czusername'] = $czusername;
		$data['cztime'] 	= time();
		$checkHasAdd = $RoomLog->addOne($data);
		if (false === $checkHasAdd) {
			return false;
		}
		return true;
	}
	
} 








