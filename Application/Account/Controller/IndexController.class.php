<?php

namespace Account\Controller;


/**
 * 首页
 *
 * @create 2016-12-22
 * @author zlw
 */
class IndexController extends BaseController 
{

    /**
     * 系统构造函数
     *
     * @create 2016-12-27
     * @author zlw
     */
    public function _initialize() 
	{
        parent::_initialize();
		
		//分类名称
		$this->assign('classify_name', '控制台');
		
		//设置当前方法
		$this->set_current_action('index', 'index');
    }
	
	/**
	 * 首页
	 *
     * @create 2016-12-22
	 * @author zlw
	 */
    public function index() 
    { 
		$this->set_seo_title('控制台');
		
        $this->display();
    }
    
    
     public function editpwd(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		}
        $uid = I('user_id', '', 'trim');
        $oldpwd = I('oldpwd', '', 'trim');
        $newpwd = I('newpwd', '', 'trim');
        
        $user_id = $this->get_user_id();
        if ($uid<>$user_id)
        {
             $this->error('数据异常，请稍后重试！');
        }
        $model = D("user");  
        $userinfo=$model->getOneById($uid);
        if($userinfo['password']<>md5(md5($oldpwd)))
        {
           $this->error('原密码输入错误！');
        }
        if($userinfo['password']==md5(md5($newpwd)))
        {
           $this->error('新密码与原密码一致，无需修改！');
        }
        $data['password']=md5(md5($newpwd));    
        $bz=$model->where('id='.$uid)->save($data);
        if ($bz)
        {
            session_unset();
            session_destroy();
            $this->success('密码修改成功，请重新登录！');
        }
     }
	
}