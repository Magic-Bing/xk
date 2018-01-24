<?php
namespace Common\Model;

use Think\Model;


/**
 * 关注奖励 - 用户关系
 *
 * @create 2016-11-8
 * @author zlw
 */
class RewardUsersModel extends Model 
{
	
	/**
	 * 表名
	 *
	 * @create 2016-11-8
	 * @author zlw
	 */
	protected $tableName = 'reward_users';
	
	/**
	 * 获取单个
	 *
	 * @create 2016-11-8
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
	 * @create 2016-11-8
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
	 * 根据用户ID获取单个
	 *
	 * @create 2016-11-8
	 * @author zlw
	 */
	public function getOneByCustomerId($customer_id)
	{
		$where = array(
			'customer_id' => $customer_id
		);
		return $this->where($where)->find();
	}	
	
	/**
	 * 根据项目ID获取单个
	 *
	 * @create 2016-11-8
	 * @author zlw
	 */
	public function getOneByProjectId($ProjectId)
	{
		$where = array(
			'project_id' => $ProjectId
		);
		return $this->where($where)->find();
	}	
	
	/**
	 * 分组获取单个
	 *
	 * @create 2016-11-8
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
	 * @create 2016-11-8
	 * @author zlw
	 */
	public function getList(
		$where, 
		$field, 
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
	 * @create 2016-11-8
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
	 * @create 2016-11-8
	 * @author zlw
	 */
	public function addOne($data)
	{
		if (!isset($data['add_time'])) {
			$data['add_time'] = time();
		}
		return $this->data($data)->add();
	}
	
	/**
	 * 更改单个
	 *
	 * @create 2016-11-8
	 * @author zlw
	 */
	public function editOne($where = array(), $data)
	{
		return $this->where($where)->data($data)->save();
	}
	
	/**
	 * 根据ID更改单个
	 *
	 * @create 2016-11-8
	 * @author zlw
	 */
	public function editOneById($id, $data)
	{
		$where['id'] = $id;
		return $this->where($where)->data($data)->save();
	}
	
	/**
	 * 删除单个
	 *
	 * @create 2016-11-8
	 * @author zlw
	 */
	public function deleteOne($where)
	{
		return $this->where($where)->delete();
	}
	
	/**
	 * 根据ID删除单个
	 *
	 * @create 2016-11-8
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
	 * 根据用户ID删除单个
	 *
	 * @create 2016-11-8
	 * @author zlw
	 */
	public function deleteOneByCustomerId($customer_id)
	{
		$where = array(
			'customer_id' => $customer_id
		);
		return $this->where($where)->delete();
	}
	
	/**
	 * 根据项目ID删除单个
	 *
	 * @create 2016-11-8
	 * @author zlw
	 */
	public function deleteOneByProjectId($ProjectId)
	{
		$where = array(
			'project_id' => $ProjectId
		);
		return $this->where($where)->delete();
	}

	
} 

