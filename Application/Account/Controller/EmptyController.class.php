<?php

namespace Account\Controller;

use Think\Controller;


/**
 * 空控制器
 *
 * @create 2016-12-22
 * @author zlw
 */
class EmptyController extends Controller
{
	
	/**
	 * 空方法
	 *
	 * @create 2016-12-22
	 * @author zlw
	 */
    public function _empty()
	{
		$this->error('方法不存在！', U('index/index'));
    }
	
	/**
	 * 默认方法
	 *
	 * @create 2016-12-22
	 * @author zlw
	 */
    public function index()
	{
		$this->error('方法不存在！', U('index/index'));
    }
	
}
