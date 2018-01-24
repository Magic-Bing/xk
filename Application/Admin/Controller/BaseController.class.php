<?php
namespace Admin\Controller;

use Common\Controller\BaseController as CommonBaseController;


/**
 * 基础控制器
 *
 * @create 2016-8-18
 * @author zlw
 */
class BaseController extends CommonBaseController 
{
    public function _initialize()
          {
                  parent::_initialize();

                  if (!$this->is_login()) {
                          redirect( U('login/index'),0);
                  }
      }
	/**
	 * 空方法
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
    public function _empty()
	{
		//$this->error('方法不存在！', U('room/index'));
                $this->error('方法不存在！');
    }
    
    
    
    public function is_login() 
    {
		if (session('?ADMINUSER_ID')) {
			return $this->get_user_id();
		} else {
			return false;
		}
    }
    public function get_user_id() 
    {
            return session('ADMINUSER_ID');
    }	
}
