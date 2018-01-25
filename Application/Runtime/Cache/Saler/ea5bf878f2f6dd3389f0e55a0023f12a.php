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
		
    <link rel="stylesheet" href="/Public/common/css/font-awesome-4.7.0/css/font-awesome.css">
    <script src="/Public/sales/js/highcharts.js"></script>
    <script src="/Public/sales/js/exporting.js"></script>
    <script src="/Public/sales/js/highcharts-3d.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
    <style>
        .weui-tabbar{
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
        .weui-tabbar__item {
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
        .weui-bar__item_on
        {
            color:#09BB07;
        }
        .weui-badge {
            display: inline-block;
            width: 15px;
            border-radius: 18px;
            background-color: #F43530;
            color: #FFFFFF;
            line-height: 1.2;
            text-align: center;
            font-size: 12px;
            vertical-align: middle;
        }
        .weui-badge_dot {
            width: 9px;
            height: 9px;
        }

        .weui-tabbar__icon {
            display: inline-block;
            width: 27px;
            font-size: 20px;
            padding: 0 0 0 0;
        }
        .weui-tabbar__label {
            text-align: center;
            color: #999999;
            font-size: 10px;
            line-height: 1.8;
        }
        .weui-bar__item_on .weui-tabbar__label
        {
            color:#09BB07;
        }
        .js-saler-project-view-content-search-compare-btn{
            background-color: #FFF;margin-top: -2px;padding: 2px 8px 2px 8px ;border-radius: 5px;display: inline;height:25px
        }
        .saler-project-view-content-search-compare-btn-click .weui-tabbar__label{
            color:#03a9f4;
        }
        .saler-project-view-header-unit-info {
            width: 21%;
            min-width: 70px;
            text-align: center;
            font-size: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
           
        }
        .hidden-list .saler-project-view-header-unit-info {
            width: 25%;
            text-align: center;
            font-size: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .saler-project-view-header-unit-info a{
            overflow: hidden;
            text-overflow: ellipsis;
            margin: 1px 0px;
            border-right: 1px solid #c9c9c9;
        }
        .saler-project-view-header-unit-info-selected > a {
            background:  #fff;
            color: #000;
            font-weight: bold;
            border: 1px solid #fff;
            border-right: 1px solid #c9c9c9;
        }
        .saler-project-view-header-unit-info .morea{
             margin: 10px 2px;
             padding:5px 0px;
        }
        .hidden-list{
            position: fixed;
            display: none;
            background-color: #e7f0f9;
            /*background-color: #fff;*/
            z-index: 99999;
            padding: 5px 5px 0 5px;
            top:113px;
            width:calc(100% - 10px);
        }
        #shadow-list{
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            position: fixed;
            z-index: 88888;
            display: none;
            cursor: pointer;
        }
        .up-center{
            text-align: center;
            height: 33px;
            line-height: 33px;
            font-weight: 400;
            font-size: 13px;
        }
        .bl{
            background-color: #ffffff;
            color: #03a9f4!important;
            cursor: pointer;
            font-weight: 700;
            border-bottom: 2px solid #03a9f4;
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
        }
        .gy{
            color: #999!important;
            cursor: pointer;
            border-bottom: 2px solid #c9c9c9;
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
        }
        .saler-project-view-content-rooms-room-name {
            font-size: 10px;
            text-align: center;
            font-weight: 700;
        }
        .saler-project-view-content-rooms-room-area {
            font-size: 10px;
            text-align: left;
        }
        .saler-project-view-content-rooms-box td.saler-project-view-content-rooms-floor {
            width: 28px;
            background: #e4e4e4;
            border: 1px solid #FFF;
            font-weight: 700;
            color: #333;
            font-size: 13px;
            text-align: center;
            padding: 5px 3px;
        }
     
        .hot-one{
            background-color: #f25741;
        }
        .hot-two{
            background-color: #ff9353
        }
        .hot-three{
            background-color: rgba(255, 188, 23, 0.69);
        }
        .hot-four{
            background-color: rgba(45, 202, 94, 0.53);
        }
        .hot-five{
            background-color: #6aba6e;
        }
        .saler-project-view-content-rooms-room-box-one {
            font-size: 10px;
            border-width: 1px;
            margin: 3px 4px;
            padding: 0 5px;
        }
        .room-li{
            border-right: 1px solid #fff;
            border-top: 1px solid #fff;
            width: calc(25% - 1px);
            font-weight: bold;
        }
        .hot-one-span{
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #f25741;
        }
        .hot-two-span{
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #ff9353;
        }
        .hot-three-span{
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: rgba(255, 188, 23, 0.69);
        }
        .hot-four-span{
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: rgba(45, 202, 94, 0.53);
        }
        .hot-five-span{
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #6aba6e;
        }
        #build-list{
            border-style: none;
            border: 0;
            background-color: rgba(203,203,203,0);
            margin-right: 15px;
            color: #999;
        }
        #show-gd{
            display: inline-block;
            background-color: #ffffff;
            color: #c9c9c9;
            cursor: pointer;
            width: 50px;
            position: fixed;
            z-index: 101;
            height: 31px;
            top:79px;
            left: calc(100% - 50px);
            font-size:12px;
        }
        .saler-project-view-header-unit-info > a{
            padding: 0;
        }

    </style>
    <div id="shadow-list">

    </div>
    <?php if($is_fx == 0): ?><div class="fl wm100 hidden-list"  >
            <?php if(is_array($builds)): $builds_k = 0; $__LIST__ = $builds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$builds_vo): $mod = ($builds_k % 2 );++$builds_k; if(is_array($new_units[$builds_vo['id']])): $units_k = 0; $__LIST__ = $new_units[$builds_vo['id']];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$units_vo): $mod = ($units_k % 2 );++$units_k; if(($builds_vo['id'] == $search_build_id) AND ($units_vo['unit'] == $search_unit_id)): ?><div class="saler-project-view-header-unit-info saler-project-view-header-unit-info-selected fl" style="display: inline-block">
                                <a class="morea" href="<?php echo U('RoomAnalysis/index', array('info' => set_search_ids(array('p' => $project_id, 'b' => $builds_vo['id'], 'u' => $units_vo['unit']))));?>">
                                    <?php echo ($builds_vo[ 'buildname']); if($units_vo['unit'] != 0): echo ($units_vo[ 'unit']); ?>单元<?php endif; ?>
                                </a>
                            </div>
                            <?php else: ?>
                            <div class=" saler-project-view-header-unit-info fl" style="display: inline-block">
                                <a class="morea" href="<?php echo U('RoomAnalysis/index', array('info' => set_search_ids(array('p' => $project_id, 'b' => $builds_vo['id'], 'u' => $units_vo['unit']))));?>">
                                    <?php echo ($builds_vo[ 'buildname']); if($units_vo['unit'] != 0): echo ($units_vo[ 'unit']); ?>单元<?php endif; ?>
                                </a>
                            </div><?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
        </div><?php endif; ?>
    <div class="saler-project-view-header-wrapper">
        <div class="clearfix saler-project-view-header" style="background:#FFF">
                <div>
                    <div class="fl wm25 saler-project-view-header-return">
                        <span class="saler-project-view-header-return-box return-btn">
                            <a href="javascript:void(0);" class="saler-project-view-header-return-btn">返回</a>
                        </span>
                    </div>
                    <div class="fl wm50 saler-project-view-header-content">
                        <span class="saler-project-view-header-content-box-no-arrow">
                            <span class="saler-project-view-header-content-box-name"><?php echo ($projinfo["pname"]); ?></span>
                        </span>
                    </div>
                    <div class="fr wm10 saler-project-view-header-right">
                        <a href="" onclick="window.location.reload()" class="saler-project-header-reload-btn js-saler-project-header-reload-btn saler-project-header-reload-a">
                            <i class="icon-refresh  bigger-230 " style="color: #c1c1c1;font-size: 18px"></i>
                        </a>
                    </div>
                </div>
            <div class="fl wm100 "  style="margin-top: 43px;height: 35px;white-space: nowrap;z-index: 100;position: absolute; display: flex;">
                <div class="fl up-center gy" id="room-xk">
                    <a href="<?php echo U('Project/index', array('info' => set_search_ids(array('p' => $project_id))));?>">
                        <div style="height:25px;margin-top: 4px;line-height: 25px;color: #999999!important;">房源销控</div>
                    </a>
                </div>
                <?php if($is_fx == 0): ?><div class="fl up-center bl" id="room-hot">
                    <a href="<?php echo U('RoomAnalysis/index', array('info' => set_search_ids(array('p' => $project_id))));?>">
                        <div style="height:25px;margin-top: 4px;line-height: 25px;color: #03A9F4">房源热度</div>
                    </a>
                </div>
                <div class="fl up-center gy" id="room-img">
                    <a href="<?php echo U('RoomAnalysis/index', array('info' => set_search_ids(array('p' => $project_id)),'is_fx' => 1 ));?>">
                        <div style="height:25px;margin-top: 4px;line-height: 25px;color: #999999">装户统计</div>
                    </a>
                </div>
                <?php else: ?>
                    <div class="fl up-center gy" id="room-hot">
                        <a href="<?php echo U('RoomAnalysis/index', array('info' => set_search_ids(array('p' => $project_id))));?>">
                            <div style="height:25px;margin-top: 4px;line-height: 25px;color: #999999">房源热度</div>
                        </a>
                    </div>
                    <div class="fl up-center bl" id="room-img">
                        <a href="<?php echo U('RoomAnalysis/index', array('info' => set_search_ids(array('p' => $project_id)),'is_fx' => 1 ));?>">
                            <div style="height:25px;margin-top: 4px;line-height: 25px;color: #03A9F4">装户统计</div>
                        </a>
                    </div><?php endif; ?>
            </div>
                <!--开启滚动条添加id="unit_s"-->
            <?php if($is_fx == 0): ?><div class="fl"  id="unit_s" style="width:calc(100% - 50px);overflow: hidden;margin-top: 78px;white-space: nowrap;padding:4px 0 0 0;z-index: 100;position: absolute;background: #FFF;">
                        <?php $project_num = 1; ?>
                        <?php if(is_array($builds)): $builds_k = 0; $__LIST__ = $builds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$builds_vo): $mod = ($builds_k % 2 );++$builds_k; if(is_array($new_units[$builds_vo['id']])): $units_k = 0; $__LIST__ = $new_units[$builds_vo['id']];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$units_vo): $mod = ($units_k % 2 );++$units_k; if(($builds_vo['id'] == $search_build_id) AND ($units_vo['unit'] == $search_unit_id)): ?><div class="saler-project-view-header-unit-info saler-project-view-header-unit-info-selected" style="display: inline-block">
                                            <a href="<?php echo U('RoomAnalysis/index', array('info' => set_search_ids(array('p' => $project_id, 'b' => $builds_vo['id'], 'u' => $units_vo['unit']))));?>">
                                                <?php echo ($builds_vo[ 'buildname']); if($units_vo['unit'] != 0): echo ($units_vo[ 'unit']); ?>单元<?php endif; ?>
                                            </a>
                                        </div>
                                        <?php else: ?>
                                        <div class=" saler-project-view-header-unit-info" style="display: inline-block">
                                            <a href="<?php echo U('RoomAnalysis/index', array('info' => set_search_ids(array('p' => $project_id, 'b' => $builds_vo['id'], 'u' => $units_vo['unit']))));?>">
                                                <?php echo ($builds_vo[ 'buildname']); if($units_vo['unit'] != 0): echo ($units_vo[ 'unit']); ?>单元<?php endif; ?>
                                            </a>
                                        </div><?php endif; ?>
                                <?php $project_num++; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <?php if($project_num > 4): ?><button id="show-gd" ><i class="fa fa-angle-double-down" aria-hidden="true" style="font-size:15px;"></i></button><?php endif; endif; ?>
        </div>
    </div>

		
    <div class="saler-project-view-base saler-project-id" data-project-id="<?php echo ((isset($project['id']) && ($project['id'] !== ""))?($project['id']):0); ?>" data-build-id="<?php echo ((isset($search_build_id) && ($search_build_id !== ""))?($search_build_id):0); ?>" data-unit-id="<?php echo ((isset($search_unit_id) && ($search_unit_id !== ""))?($search_unit_id):0); ?>">
        <div class="saler-project-view-content-wrapper">
            <div class="saler-project-view-content">

                    <div class="clearfix saler-project-view-content-tabs" style="margin-top: 95px;">

                        </div>
                <?php if($is_fx == 0): ?><div id="iscroller-wrapper" class="saler-project-view-content-rooms iscroller-rooms iscroller-style"  style="top: 112px;">
                    <?php else: ?>
                    <div id="iscroller-wrapper" class="saler-project-view-content-rooms iscroller-rooms iscroller-style" style="top: 80px;"><?php endif; ?>
                                    <div id="iscroller-scroller" class="saler-project-view-content-rooms-box iscroller-rooms-scroller iscroller-scroller-style">
                                        <div id="pullDown" style="display:none;">
                                            <span class="clearfix pull-down-box">
                                                <span class="pullDownIcon"></span>
                                                <span class="pullDownLabel">下拉刷新...</span>
                                            </span>
                                        </div>
                                        <div class="wm100" id="img-html">
                                            <?php if($is_fx == 0): ?><table class="saler-project-view-content-rooms-table">
                                                <?php if(is_array($floors)): $floors_k = 0; $__LIST__ = $floors;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$floors_vo): $mod = ($floors_k % 2 );++$floors_k;?><tr>
                                                        <td class="saler-project-view-content-rooms-floor">
                                                            <?php echo ((isset($floors_vo["floor"]) && ($floors_vo["floor"] !== ""))?($floors_vo["floor"]):"1"); ?>F
                                                        </td>
                                                        <td class="saler-project-view-content-rooms-room" >
                                                            <div class="saler-project-view-content-rooms-list">
                                                                <ul class="clearfix">

                                                                    <?php if(is_array($rooms[$floors_vo['floor']])): $rooms_k = 0; $__LIST__ = $rooms[$floors_vo['floor']];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rooms_vo): $mod = ($rooms_k % 2 );++$rooms_k; if($rooms_vo["first_count"] >= 3): ?><li class="fl room-li wm25 hot-one">
                                                                                <?php elseif($rooms_vo["first_count"] == 2): ?>
                                                                            <li class="fl room-li wm25 hot-two">
                                                                                <?php elseif($rooms_vo["first_count"] == 1): ?>
                                                                            <li class="fl room-li wm25 hot-three">
                                                                                <?php elseif(($rooms_vo["first_count"] == 0) and ($rooms_vo["sc_count"] >= 3)): ?>
                                                                            <li class="fl room-li wm25 hot-four">
                                                                                <?php else: ?>
                                                                            <li class="fl wm25 room-li hot-five"><?php endif; ?>

                                                                        <a href="javascript:;" class="saler-project-view-content-rooms-room-a">
                                                                            <div class="saler-project-view-content-rooms-room-box-one ">
                                                                                <div class="saler-project-view-content-rooms-room-name">
                                                                                    <?php echo ($rooms_vo[ 'room']); ?>
                                                                                </div>
                                                                                <div class="saler-project-view-content-rooms-room-area">
                                                                                    <div style="float:left;width:50%"><i class="fa fa-heart-o"></i> <?php echo ($rooms_vo[ 'sc_count']); ?></div>
                                                                                    <div style="float:right;width:50%;text-align:right;">① <?php echo ($rooms_vo[ 'first_count']); ?><div>
                                                                                </div>
                                                                            </div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                        </li><?php endforeach; endif; else: echo "" ;endif; ?>

                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </table>
                                                <?php else: ?>

                                                <h1 style="font-size: 16px;background-color: #FFF;padding: 5px;letter-spacing: 1px">
                                                    <div style="position: absolute;right: 10px;z-index: 99999;font-size: 12px;font-weight: 400;">
                                                        <i class="fa fa-stop" style="color:rgba(255, 188, 23, 0.69);"></i>房源  <i class="fa fa-stop" style="margin-left: 5px;color:rgba(255, 67, 52, 0.69);"></i>收藏
                                                    </div>
                                                    <span style="padding: 0 2px;background: #ff7d73;margin-right: 10px;"> </span>
                                                    楼栋动态供需单
                                                </h1>
                                                <div id="container-build" style="min-width:100%;height:200px;margin-bottom: 10px;"></div>
                                                <h1 class="fl wm100" style="font-size: 16px;background-color:#FFF;padding: 5px;letter-spacing: 1px">
                                                    <span style="padding: 0 2px;background: #ff7d73;margin-right: 10px;"> </span>
                                                    户型动态供需单
                                                    <select  id="build-list" class="fr">
                                                        <option value="">全部</option>
                                                        <?php if(is_array($group_room_build)): $k = 0; $__LIST__ = $group_room_build;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><option value="<?php echo ($vo['bld_id']); ?>"><?php echo ($vo['buildname']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </select>
                                                </h1>
                                                <div id="container-hx" style="min-width:100%;height:200px;margin-bottom: 10px;"></div>
                                                <h1 style="font-size: 16px;background-color: #FFF;margin-top: 45px;padding: 5px;letter-spacing: 1px">
                                                    <span style="padding: 0 2px;background: #ff7d73;margin-right: 10px;"> </span>意向热度统计</h1>
                                                <div class="wm100" id="imgPage" style="background-color: #fff">
                                                    <div id="container" class="fl wm50" style="height:150px"></div>
                                                    <div id="explain" class="fl wm50" style="height:150px;background-color: #FFF">
                                                        <table class="wm100" style="height: 100%;">
                                                            <tr>
                                                                <td class="wm30">
                                                                    <span class="hot-one-span"></span> 高
                                                                </td>
                                                                <td class="wm70"><?php echo ($hot_count["hot_one"]["num"]); ?>套 <?php echo ($hot_count["hot_one"]["zb"]); ?>%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="wm30">
                                                                    <span class="hot-two-span"></span> 中高
                                                                </td>
                                                                <td class="wm70"> <?php echo ($hot_count["hot_two"]["num"]); ?>套 <?php echo ($hot_count["hot_two"]["zb"]); ?>%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="wm30">
                                                                    <span class="hot-three-span"></span> 中
                                                                </td>
                                                                <td class="wm70"><?php echo ($hot_count["hot_three"]["num"]); ?>套 <?php echo ($hot_count["hot_three"]["zb"]); ?>%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="wm30">
                                                                    <span class="hot-four-span"></span> 中低
                                                                </td>
                                                                <td class="wm70"><?php echo ($hot_count["hot_four"]["num"]); ?>套 <?php echo ($hot_count["hot_four"]["zb"]); ?>%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="wm30">
                                                                    <span class="hot-five-span"></span> 低
                                                                </td>
                                                                <td class="wm70"><?php echo ($hot_count["hot_five"]["num"]); ?>套 <?php echo ($hot_count["hot_five"]["zb"]); ?>%</td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                </div>

                                                <script>
                                                    //    var chart = null;//用于环形图中间标题显示
                                                    $(function () {
                                                        //房源热度饼图
                                                        $('#container').highcharts({
                                                            colors: "rgba(255, 67, 52, 0.69);rgba(255, 159, 98, 0.69);rgba(255,188,23,0.69);rgba(45,202,94,0.53); #6aba6e".split(";"),
                                                            credits:{
                                                                enabled: 0//是否显示右下角的超链接
                                                            },
                                                            exporting:{
                                                                enabled:false //用来设置是否显示‘打印’,'导出'等功能按钮，不设置时默认为显示
                                                            },
                                                            chart: {
                                                                type:'pie',
                                                                spacing: [0, 0, 0, 0],//设置图形上下左右的距离
                                                                options3d: {
                                                                    enabled: false,//打开3D
                                                                    alpha: 25//立体高度
                                                                }
                                                            },
                                                            title: {
                                                                floating:true,
                                                                text: '',
                                                                style:{fontSize:'10px'}
                                                            },

                                                            tooltip: {
                                                                enabled: 1,//关闭点击图形弹出的小框
//                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                                            },
                                                            plotOptions: {
                                                                pie: {
                                                                    depth: 25,//立体高度
                                                                    allowPointSelect: true,
                                                                    cursor: 'pointer',
                                                                    dataLabels: {
                                                                        enabled: false,//关闭图形的线条和文字提示
//                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
//                        style: {
//                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
//                        }
                                                                    },
                                                                    point: {
                                                                        events: {
//                            click: function(e) { // 点击图形改变中途title的值
//                                chart.setTitle({
//                                    text: e.point.name+ '\t'+ e.point.y + ' %'
//                                });
//                            }
                                                                        }
                                                                    },
                                                                }
                                                            },

                                                            series: [{
                                                                type: 'pie',
                                                                innerSize: '0%',//中间区域占比大小
                                                                name: '占比',
                                                                data: [
                                                                    {
                                                                        name:'高',
                                                                        y:<?php echo ($hot_count["hot_one"]["zb"]); ?>,
                                                                    sliced: true,
                                                            selected: true
                                                    },
                                                        ['中高',<?php echo ($hot_count["hot_two"]["zb"]); ?>],
                                                        {name: '中', y: <?php echo ($hot_count["hot_three"]["zb"]); ?>},
                                                        ['中低',    <?php echo ($hot_count["hot_four"]["zb"]); ?>],
                                                        {
                                                            name:'低',
                                                                y: <?php echo ($hot_count["hot_five"]["zb"]); ?>
                                                        }
                                                        ]
                                                    }]
                                                    }, function(c) {
                                                            var s = c.series[0],
                                                                points = s.points,
                                                                lastPoint = points[0];
                                                            c.tooltip.shared = false;
                                                            c.tooltip.refresh(lastPoint);
                                                        });
                                                        //楼栋下房间收藏柱状图
                                                        $('#container-build').highcharts({
                                                            colors: "rgba(255,188,23,0.69);rgba(255, 67, 52, 0.69)".split(";"),
                                                            credits:{
                                                                enabled: 0//是否显示右下角的超链接
                                                            },
                                                            chart: {
                                                                type: 'column'
                                                            },
                                                            title: {
                                                                text: ''
                                                            },
                                                            exporting:{
                                                                enabled:false //用来设置是否显示‘打印’,'导出'等功能按钮，不设置时默认为显示
                                                            },
                                                            xAxis: {
                                                                categories: <?php echo json_encode($arr_name);?>,
                                                        crosshair: true
                                                    },
                                                        yAxis: {//左侧提示标题
                                                            min: 0,
                                                                title: {
                                                                text: ''
                                                            }
                                                        },
                                                        tooltip: {
                                                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                                            '<td style="padding:0"><b>{point.y:1f} </b></td></tr>',
                                                                footerFormat: '</table>',
                                                                shared: true,
                                                                useHTML: true
                                                        },
                                                        plotOptions: {
                                                            column: {
                                                                borderWidth: 0,
                                                                    dataLabels:{
                                                                    enabled:true, // dataLabels设为true
                                                                }
                                                            }
                                                        },
                                                        series: [{
                                                            name: '房源',
                                                            data: <?php echo json_encode($arr_room_count);?>
                                                    }, {
                                                            name: '收藏',
                                                                data:  <?php echo json_encode($arr_sc_count);?> //直接放数组是不行的，必须转成json格式
                                                        }],
                                                        legend: {
                                                            enabled: false
                                                        }
                                                    });
                                                        //户型分组柱状图
                                                        $('#container-hx').highcharts({
                                                            colors: "rgba(255,188,23,0.69);rgba(255, 67, 52, 0.69)".split(";"),
                                                            credits:{
                                                                enabled: 0//是否显示右下角的超链接
                                                            },
                                                            chart: {
                                                                type: 'column'
                                                            },
                                                            title: {
                                                                text: ''
                                                            },
                                                            exporting:{
                                                                enabled:false //用来设置是否显示‘打印’,'导出'等功能按钮，不设置时默认为显示
                                                            },
                                                            xAxis: {
                                                                categories: <?php echo json_encode($hx_name);?>,
                                                        crosshair: true
                                                    },
                                                        yAxis: {//左侧提示标题
                                                            min: 0,
                                                                title: {
                                                                text: ''
                                                            }
                                                        },
                                                        tooltip: {
                                                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                                            '<td style="padding:0"><b>{point.y:1f} </b></td></tr>',
                                                                footerFormat: '</table>',
                                                                shared: true,
                                                                useHTML: true
                                                        },
                                                        plotOptions: {
                                                            column: {
                                                                borderWidth: 0,
                                                                    dataLabels:{
                                                                    enabled:true, // dataLabels设为true
                                                                }
                                                            }
                                                        },
                                                        series: [{
                                                            name: '房源',
                                                            data: <?php echo json_encode($hx_room_count);?>
                                                    }, {
                                                            name: '收藏',
                                                                data:  <?php echo json_encode($hx_sc_count);?> //直接放数组是不行的，必须转成json格式
                                                        }],
                                                        legend: {
                                                            enabled: false
                                                        }
                                                    });
                                                    });

                                                </script><?php endif; ?>
                                        </div>

                                        <div class="block60 room-bottom-block" style="display:none;"></div>
                                    </div>
                                </div>

    <div class="weui-tabbar1">
        <a href="<?php echo U('DataStatistics/index', array('info' => set_search_ids(array('p' => $project_id))));?>" class="weui-tabbar__item1">
                            <span style="display: inline-block;position: relative;">
                                <i class="fa fa-home weui-tabbar__icon1"></i>
                            </span>
            <p class="weui-tabbar__label1">首页</p>
        </a>
        <a href="<?php echo U('ChooseAnalysis/index', array('info' => set_search_ids(array('p' => $project_id))));?>" class="weui-tabbar__item1 ">
                            <span style="display: inline-block;position: relative;">
                                    <i class="fa fa-group weui-tabbar__icon1"></i>
                            </span>
            <p class="weui-tabbar__label1">客户分析</p>
        </a>
        <a href="javascript:;" class="weui-tabbar__item1 weui-bar__item_on1">
							<span style="display: inline-block;position: relative;">
								<i class="fa fa-bar-chart weui-tabbar__icon1"></i>
							</span>
            <p class="weui-tabbar__label1">装户分析</p>
        </a>
        <a href="<?php echo U('MyReport/index', array('info' => set_search_ids(array('p' => $project_id))));?>" class="weui-tabbar__item1">
                            <span style="display: inline-block;position: relative;">
                                <i class="fa fa-user-circle-o weui-tabbar__icon1"></i>
                                <span class="weui-badge weui-badge_dot" style="position: absolute;top: 2px;right: 0px;display:none;"></span>
                            </span>
            <p class="weui-tabbar__label1">我的</p>
        </a>
    </div>
    </div>
                    </div>
            </div>
            
                
		
                
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
                
		

                <link href="/Public/common/js/jquery/iscroll/iscroll.css" type="text/css" rel="stylesheet" />
                <script src="/Public/common/js/jquery/iscroll/iscroll.js"></script>
                <script>


                    //下拉框change事件
                    $(document).on('change',"#build-list",function () {
                        var val=$(this).val();
                        $.post("<?php echo U('/Saler/RoomAnalysis/getHxCount');?>",{'hd_id':"<?php echo ($project_id); ?>",'vo':val},function (data) {
                            $('#container-hx').highcharts({
                                colors: "rgba(255,188,23,0.69);rgba(255, 67, 52, 0.69)".split(";"),
                                credits:{
                                    enabled: 0//是否显示右下角的超链接
                                },
                                chart: {
                                    type: 'column'
                                },
                                title: {
                                    text: ''
                                },
                                exporting:{
                                    enabled:false //用来设置是否显示‘打印’,'导出'等功能按钮，不设置时默认为显示
                                },
                                xAxis: {
                                    categories:data[0] ,
                                    crosshair: true
                        },
                            yAxis: {//左侧提示标题
                                min: 0,
                                    title: {
                                    text: ''
                                }
                            },
                            tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:1f} </b></td></tr>',
                                    footerFormat: '</table>',
                                    shared: true,
                                    useHTML: true
                            },
                            plotOptions: {
                                column: {
                                    borderWidth: 0,
                                    dataLabels:{
                                        enabled:true, // dataLabels设为true
                                    }
                                }
                            },
                            series: [{
                                name: '房源',
                                data:data[1]
                        }, {
                                name: '收藏',
                                data:data[2]   //直接放数组是不行的，必须转成json格式
                            }]
                        });
                        },'json');
                    });
                    //显示更多楼栋
                    $("#show-gd").on("click",function () {
                        $("#shadow-list").show();
                        $(".hidden-list").show();
                    });
                    //关闭更多楼栋
                    $("#shadow-list").on("click",function () {
                        $("#shadow-list").hide();
                        $(".hidden-list").hide();
                    });
                    $(function () {
                        if (window.location.hash.length > 1) {
                            $(".js-saler-project-view-content-search-compare-btn").trigger("click");
                        }
                        //滚动条设置
//                        $("#unit_s .saler-project-view-header-unit-info-selected").perfectScrollbar('update');
                        <?php if($is_fx == 0): ?>var uts=$("#unit_s");
                        if((parseFloat($("#unit_s .saler-project-view-header-unit-info-selected").offset().left)+parseFloat($("#unit_s .saler-project-view-header-unit-info-selected").width()))>= parseFloat(uts.width())){
                            $("#unit_s").perfectScrollbar();
                            $("#unit_s").scrollLeft(parseFloat($("#unit_s .saler-project-view-header-unit-info-selected").offset().left));
                            $("#unit_s").perfectScrollbar('update');
                        }else{
                            $("#unit_s").perfectScrollbar();
                        }<?php endif; ?>
                    });
                    var iscroller_project,
                            pullDownEl,
                            pullDownOffset,
                            loadingStep = 0;

                    function loaded() {
                        pullDownEl = document.getElementById('pullDown');
                        pullDownOffset = pullDownEl.offsetHeight;
                        setTimeout(function () {
                            iscroller_project = new iScroll("iscroller-wrapper", {
                                bounce: true,
                                checkDOMChanges: true,
                                onBeforeScrollStart: function (e) {
                                    var target = e.target;
                                    while (target.nodeType != 1) {
                                        target = target.parentNode;
                                    }
                                    if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA') {
                                        e.preventDefault();
                                    }
                                },
                            });
                        }, 100);
                        setTimeout(function () {
                            document.getElementById('iscroller-wrapper').style.left = '0';
                            pullDownEl.style.display = 'none';
                        }, 200);
                    }
                    /**
                     * 下拉刷新 （自定义实现此方法）
                     * iscroller_project.refresh();      
                     * // 数据加载完成后，调用界面更新方法
                     */
                    function pullDownAction() {
                        setTimeout(function () {

                            window.location.reload();
                        }, 1000);
                    }
                    document.addEventListener('touchmove', function (e) {
                        e.preventDefault();
                    }, false);
                    document.addEventListener('DOMContentLoaded', function () {
                        setTimeout(loaded, 200);
                    }, false);
                </script>

            
	</body>
	
</html>