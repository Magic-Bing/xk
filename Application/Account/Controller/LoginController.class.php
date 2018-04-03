<?php

namespace Account\Controller;

use Think\Controller;


/**
 * 登录
 *
 * @create 2016-12-22
 * @author zlw
 */
class LoginController extends Controller 
{
	
	/**
	 * 判断是否已经登录
	 *
     * @create 2016-12-22
	 * @author zlw
	 */
    private function check_login() 
   {
		if (session('?ACCOUNT_ID')) {
			//$this->error('你已经登录，正在跳转到首页', U('index/index'));
                     redirect(U('index/index'),0);
		}
    }	
	
	/**
	 * 首页
	 *
     * @create 2016-12-22
	 * @author zlw
	 */
    public function index() 
	{
		//判断是否登录
		$this->check_login();
		
        $this->assign('seo_title', '云销控登录');
        $this->display();
    }	

	/**
	 * 登录
	 *
     * @create 2016-12-22
	 * @author zlw
	 */
    public function check() 
	{
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('login/index'));
		}

		//判断是否登录
		$this->check_login();

		$name = I('name', '', 'trim');
		if (empty($name)) {
			$this->error('用户名不能为空！', U('login/index'));
		}
		
		$password = I('password', '', 'trim');
		if (empty($password)) {
			$this->error('密码不能为空！', U('login/index'));
		}
		
		$where['code'] = $name;
		$user = D("User")->getOne($where);
		if (empty($user)) {
			$this->error('用户名或者密码错误！', U('login/index'));
		}
		
		if ($user['password'] != md5(md5($password))) {
			$this->error('用户名或者密码错误！', U('login/index'));
		}
		
		//添加登录信息
		session('ACCOUNT_ID', $user['id']);
                session('ACCOUNT_TYPE', $user['type']);
                session('selected_project','');
                session('selected_company','');
                session("selected_batch",'');
		$this->success('登录成功！', U('index/index'));		
    }

	/**
	 * 退出
	 *
     * @create 2016-12-22
	 * @author zlw
	 */
    public function logout() 
	{
		session('ACCOUNT_ID', null);
        session('selected_project',null);
        session('selected_company',null);
        session("selected_batch",null);
		//$this->success('退出成功！', U('login/index'));
                redirect(U('../login/index'),0);
	}
	
	
}

