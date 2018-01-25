<?php

return array(
	//路由设置
    'URL_ROUTER_ON'         =>  true,   // 是否开启URL路由
    'URL_ROUTE_RULES'       =>  array(), // 默认路由规则 针对模块
    'URL_MAP_RULES'         =>  array(), // URL映射定义规则
	
	//静态文件配置
	'TMPL_PARSE_STRING' => array(
		'__PUBLIC__' => __ROOT__ . '/Public',
		'__COMMON__' => __ROOT__ . '/Public/common',
		'__USER__' 	 => __ROOT__ . '/Public/user',
		'__JS__' 	 => __ROOT__ . '/Public/user/js',
		'__CSS__' 	 => __ROOT__ . '/Public/user/css',
		'__IMG__' 	 => __ROOT__ . '/Public/user/img',
	),
	
	//加载扩展配置文件
	'LOAD_EXT_CONFIG' => array(
		'LOTTERY' => 'lottery', //中奖配置
		'VOUCHER' => 'voucher', //代金券配置
	), 

	//自定义错误页面
	'TMPL_ACTION_ERROR'     =>  COMMON_PATH.'View/Common/Mobile/error.html', // 默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'   =>  COMMON_PATH.'View/Common/Mobile/success.html', // 默认成功跳转对应的模板文件
	'TMPL_EXCEPTION_FILE'   =>  COMMON_PATH.'View/Common/Mobile/exception.html',// 异常页面的模板文件

);