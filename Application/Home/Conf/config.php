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
		'__XK__' 	 => __ROOT__ . '/Public/xk',
		'__JS__' 	 => __ROOT__ . '/Public/xk/js',
		'__CSS__' 	 => __ROOT__ . '/Public/xk/css',
		'__IMG__' 	 => __ROOT__ . '/Public/xk/img',
	),
);