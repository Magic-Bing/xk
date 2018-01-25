<?php

namespace Admin\Controller;


/**
 * 代金券活动管理
 *
 * @create 2016-11-25
 * @author zlw
 */
class VoucherActivityController extends BaseController 
{	
	
	/**
	 * 活动
	 *
	 * @create 2016-11-25
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
		
		$VoucheractivityView = D('Common/VoucheractivityView');
		
		//条件
		$voucher_activity_where = array();
		if (!empty($search_project_id)) {
			$voucher_activity_where['project_id'] = $search_project_id;
		}
		
		//总数
		$voucher_activity_count = $VoucheractivityView->where($voucher_activity_where)->count();
	
		//分页
		$Page 		= $this->page($voucher_activity_count, 20);
		$page_show  = $Page->show();	
		
		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
	
		$voucher_activity_list = $VoucheractivityView->getList(
			$voucher_activity_where, 
			'*', 
			'end_time DESC, id DESC', 
			$limit
		);

		$this->assign('page_show', $page_show); 
		$this->assign('voucher_activity_list', $voucher_activity_list);
		
		$this->set_seo_title("代金券活动设置");
        $this->display();
	}	
	
	
	/**
	 * 添加
	 *
	 * @create 2016-11-25
	 * @author zlw
	 */
	public function add()
	{
		if (IS_AJAX) {
			$name = I('name', 0, 'trim');
                        $cyfs = I('cyfs', 0, 'trim');
			$description = I('description', '', 'trim');
			$project_id = I('project_id', 0, 'intval');
			$batch_id = I('batch_id', 0, 'intval');
			$start_time = I('start_time', '', 'trim');
			$end_time = I('end_time', '', 'trim');
			$status = I('status', '', 'trim');
			$remark = I('remark', '', 'trim');
			
			$attrs = I('attrs', '', 'trim');
			
			if ($project_id == 0
				|| empty($name)
				|| empty($start_time)
				|| empty($end_time)
			) {
				$this->error("信息不能为空，请确认后重试！");
			}
			
			$VoucherActivity = D('VoucherActivity');
			$Voucher = D("Voucher");
			
			$data['name'] = $name;
                        $data['cyfs'] = $cyfs;	
			$data['description'] = $description;		
			$data['project_id'] = $project_id;		
			$data['batch_id'] = $batch_id;		
			$data['start_time'] = strtotime($start_time);
			$data['end_time'] = strtotime($end_time);
			$data['attr_count'] = count($attrs);
			$data['status'] = $status;		
			$data['remark'] = $remark;		
			$data['add_user_id'] = $this->get_user_id();		
			$data['add_time'] = time();		
			$data['add_ip'] = get_client_ip(0, true);		
			
                        //同一类活动同一时间段只能有一个激活
                        if ($status=="1")
                        {
                            $VoucherActivity_where['project_id']=$project_id;
                            $VoucherActivity_where['batch_id']=$batch_id;
                            $VoucherActivity_where['cyfs']=$cyfs;
                            $VoucherActivity_where['status']=1;
                            $VoucherActivity_where[]="331=331";
                            $VoucherActivity_where[]="(start_time >=". strtotime($start_time) ." and start_time <=". strtotime($end_time) ." )  or (end_time >=". strtotime($start_time) ." and end_time <=". strtotime($end_time) ." )  or (start_time <=". strtotime($start_time) ." and end_time >=". strtotime($end_time) ." )";
                            $is_voucherhave=$VoucherActivity->getOne($VoucherActivity_where);
                            if (!empty($is_voucherhave))
                            {
                                $this->error("同一时间段只能有一个激活的同类型活动！");
                            }
                        }
                        
			$chech_has_add = $VoucherActivity->addOne($data);
			if (false === $chech_has_add) {
                            $this->error("添加失败，请稍后重试！");
			}
                        
			//清除不符合条件的代金券
			$attrs = $Voucher->unsetVoucherByProjectId($attrs);
			
			//添加选择代金券
			$add_user_id = $this->get_user_id();		
			D("VoucherActivityAttr")->addVouchers($chech_has_add, $attrs, $add_user_id);
			
			//更改代金券开启次数
			$Voucher->updateQuantityByProjectId($project_id);

			$this->success("恭喜你，添加成功！", '');
		} else {
			//项目ID
			$project_id = I('project_id', 0, 'intval');
			$this->assign('project_id', $project_id);
		
			//获取项目列表
			$project_where = array();
                        $project_where['status']=1;
			$project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id ASC, id ASC', '50');
			if (!empty($project_old_list)) {
				foreach ($project_old_list as $project_list_key => $project_list_value) {
					$project_list[$project_list_value['id']] = $project_list_value;
				}
			} else {
				$project_list = array();
			}
			$this->assign('project_list', $project_list);
			
			//当前项目代金券
			$project_voucher_where = array();
			if (!empty($project_id)) {
				$project_voucher_where['project_id'] = $project_id;
			} else {
				$project_voucher_where['project_id'] = '-999';
			}
			$project_voucher = D('Common/VoucherView')->getList($project_voucher_where, '*', 'type DESC, id DESC');
			$this->assign('project_voucher', $project_voucher);
			
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
			
			$this->set_seo_title('添加代金券活动');
			$this->display();
		}
	}
	
