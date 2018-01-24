<?php
namespace Common\Model;

use Think\Model;


/**
 * 微信认购日志
 *
 * @create 2017-04-26
 * @author jxw
 */
class WxrgLogModel extends Model 
{
	
	/**
	 * 表名
	 *
	 * @create 2017-04-26
	 * @author jxw
	 */
	protected $tableName = 'wxrglog';

	
	/**
	 * 添加单个
	 *
	 * @create 2017-04-26
	 * @author jxw
	 */
	public function addOne($data) {
		return $this->data($data)->add();
	}

	
	/**
	 * 获取单个
	 *
	 * @create 2017-04-26
	 * @author jxw
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
	 * 根据房间ID
	 *
         * @create 2017-04-26
	 * @author jxw
	 */
	public function getOneByRoomId($roomId)
	{
		$where = array(
			'room_id' => $roomId
		);
		return $this->where($where)->find();
	}

        public function getList(
		$where, 
		$field = '*',
		$orderBy = 'id DESC'
	) {
		return $this->field($field)
			->where($where)
			->order($orderBy)
			->select();
	}
	
	//**==================== 日志记录 ========================**//
	
	
	/**
	 * 微信认购记录
	 *
	 * @create 2017-04-26
	 * @author jxw
	 */
	public function wxrglog(
		$room_id, 
		$cst_id, 
		$cst_name,
                $hd_id
	) {
		$WxrgLog = D("WxrgLog");
		$data['hd_id'] = $hd_id;
		$data['room_id'] = $room_id;
                $data['cst_id'] = $cst_id;
		$data['type'] = '微信认购';
		$data['cst_name'] = $cst_name;
		$data['cztime'] = time();
                $data['sjm'] = $room_id.$cst_id.rand(100,999);
		
		$checkHasAdd = $WxrgLog->addOne($data);
		if (false === $checkHasAdd) {
			return false;
		}
		return true;
	}
	
} 








