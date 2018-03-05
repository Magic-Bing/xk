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

        $pd=$Model->table("xk_station2user su")->field("su.id,p.id pid,sp.proj_id,sp.pc_id,e.id eid")->
        join("xk_station2pc sp ON su.station_id=sp.station_id")->
        join("LEFT JOIN xk_event_order_house e ON e.project_id=sp.proj_id AND e.batch_id=sp.pc_id")->
        join("LEFT JOIN xk_pzcsvalue p ON p.project_id=sp.proj_id AND p.batch_id=sp.pc_id AND p.pzcs_id=1 AND cs_value=-1")->
        where("su.userid={$user[0]['id']}")->select();
        if($pd) {
            $pd=$this->unique($pd);
            session('USER_ID', $user[0]['id']);
            session('type', $user[0]['type']);
        /*    $bl=false;
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
//            }*/
            //判断个数
            $len=count($pd);
            if($len === 1){//等于1的时候，直接跳往首页
                if($pd[0]['pid']){
                    $this->success( U('DataStatistics/index',array('info' => set_search_ids(array('p' => $pd[0]['proj_id'])))));
                }else{
                    $this->success( U('DataStatistics/dz_index',array('p' =>$pd[0]['proj_id'],'b' =>$pd[0]['pc_id'] )));
                }
            }else{//多个跳往选择页面
                $this->success(U('index/dz_index'));
            }
        }else{
            $this->error('该账号没有数据权限，无法查看！', U('logging/index'));
        }

    }

    /*
         * 删除二位数组中的一维数组
         * 2018-3-5
         * qzb*/
    function unique($arr) {
        foreach($arr as $k => $v) $arr[$k] = serialize($v);
        $arr = array_unique($arr);
        foreach($arr as $k => $v) $arr[$k] = unserialize($v);
        return $arr;
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

