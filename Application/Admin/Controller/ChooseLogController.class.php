<?php

namespace Admin\Controller;


/**
 * 用户竞价选房记录管理
 *
 * @create 2016-12-21
 * @author zlw
 */
class ChooseLogController extends BaseController 
{	
	
	/**
	 * 首页
	 *
	 * @create 2016-12-21
	 * @author zlw
	 */
    public function index()
	{
		//项目ID
		$search_project_id = I('get.project_id', '', 'intval');
		$search_id = I('get.id', '', 'trim');
		$search_phone = I('get.phone', '', 'trim');
		$search_add_time = I('get.add_time', '', 'trim');
		
		if (!empty($search_add_time)) {
			$search_add_time = strtotime(str_replace('+', ' ', $search_add_time));
			$search_format_add_time = date('Y-m-d H:i:s', $search_add_time);
		} else {
			$search_format_add_time = '';
		}

		//设置当前搜索
		$search = array(
			'search_project_id' => $search_project_id,
			'search_id' => $search_id,
			'search_phone' => $search_phone,
			'search_add_time' => $search_format_add_time,
		);
		$this->assign($search);

		//项目
		$Project = D('Common/Project');
		
		//获取当前项目
		$project_info = $Project->getProjectById($search_project_id);
		$this->assign('project', $project_info);
		
		//获取项目列表
		$project_where = array();
		//$project_where['status'] = 1;
		$project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id ASC, id ASC', '50');
		if (!empty($project_old_list)) {
			foreach ($project_old_list as $project_list_key => $project_list_value) {
				$project_list[$project_list_value['id']] = $project_list_value;
			}
		} else {
			$project_list = array();
		}
		$this->assign('project_list', $project_list);
		
		//批次
		$batch_list = D('Batch')->getList(array('proj_id' => $search_project_id), '*');
		$this->assign('batch_list', $batch_list);
		
		$ChooselogView = D('Common/ChooselogView');
		
		//条件
		$choose_log_where = array();
		if (!empty($search_project_id)) {
			$choose_log_where['activity_project_id'] = $search_project_id;
		}
		if (!empty($search_id)) {
			$choose_log_where['id'] = array('like', '%'.$search_id.'%');
		}
		if (!empty($customer_phone)) {
			$choose_log_where['customer_phone'] = array('like', '%'.$customer_phone.'%');
		}
		if (!empty($search_add_time)) {
			$choose_log_where['add_time'] = array('elt', $search_add_time);
		}
		
		//总数
		$choose_log_count = $ChooselogView->where($choose_log_where)->count();
	
		//分页
		$Page 		= $this->page($choose_log_count, 20);
		$page_show  = $Page->show();	
		
		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
	
		$choose_log_list = $ChooselogView->getList(
			$choose_log_where, 
			'*', 
			'add_time DESC, id DESC', 
			$limit
		);

		$this->assign('page_show', $page_show); 
		$this->assign('choose_log_list', $choose_log_list);
		
		$this->set_seo_title("用户竞价记录");
        $this->display();
	}	
	
	/**
	 * 删除
	 *
	 * @create 2016-12-21
	 * @author zlw
	 */
    public function delete()
	{
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$id = I('post.id', 0, 'intval');
		if ($id == 0) {
			$this->error("代金券不存在，请确认后重试！");
		}
		
		$ChooseLog = D('ChooseLog');
		
		$choose_log = $ChooseLog->getOneById($id);
		if (empty($choose_log)) {
			$this->success("删除成功！");
		}
		
		$check_has_delete = $ChooseLog->deleteOneById($id);
		if (false === $check_has_delete) {
			$this->error("删除失败，请确认后重试！");
		}
		
		$this->success("删除成功！");
	}
	
	/**
	 * 移除
	 *
	 * @create 2016-12-21
	 * @author zlw
	 */
    public function redelete()
	{
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$id = I('post.id', 0, 'intval');
		if ($id == 0) {
			$this->error("记录不存在，请确认后重试！");
		}
		
		$ChooseLog = D('ChooseLog');
		
		$choose_log = $ChooseLog->getOneById($id);
		if (empty($choose_log)) {
			$this->success("操作成功！");
		}
		
		$data['status'] = '0';
		$check_has_edit = $ChooseLog->editOneById($id, $data);
		if (false === $check_has_edit) {
			$this->error("移除失败，请确认后重试！");
		}
		
		$this->success("移除成功！");
	}
	
	/**
	 * 恢复
	 *
	 * @create 2016-12-21
	 * @author zlw
	 */
    public function resave()
	{
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$id = I('post.id', 0, 'intval');
		if ($id == 0) {
			$this->error("记录不存在，请确认后重试！");
		}
		
		$ChooseLog = D('ChooseLog');
		
		$choose_log = $ChooseLog->getOneById($id);
		if (empty($choose_log)) {
			$this->success("操作成功！");
		}
		
		$data['status'] = '1';
		$check_has_edit = $ChooseLog->editOneById($id, $data);
		if (false === $check_has_edit) {
			$this->error("恢复失败，请确认后重试！");
		}
		
		$this->success("恢复成功！");
	}
	
}
