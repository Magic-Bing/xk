<?php

namespace Admin\Controller;

use Think\Upload as Upload;
use Lookey\Web\Excel as Excel;


/**
 * 竞价选房
 *
 * @create 2016-12-19
 * @author zlw
 */
class ChooseController extends BaseController 
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
		
		$ChooseView = D('Common/ChooseView');
		
		//条件
		$choose_where = array();
		if (!empty($search_project_id)) {
			$choose_where['project_id'] = $search_project_id;
		}
		
		//总数
		$choose_count = $ChooseView->where($choose_where)->count();
	
		//分页
		$Page 		= $this->page($choose_count, 20);
		$page_show  = $Page->show();	
		
		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
	
		$choose_list = $ChooseView->getList(
			$choose_where, 
			'*', 
			'id DESC', 
			$limit
		);

		$this->assign('page_show', $page_show); 
		$this->assign('choose_list', $choose_list);
		
		$this->set_seo_title("客户信息");
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
			$name = I('name', 0, 'trim');
			$project_id = I('project_id', 0, 'intval');
			$batch_id = I('batch_id', 0, 'intval');
			$customer_name = I('customer_name', '', 'trim');
			$customer_phone = I('customer_phone', '', 'trim');
			$row_number = I('row_number', 0, 'intval');
			$money = I('money', 0, 'trim');
			$area = I('area', 0, 'trim');
			$price = I('price', 0, 'trim');
			$house_type = I('house_type', '', 'trim');
			$floor = I('floor', '', 'trim');
			$room = I('room', '', 'trim');
			$password = I('password', '', 'trim');
			$remark = I('remark', '', 'trim');
			$status = I('status', '', 'trim');
			
			if ($project_id == 0
				|| empty($customer_name)
				|| empty($customer_phone)
				|| empty($money)
			) {
				$this->error("信息不能为空，请确认后重试！");
			}
			
			if (!is_phone_number($customer_phone)) {
				$this->error("客户手机号码错误，请确认后重试！");
			}
			
			$Choose = D('Choose');
			
			$data['name'] = $name;		
			$data['project_id'] = $project_id;		
			$data['batch_id'] = $batch_id;
			
			$data['customer_name'] = $customer_name;		
			$data['customer_phone'] = $customer_phone;		
			$data['row_number'] = $row_number;		
			$data['money'] = $money;		
			$data['area'] = $area;		
			$data['price'] = $price;		
			$data['house_type'] = $house_type;		
			$data['floor'] = $floor;		
			$data['room'] = $room;		
			$data['password'] = $password;		
			
			$data['remark'] = $remark;		
			$data['status'] = $status;		
			$data['add_time'] = time();		
			$data['add_ip'] = get_client_ip(0, true);		
			
			$chech_has_add = $Choose->addOne($data);
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

			$this->set_seo_title('添加客户信息');
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
			
			$project_id = I('project_id', 0, 'intval');
			$batch_id = I('batch_id', 0, 'intval');
			$customer_name = I('customer_name', '', 'trim');
			$customer_phone = I('customer_phone', '', 'trim');
			$row_number = I('row_number', 0, 'intval');
			$money = I('money', 0, 'trim');
			$area = I('area', 0, 'trim');
			$price = I('price', 0, 'trim');
			$house_type = I('house_type', '', 'trim');
			$floor = I('floor', '', 'trim');
			$room = I('room', '', 'trim');
			$password = I('password', '', 'trim');
			$remark = I('remark', '', 'trim');
			$status = I('status', '', 'trim');
			
			if ($id == 0
				|| $project_id == 0
				|| empty($customer_name)
				|| empty($customer_phone)
				|| empty($money)
			) {
				$this->error("信息不能为空，请确认后重试！");
			}
			
			if (!is_phone_number($customer_phone)) {
				$this->error("客户手机号码错误，请确认后重试！");
			}
			
			$Choose = D('Choose');
	
			$where['id'] = $id;
			
			$data['name'] = $name;		
			$data['project_id'] = $project_id;		
			$data['batch_id'] = $batch_id;
			$data['customer_name'] = $customer_name;		
			$data['customer_phone'] = $customer_phone;		
			$data['row_number'] = $row_number;		
			$data['money'] = $money;		
			$data['area'] = $area;		
			$data['price'] = $price;		
			$data['house_type'] = $house_type;		
			$data['floor'] = $floor;		
			$data['room'] = $room;		
			$data['password'] = $password;		
			$data['remark'] = $remark;		
			$data['status'] = $status;		
			
			$chech_has_edit = $Choose->editOne($where, $data);
			if (false === $chech_has_edit) {
				$this->error("更改失败，请稍后重试！");
			} else {
				$this->success("恭喜你，更改成功！", '');
			}			
		} else {
			$id = I('id', 0, 'intval');
			if ($id == 0) {
				$this->error("信息不存在，请确认后重试！");
			}
			$this->assign('id', $id);
			
			//奖励信息
			$Choose = D('Choose');
			
			$choose = $Choose->getOneById($id);
			if (empty($choose)) {
				$this->error("信息不存在，请确认后重试！");
			}
			
			$this->assign('choose', $choose);
		
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
			$batch_id = $choose['batch_id'];
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
		
		$Choose = D('Choose');
		
		$choose = $Choose->getOneById($id);
		if (empty($choose)) {
			$this->success("删除成功！");
		}
		
		$check_has_delete = $Choose->deleteOneById($id);
		if (false === $check_has_delete) {
			$this->error("删除失败，请确认后重试！");
		}
		
		$this->success("删除成功！");
	}

	/**=============== 导入与导出 ==================**/
	
	/**
	 * 导入数据
	 *
	 * @create 2016-12-20
	 * @author zlw
	 */
	public function import()
    {
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$upload = new Upload();// 实例化上传类
		$upload->maxSize   = 3145728 ;// 设置附件上传大小
        $upload->exts      = array('xls','xlsx','txt');// 设置附件上传类
		$upload->autoSub   = false; 
		$upload->rootPath  = './Uploads/'; 
		$upload->savePath  = '/choose/'; // 设置附件上传目录
		$upload->saveName  = date('YmdHis');
        
		$info = $upload->uploadOne($_FILES['excel']);
		if (!$info) {
			$this->error($upload->getError());
		}
		
        $filename = './Uploads'.$info['savepath'].$info['savename'];      
		$ext = $info['ext'];
        
		$excels = D('Excel', 'Logic')->import($filename, $ext);
		
		if (empty($excels)) {
			$this->error('数据为空，请确认后重试！');
		}
		
		//定义默认数据
		$project_id = 0;
		$project_name = '';
		$batch_id = 0;
		
		$data = array();
		foreach ($excels as $key => $excel) {
			if ($key == 1) {
				$project_id = $excel['B'];
				$project_name = $excel['D'];
				$batch_id = $excel['F'];
			} elseif ($key >= 3) {
				$data[] = array(
					'project_id' => $project_id,
					'batch_id' => $batch_id,
					'customer_name' => $excel['A'],
					'customer_phone' => $excel['B'],
					'money' => $excel['C'],
					'row_number' => $excel['D'],
					'area' => $excel['E'],
					'price' => $excel['F'],
					'house_type' => $excel['G'],
					'floor' => $excel['H'],
					'room' => $excel['I'],
					'remark' => '', //备注
					'add_time' => time(),
					'add_ip' => get_client_ip(0, true),
				);
			}
		}
		
		$check_has_add = D('Choose')->addAll($data);
		if (false === $check_has_add) {
			$this->error("导入失败，请稍后重试！");
		} else {
			$this->success("恭喜你，导入成功！");
		}			
	}

	/**
	 * 导出数据
	 *
	 * @create 2016-12-19
	 * @author zlw
	 */
	public function export()
    {
		$project_id = I("project_id", '', 'intval');
		if (empty($project_id) || $project_id == 0) {
			$this->error('项目ID不存在，请重试！');
		}
		
		//获取项目信息
		$project = D('Common/Project')->getOneById($project_id);
		if (empty($project)) {
			$this->error('项目不存在，请重试！');
		}
		
		//批次ID
		$batch_id = I("batch_id", '', 'intval');
		if (empty($batch_id) || $batch_id == 0) {
			$this->error('项目批次ID错误，请重试！');
		}
		
		//当前批次
		$batch_where['id'] = $batch_id;
		$batch = D('Batch')->getOne($batch_where, '*');
		if (empty($batch)) {
			$this->error('项目批次不存在，请重试！');
		}

		$headArr = array(
			'title' => array(
				array('项目标识', '_bg' => true, '_bold' => true),
				$project_id,
				array('项目名称', '_bg' => true, '_bold' => true),
				$project['name'],
				array('批次', '_bg' => true, '_bold' => true),
				$batch_id,
			),
			'head'  => array(
				array('客户名称', '_bg' => true, '_bold' => true),
				array('手机号码', '_bg' => true, '_bold' => true),
				array('诚意金金额', '_bg' => true, '_bold' => true),
				array('排号顺序', '_bg' => true, '_bold' => true),
				
				'意向面积',
				'意向金额',
				'意向户型',
				'意向楼层',
				'意向房间',
			),
		);
		
        $filename = $project['name'].'-'.$batch['name'];

        D('Excel', 'Logic')->export($filename, $headArr);
    }
	
}
