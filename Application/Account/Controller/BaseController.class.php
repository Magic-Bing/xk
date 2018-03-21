<?php

namespace Account\Controller;

use Common\Controller\BaseController as CommonBaseController;


/**
 * 基础控制器
 *
 * @create 2016-12-22
 * @author zlw
 */
class BaseController extends CommonBaseController 
{
    /**
     * 系统构造函数
     *
     * @create 2016-12-22
     * @author zlw
     */
    public function _initialize() 
	{
        parent::_initialize();
		
		//网站名称
		$this->set_website();
		
		//验证登录
		$this->check_login();
		
		//用户信息
		$this->set_user_info();
		//获取指定的模块
        $this->get_choose_fun();
		
		//未读竞价记录
		//$this->log_noread_count();
    }


    public function error_page()
    {
        $this->error('没有权限进入该页面！','/index/index');
    }
    /**
     * 空方法
     *
     * @create 2016-12-23
     * @author zlw
     */
    public function _empty() 
	{
        $this->error('方法不存在！');
    }
	
	/**
	 * 判断是否已经登录
	 *
     * @create 2016-12-23
	 * @author zlw
	 */
    protected function check_login() 
	{
		if (!session('?ACCOUNT_ID')) {
                    //$this->error('你还没有登录，正在跳转到登录页面', U('login/index'));
            redirect(U('../login/index'),0);
		}else{
		  $id=session('ACCOUNT_ID');
		  $pd=M()->table("xk_user")->where("id=$id")->find();
		  if(!$pd){
              session('ACCOUNT_ID', null);
              redirect(U('../login/index'),0);
          }
        }
    }	
	
	/**
	 * 设置网站名称
	 *
     * @create 2016-12-23
	 * @author zlw
	 */
    protected function set_website($website = '') 
	{
		if (empty($website)) {
			$website = '云销控管理系统';
		}
		$this->assign('website', $website);
    }	
	
    /**
     * 设置用户信息
     *
     * @create 2016-12-23
     * @author zlw
    */
    protected function set_user_info($user_info = '') 
    {
            if (empty($user_info)) {
                    $user_id = $this->get_user_id();

                    $where['id'] = $user_id;
                    $where[]="9933=9933";
                    $user = D("User")->getOne($where);
                    if (empty($user)) {
                            $this->set_logout();

                            $this->error('用户不存在，请稍后重试！', U('login/index'));
                    }
                    $user_info = $user;
            }
            $this->assign('user_info', $user_info);
    }	

    /**
     * 是否登录
     *
     * @create 2016-12-23
     * @author zlw
     */
    protected function is_login() 
	{
        if (session('?ACCOUNT_ID')) {
            return $this->get_user_id();
        } else {
            return false;
        }
    }

    /**
     * 获取登录ID
     *
     * @create 2016-12-23
     * @author zlw
     */
    protected function get_user_id() 
    {
        return session('ACCOUNT_ID');
    }
    
     /**
     * 获取登录用户类型
     *
     * @create 2016-12-23
     * @author zlw
     */
    protected function get_user_type() 
    {
        return session('ACCOUNT_TYPE');
    }
    

	/**
	 * 设置退出
	 *
     * @create 2016-12-23
	 * @author zlw
	 */
    protected function set_logout() 
	{
		session('ACCOUNT_ID', null);
                session('ACCOUNT_TYPE', null);
	}

	/**
	 * 未读取的竞价记录
	 *
     * @create 2016-12-30
	 * @author zlw
	 */
    protected function log_noread_count() 
	{
		//用户的项目和项目批次
		$user_project_ids = $this->get_user_project_ids();
		$user_batch_ids = $this->get_user_batch_ids();
		
		if (!empty($user_project_ids) && !empty($user_project_ids)) {
			$log_noread_count = D('ChooselogView')->getNoreadLogCount($user_project_ids, $user_batch_ids);
		} else {
			$log_noread_count = 0;
		}
		
		$this->assign('log_noread_count', $log_noread_count);
	}
	/*=====================获取用户有权限查看的模块======================*/
    protected  function get_choose_fun(){
        //当前用户ID
        $model=M();
        $user_id = $this->get_user_id();
        $pd=$model->table("xk_user")->field("is_all")->where("id=$user_id")->find();
        if((int)$pd['is_all'] ===1) {
            $fun = $model->table("xk_fun")->where("is_fun=1")->order("px ASC")->select();
            $this->assign("fun", $fun);
        }else{
            $fun=$model->table("xk_station2user su")->field("f.*")->join("xk_fun_station fs on fs.station_id=su.station_id")->join("xk_fun f on f.id=fs.fun_id")->where("su.userid=$user_id and f.is_fun=1")->order("f.px ASC")->select();

            $this->assign("fun", $fun);
        }
    }
	/*#----------- 设置左侧导航信息 ---------------#*/

	/**
	 * 设置组名称
	 *
     * @create 2016-12-27
	 * @author zlw
	 */
    protected function set_group_name($name = '') 
	{
		$this->assign('group_name', $name);
	}

	/**
	 * 设置组方法
	 *
     * @create 2016-12-27
	 * @author zlw
	 */
    protected function set_group_action($action = '', $group = '') 
	{
		$group_action_list = array();
		if (!is_array($action)) {
			$group_action_list[] = $action;
		} else {
			$group_action_list = $action;
		}
		
		if (!empty($group)) {
			$group_action[$group] = $group_action_list;
		} else {
			$group_action = $group_action_list;
		}
		
		$this->assign('group_action', $group_action);
	}
        
        
	/**
	 * 设置当前方法
	 *
     * @create 2016-12-27
	 * @author zlw
	 */
    protected function set_now_action($now_action = '') 
	{
		$this->assign('now_action', $now_action);
	}

