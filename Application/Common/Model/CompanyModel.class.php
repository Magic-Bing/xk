<?php
namespace Common\Model;

use Think\Model;

/**
 * 公司表
 *
 * @create 2016-9-30
 * @author zlw
 */
class  CompanyModel extends Model 
{
	
	/**
	 * 根据ID获取单个
	 *
	 * @create 2016-9-30
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
	 * 获取列表
	 *
	 * @create 2016-9-30
	 * @author zlw
	 */
	public function getList($where, $orderBy = 'id DESC')
	{
		return $this->where($where)
				->order($orderBy)
				->select();
	}
	
} 








