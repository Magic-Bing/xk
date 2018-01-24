<?php
namespace Common\Model;

use Think\Model;

/**
 * 权限
 *
 * @create 2016-9-9
 * @author zlw
 */
class StationModel extends Model 
{
	
	/**
	 * 表名
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	protected $tableName = 'station';
	
	
	/**
	 * 添加单个
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	public function getpProjectListByUserId($user_id, $project_id = '')
	{
		$where = '';
		if (!empty($project_id)) {
			$where .= ' AND __STATION2PROJ__.proj_id = '.$project_id;
		}
		
		return $this
			->join('__STATION2USER__ ON __STATION2USER__.station_id = __STATION__.id AND __STATION2USER__.userid = ' . $user_id)
			->join('__STATION2PROJ__ ON __STATION2PROJ__.station_id = __STATION__.id ' . $where)
			->select();
	}
	
	
} 








