<?php

return array(
	
	//登录配置
	'LOGGING'				=>  array(
		'SALT'  => 'sdf2313dgfsd988j',
	),

	//路由设置
    'URL_ROUTER_ON'         =>  true,   // 是否开启URL路由
    'URL_ROUTE_RULES'       =>  array(), // 默认路由规则 针对模块
    'URL_MAP_RULES'         =>  array(), // URL映射定义规则
	
	//静态文件配置
	'TMPL_PARSE_STRING' => array(
		'__PUBLIC__' => __ROOT__ . '/Public',
		'__COMMON__' => __ROOT__ . '/Public/common',
		'__SALES__'  => __ROOT__ . '/Public/sales',
		'__JS__' 	 => __ROOT__ . '/Public/sales/js',
		'__CSS__' 	 => __ROOT__ . '/Public/sales/css',
		'__IMG__' 	 => __ROOT__ . '/Public/sales/img',
	),
	
	//自定义错误页面
	'TMPL_ACTION_ERROR'     =>  COMMON_PATH.'View/Common/Mobile/error.html', // 默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'   =>  COMMON_PATH.'View/Common/Mobile/success.html', // 默认成功跳转对应的模板文件
	'TMPL_EXCEPTION_FILE'   =>  COMMON_PATH.'View/Common/Mobile/exception.html',// 异常页面的模板文件

);