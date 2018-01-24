<?php
namespace Home\Controller;

/**
 * 首页
 *
 * @create 2016-8-22
 * @author zlw
 */
class IndexController extends BaseController 
{
	
	/**
	 * 首页
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
    public function index() 
    { 
        $userid = $this->get_user_id_acc();
        if($this->is_logintype($userid)=="room")
        {
            redirect(U('account/index'), 0);
        }
        else
        {
            redirect(U('login/index'), 0);
        }
        //$this->display();
    }
}