	/**
	 * 代金券修改
	 *
	 * @create 2016-11-25
	 * @author zlw
	 */
	public function edit()
	{
		if (IS_AJAX) {			
			$id = I('id', 0, 'intval');
			
			$name = I('name', 0, 'trim');
                        $cyfs = I('cyfs', 0, 'trim');
			$description = I('description', '', 'trim');
			$project_id = I('project_id', 0, 'intval');
			$batch_id = I('batch_id', 0, 'intval');
			$start_time = I('start_time', '', 'trim');
			$end_time = I('end_time', '', 'trim');
			$status = I('status', '', 'trim');
			$remark = I('remark', '', 'trim');
			
			$attrs = I('attrs', '', 'trim');
			
			if ($project_id == 0
				|| empty($name)
				|| empty($start_time)
				|| empty($end_time)
			) {
				$this->error("信息不能为空，请确认后重试！");
			}
			
			$VoucherActivity = D('VoucherActivity');
			$Voucher = D("Voucher");
	
			$where['id'] = $id;
			
			$data['name'] = $name;	
                        $data['cyfs'] = $cyfs;
			$data['description'] = $description;		
			$data['project_id'] = $project_id;		
			$data['batch_id'] = $batch_id;		
			$data['start_time'] = strtotime($start_time);
			$data['end_time'] = strtotime($end_time);
			$data['attr_count'] = count($attrs);
			$data['status'] = $status;		
			$data['remark'] = $remark;		
			
                        //同一类活动同一时间段只能有一个激活
                        if ($status=="1")
                        {
                            $VoucherActivity_where['project_id']=$project_id;
                            $VoucherActivity_where['batch_id']=$batch_id;
                            $VoucherActivity_where['cyfs']=$cyfs;
                            $VoucherActivity_where[]="id<>".$id;
                            $VoucherActivity_where['status']=1;
                            $VoucherActivity_where[]="332=332";
                            $VoucherActivity_where[]="(start_time >=". strtotime($start_time) ." and start_time <=". strtotime($end_time) ." )  or (end_time >=". strtotime($start_time) ." and end_time <=". strtotime($end_time) ." )  or (start_time <=". strtotime($start_time) ." and end_time >=". strtotime($end_time) ." )";
                            $is_voucherhave=$VoucherActivity->getOne($VoucherActivity_where);
                            if (!empty($is_voucherhave))
                            {
                                $this->error("同一时间段只能有一个激活的同类型活动！");
                            }
                        }
                        
			//当前活动信息
			$voucher_activity = $VoucherActivity->getOneById($id);
			
			$chech_has_edit = $VoucherActivity->editOne($where, $data);
			if (false === $chech_has_edit) {
				$this->error("更改失败，请稍后重试！");
			} 
			
			//清除不符合条件的代金券
			$attrs = $Voucher->unsetVoucherByProjectId($attrs);
			
			//添加选择代金券
			$add_user_id = $this->get_user_id();		
			D("VoucherActivityAttr")->addVouchers($id, $attrs, $add_user_id);
			
			//更改代金券开启次数
			$Voucher->updateQuantityByProjectId($project_id);
			$Voucher->updateQuantityByProjectId($voucher_activity['project_id']);
			
			$this->success("恭喜你，更改成功！", '');
		} else {
			$id = I('id', 0, 'intval');
			if ($id == 0) {
				$this->error("代金券不存在，请确认后重试！");
			}
			
			//活动信息
			$VoucherActivity = D('VoucherActivity');
			
			$voucher_activity = $VoucherActivity->getOneById($id);
			if (empty($voucher_activity)) {
				$this->error("代金券不存在，请确认后重试！");
			}
			$this->assign('voucher_activity', $voucher_activity);
			
			//活动所选代金券
			$attr_where['activity_id'] = $id;
			$attrs = D('VoucherActivityAttr')->getList($attr_where);
			
			$activity_vouchers = array();
			foreach ($attrs as $attr) {
				$activity_vouchers[$attr['voucher_id']] = $attr;
			}
			$this->assign('activity_vouchers', $activity_vouchers);
			
			//获取项目ID
			$project_id = I('project_id', 0, 'intval');
			if (empty($project_id)) {
				$project_id = $voucher_activity['project_id'];
			}
			
			//当前项目
			$this->assign('project_id', $project_id);
		
			//获取项目列表
			$project_where = array();
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
			
			//当前项目代金券
			$project_voucher_where = array();
			if (!empty($project_id)) {
				$project_voucher_where['project_id'] = $project_id;
			}
			$project_voucher = D('Common/VoucherView')->getList($project_voucher_where, '*', 'type DESC, id DESC');
			$this->assign('project_voucher', $project_voucher);
			
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
			$batch_id = $voucher_activity['batch_id'];
			$batch_where['id'] = $batch_id;
			$batch = D('Batch')->getOne($batch_where, '*');
			$this->assign('batch', $batch);

			$this->set_seo_title('编辑代金券活动');
			$this->display();
		}
	}
	
