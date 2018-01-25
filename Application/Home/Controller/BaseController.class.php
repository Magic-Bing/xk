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
