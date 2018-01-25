<?php

namespace Admin\Controller;

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
                session('ADMINUSER_ID', null);
                
		$name = I('name', '', 'trim');
		if (empty($name)) {
			$this->error('用户名不能为空！', U('login/index'));
		}
		
                $Model = new \Think\Model();
                $user=$Model->query("SELECT * FROM xk_admin WHERE code='" . $name . "' or mobile='".$name."' and is_qy =1 limit 1" );
		
		$password = I('pwd', '', 'trim');
                
                if ($user[0]['password'] != md5(md5($password))) {
			$this->error('用户名或者密码错误！', U('login/index'));
		}

                session('ADMINUSER_ID', $user[0]['id']);
                $this->success(U('index/index'));
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
		$this->success('退出成功！', U('login/index'));
	}
	
	
}

