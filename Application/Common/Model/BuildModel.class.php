<?php
namespace Common\Model;

use Think\Model;

/**
 * 楼栋表
 *
 * @create 2016-8-22
 * @author zlw
 */
class BuildModel extends Model 
{
	
	/**
	 * 获取楼栋
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
	public function getBuildById($id)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->find();
	}
	
	public function getBuildingsOrderBuildCodeByBatchIdProjectId($batchId,$projectId){
	    $where = [
	        'pc_id' => $batchId
            ,'proj_id' => $projectId
        ];
	    return $this->where($where)->order('buildcode asc')->select();
    }

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
	
} 








