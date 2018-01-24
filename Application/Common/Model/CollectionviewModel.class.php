<?php
namespace Common\Model;

use Think\Model;

/**
 * 房间收藏
 *
 * @create 2016-9-6
 * @author zlw
 */
class CollectionviewModel extends Model 
{
	
	/**
	 * 表名
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	protected $tableName = 'cst2roomslist';
	

	/**
	 * 获取列表
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	public function getList(
		array $where = array(), 
		$orderBy = 'id DESC',
		$field = '*'
	) {
		return $this->field($field)
				->where($where)
				->order($orderBy)
				->select();
	}
	
	
	/**
	 * 获取分组列表
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	public function getListGroupBy(
		$field, 
		$groupBy, 
		$orderBy = 'id DESC',
		array $where = array()
	) {
		return $this->field($field)
			->where($where)
			->group($groupBy)
			->order($orderBy)
			->select();
	}
	
        /**
	 * 获取备选房间列表 微信认购
	 *
	 * @create 2017-04-26
	 * @author jxw
	 */
	public function getListJoinWxrg(
		array $where = array(), 
		$orderBy = 'id DESC',
		$field = '*'
	) {
		return $this->field($field)
				->where($where)
                                ->join('LEFT JOIN (select id as wxrg_id,cst_name,cst_id as cid,room_id as rid,sjm from xk_wxrglog  where status=1) as __WXRG__ ON __WXRG__.rid  = xk_cst2roomslist.room_id')
				->order($orderBy)
				->select();
	}
	
	/**
	 * 更改
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	public function editOne($data, $where)
	{
		return $this->where($where)->data($data)->save();
	}
	
	
	/**
	 * 根据ID更改
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
	public function editOneById($data, $id)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->data($data)->save();
	}
	
} 








