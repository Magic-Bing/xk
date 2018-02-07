<?php

namespace Home\Controller;

use Common\Controller\BaseController as CommonBaseController;

/**
 * 基础控制器
 *
 * @create 2016-8-18
 * @author zlw
 */
class BaseController extends CommonBaseController {

    public function _initialize() {
        parent::_initialize();
        if (!$this->is_mobile())
        {
            //$userid=$this->is_login();
            if (!$this->is_login_acc()) {
                redirect(U('login/index'), 0);
            } else {
               
            }
        }
        else
        {
             redirect(U('saler/index/index'), 0);
        }
    }

    /**
     * 空方法
     *
     * @create 2016-8-22
     * @author zlw
     */
    public function _empty() {
        //$this->error('方法不存在！', U('room/index'));
        $this->error('方法不存在！');
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
    {
        $user_project_list = $this->get_user_project();
        return $user_project_list['user_batch_ids'];
    }
    protected function get_user_project()
    {
        //当前用户ID
        $user_id = $this->get_user_id_acc();
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
    public function is_login() {
        if (session('?XKUSER_ID')) {
            return $this->get_user_id();
        } else {
            return false;
        }
    }
    
    public function is_login_acc() {
        if (session('?ACCOUNT_ID')) {
            return $this->get_user_id_acc();
        } else {
            return false;
        }
    }

    public function get_user_id() {
        return session('XKUSER_ID');
    }
    public function get_user_id_acc() {
        return session('ACCOUNT_ID');
    }
    
    public function is_logintype($name)
    {
        $Model = new \Think\Model();
        $user=$Model->query("SELECT * FROM xk_user WHERE code='" . $name . "' or mobile='".$name."' and type in(1,2,3) limit 1" );
        if ($user[0]['type']==1)//查看led
        {
            return "led";
        }
        else//销控
        {
            return "room";
        }
    }
}
