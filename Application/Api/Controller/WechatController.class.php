<?php

namespace Api\Controller;

use Think\Hook;
use Lookey\Wxsdk\Event as WxEvent;


/**
 * 首页
 *
 * @create 2016-11-7
 * @author zlw
 */
class WechatController extends BaseController 
{
	
	/**
	 * 首页
	 *
	 * @create 2016-11-7
	 * @author zlw
	 */
    public function index()
	{
		$this->callback();
    }
	
	/**
	 * 微信接收事件
	 *
	 * @create 2016-11-15
	 * @author zlw
	 */
    public function callback()
	{
		$Event = new WxEvent();
		
		if ($Event->isEchostr()) {
			$Event->returnEchostr();
		} else {
			$Event->getEvent();
			$params = $Event->getPostArr();
			
			//测试用例
			//$params['MsgType'] = 'event';
			//$params['Event'] = 'subscribe';
			
			Hook::listen('weixin_callback', $params);
		}
    } 
    
}


