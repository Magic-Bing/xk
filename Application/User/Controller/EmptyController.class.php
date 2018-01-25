<?php

namespace User\Controller;

use Think\Controller;


/**
 * 空控制器
 *
 * @create 2016-8-25
 * @author zlw
 */
class EmptyController extends Controller
{
	
	/**
	 * 默认方法
	 *
	 * @create 2016-8-25
	 * @author zlw
	 */
    public function index()
	{
		$this->error('方法不存在！', U('index/index'));
    }
	
}
