<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>

	<head>
		<title><?php echo ((isset($seo_title) && ($seo_title !== ""))?($seo_title):'置业顾问'); ?></title>
		<meta name="keywords" content="<?php echo ((isset($seo_keywords) && ($seo_keywords !== ""))?($seo_keywords):'置业顾问'); ?>"/>
		<meta name="description" content="<?php echo ((isset($seo_description) && ($seo_description !== ""))?($seo_description):'置业顾问'); ?>"/>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<meta name="apple-mobile-web-app-capable" content="yes"/>
		<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<meta name="MobileOptimized" content="320">
		<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
		<meta http-equiv="Pragma" content="no-cache">
		<meta name="HandheldFriendly" content="true">
		
			<link href="/Public/common/css/base.css" type="text/css" rel="stylesheet"/>
			<link href="/Public/common/css/layout.css" type="text/css" rel="stylesheet"/>
		
		
			<link href="/Public/sales/css/saler.css" type="text/css" rel="stylesheet"/>
		
		
			<link href="/Public/common/css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
		
			<script src="/Public/common/js/jquery/jquery-1.11.3.min.js"></script>
			<!--<script src="/Public/common/js/jquery/jquery-ui-1.12.0.custom/jquery-ui.js"></script>-->
			<script src="/Public/common/js/jquery/jquery.mousewheel.js"></script>
			<link href="/Public/common/js/jquery/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet"/>
			<script src="/Public/common/js/jquery/perfect-scrollbar/perfect-scrollbar.js"></script>
			<script src="/Public/common/js/functions.js"></script>
			<script src="/Public/common/js/layer_mobile/layer.js"></script>
			<script src="/Public/common/js/mobile/layer.js"></script>
			<script src="/Public/common/js/mobile/functions.js"></script>
			<script src="/Public/common/js/mobile/common.js"></script>
		
		
			<script src="/Public/sales/js/data.js"></script>
			<script src="/Public/sales/js/common.js"></script>
			<script src="/Public/sales/js/saler.js"></script>
		
		
		
			<script type="text/javascript">
				var saler_url = {
					index: '<?php echo U("index/index");?>',
					room_index: '<?php echo U("room/index");?>',
					project_room_compare: '<?php echo U("compare/room");?>',
					search: '<?php echo U("search/index");?>',
					hot_sale: '<?php echo U("hot/index");?>',
					login: '<?php echo U("logging/check");?>',
                                        login1: '<?php echo U("logging1/check");?>',
					logout: '<?php echo U("logging/logout");?>',
					project_index: '<?php echo U("project/index");?>',
                    getNotBuy: '<?php echo U("MyReport/getNotBuy");?>',
				}
				var search_url = {
					room: '<?php echo U("search/room");?>',
				}
				var saler_hot = {

				}
				var saler_event_house ={
                    room: '<?php echo U("EventOrderHouse/hot");?>'
					,login : '<?php echo U("EventOrderHouse/check");?>'
					,logout : '<?php echo U("EventOrderHouse/logout");?>'
				};

			</script>
		
		
	</head>
	
	<body>
		
	<div class="saler-project-header-wrapper" style="background: #03a9f4">
                <div class="fl wm25 arrow-left-white common-header-return">
				<span class="common-header-return-box return-btn">
					<a href="javascript:void(0);" class="common-header-return-btn" style="color:#FFF">返回</a>
				</span>
		</div>
		<span class="saler-project-header" style="width:75%;border:0px;">
			选择微信开盘活动
		</span>
		<span>
				<a href="/saler/logging/logout.html" class="a-logout" style="">注销</a>
		</span>
	</div>

		
	<div class="base">
		<div class="saler-project-content-wrapper">
			<div class="saler-project-content">
				<ul class="saler-project-content-list">
				
					<?php if(is_array($projects)): $projects_k = 0; $__LIST__ = $projects;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$projects_vo): $mod = ($projects_k % 2 );++$projects_k;?><li class="saler-project-content-li">
                                                    <!--<?php if($userinfo['type'] < 3 ): ?><a href="<?php echo U('saler/project/index', array('info' => set_search_ids(array('p' => $projects_vo['id']))));?>" class="saler-project-content-a">
								<?php echo ((isset($projects_vo["name"]) && ($projects_vo["name"] !== ""))?($projects_vo["name"]):"项目"); ?>
								<input style="float:right;margin-right:5px" type="radio" name="xzproj" class="js_xzproj_radio"/>
							</a>
                                                    <?php else: ?>
                                                    <a href="../../saler/statistics/index.html?pid=<?php echo ($projects_vo["id"]); ?>" class="saler-project-content-a">
								<?php echo ((isset($projects_vo["name"]) && ($projects_vo["name"] !== ""))?($projects_vo["name"]):"项目"); ?>
								<input style="float:right;margin-right:5px" type="radio" name="xzproj" class="js_xzproj_radio"/>
							</a><?php endif; ?>-->
                                                    <a href="../../saler/DataStatistics/index/info/p<?php echo ($projects_vo["id"]); ?>" class="saler-project-content-a">
                                                            <?php echo ((isset($projects_vo["name"]) && ($projects_vo["name"] !== ""))?($projects_vo["name"]):"项目"); ?>
                                                            <input style="float:right;margin-right:5px" type="radio" name="xzproj" class="js_xzproj_radio"/>
                                                    </a>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
		</div>
	<div>

                
		
                
                    <style>
                        .weui-tabbar1 {
                            display: -webkit-box;
                            display: -webkit-flex;
                            display: flex;
                            position: absolute;
                            z-index: 500;
                            bottom: 0;
                            width: 100%;
                            background-color: #ffffff;
                            border-top: 1px solid #e6e6e6;
                        }
                        
                        .weui-tabbar__item1 {
                            display: block;
                            -webkit-box-flex: 1;
                            -webkit-flex: 1;
                            flex: 1;
                            padding: 2px 0 0;
                            font-size: 0;
                            color: #999999;
                            text-align: center;
                            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
                        }
                        .weui-tabbar__label1 {
                            text-align: center;
                            color: #999999;
                            font-size: 10px;
                            line-height: 1.8;
                        }
                        .weui-tabbar__icon1 {
                            display: inline-block;
                            width: 27px;
                            font-size: 20px;
                            padding: 0 0 0 0;
                        }
                        .weui-bar__item_on1 {
                            color: #09BB07;
                        }
                        .weui-bar__item_on1 .weui-tabbar__label1 {
                            color: #09BB07;
                        }
                    </style>
                
		
	</body>
	
</html>