	/**
	 * 设置方法
	 *
     * @create 2016-12-27
	 * @author zlw
	 */
    protected function set_current_action($action = '', $group = '') 
	{
		$this->set_group_action($action, $group);
		$this->set_now_action($action);
	}
	
	/*#----------- 用户项目信息 ---------------#*/
	
	/**
	 * 获取用户的项目
	 *
     * @create 2016-12-26
	 * @author zlw
	 */
//    protected function get_user_project()
//	{
//		//当前用户ID
//		$user_id = $this->get_user_id();
//		$is_all=M("user")->field("is_all")->where("id=$user_id")->find();
////		echo json_encode($is_all);exit;
//		//当前用户的项目
//		$StationrelevanceView = D("StationrelevanceView");
//		if($is_all['is_all']!=1){
//            $user_project_where['station2user_user_id'] = $user_id;
//        }
//		$user_project_where['Project.status'] = 1;
//		$user_project_list = $StationrelevanceView->getList($user_project_where);
//		//用户的相关项目和批次
////        echo json_encode($user_project_list);exit;
//		$user_project_ids = array();
//		$user_batch_ids = array();
//		if (!empty($user_project_list)) {
//			foreach ($user_project_list as $user_project) {
//				$user_project_ids[$user_project['project_id']] = $user_project['project_id'];
//				$user_batch_ids[$user_project['batch_id']] = $user_project['batch_id'];
//			}
//		} else {
//			$user_project_ids = array('-99999');
//			$user_batch_ids = array('-99999');
//		}
//		$user_projects = array(
//			'user_project_ids' => $user_project_ids,
//			'user_batch_ids' => $user_batch_ids,
//			'user_project_list' => $user_project_list,
//		);
////		echo json_encode($user_projects);exit;
//		return $user_projects;
//	}
    protected function get_user_project()
    {
        //当前用户ID
        $user_id = $this->get_user_id();
        $model=M();
        $is_all=$model->table("xk_user")->field("is_all")->where("id=$user_id")->find();
        $user_project_ids = [];
        $user_batch_ids = [];
        if((int)$is_all['is_all']===1) {
            $pids = $model->table("xk_project")->field("id")->select();
            for ($i = 0; $i < count($pids); $i++) {
                $user_project_ids[$pids[$i]['id']] = $pids[$i]['id'];
            }
            $kids = $model->table("xk_kppc")->field("id")->select();
            for ($i = 0; $i < count($kids); $i++) {
                $user_batch_ids[$kids[$i]['id']] = $kids[$i]['id'];
            }
        }else{
            $res=$model->table("xk_station2user su")->field("sp.proj_id pid,k.id kid")->
                join("xk_station2proj sp ON sp.station_id=su.station_id")->
                join("xk_kppc k ON k.proj_id=sp.proj_id")->where("su.userid=$user_id")->select();
            foreach ($res as $user_project) {
				$user_project_ids[$user_project['pid']] = $user_project['pid'];
				$user_batch_ids[$user_project['kid']] = $user_project['kid'];
			}

        }
        if(!$user_project_ids){
            $user_project_ids = array('-99999');
            $user_batch_ids = array('-99999');
        }
        $user_projects = array(
            'user_project_ids' => $user_project_ids,
            'user_batch_ids' => $user_batch_ids,
        );
//		echo json_encode($user_projects);exit;
        return $user_projects;
    }
	
        /**
	 * 获取用户的公司权限列表
	 *
        * @create 2016-12-26
	 * @author zlw
	 */
        protected function get_user_company() 
	{	
                $user_id = $this->get_user_id();
                $where['id'] = $user_id;
                $where[]="9933=9933";
                $user = D("User")->getOne($where);
                $Model = new \Think\Model();
                unset($where);
                //超级管理员获取全部的公司
                if ($user['is_all']==1)
                {
                    $companys=$Model->query("SELECT b.name as compname,b.id FROM xk_company b  order by b.id" );
                }
                else
                {
                    $companys=$Model->query("SELECT b.name as compname,b.id FROM xk_user a left join xk_company b on a.cp_id=b.id  where a.id=" . $user_id . " and 888=888 order by b.id" );
                }
                return $companys;
	}	
      
        
	/**
	 * 获取用户的项目ID列表
	 *
     * @create 2016-12-26
	 * @author zlw
	 */
    protected function get_user_project_ids() 
	{	
		$user_project_list = $this->get_user_project();
		return $user_project_list['user_project_ids'];
	}	
	
	/**
	 * 获取用户的项目批次ID列表
	 *
     * @create 2016-12-26
	 * @author zlw
	 */
    protected function get_user_batch_ids()
    {	$uid=$this->get_user_id();
        $is_all=M()->table("xk_user")->field("is_all")->where("id=$uid")->find();
        $arr=[];
        if((int)$is_all['is_all']===1) {
            $kids = M()->table("xk_kppc")->field("id")->select();
            for ($i = 0; $i < count($kids); $i++) {
                $arr[$kids[$i]['id']] = $kids[$i]['id'];
            }
        }else{
            $res=M()->table("xk_station2user su")->field('sp.pc_id')->join("xk_station2pc sp ON su.station_id=sp.station_id")->where('su.userid='.$uid)->select();
            for($i=0;$c=count($res),$i<$c;$i++){
                $arr[$res[$i]['pc_id']]=$res[$i]['pc_id'];
            }
        }

        return $arr;
	}

	
	/**
	 * 获取用户的项目列表
	 *
     * @create 2016-12-26
	 * @author zlw
	 */
    protected function get_user_project_list() 
	{	
		$user_project_list = $this->get_user_project();
		return $user_project_list['user_project_list'];
	}	
	
	//获取ip
    function getIP() {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        }
        elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        }
        elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}
