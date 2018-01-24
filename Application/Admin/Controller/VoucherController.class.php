<?php

namespace Admin\Controller;


/**
 * 代金券管理
 *
 * @create 2016-11-24
 * @author zlw
 */
class VoucherController extends BaseController 
{	
	
	/**
	 * 代金券
	 *
	 * @create 2016-11-24
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
		
		$VoucherView = D('Common/VoucherView');
		
		//条件
		$voucher_where = array();
		if (!empty($search_project_id)) {
			$voucher_where['project_id'] = $search_project_id;
		}
		
		//总数
		$voucher_count = $VoucherView->where($voucher_where)->count();
	
		//分页
		$Page 		= $this->page($voucher_count, 20);
		$page_show  = $Page->show();	
		
		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
	
		$voucher_list = $VoucherView->getList(
			$voucher_where, 
			'*', 
			'end_time DESC, id DESC', 
			$limit
		);

		$this->assign('page_show', $page_show); 
		$this->assign('voucher_list', $voucher_list);
		
		$this->set_seo_title("代金券设置");
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
			$project_id = I('project_id', 0, 'intval');
			$batch_id = I('batch_id', 0, 'intval');
			$type = I('type', '', 'trim');
			$money = I('money', '', 'trim');
			$quantity = I('quantity', 0, 'intval');
			$open_quantity = I('open_quantity', 0, 'intval');
			$use_quantity = I('use_quantity', 0, 'intval');
			$end_time = I('end_time', '', 'trim');
			$description = I('description', '', 'trim');
			$min_money = I('min_money', '', 'trim');
			$directional_type = I('directional_type', '', 'trim');
			$house_type = I('house_type', '', 'trim');
			$room_id = I('room_id', '', 'trim');
			$status = I('status', '', 'trim');
			$remark = I('remark', '', 'trim');
			
			if ($project_id == 0
				|| empty($name)
				|| empty($type)
				|| empty($money)
				|| empty($quantity)
				|| empty($end_time)
			) {
				$this->error("信息不能为空，请确认后重试！");
			}
			
			$Voucher = D('Voucher');
			
			$data['name'] = $name;		
			$data['project_id'] = $project_id;		
			$data['batch_id'] = $batch_id;		
			$data['type'] = $type;		
			$data['money'] = $money;		
			$data['quantity'] = $quantity;		
			$data['open_quantity'] = $open_quantity;		
			$data['use_quantity'] = $use_quantity;		
			$data['end_time'] = strtotime($end_time);
			$data['description'] = $description;		
			$data['min_money'] = $min_money;		
			$data['directional_type'] = $directional_type;		
			$data['house_type'] = $house_type;		
			$data['room_id'] = $room_id;		
			$data['status'] = $status;		
			$data['remark'] = $remark;		
			$data['add_user_id'] = $this->get_user_id();		
			$data['add_time'] = time();		
			$data['add_ip'] = get_client_ip(0, true);		
			
			$chech_has_add = $Voucher->addOne($data);
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

			$this->set_seo_title('添加代金券');
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
			$project_id = I('project_id', 0, 'intval');
			$batch_id = I('batch_id', 0, 'intval');
			$type = I('type', '', 'trim');
			$money = I('money', '', 'trim');
			$quantity = I('quantity', 0, 'intval');
			$open_quantity = I('open_quantity', 0, 'intval');
			$use_quantity = I('use_quantity', 0, 'intval');
			$end_time = I('end_time', '', 'trim');
			$description = I('description', '', 'trim');
			$min_money = I('min_money', '', 'trim');
			$directional_type = I('directional_type', '', 'trim');
			$house_type = I('house_type', '', 'trim');
			$room_id = I('room_id', '', 'trim');
			$status = I('status', '', 'trim');
			$remark = I('remark', '', 'trim');
			
			if ($project_id == 0
				|| empty($name)
				|| empty($type)
				|| empty($money)
				|| empty($quantity)
				|| empty($end_time)
			) {
				$this->error("信息不能为空，请确认后重试！");
			}
			
			$Voucher = D('Voucher');
	
			$where['id'] = $id;
			
			$data['name'] = $name;		
			$data['project_id'] = $project_id;		
			$data['batch_id'] = $batch_id;		
			$data['type'] = $type;		
			$data['money'] = $money;		
			$data['quantity'] = $quantity;		
			$data['open_quantity'] = $open_quantity;		
			$data['use_quantity'] = $use_quantity;		
			$data['end_time'] = strtotime($end_time);
			$data['description'] = $description;		
			$data['min_money'] = $min_money;		
			$data['directional_type'] = $directional_type;		
			$data['house_type'] = $house_type;		
			$data['room_id'] = $room_id;		
			$data['status'] = $status;		
			$data['remark'] = $remark;		
			
			$chech_has_edit = $Voucher->editOne($where, $data);
			if (false === $chech_has_edit) {
				$this->error("更改失败，请稍后重试！");
			} else {
				$this->success("恭喜你，更改成功！", '');
			}			
		} else {
			$id = I('id', 0, 'intval');
			if ($id == 0) {
				$this->error("代金券不存在，请确认后重试！");
			}
			
			//奖励信息
			$Voucher = D('Voucher');
			
			$voucher = $Voucher->getOneById($id);
			if (empty($voucher)) {
				$this->error("代金券不存在，请确认后重试！");
			}
			
			$this->assign('voucher', $voucher);
			
			//获取房间信息
			if (!empty($voucher['room_id'])) {
				$room = D('Roomview')->getOne(array('id' => $voucher['room_id']));
				$this->assign('room', $room);
			}
		
			//获取项目列表
			$project_where = array();
                        $project_where['status']=1;
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
			$batch_id = $voucher['batch_id'];
			$batch_where['id'] = $batch_id;
			$batch = D('Batch')->getOne($batch_where, '*');
			$this->assign('batch', $batch);

			$this->set_seo_title('编辑代金券');
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
		
		$Voucher = D('Voucher');
		
		$voucher = $Voucher->getOneById($id);
		if (empty($voucher)) {
			$this->success("删除成功！");
		}
		
		$check_has_delete = $Voucher->deleteOneById($id);
		if (false === $check_has_delete) {
			$this->error("删除失败，请确认后重试！");
		}
		
		$this->success("删除成功！");
	}

	/**
	 * 搜索房间并返回信息
	 *
	 * @create 2016-12-01
	 * @author zlw
	 */
	public function search_room()
	{
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！');
		}
		
