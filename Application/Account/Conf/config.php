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
		'__XK__' 	 => __ROOT__ . '/Public/account',
		'__JS__' 	 => __ROOT__ . '/Public/account/js',
		'__CSS__' 	 => __ROOT__ . '/Public/account/css',
		'__IMG__' 	 => __ROOT__ . '/Public/account/img',
		'__ASSETS__' 	 => __ROOT__ . '/Public/account/assets',
	),

	//自定义错误页面
	'TMPL_ACTION_ERROR'     =>  APP_PATH.MODULE_NAME.'/View/Common/Error/302.html', // 默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'   =>  APP_PATH.MODULE_NAME.'/View/Common/Error/302.html', // 默认成功跳转对应的模板文件
	'TMPL_EXCEPTION_FILE'   =>  APP_PATH.MODULE_NAME.'/View/Common/Error/404.html',// 异常页面的模板文件
);
