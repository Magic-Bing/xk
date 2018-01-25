<?php

namespace Common\Logic;

use Think\Model;


/**
 * 微信相关
 *
 * @create 2016-11-16
 * @author zlw
 */
class WeixinLogic
{
	
	/**
	 * 获取项目的app_id和app_secret
	 *
	 * @create 2016-11-16
	 * @author zlw
	 */
	public function getAppidAndAppsecret($project_id = '')
	{
		if (empty($project_id)) {
			$project_id = $this->getProjectId();
			if (empty($project_id)) {
				return false;
			}
		}
		
		$where = array(
			'id' => $project_id
		);
		$project = D('Project')->where($where)
			->order('id DESC')
			->find();
		if (empty($project)) {
			return false;
		}

		$data = array(
			'app_id' => $project['app_id'],
			'app_secret' => $project['app_secret'],
		);
		
		return $data;
	}
	
	/**
	 * 设置项目ID
	 *
	 * @create 2016-11-16
	 * @author zlw
	 */
	public function setProjectId($project_id = '')
	{
		if (empty($project_id)) {
			return false;
		}
		
		$project_id = $this->crypt($project_id, 'encode');
		cookie('project_id', $project_id, 86400);
		
		return $project_id;
	}
	
	/**
	 * 获取项目ID
	 *
	 * @create 2016-11-16
	 * @author zlw
	 */
	public function getProjectId()
	{
		$project_id = session('project_id');
		if (empty($project_id)) {
			$project_id = cookie('project_id');
			if (!empty($project_id)) {
				//解密信息
				$project_id = $this->crypt($project_id, 'decode');
				session('project_id', $project_id);
			} else {
				return null;
			}
		}
		
		return $project_id;
	}
	
	/**
	 * 获取批次ID
	 *
	 * @create 2016-12-14
	 * @author zlw
	 */
	public function getBatchId($projectId = null)
	{
		if (empty($projectId)) {
			$projectId = $this->getProjectId();
		}
	
		//批次
		$batchWhere['proj_id'] = $projectId;
		$batchWhere['is_dq'] = 1;
		$batch = D("Batch")->getOne($batchWhere);
		
		//批次ID
		if (!empty($batch)) {
			$batchId = $batch['id'];
		} else {
			$batchId = 0;
		}
		
		return $batchId;
	}
	
	/**
	 * 加密和解密
	 *
	 * @create 2016-11-16
	 * @author zlw
	 */
	public function crypt($string, $type = 'encode')
	{
		//加密密钥
		$key = C("PROJECT_KEY").MD5('5e7ws');
		
		if (strtolower($type) == 'decode') {
			//解密
			$code_string = think_decrypt($string, $key);
		} else {
			//加密
			$code_string = think_encrypt($string, $key);
		}	
		
		return $code_string;
	}	
	
} 

