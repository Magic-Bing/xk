<?php

namespace Admin\Controller;


/**
 * 代金券提醒
 *
 * @create 2016-12-13
 * @author zlw
 */
class VoucherTipController extends BaseController 
{	
	
	/**
	 * 首页
	 *
	 * @create 2016-12-13
	 * @author zlw
	 */
    public function index()
	{
		//项目ID
		$search_project_id = I('get.project_id', '', 'intval');
		$search_id = I('get.search_id', '', 'trim');
		$search_customer = I('get.search_customer', '', 'trim');
		$search_add_time = I('get.search_add_time', '', 'trim');
		
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
			'search_customer' => $search_customer,
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
		
		$VouchertipView = D('VouchertipView');
		
		//条件
		$voucher_tip_where = array();
		if (!empty($search_project_id)) {
			$voucher_tip_where['project_id'] = $search_project_id;
		}
		if (!empty($search_id)) {
			$voucher_tip_where['id'] = array('like', '%'.$search_id.'%');
		}
		if (!empty($search_customer)) {
			$voucher_tip_where['customer_name'] = array('like', '%'.$search_customer.'%');
		}
		if (!empty($search_add_time)) {
			$voucher_tip_where['add_time'] = array('elt', $search_add_time);
		}
		
		//总数
		$voucher_tip_count = $VouchertipView->where($voucher_tip_where)->count();
	
		//分页
		$Page 		= $this->page($voucher_tip_count, 15);
		$page_show  = $Page->show();	
		
		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
	
		$voucher_tip_list = $VouchertipView->getList(
			$voucher_tip_where, 
			'*', 
			'add_time DESC, id DESC', 
			$limit
		);

		$this->assign('page_show', $page_show); 
		$this->assign('voucher_tip_list', $voucher_tip_list);
		
		$this->set_seo_title("代金券提醒");
        $this->display();
	}	
	
	/**
	 * 删除
	 *
	 * @create 2016-11-30
	 * @author zlw
	 */
    public function delete()
	{
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$id = I('post.id', 0, 'intval');
		if ($id == 0) {
			$this->error("代金券日志不存在，请确认后重试！");
		}
		
		$VoucherTip = D('VoucherTip');
		
		$voucher_log = $VoucherTip->getOneById($id);
		if (empty($voucher_log)) {
			$this->success("删除成功！");
		}
		
		$check_has_delete = $VoucherTip->deleteOneById($id);
		if (false === $check_has_delete) {
			$this->error("删除失败，请确认后重试！");
		}
		
		$this->success("删除成功！");
	}
	
	/**
	 * 提醒
	 *
	 * @create 2016-12-13
	 * @author zlw
	 */
    public function tip()
	{
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$id = I('post.id', 0, 'intval');
		if ($id == 0) {
			$this->error("提醒不存在，请确认后重试！");
		}
		
		$VoucherTip = D('VoucherTip');
		
		$voucher_log = $VoucherTip->getOneById($id);
		if (empty($voucher_log)) {
			$this->success("操作成功！");
		}
		
		$data['is_tip'] = '1';
		$check_has_edit = $VoucherTip->editOneById($id, $data);
		if (false === $check_has_edit) {
			$this->error("操作失败，请确认后重试！");
		}
		
		$this->success("操作成功！");
	}
	
	/**
	 * 更改为未提醒
	 *
	 * @create 2016-12-13
	 * @author zlw
	 */
    public function retip()
	{
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$id = I('post.id', 0, 'intval');
		if ($id == 0) {
			$this->error("提醒不存在，请确认后重试！");
		}
		
		$VoucherTip = D('VoucherTip');
		
		$voucher_log = $VoucherTip->getOneById($id);
		if (empty($voucher_log)) {
			$this->success("操作成功！");
		}
		
		$data['is_tip'] = '0';
		$check_has_edit = $VoucherTip->editOneById($id, $data);
		if (false === $check_has_edit) {
			$this->error("操作失败，请确认后重试！");
		}
		
		$this->success("操作成功！");
	}
	
}
