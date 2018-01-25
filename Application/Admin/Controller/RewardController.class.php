<?php

namespace Admin\Controller;


/**
 * 关注推广奖励设置
 *
 * @create 2016-11-7
 * @author zlw
 */
class RewardController extends BaseController 
{
	
	
	/**
	 * 首页
	 *
	 * @create 2016-11-7
	 * @author zlw
	 */
    public function index()
	{
		$this->option();
	}
	
	//*----------------- 设置 ----------------------*//	
	
	/**
	 * 设置
	 *
	 * @create 2016-11-7
	 * @author zlw
	 */
    public function option()
	{
		//项目ID
		$search_project_id = I('get.project_id', '', 'intval');

		//设置当前搜索
		$search = array(
			'search_project_id' => $search_project_id,
		);
		$this->assign($search);

		//项目
		$Project = D('Common/Project');
		
		//获取当前项目
		$project_info = $Project->getProjectById($search_project_id);
		$this->assign('project', $project_info);
		
		//获取公司信息
		$company_id = $project_info['cp_id'];
		$company = D('Common/Company')->getOneById($company_id);
		$this->assign('company', $company);
		
		//获取项目列表
		$project_where['status'] = 1;
		$project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id ASC, id ASC', '50');
		if (!empty($project_old_list)) {
			foreach ($project_old_list as $project_list_key => $project_list_value) {
				$project_list[$project_list_value['id']] = $project_list_value;
			}
		} else {
			$project_list = array();
		}
		$this->assign('project_list', $project_list);
		
		//奖励设置列表
		$reward_where = array();
		if (!empty($project_info)) {
			$reward_where['project_id'] = $project_info['id'];
		}
		
		$RewardOption = D('Common/RewardOption');
		
		//活动总数
		$reward_count = $RewardOption->where($reward_where)->count();
	
		//分页
		$Page 		= $this->page($reward_count, 20);
		$page_show  = $Page->show();	
		
		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
	
		$reward_list = $RewardOption->getList($reward_where, '*', 'end_time DESC, id DESC', $limit);

		$this->assign('page_show', $page_show); 
		$this->assign('reward_list', $reward_list);

		$this->set_seo_title("推广奖励设置");
        $this->display("option");
    } 
	
	
	/**
	 * 添加
	 *
	 * @create 2016-9-30
	 * @author zlw
	 */
	public function option_add()
	{
		if (IS_AJAX) {
			$project_id = I('project_id', 0, 'intval');
			$one_reward = I('one_reward', '', 'trim');
			$two_reward = I('two_reward', '', 'trim');
			$three_reward = I('three_reward', '', 'trim');
			$lowest_cash = I('lowest_cash', '', 'trim');
			$end_time = I('end_time', '', 'trim');
			$status = I('status', '', 'trim');
			$remark = I('remark', '', 'trim');
			
			if ($project_id == 0
				|| empty($one_reward)
				|| empty($two_reward)
				|| empty($three_reward)
				|| empty($lowest_cash)
				|| empty($end_time)
				|| empty($remark)
			) {
				$this->error("信息不能为空，请确认后重试！");
			}
			
			$RewardOption = D('Common/RewardOption');
			
			$data['project_id'] = $project_id;		
			$data['one_reward'] = $one_reward;		
			$data['two_reward'] = $two_reward;		
			$data['three_reward'] = $three_reward;		
			$data['lowest_cash'] = $lowest_cash;		
			$data['end_time'] = strtotime($end_time);
			$data['status'] = $status;		
			$data['remark'] = $remark;		
			
			$chech_has_add = $RewardOption->addOne($data);
			if (false === $chech_has_add) {
				$this->error("添加失败，请稍后重试！");
			} else {
				$this->success("恭喜你，更改成功！", '');
			}			
		} else {
			//项目ID
			$project_id = I('project_id', 0, 'intval');
			$this->assign('project_id', $project_id);
			
			//奖励信息
			$RewardOption = D('Common/RewardOption');
		
			//获取项目列表
			$project_where['status'] = 1;
			$project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id ASC, id ASC', '50');
			if (!empty($project_old_list)) {
				foreach ($project_old_list as $project_list_key => $project_list_value) {
					$project_list[$project_list_value['id']] = $project_list_value;
				}
			} else {
				$project_list = array();
			}
			$this->assign('project_list', $project_list);

			$this->set_seo_title('推广奖励添加');
			$this->display();
			
		}
	}
	
	
	/**
	 * 修改房间信息
	 *
	 * @create 2016-11-7
	 * @author zlw
	 */
	public function option_edit()
	{
		if (IS_AJAX) {			
			$id = I('id', 0, 'intval');
			
			$project_id = I('project_id', 0, 'intval');
			$one_reward = I('one_reward', '', 'trim');
			$two_reward = I('two_reward', '', 'trim');
			$three_reward = I('three_reward', '', 'trim');
			$lowest_cash = I('lowest_cash', '', 'trim');
			$end_time = I('end_time', '', 'trim');
			$status = I('status', '', 'trim');
			$remark = I('remark', '', 'trim');
			
			if ($id == 0 
				|| $project_id == 0
				|| empty($one_reward)
				|| empty($two_reward)
				|| empty($three_reward)
				|| empty($lowest_cash)
				|| empty($end_time)
				|| empty($remark)
			) {
				$this->error("信息不能为空，请确认后重试！");
			}
			
			$RewardOption = D('Common/RewardOption');
	
			$where['id'] = $id;
			
			$data['project_id'] = $project_id;		
			$data['one_reward'] = $one_reward;		
			$data['two_reward'] = $two_reward;		
			$data['three_reward'] = $three_reward;		
			$data['lowest_cash'] = $lowest_cash;		
			$data['end_time'] = strtotime($end_time);
			$data['status'] = $status;		
			$data['remark'] = $remark;		
			
			$chech_has_edit = $RewardOption->editOne($where, $data);
			if (false === $chech_has_edit) {
				$this->error("更改失败，请稍后重试！");
			} else {
				$this->success("恭喜你，更改成功！", '');
			}			
		} else {
			$id = I('id', 0, 'intval');
			if ($id == 0) {
				$this->error("房间不存在，请确认后重试！");
			}
			
			//奖励信息
			$RewardOption = D('Common/RewardOption');
			
			$rewardOption = $RewardOption->getOneById($id);
			if (empty($rewardOption)) {
				$this->error("推广奖励不存在，请确认后重试！");
			}
			
			$this->assign('rewardOption', $rewardOption);
		
			//获取项目列表
			$project_where['status'] = 1;
			$project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id ASC, id ASC', '50');
			if (!empty($project_old_list)) {
				foreach ($project_old_list as $project_list_key => $project_list_value) {
					$project_list[$project_list_value['id']] = $project_list_value;
				}
			} else {
				$project_list = array();
			}
			$this->assign('project_list', $project_list);

			$this->set_seo_title('推广奖励修改');
			$this->display();
		}
	}
	
