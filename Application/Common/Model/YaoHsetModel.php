<?php
namespace Common\Model;

use Think\Model;

/**
 * 模型基类
 */
class YaoHsetModel extends Model
{

    protected $tableName = 'yaohset';

	/**
	 * 获取单个
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
	 */
	public function getList(
		$where, 
		$field = '*', 
		$orderBy = 'id DESC',
		$limit = ''
	) {
		return $this->field($field)
                        ->join("INNER JOIN (select a.id as bid,a.proj_id ,a.name as batch_name,b.name as project_name from xk_kppc a left join xk_project b on a.proj_id=b.id where is_yx =1) pc ON xk_yaohset.batch_id=pc.bid  and xk_yaohset.project_id=pc.proj_id")
			->where($where)
			->order($orderBy)
			->limit($limit)
			->select();
	}
	
	/**
	 * 分组获取列表
	 *
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
	 */
	public function addOne($data)
	{
		return $this->data($data)->add();
	}
	
	/**
	 * 更改
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
	 */
	public function deleteOne($where)
	{
		return $this->where($where)->delete();
	}
	
	/**
	 * 根据ID删除单个
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
	 */
	public function setDecById($id, $name, $num = 1)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->setDec($name, $num);
	}

}
