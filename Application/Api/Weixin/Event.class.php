<?php

namespace Api\Weixin;

use Think\Hook;


/**
 * 微信回调
 *
 * @create 2016-11-16
 * @author zlw
 */
class Event
{
	
	/**
	 * 二维码关注反馈
	 *
	 * @create 2016-11-7
	 * @author zlw
	 */
    public function weixin_callback(&$param)
	{
		//响应类型
		$msg_type_list = array(
			'text', 'image', 'location', 'voice', 
			'voice', 'video', 'link', 'event', 
		);
		$msg_type = trim($param['MsgType']);
		
		//事件
		$event_list = array(
			'subscribe', 'unsubscribe', 'CLICK', 'SCAN',
		);
		$event = trim($param['Event']);
		
		Hook::listen('wxcallback_before', $param);
		
		//事件扩展
		if (in_array($msg_type, $msg_type_list)) {
			if ($msg_type == 'event') {
				if (in_array($event, $event_list)) {
					Hook::listen('wxcallback_event_'.$event, $param);
				} else {
					Hook::listen('wxcallback_event_unknow', $param);
				}
			} else {
				Hook::listen('wxcallback_'.$msg_type, $param);
			}
		} else {
			Hook::listen('wxcallback_unknow', $param);
		}

		Hook::listen('wxcallback_after', $param);
	}
    
    
}


