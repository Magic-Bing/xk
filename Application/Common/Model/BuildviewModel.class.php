<?php
namespace Common\Model;

use Think\Model;

/**
 * 楼栋表
 *
 * @create 2016-8-22
 * @author zlw
 */
class BuildviewModel extends Model 
{
	protected $tableName = 'buildlist';

	
	/**
	 * 获取楼栋列表
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
	public function getBuildList($where, $orderBy = 'id DESC')
	{
		return $this->where($where)
				->order($orderBy)
				->select();
	}
	
	
	/**
	 * 获取楼栋列表
	 *
	 * @create 2016-10-12
	 * @author zlw
	 */
	public function getList(
		$field = '*',
		$where, 
		$orderBy = 'id DESC'
	) {
		return $this->where($where)
				->field($field)
				->order($orderBy)
				->select();
	}
	
} 








