<?php

//行为扩展
return array(

	//二维码基础回调
    'weixin_callback' => array(
		'Api\\Weixin\\Event',
	), 
	
	//事件回调 - 关注
    'wxcallback_after' => array(
		'Api\\Weixin\\Qrcode',
	), 
	
);