	/**
	 * 删除
	 *
	 * @create 2016-10-21
	 * @author zlw
	 */
    public function option_delete()
	{
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$id = I('post.id', 0, 'intval');
		if ($id == 0) {
			$this->error("推广奖励不存在，请确认后重试！");
		}
		
		$RewardOption = D('Common/RewardOption');
		
		$rewardOption = $RewardOption->getOneById($id);
		if (empty($rewardOption)) {
			$this->success("删除成功！");
		}
		
		$check_has_delete = $RewardOption->deleteOneById($id);
		if (false === $check_has_delete) {
			$this->error("删除失败，请确认后重试！");
		}
		
		$this->success("删除成功！");
	}
	
	//*----------------- 日志 ----------------------*//
	
	/**
	 * 日志
	 *
	 * @create 2016-11-15
	 * @author zlw
	 */
    public function logs()
	{		
		//项目ID
		$search_project_id = I('get.project_id', '', 'intval');

		//设置当前搜索
		$search = array(
			'search_project_id' => $search_project_id,
		);
		$this->assign($search);
		
		$RewardlogView = D("RewardlogView");
		$Customer = D("Customer");

		//条件
		$where = array();
		if (!empty($search_project_id)) {
			$where['project_id'] = $search_project_id;
		}
		
		//活动总数
		$count = $RewardlogView->where($where)->count();
	
		//分页
		$Page 		= $this->page($count, 15);
		$page_show  = $Page->show();	
		$this->assign('page_show', $page_show); 

		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
		
		//奖励日志
		$reward_logs = $RewardlogView->getList($where, '*', 'add_time DESC', $limit);
		$this->assign('reward_logs', $reward_logs);
		
		//用户ID列表
		$customer_ids = array();
		if (!empty($reward_log)) {
			foreach ($reward_log as $reward_log_key => $reward_log_value) {
				$customer_ids[$reward_log_value['reward_customer_id']] = $reward_log_value['reward_customer_id'];
			}
		}
		
		//用户列表
		$customers = array();
		if (!empty($customer_ids)) {
			unset($where);
			$where['id'] = array('in', $customer_ids);
			$customers = $Customer->getList($where);
			
			foreach ($customers as $customers_value) {
				$customers[$customers_value['id']] = $customers_value;
			}
		}
		$this->assign('customers', $customers);
		
		//获取项目列表
		$project_where['status'] = 1;
		$project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id ASC, id ASC', '50');
		if (!empty($project_old_list)) {
			foreach ($project_old_list as $project_list_key => $project_list_value) {
				$project_list[$project_list_value['id']] = $project_list_value;
			}
		} else {
			$project_list = array();
		}
		$this->assign('project_list', $project_list);
		
		$this->set_seo_title('提取奖励');
		$this->display();
	}
	
