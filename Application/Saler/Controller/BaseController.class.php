<?php

namespace Saler\Controller;

use Common\Controller\BaseController as CommonBaseController;


/**
 * 基础控制器
 *
 * @create 2016-8-18
 * @author zlw
 */
class BaseController extends CommonBaseController 
{
	
	/**
	 * 构造方法
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	public function _initialize()
	{
		parent::_initialize();
                
                $this->set_seo_title(C('WEIXIN_TITLE'));
   
		if (!$this->is_login()) {
			//$this->error('你还没有登录！', U('logging/index'));
                        redirect( U('logging/index'),0);
		}else{
            $id=session('USER_ID');
            $pd=M()->table("xk_user")->where("id=$id")->find();
            if(!$pd){
                session('USER_ID', null);
                redirect(U('logging/index'),0);
            }
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
            session('USER_ID', null);
            $this->error('错误的操作，请重新登录！', U('Logging/index'));
    }
	
	
	/**
	 * 判断是否登录
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	public function is_login() 
	{
		if (session('?USER_ID')) {
			return $this->get_user_id();
		} else {
			return false;
		}
	}
	
	
	/**
	 * 获取客户ID
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	public function get_user_id() 
	{
		return session('USER_ID');
	}
        
	//计算房间热力指数得分(5为满分)
	public function roomrlzs($room_attribute,$project_id) 
	{
            $Model = new \Think\Model();
            $zgs=$Model->query("select sum(djcount)/count(1) as zdj,sum(sscount)/count(1) as zss,sum(sccount)/count(1) as zsc from xk_roomattribute a left join xk_roomlist b on a.room_id=b.id where b.proj_id='".$project_id ."' and b.is_dq=1 and 66=66");
            $djcount=$room_attribute['djcount'];
            $sscount=$room_attribute['sscount'];
            $sccount=$room_attribute['sccount'];
            
            $zdjcount=$zgs[0]['zdj'];
            $zsscount=$zgs[0]['zss'];
            $zsccount=$zgs[0]['zsc'];
            if (empty($zdjcount)||$zdjcount==0)
            {
                $djcount=1;
                $zdjcount=1;
            }
            if (empty($zsscount)||$zsscount==0)
            {
                $sscount=1;
                $zsscount=1;
            }
            if (empty($zsccount)||$zsccount==0)
            {
                $sccount=1;
                $zsccount=1;
            } 
            $num=round(($djcount/$zdjcount*0.2 + $sscount/$zsscount*0.3 + $sccount/$zsccount*0.5) * 5,0);
            if ($num>5)
                $num=5;
            return $num;
	}
}
