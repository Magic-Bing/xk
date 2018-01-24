<?php
namespace Home\Controller;

use Think\Controller;


/**
 * 空控制器
 *
 * @create 2016-8-22
 * @author zlw
 */
class EmptyController extends Controller
{
	
	/**
	 * 默认方法
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
    public function index()
	{
		$this->error('方法不存在！', U('room/index'));
    }
	
}
