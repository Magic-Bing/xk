<?php

namespace Saler\Controller;

use Think\Controller;


/**
 * 置业顾问 - 登录
 *
 * @create 2016-8-25
 * @author zlw
 */
class LoggingController extends Controller 
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
			$this->error('请求错误，请确认后重试！', U('logging/index'));
		}
		
		$name = I('name', '', 'trim');
		if (empty($name)) {
			$this->error('用户名不能为空！', U('logging/index'));
		}
                $Model = new \Think\Model();
                $user=$Model->query("SELECT * FROM xk_user WHERE (code='" . $name . "' or mobile='".$name."')  limit 1" );
		
		$password = I('pwd', '', 'trim');
                if ($user[0]['password'] != md5(md5($password))) {
			$this->error('用户名或者密码错误！', U('logging/index'));
		}
		//判断开盘模式

        $pd=$Model->table("xk_station2user su")->field("su.id,p.id pid")->
        join("xk_station2pc sp ON su.station_id=sp.station_id")->
        join("LEFT JOIN xk_pzcsvalue p ON p.project_id=sp.proj_id AND p.batch_id=sp.pc_id AND p.pzcs_id=1 AND cs_value=-1")->
        where("su.userid={$user[0]['id']}")->select();
        if($pd) {
            session('USER_ID', $user[0]['id']);
            session('type', $user[0]['type']);
            $bl=false;
            for($i=0;$len=count($pd),$i<$len;$i++){
                if(!$pd[$i]['pid']){
                    $bl=true;
                    break;
                }
            }
            if($bl){
                $this->success(U('index/dz_page'));
            }else{
                $this->success(U('index/index'));
            }

        }else{
            $this->error('该账号没有数据权限，无法查看！', U('logging/index'));
        }

    }
	

	/**
	 * 退出
	 *
	 * @create 2016-9-9
	 * @author zlw
	 */
        public function logout() 
	{
		session('USER_ID', null);
                cookie('hdname', null);
                //$this->success('退出成功！', U('../logging/index'));
		redirect(U('logging/index'),0);
	}
}

