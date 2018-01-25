<?php

namespace Admin\Controller;


/**
 * 竞价选房
 *
 * @create 2016-12-20
 * @author zlw
 */
class ChooseActivityController extends BaseController 
{	
	
	/**
	 * 竞价选房
	 *
	 * @create 2016-12-19
	 * @author zlw
	 */
    public function index()
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
		
		$ChooseactivityView = D('Common/ChooseactivityView');
		
		//条件
		$choose_where = array();
		if (!empty($search_project_id)) {
			$choose_where['project_id'] = $search_project_id;
		}
		
		//总数
		$choose_activity_count = $ChooseactivityView->where($choose_where)->count();
	
		//分页
		$Page 		= $this->page($choose_activity_count, 20);
		$page_show  = $Page->show();	
		
		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
	
		$choose_activity_list = $ChooseactivityView->getList(
			$choose_where, 
			'*', 
			'id DESC', 
			$limit
		);

		$this->assign('page_show', $page_show); 
		$this->assign('choose_activity_list', $choose_activity_list);
		
		$this->set_seo_title("活动信息");
        $this->display();
	}	
	
	
	/**
	 * 添加
	 *
	 * @create 2016-12-19
	 * @author zlw
	 */
	public function add()
	{
		if (IS_AJAX) {
			$name = I('name', '', 'trim');
			$description = I('description', '', 'trim');
			$project_id = I('project_id', 0, 'intval');
			$batch_id = I('batch_id', 0, 'intval');
			$sort = I('sort', '', 'trim');
			$person_count = I('person_count', 0, 'intval');
			$start_time = I('start_time', '', 'trim');
			$end_time = I('end_time', '', 'trim');
			$long_time = I('long_time', 0, 'intval');
			$type = I('type', '', 'trim');
			$remark = I('remark', '', 'trim');
			$status = I('status', '', 'trim');
			
			if ($project_id == 0
				|| $batch_id == 0
				|| empty($name)
				|| $start_time == 0
			) {
				$this->error("信息不能为空，请确认后重试！");
			}
			
			$ChooseActivity = D('ChooseActivity');
			
			$data['name'] = $name;		
			$data['description'] = $description;		
			$data['project_id'] = $project_id;		
			$data['batch_id'] = $batch_id;
			
			$data['sort'] = $sort;		
			$data['person_count'] = $person_count;		
			$data['start_time'] = strtotime($start_time);		
			$data['end_time'] = !empty($end_time) ? strtotime($end_time) : '';		
			$data['long_time'] = $long_time;		
			$data['type'] = $type;		
			
			$data['remark'] = $remark;		
			$data['status'] = $status;		
			$data['add_user_id'] = $this->get_user_id();		
			$data['add_time'] = time();		
			$data['add_ip'] = get_client_ip(0, true);		
			
			$chech_has_add = $ChooseActivity->addOne($data);
			if (false === $chech_has_add) {
				$this->error("添加失败，请稍后重试！");
			} else {
				$this->success("恭喜你，添加成功！", '');
			}			
		} else {
			//项目ID
			$project_id = I('project_id', 0, 'intval');
			$this->assign('project_id', $project_id);
		
			//获取项目列表
			$project_where = array();
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
			$batch_list = D('Batch')->getList(array(), '*');
			$this->assign('batch_list', $batch_list);
			
			if (!empty($batch_list)) {
				foreach ($batch_list as $batch_list_key => $batch_list_value) {
					$project_batch_list[$batch_list_value['proj_id']][] = array(
						'n' => urlencode($batch_list_value['name']),
						'v' => $batch_list_value['id'],
					);
				}
			} else {
				$project_batch_list = array();
			}
			
			$project_new_list = array();
			if (!empty($project_old_list)) {
				foreach ($project_old_list as $project_old_list_key => $project_old_list_value) {
					$project_new_list[] = array(
						'n' => urlencode($project_old_list_value['company_name'].'--'.$project_old_list_value['name']),
						'v' => $project_old_list_value['id'],
						's' => isset($project_batch_list[$project_old_list_value['id']]) 
							? $project_batch_list[$project_old_list_value['id']] : ''
 					);
				}
			}
			
			$project_json = urldecode(json_encode($project_new_list));
			$this->assign('project_json', $project_json);

			$this->set_seo_title('添加活动信息');
			$this->display();
		}
	}
	
	/**
	 * 编辑
	 *
	 * @create 2016-12-19
	 * @author zlw
	 */
	public function edit()
	{
		if (IS_AJAX) {			
			$id = I('id', 0, 'intval');
			
			$name = I('name', '', 'trim');
			$description = I('description', '', 'trim');
			$project_id = I('project_id', 0, 'intval');
			$batch_id = I('batch_id', 0, 'intval');
			$sort = I('sort', '', 'trim');
			$person_count = I('person_count', 0, 'intval');
			$start_time = I('start_time', '', 'trim');
			$end_time = I('end_time', '', 'trim');
			$long_time = I('long_time', 0, 'intval');
			$type = I('type', '', 'trim');
			$remark = I('remark', '', 'trim');
			$status = I('status', '', 'trim');
			
			if ($project_id == 0
				|| $batch_id == 0
				|| empty($name)
				|| $start_time == 0
			) {
				$this->error("信息不能为空，请确认后重试！");
			}
			
			$ChooseActivity = D('ChooseActivity');
	
			$where['id'] = $id;
			
			$data['name'] = $name;		
			$data['description'] = $description;		
			$data['project_id'] = $project_id;		
			$data['batch_id'] = $batch_id;
			$data['sort'] = $sort;		
			$data['person_count'] = $person_count;		
			$data['start_time'] = strtotime($start_time);		
			$data['end_time'] = !empty($end_time) ? strtotime($end_time) : '';		
			$data['long_time'] = $long_time;		
			$data['type'] = $type;		
			$data['remark'] = $remark;		
			$data['status'] = $status;		
			
			$chech_has_edit = $ChooseActivity->editOne($where, $data);
			if (false === $chech_has_edit) {
				$this->error("更改失败，请稍后重试！");
			} else {
				$this->success("恭喜你，更改成功！", '');
			}			
		} else {
			$id = I('id', 0, 'intval');
			if ($id == 0) {
				$this->error("活动信息不存在，请确认后重试！");
			}
			$this->assign('id', $id);
			
			//奖励信息
			$ChooseActivity = D('ChooseActivity');
			
			$choose_activity = $ChooseActivity->getOneById($id);
			if (empty($choose_activity)) {
				$this->error("活动信息不存在，请确认后重试！");
			}
			
			$this->assign('choose_activity', $choose_activity);
		
			//获取项目列表
			$project_where = array();
			$project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id ASC, id ASC', '500');
			if (!empty($project_old_list)) {
				foreach ($project_old_list as $project_list_key => $project_list_value) {
					$project_list[$project_list_value['id']] = $project_list_value;
				}
			} else {
				$project_list = array();
			}
			$this->assign('project_list', $project_list);
			
			//批次
			$batch_list = D('Batch')->getList(array(), '*');
			$this->assign('batch_list', $batch_list);
			
			if (!empty($batch_list)) {
				foreach ($batch_list as $batch_list_key => $batch_list_value) {
					$project_batch_list[$batch_list_value['proj_id']][] = array(
						'n' => urlencode($batch_list_value['name']),
						'v' => $batch_list_value['id'],
					);
				}
			} else {
				$project_batch_list = array();
			}
			
			$project_new_list = array();
			if (!empty($project_old_list)) {
				foreach ($project_old_list as $project_old_list_key => $project_old_list_value) {
					$project_new_list[] = array(
						'n' => urlencode($project_old_list_value['company_name'].'--'.$project_old_list_value['name']),
						'v' => $project_old_list_value['id'],
						's' => isset($project_batch_list[$project_old_list_value['id']]) 
							? $project_batch_list[$project_old_list_value['id']] : ''
 					);
				}
			}
			
			$project_json = urldecode(json_encode($project_new_list));
			$this->assign('project_json', $project_json);
			
			//当前批次
			$batch_id = $choose_activity['batch_id'];
			$batch_where['id'] = $batch_id;
			$batch = D('Batch')->getOne($batch_where, '*');
			$this->assign('batch', $batch);

			$this->set_seo_title('编辑用户信息');
			$this->display();
		}
	}
	
	/**
	 * 删除
	 *
	 * @create 2016-12-19
	 * @author zlw
	 */
    public function delete()
	{
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$id = I('post.id', 0, 'intval');
		if ($id == 0) {
			$this->error("ID错误，请确认后重试！");
		}
		
		$ChooseActivity = D('ChooseActivity');
		
		$choose_activity = $ChooseActivity->getOneById($id);
		if (empty($choose_activity)) {
			$this->success("删除成功！");
		}
		
		$check_has_delete = $ChooseActivity->deleteOneById($id);
		if (false === $check_has_delete) {
			$this->error("删除失败，请确认后重试！");
		}
		
		$this->success("删除成功！");
	}
	
}
