<?php

namespace Admin\Controller;


/**
 * 竞价选房 - 用户登录
 *
 * @create 2016-12-21
 * @author zlw
 */
class ChooseUserController extends BaseController 
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
		
		$ChooseuserView = D('Common/ChooseuserView');
		
		//条件
		$choose_user_where = array();
		if (!empty($search_project_id)) {
			$choose_user_where['project_id'] = $search_project_id;
		}
		if (!empty($search_id)) {
			$choose_user_where['id'] = array('like', '%'.$search_id.'%');
		}
		if (!empty($customer_phone)) {
			$choose_user_where['customer_phone'] = array('like', '%'.$customer_phone.'%');
		}
		if (!empty($search_add_time)) {
			$choose_user_where['add_time'] = array('elt', $search_add_time);
		}
		
		//总数
		$choose_user_count = $ChooseuserView->where($choose_user_where)->count();
	
		//分页
		$Page 		= $this->page($choose_user_count, 20);
		$page_show  = $Page->show();	
		
		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
	
		$choose_user_list = $ChooseuserView->getList(
			$choose_user_where, 
			'*', 
			'add_time DESC, id DESC', 
			$limit
		);

		$this->assign('page_show', $page_show); 
		$this->assign('choose_user_list', $choose_user_list);
		
		$this->set_seo_title("用户登录记录");
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
		
		$ChooseUser = D('ChooseUser');
		
		$choose_user = $ChooseUser->getOneById($id);
		if (empty($choose_user)) {
			$this->success("删除成功！");
		}
		
		$check_has_delete = $ChooseUser->deleteOneById($id);
		if (false === $check_has_delete) {
			$this->error("删除失败，请确认后重试！");
		}
		
		$this->success("删除成功！");
	}
	
}