	/**
	 * 删除
	 *
	 * @create 2016-11-25
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
		
		$VoucherActivity = D('VoucherActivity');
		
		$voucher_activity = $VoucherActivity->getOneById($id);
		if (empty($voucher_activity)) {
			$this->success("删除成功！");
		}
		
		$check_has_delete = $VoucherActivity->deleteOneById($id);
		if (false === $check_has_delete) {
			$this->error("删除失败，请确认后重试！");
		}
		
		//删除所选代金券
		D('VoucherActivityAttr')->deleteOne(array('activity_id' => $id));
		
		$this->success("删除成功！");
	}
	
	/**
	 * 异步获取代金券
	 *
	 * @create 2016-11-30
	 * @author zlw
	 */
	public function get_vouchers()
	{
		if (!IS_AJAX) {
			$this->error("访问错误，请确认后重试！");
		}
		
		//活动ID
		$activity_id = I('activity_id', '', 'intval');
		
		//活动所选代金券
		$attr_where['activity_id'] = $activity_id;
		$attrs = D('VoucherActivityAttr')->getList($attr_where);
		
		$activity_vouchers = array();
		foreach ($attrs as $attr) {
			$activity_vouchers[$attr['voucher_id']] = $attr;
		}
		$this->assign('activity_vouchers', $activity_vouchers);
		
		//获取项目ID
		$project_id = I('project_id', 0, 'intval');
		
		//当前项目
		$this->assign('project_id', $project_id);
		
		//当前项目代金券
		$project_voucher_where = array();
		if ($project_id != 0) {
			$project_voucher_where['project_id'] = $project_id;
		} else {
			$project_voucher_where['project_id'] = '-999';
		}
		$project_voucher = D('Common/VoucherView')->getList($project_voucher_where, '*', 'type DESC, id DESC');
		$this->assign('project_voucher', $project_voucher);

		//页面
		$vouchers = $this->fetch('vouchers');
		
		//活动所选代金券个数
		$attr_view_where['activity_id'] = $activity_id;
		$attr_view_where['activity_project_id'] = $project_id;
		$count = D('VoucheractivityattrView')->where($attr_view_where)->count();
		
		$data = array(
			'count' => $count,
			'vouchers' => $vouchers
		);
		
		$this->success($data);
	}
	
}
