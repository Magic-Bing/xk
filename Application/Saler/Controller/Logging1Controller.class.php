<?php

namespace Saler\Controller;

use Think\Controller;


/**
 * 高级用户 - 登录
 *
 * @create 2016-8-25
 * @author zlw
 */
class Logging1Controller extends Controller 
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
			$this->error('请求错误，请确认后重试！', U('logging1/index'));
		}
		$name = I('name', '', 'trim');
		if (empty($name)) {
			$this->error('用户名不能为空！', U('logging1/index'));
		}
                $Model = new \Think\Model();
                $user=$Model->query("SELECT * FROM xk_user WHERE (code='" . $name . "' or mobile='".$name."')  limit 1" );
		
		$password = I('pwd', '', 'trim');
                if ($user[0]['password'] != md5(md5($password))) {
			$this->error('用户名或者密码错误！', U('logging1/index'));
		}

            session('USER_ID', $user[0]['id']);
            $this->success(U('index1/index'));


    }
	

	/**
	 * 退出
	 *
	 * @create 2016-9-9
	 * @author zlw
	 */
        public function logout1() 
	{
		session('USER_ID', null);
		
		$this->success('退出成功！', U('logging1/index'));
	}
}

