<?php
namespace Common\Model;

use Think\Model\ViewModel;


/**
 * 项目视图表
 *
 * @create 2016-10-8
 * @author zlw
 */
class ProjectViewModel extends ViewModel 
{
	
	//视图配置
	public $viewFields = array(
		'Project' => array(
			'id', 'name', 'cp_id', 
			'address', 'mobile', 'projfzr',
			'createdate', 'status', 
			
			'wx_avatar', 'poster_path', 
			
			'app_id', 'app_secret', 'mch_id', 'api_password',
			'wishing', 'act_name', 'remark', 
			'public_key', 'private_key', 'rootca',
			
			'_type' => 'LEFT'
		),
		'Company' => array(
			'id' 	=> 'company_id',
			'name' 	=> 'company_name',
			
			'_on' 	=> 'Project.cp_id = Company.id'
		),
	);
	
	/**
	 * 根据ID获取单个
	 *
	 * @create 2016-11-7
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
	 * @create 2016-10-8
	 * @author zlw
	 */
	public function getList(
		array $where = array(), 
		$orderBy = 'id DESC',
		$limit = '50'
	) {		
		return $this->where($where)
				->order($orderBy)
				->limit($limit)
				->select();
	}
	
} 








