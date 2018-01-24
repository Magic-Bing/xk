<?php

namespace Home\Controller;

use Think\Controller;


/**
 * 置业顾问 - 登录
 *
 * @create 2016-8-25
 * @author zlw
 */
class LoginController extends Controller 
{

	/**
	 * 设置标题
	 *
	 * @create 2016-8-25
	 * @author zlw
	 */
    public function set_seo_title($seo_title = '') 
	{
        $this->assign('seo_title', $seo_title);
    }

	
	/**
	 * 首页
	 *
	 * @create 2016-8-25
	 * @author zlw
	 */
    public function index() 
	{
	$this->set_seo_title("登录");
        $this->display();
    }
	

	/**
	 * 登录
	 *
	 * @create 2016-9-9
	 * @author zlw
	 */
    public function check() 
	{
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('login/index'));
		}
                session('XKUSER_ID', null);
		session('LEDUSER_ID', null);
                
		$name = I('name', '', 'trim');
		if (empty($name)) {
			$this->error('用户名不能为空！', U('login/index'));
		}
		
                $Model = new \Think\Model();
                $user=$Model->query("SELECT * FROM xk_user WHERE code='" . $name . "' or mobile='".$name."' limit 1" );
		
		$password = I('pwd', '', 'trim');
                
                if ($user[0]['password'] != md5(md5($password))) {
			$this->error('用户名或者密码错误！', U('login/index'));
		}
                if($user[0]['status']==1)
                {
                    $this->error('用户状态异常！', U('login/index'));
                }
                
                session('ACCOUNT_ID', $user[0]['id']);
                session('ACCOUNT_TYPE', $user['type']);
                session('XKUSER_ID', $user[0]['id']);
                $this->success(U('account/index'));
    }
	

	/**
	 * 退出
	 *
	 * @create 2016-9-9
	 * @author zlw
	 */
    public function logout() 
	{
		session('XKUSER_ID', null);
                session('ACCOUNT_ID', null);
		$this->success('退出成功！', U('login/index'));
	}
	
	
}

