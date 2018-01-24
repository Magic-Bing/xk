<?php
namespace Common\Model;

use Think\Model;

/**
 * 竞价活动
 *
 * @create 2017-1-13
 * @author jxw
 */
class Choose_activityModel extends Model 
{
	
        /**
	 * 获取单个
	 *
	 * @create 2017-01-13
	 * @author jxw
	 */
	public function getOne(
		$where, 
		$field = '*', 
		$orderBy = 'id DESC',
                $limit = 'limit 1'
	) {
		return $this->field($field)
			->where($where)
			->order($orderBy)
                        ->limit($limit)
			->find();
	}
	
    
	/**
	 * 根据ID获取单个
	 *
	 * @create 2017-01-13
	 * @author jxw
	 */
	public function getOneById($id)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->find();
	}
	
	
	/**
	 * 获取列表
	 *
	 * @create 2017-01-13
	 * @author jxw
	 */
	public function getList($where, $orderBy = 'id DESC')
	{
		return $this->where($where)
				->order($orderBy)
				->select();
	}
	
} 








