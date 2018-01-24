<?php
namespace Common\Model;

use Think\Model;


/**
 * 用户表
 *
 * @create 2016-9-12
 * @author zlw
 */
class CustomerModel extends Model 
{
	
	/**
	 * 添加单个
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function addOne($data)
	{
		return $this->data($data)->add();
	}
	
	/**
	 * 单个获取
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function getOne($where)
	{
		return $this->where($where)->find();
	}
	
	/**
	 * 根据ID获取
	 *
	 * @create 2016-9-9
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
	 * 根据姓名获取
	 *
	 * @create 2016-9-9
	 * @author zlw
	 */
	public function getOneByName($name)
	{
		$where = array(
			'name' => $name
		);
		return $this->where($where)->find();
	}
	
	/**
	 * 根据openid获取
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function getOneByOpenId($open_id)
	{
		$where = array(
			'openid' => $open_id
		);
		return $this->where($where)->find();
	}

	/**
	 * 获取列表
	 *
	 * @create 2016-11-15
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
	 * 根据姓名获取
	 *
	 * @create 2016-9-9
	 * @author zlw
	 */
	public function getListByName($name)
	{
		$where = array(
			'name' => $name
		);
		return $this->where($where)->select();
	}
	
	/**
	 * 根据姓名获取个数
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function getCountByName($name)
	{
		$where = array(
			'name' => $name
		);
		return $this->where($where)->count();
	}
	
	/**
	 * 根据姓名排序获取个数
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function getCountByLikeName($name)
	{
		$k = 0;
		while (!empty($name)) {
			$name = ($k == 0)
				? $name 
				: $name.$k;
			$check_user_name = $this->getOneByName($name);
		
			if (empty($check_user_name)) {
				break;
			}
			
			$k = $k + 1;
		}
		
		return $k;
	}
	
	/**
	 * 更改单个
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function editOne($data, $where)
	{
		if (empty($data)) {
			return false;
		}
		return $this->data($data)->where($where)->save();
	}
	
} 