		//条件
		$room = I('room', '', 'trim');
		if (empty($room)) {
			$this->error('房间号不能为空，请确认后重试！');
		}
		$this->assign('room', $room);
		
		$project_id = I('project_id', 0, 'intval');
		if (empty($project_id)) {
			$this->error('项目ID不能为空，请确认后重试！');
		}
		$this->assign('project_id', $project_id);
		
		//当前房间
		$where['proj_id'] = $project_id;
		$where['room'] = array('like', '%' . $room . '%');;
		$where['is_xf'] = array('neq', 1);
		$rooms = D("Room")->getRoomList($where, "bld_id ASC, cast(unit as SIGNED) ASC,cast(floor as SIGNED) ASC ,cast(no as SIGNED) ASC");
		
		//获取相关信息
		if (!empty($rooms)) {
			foreach ($rooms as $key => $room) {
				//楼栋信息
				$bld_id = $room['bld_id'];
				$build = D("Build")->getBuildById($bld_id);
				
				//判断时间
				if (date('d', $room['xftime']) == date('d')) {
					$time = date('H:i', $room['xftime']);
				} elseif (!empty($room['xftime'])) {
					$time = date('Y-m-d H:i', $room['xftime']);
				} else {
					$time = '';
				}
				$data = array(
					'id' => $room['id'],
					'room_name' => $build['buildname'].'-'.$room['unit'].'-'.$room['room'],
					'room_number' => $room['floor'].$room['no'],
					'room_no' => $room['room'],
					'xftime' => $time
				);
				
				$rooms[$key] = $data;
			}
		}
		
		$this->success($rooms);
	}
	
}
