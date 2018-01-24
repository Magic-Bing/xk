<?php
namespace Common\Model;

use Think\Model;


/**
 * 关注奖励 - 用户奖励总数记录
 *
 * @create 2016-11-11
 * @author zlw
 */
class RewardMoneyModel extends Model 
{
	
	/**
	 * 表名
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	protected $tableName = 'reward_money';
	
	/**
	 * 获取单个
	 *
	 * @create 2016-11-11
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
	 * @create 2016-11-11
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
	 * @create 2016-11-11
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
	 * @create 2016-11-11
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
	 * 根据用户ID和项目ID获取单个
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	public function getOneByCustomerIdAndProjectId($customer_id, $project_id)
	{
		$where = array(
			'customer_id' => $customer_id,
			'project_id' => $project_id
		);
		return $this->where($where)->find();
	}	
	
	/**
	 * 分组获取单个
	 *
	 * @create 2016-11-11
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
	 * @create 2016-11-11
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
	 * @create 2016-11-11
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
	 * @create 2016-11-11
	 * @author zlw
	 */
	public function addOne($data)
	{
		if (!isset($data['add_time'])) {
			$data['add_time'] = time();
		}
		return $this->data($data)->lock(true)->add();
	}
	
	/**
	 * 更改单个
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	public function editOne($where = array(), $data)
	{
		return $this->where($where)->data($data)->lock(true)->save();
	}
	
	/**
	 * 根据ID更改单个
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	public function editOneById($id, $data)
	{
		$where['id'] = $id;
		return $this->where($where)->data($data)->lock(true)->save();
	}
	
	/**
	 * 删除单个
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	public function deleteOne($where)
	{
		return $this->where($where)->lock(true)->delete();
	}
	
	/**
	 * 根据ID删除单个
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	public function deleteOneById($id)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->lock(true)->delete();
	}
	
	/**
	 * 根据用户ID删除单个
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	public function deleteOneByCustomerId($customer_id)
	{
		$where = array(
			'customer_id' => $customer_id
		);
		return $this->where($where)->lock(true)->delete();
	}
	
	/**
	 * 根据项目ID删除单个
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	public function deleteOneByProjectId($ProjectId)
	{
		$where = array(
			'project_id' => $ProjectId
		);
		return $this->where($where)->lock(true)->delete();
	}
	
	/**================ 奖励变化 ==================**/
	
	/**
	 * 添加奖励
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	public function addCustomerReward(
		$customerId, 
		$projectId, 
		$reward = 0,
		$wxopenid = ''
	) {
		$where['customer_id'] = $customerId;
		$where['project_id'] = $projectId;
		
		$rewardInfo = $this->where($where)->find();
		if (empty($rewardInfo)) {
			$data['wxopenid'] = $wxopenid;
			$data['customer_id'] = $customerId;
			$data['project_id'] = $projectId;
			$data['reward'] = $reward;
			$data['add_time'] = time();
			$data['add_ip'] = get_client_ip(0, true);
			
			return $this->data($data)->add();			
		} else {
			return $this->where($where)->lock(true)->setInc('reward', $reward);
		}
	}
	
	/**
	 * 减去奖励
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	public function deleteCustomerReward($customerId, $projectId, $reward = 0)
	{
		$where['customer_id'] = $customerId;
		$where['project_id'] = $projectId;
		
		$rewardInfo = $this->where($where)->find();
		if (empty($rewardInfo)) {			
			return false;			
		} else {
			return $this->where($where)->lock(true)->setDec('reward', $reward);
		}
	}
	
	/**
	 * 更改通知状态
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	public function editCustomerRewardNotice($customerId, $projectId, $notice = 0)
	{
		$where['customer_id'] = $customerId;
		$where['project_id'] = $projectId;
		
		$rewardInfo = $this->where($where)->find();
		if (empty($rewardInfo)) {			
			return false;			
		} else {
			$data['is_notice'] = $notice;
			return $this->where($where)->data($data)->lock(true)->save();
		}
	}
	
	/**
	 * 添加提取奖励
	 *
	 * @create 2016-11-14
	 * @author zlw
	 */
	public function addUseCustomerReward($where, $reward = 0)
	{
		$rewardInfo = $this->where($where)->find();
		if (empty($rewardInfo)) {			
			return false;			
		} else {
			return $this->where($where)->lock(true)->setInc('use_reward', $reward);
		}
	}

	
} 

