<?php
namespace Common\Model;

use Think\Model;

/**
 * 项目表
 *
 * @create 2018-8-22
 * @author zlw
 */
class ProjectModel extends Model 
{

	
	/**
	 * 获取项目
	 *
	 * @create 2016-8-29
	 * @author zlw
	 */
	public function getProjectById($id)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->find();
	}
	

	/**
	 * 获取单个
	 *
	 * @create 2016-12-09
	 * @author zlw
	 */
	public function getOne($where)
	{
		return $this->where($where)->find();
	}
	

	/**
	 * 获取项目
	 *
	 * @create 2016-10-9
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
	 * 获取项目表列表
	 *
	 * @create 2018-8-22
	 * @author zlw
	 */
	public function getProjectList(
		array $where = array(), 
		$orderBy = 'id DESC'
	) {
		$Project = M('Project');
		
		return $Project->where($where)
				->order($orderBy)
				->select();
	}
	
	/**
	 * 更改单个
	 *
	 * @create 2016-11-17
	 * @author zlw
	 */
	public function editOne($where = array(), $data)
	{
		return $this->where($where)->data($data)->save();
	}
	
	/**
	 * 根据ID更改单个
	 *
	 * @create 2016-11-17
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
	 * @create 2016-11-17
	 * @author zlw
	 */
	public function deleteOne($where)
	{
		return $this->where($where)->delete();
	}
	
	/**
	 * 根据ID删除单个
	 *
	 * @create 2016-11-17
	 * @author zlw
	 */
	public function deleteOneById($id)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->delete();
	}
	
} 








