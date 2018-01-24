<?php

namespace Admin\Controller;

use Think\Upload;


/**
 * 项目管理
 *
 * @create 2016-11-17
 * @author zlw
 */
class ProjectController extends BaseController 
{	
	
	/**
	 * 首页
	 *
	 * @create 2016-11-17
	 * @author zlw
	 */
    public function index()
	{
		exit('访问错误');
	}
	
	/**
	 * 设置证书
	 *
	 * @create 2016-11-17
	 * @author zlw
	 */
    public function setkey()
	{
		if (IS_POST) {
			$id = I('id', 0, 'intval');
			if ($id == 0) {
				$this->error('ID不能为空，请确认后重试！');
			}
			
			//项目句柄
			$Project = D("Project");
			
			$project = $Project->getOneById($id);
			if (empty($project)) {
				$this->error('项目不存在，请确认后重试！');
			}
			
			//证书地址
			$key_path = C("WX.CREDENTIALS_PATH");
			
			$upload = new Upload();// 实例化上传类
			$upload->maxSize   = 3145728 ;// 设置附件上传大小
			$upload->exts      = array('pem');// 设置附件上传类
			$upload->rootPath  = '.'.$key_path.'/'; // 保存根路径
			$upload->autoSub   = false; 
			
			$upload->savePath  = '/'.md5('project-'.$id).'/'; // 设置附件上传目录
			
			//当前项目证书位置
			$key_file_path = '.'.$key_path.'/'.md5('project-'.$id).'/';
			
			//删除原有证书文件及目录
			//delete_dir_and_file($key_file_path, true);

			//上传证书
			$public_key_info = $upload->uploadOne($_FILES['public_key']);
			$private_key_info = $upload->uploadOne($_FILES['private_key']);
			$rootca_info = $upload->uploadOne($_FILES['rootca']);
			
			if (!$public_key_info 
				&& !$private_key_info 
				&& !$rootca_info 
			) {
				$this->error($upload->getError());
			}
			
			$upload_data['public_key'] = $public_key_info['savepath'].$public_key_info['savename'];
			$upload_data['private_key'] = $private_key_info['savepath'].$private_key_info['savename'];
			$upload_data['rootca'] = $rootca_info['savepath'].$rootca_info['savename'];
			
			$where['id'] = $id;
			$data = array();
			if ($public_key_info) {
				$data['public_key'] = $upload_data['public_key'];
				
				$old_public_key = '.'.$key_path . $project['public_key'];
				if (file_exists($old_public_key)) {
					unlink($old_public_key);
				}
			}
			if ($private_key_info) {
				$data['private_key'] = $upload_data['private_key'];
				
				$old_private_key = '.'.$key_path . $project['private_key'];
				if (file_exists($old_private_key)) {
					unlink($old_private_key);
				}
			}
			if ($rootca_info) {
				$data['rootca'] = $upload_data['rootca'];
				
				$old_rootca = '.'.$key_path . $project['rootca'];
				if (file_exists($old_rootca)) {
					unlink($old_rootca);
				}
			}
			
			$check_has_edit = $Project->editOne($where, $data);
			if ($check_has_edit === false) {
				$this->error('更改错误，请重试！');
			}
			
			$this->success('更改成功！');
		} else {
			$id = I('id', 0, 'intval');
			if ($id == 0) {
				$this->error('请求错误，请确认后重试！');
			}
			$this->assign('id', $id); 
			
			$project = D('ProjectView')->getOneById($id);
			if (empty($project)) {
				$this->error('项目不存在，请确认后重试！');
			}
			
			//证书位置
			$key_path = C("WX.CREDENTIALS_PATH");
			$this->assign('key_path', '.'.$key_path); 
			
			$this->assign('project', $project); 
			$this->display();			
		}
	}
	
	/**
	 * 设置图片 - 包括微信头像和原始海报
	 *
	 * @create 2016-11-17
	 * @author zlw
	 */
    public function setpic()
	{
		if (IS_POST) {
			$id = I('id', 0, 'intval');
			if ($id == 0) {
				$this->error('ID不能为空，请确认后重试！');
			}
			
			//项目句柄
			$Project = D("Project");
			
			$project = $Project->getOneById($id);
			if (empty($project)) {
				$this->error('项目不存在，请确认后重试！');
			}
			
			//公众号头像地址
			$wxoa_path = C("WX.WXOA_PATH");
			
			//原始海报地址
			$post_path = C("WX.POST_PATH");
			
			$upload = new Upload();// 实例化上传类
			$upload->maxSize   = 3145728 ;// 设置附件上传大小
			$upload->exts      = array('png', 'jpeg', 'jpg');// 设置附件上传类
			$upload->autoSub   = true; 
			$upload->savePath  = '/'; // 设置附件上传目录
			
			// 上传公众号头像
			$upload->rootPath  = '.'.$wxoa_path.'/'; 
			$wx_avatar_info = $upload->uploadOne($_FILES['wx_avatar']);
			
			// 上传原始海报
			$upload->rootPath  = '.'.$post_path.'/'; 
			$poster_info = $upload->uploadOne($_FILES['poster']);
			
			if (!$wx_avatar_info 
				&& !$poster_info 
			) {
				if (!$wx_avatar_info) {
					$this->error($upload->getError());
				}
			}
			
			$upload_data['wx_avatar'] = $wx_avatar_info['savepath'].$wx_avatar_info['savename'];
			$upload_data['poster'] = $poster_info['savepath'].$poster_info['savename'];
			
			$where['id'] = $id;
			$data = array();
			if ($wx_avatar_info) {
				$data['wx_avatar'] = $upload_data['wx_avatar'];
				
				$old_wx_avatar = '.'.$wxoa_path . $project['wx_avatar'];
				if (file_exists($old_wx_avatar)) {
					unlink($old_wx_avatar);
				}
			}
			if ($poster_info) {
				$data['poster_path'] = $upload_data['poster'];
				
				$old_poster = '.'.$post_path . $project['poster_path'];
				if (file_exists($old_poster)) {
					unlink($old_poster);
				}
			}
			
			$check_has_edit = $Project->editOne($where, $data);
			if ($check_has_edit === false) {
				$this->error('更改错误，请重试！');
			}

			$this->success('更改成功！');
		} else {
			$id = I('id', 0, 'intval');
			if ($id == 0) {
				$this->error('请求错误，请确认后重试！');
			}
			$this->assign('id', $id); 
			
			$project = D('ProjectView')->getOneById($id);
			if (empty($project)) {
				$this->error('项目不存在，请确认后重试！');
			}
			$this->assign('project', $project); 
			
			//公众号头像地址
			$wxoa_path = C("WX.WXOA_PATH");
			$this->assign('wxoa_path', '.'.$wxoa_path); 
			
			//原始海报地址
			$post_path = C("WX.POST_PATH");
			$this->assign('post_path', '.'.$post_path);
			
			//公众号头像
			$wxoa_file = '.'.$wxoa_path.$project['wx_avatar'];
			$this->assign('wxoa_file', $wxoa_file);
			
			//原始海报
			$poster_file = '.'.$post_path.$project['poster_path'];
			$this->assign('poster_file', $poster_file);
			
			//公众号头像URI
			$wxoa_file_uri = $wxoa_path.$project['wx_avatar'];
			$this->assign('wxoa_file_uri', $wxoa_file_uri);
			
			//原始海报URI
			$poster_file_uri = $post_path.$project['poster_path'];
			$this->assign('poster_file_uri', $poster_file_uri);
			
			$this->display();			
		}
	}
	
	
}