	/**
	 * 日志 - 删除
	 *
	 * @create 2016-11-15
	 * @author zlw
	 */
    public function logs_delete()
	{
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$id = I('post.id', 0, 'intval');
		if ($id == 0) {
			$this->error("推广奖励不存在，请确认后重试！");
		}
		
		$RewardLog = D('RewardLog');
		
		$rewardLog = $RewardLog->getOneById($id);
		if (empty($rewardLog)) {
			$this->success("删除成功！");
		}
		
		$check_has_delete = $RewardLog->deleteOneById($id);
		if (false === $check_has_delete) {
			$this->error("删除失败，请确认后重试！");
		}
		
		$this->success("删除成功！");
	}
	
	/**
	 * 日志 - 软删除
	 *
	 * @create 2016-11-15
	 * @author zlw
	 */
    public function logs_redelete()
	{
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$id = I('post.id', 0, 'intval');
		if ($id == 0) {
			$this->error("推广奖励不存在，请确认后重试！");
		}
		
		$RewardLog = D('RewardLog');
		
		$rewardLog = $RewardLog->getOneById($id);
		if (empty($rewardLog)) {
			$this->success("删除成功！");
		}
		
		$data['status'] = '0';
		$check_has_edit = $RewardLog->editOneById($id, $data);
		if (false === $check_has_edit) {
			$this->error("移除失败，请确认后重试！");
		}
		
		$this->success("移除成功！");
	}
	
	/**
	 * 日志 - 软恢复
	 *
	 * @create 2016-11-15
	 * @author zlw
	 */
    public function logs_resave()
	{
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$id = I('post.id', 0, 'intval');
		if ($id == 0) {
			$this->error("推广奖励不存在，请确认后重试！");
		}
		
		$RewardLog = D('RewardLog');
		
		$rewardLog = $RewardLog->getOneById($id);
		if (empty($rewardLog)) {
			$this->success("删除成功！");
		}
		
		$data['status'] = '1';
		$check_has_edit = $RewardLog->editOneById($id, $data);
		if (false === $check_has_edit) {
			$this->error("恢复失败，请确认后重试！");
		}
		
		$this->success("恢复成功！");
	}
	
	//*----------------- 关系 ----------------------*//
	
	/**
	 * 用户关系
	 *
	 * @create 2016-11-16
	 * @author zlw
	 */
    public function users()
	{		
		//项目ID
		$search_project_id = I('get.project_id', '', 'intval');

		//设置当前搜索
		$search = array(
			'search_project_id' => $search_project_id,
		);
		$this->assign($search);
		
		$RewardusersView = D("RewardusersView");

		//条件
		$where = array();
		if (!empty($search_project_id)) {
			$where['project_id'] = $search_project_id;
		}
		
		//活动总数
		$count = $RewardusersView->where($where)->count();
	
		//分页
		$Page 		= $this->page($count, 15);
		$page_show  = $Page->show();	
		$this->assign('page_show', $page_show); 

		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
		
		//奖励日志
		$reward_users = $RewardusersView->getList($where, '*', 'add_time DESC', $limit);
		$this->assign('reward_users', $reward_users);
		
		//获取项目列表
		$project_where['status'] = 1;
		$project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id ASC, id ASC', '50');
		if (!empty($project_old_list)) {
			foreach ($project_old_list as $project_list_key => $project_list_value) {
				$project_list[$project_list_value['id']] = $project_list_value;
			}
		} else {
			$project_list = array();
		}
		$this->assign('project_list', $project_list);
		
		//二维码地址
		$qrcode_path = C('WX.QRCODE_PATH') . '/';
		$this->assign('qrcode_path', $qrcode_path);
		
		$this->set_seo_title('提取奖励');
		$this->display();
	}
	
	/**
	 * 用户关系 - 删除
	 *
	 * @create 2016-11-16
	 * @author zlw
	 */
    public function users_delete()
	{
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$id = I('post.id', 0, 'intval');
		if ($id == 0) {
			$this->error("推广奖励不存在，请确认后重试！");
		}
		
		$RewardUsers = D('RewardUsers');
		
		$rewardUsers = $RewardUsers->getOneById($id);
		if (empty($rewardUsers)) {
			$this->success("删除成功！");
		}
		
		$check_has_delete = $RewardUsers->deleteOneById($id);
		if (false === $check_has_delete) {
			$this->error("删除失败，请确认后重试！");
		}
		
		$this->success("删除成功！");
	}
	
	
}









