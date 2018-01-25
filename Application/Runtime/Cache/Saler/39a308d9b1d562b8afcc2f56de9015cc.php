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
    <style>
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
            top:86px;
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
        <div class="fl wm100 hidden-list"  >
            <?php if(is_array($builds)): $builds_k = 0; $__LIST__ = $builds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$builds_vo): $mod = ($builds_k % 2 );++$builds_k; if(is_array($new_units[$builds_vo['id']])): $units_k = 0; $__LIST__ = $new_units[$builds_vo['id']];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$units_vo): $mod = ($units_k % 2 );++$units_k; if(($builds_vo['id'] == $search_build_id) AND ($units_vo['unit'] == $search_unit_id)): ?><div class="saler-project-view-header-unit-info saler-project-view-header-unit-info-selected fl" style="display: inline-block">
                                <a class="morea" href="<?php echo U('project/index', array('info' => set_search_ids(array('p' => $search_project_id, 'b' => $builds_vo['id'], 'u' => $units_vo['unit']))));?>">
                                    <?php echo ($builds_vo[ 'buildname']); if($units_vo['unit'] != 0): echo ($units_vo[ 'unit']); ?>单元<?php endif; ?>
                                </a>
                            </div>
                            <?php else: ?>
                            <div class=" saler-project-view-header-unit-info fl" style="display: inline-block">
                                <a class="morea" href="<?php echo U('project/index', array('info' => set_search_ids(array('p' => $search_project_id, 'b' => $builds_vo['id'], 'u' => $units_vo['unit']))));?>">
                                    <?php echo ($builds_vo[ 'buildname']); if($units_vo['unit'] != 0): echo ($units_vo[ 'unit']); ?>单元<?php endif; ?>
                                </a>
                            </div><?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
        </div>
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
                <div class="fl up-center bl" id="room-xk">
                    <a href="<?php echo U('Project/index', array('info' => set_search_ids(array('p' => $search_hd_id))));?>">
                        <div style="height:25px;margin-top: 4px;line-height: 25px;color: #03A9F4!important;">房源销控</div>
                    </a>
                </div>
                <div class="fl up-center gy" id="room-hot">
                    <a href="<?php echo U('RoomAnalysis/index', array('info' => set_search_ids(array('p' => $search_hd_id))));?>">
                        <div style="height:25px;margin-top: 4px;line-height: 25px;color: #999999">房源热度</div>
                    </a>
                </div>
                <div class="fl up-center gy" id="room-img">
                    <a href="<?php echo U('RoomAnalysis/index', array('info' => set_search_ids(array('p' => $search_hd_id)),'is_fx' => 1 ));?>">
                        <div style="height:25px;margin-top: 4px;line-height: 25px;color: #999999">装户统计</div>
                    </a>
                </div>

            </div>
                <!--开启滚动条添加id="unit_s"-->
                <div class="fl " id="unit_s" style="width: calc(100% - 50px);overflow: hidden;margin-top: 78px;white-space: nowrap;padding:4px 0 0;z-index: 100;position: absolute;background: #FFF;">
                        <?php $project_num = 1; ?>
                        <?php if(is_array($builds)): $builds_k = 0; $__LIST__ = $builds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$builds_vo): $mod = ($builds_k % 2 );++$builds_k; if(is_array($new_units[$builds_vo['id']])): $units_k = 0; $__LIST__ = $new_units[$builds_vo['id']];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$units_vo): $mod = ($units_k % 2 );++$units_k; if(($builds_vo['id'] == $search_build_id) AND ($units_vo['unit'] == $search_unit_id)): ?><div class="saler-project-view-header-unit-info saler-project-view-header-unit-info-selected" style="display: inline-block">
                                            <a href="<?php echo U('project/index', array('info' => set_search_ids(array('p' => $search_hd_id, 'b' => $builds_vo['id'], 'u' => $units_vo['unit']))));?>">
                                                <?php echo ($builds_vo[ 'buildname']); if($units_vo['unit'] != 0): echo ($units_vo[ 'unit']); ?>单元<?php endif; ?>
                                            </a>
                                        </div>
                                        <?php else: ?>
                                        <div class=" saler-project-view-header-unit-info" style="display: inline-block">
                                            <a href="<?php echo U('project/index', array('info' => set_search_ids(array('p' => $search_hd_id, 'b' => $builds_vo['id'], 'u' => $units_vo['unit']))));?>">
                                                <?php echo ($builds_vo[ 'buildname']); if($units_vo['unit'] != 0): echo ($units_vo[ 'unit']); ?>单元<?php endif; ?>
                                            </a>
                                        </div><?php endif; ?>
                                <?php $project_num++; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                </div>
             <?php if($project_num > 4): ?><button id="show-gd" ><i class="fa fa-angle-double-down" aria-hidden="true" style="font-size:15px;"></i></button><?php endif; ?>
        </div>
    </div>

		
    <div class="saler-project-view-base saler-project-id" data-project-id="<?php echo ((isset($search_hd_id) && ($search_hd_id !== ""))?($search_hd_id):0); ?>" data-build-id="<?php echo ((isset($search_build_id) && ($search_build_id !== ""))?($search_build_id):0); ?>" data-unit-id="<?php echo ((isset($search_unit_id) && ($search_unit_id !== ""))?($search_unit_id):0); ?>">
        <div class="saler-project-view-content-wrapper">
            <div class="saler-project-view-content">
                    <div class="clearfix saler-project-view-content-tabs" style="margin-top: 115px;">
                        <div class="clearfix saler-project-view-content-search" style="padding: 5px 5px;">
                            <div class="fl wm100 saler-project-view-content-search-box" >
                                <input class="fr border-sizing saler-project-view-content-search-input" type="text" value="" placeholder="搜索" style="width: calc(100% - 58px);display: inline;height: 30px;margin-top: 2px;margin-left: 5px">
                                <button  class="fl weui-tabbar__item js-saler-project-view-content-search-compare-btn" style="min-width: 53px;height: 30px;margin-top: 2px;">
                                    <span class="weui-tabbar__label" style="font-size:11px;"><i class="fa fa-star-half-full weui-tabbar__icon" style="width: auto;font-size: 14px;"></i>对比</span>
                                </button>
                            </div>

                        </div>


                            <div id="iscroller-wrapper" class="saler-project-view-content-rooms iscroller-rooms iscroller-style" style="top: 155px;">
                                    <div id="iscroller-scroller" class="saler-project-view-content-rooms-box iscroller-rooms-scroller iscroller-scroller-style">
                                        <div id="pullDown" style="display:none;">
                                            <span class="clearfix pull-down-box">
                                                <span class="pullDownIcon"></span>
                                                <span class="pullDownLabel">下拉刷新...</span>
                                            </span>
                                        </div>

                                        <table class="saler-project-view-content-rooms-table">
                                            <?php if(is_array($floors)): $floors_k = 0; $__LIST__ = $floors;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$floors_vo): $mod = ($floors_k % 2 );++$floors_k;?><tr>
                                                    <td class="saler-project-view-content-rooms-floor" data-floor-id="<?php echo ((isset($floors_vo["floor"]) && ($floors_vo["floor"] !== ""))?($floors_vo["floor"]):" 1 "); ?>">
                                                        <?php echo ((isset($floors_vo["floor"]) && ($floors_vo["floor"] !== ""))?($floors_vo["floor"]):"1"); ?>F
                                                    </td>
                                                    <td class="saler-project-view-content-rooms-room" data-floor-id="<?php echo ((isset($floors_vo["floor"]) && ($floors_vo["floor"] !== ""))?($floors_vo["floor"]):" 1 "); ?>">
                                                        <div class="saler-project-view-content-rooms-list">
                                                            <ul class="clearfix">
                                                                <?php if(is_array($rooms[$floors_vo['floor']])): $rooms_k = 0; $__LIST__ = $rooms[$floors_vo['floor']];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rooms_vo): $mod = ($rooms_k % 2 );++$rooms_k;?><li class="fl wm25">
                                                                        <a href="<?php echo U('room/index', array('id' => $rooms_vo['id'],'hid' => $search_hd_id));?>" class="saler-project-view-content-rooms-room-a">
                                                                            <?php if(!empty($rooms_vo['djcount'])): ?><i class="saler-project-hot"></i><?php endif; ?>
                                                                            <div class="saler-project-view-content-rooms-room-box <?php if( $rooms_vo[ 'is_xf'] == 1 ): ?>saler-project-view-content-rooms-room-box-selected<?php endif; ?>">
                                                                                <div class="saler-project-view-content-rooms-room-name">
                                                                                    <?php echo ($rooms_vo[ 'room']); ?>
                                                                                </div>
                                                                                <div class="saler-project-view-content-rooms-room-area">
                                                                                    <?php echo ((isset($rooms_vo[ 'area']) && ($rooms_vo[ 'area'] !== ""))?($rooms_vo[ 'area']):'0'); ?>㎡
                                                                                </div>
                                                                                <div class="saler-project-view-content-rooms-room-cost">
                                                                                    ¥<?php echo number_format($rooms_vo[ 'total'],2,".",""); ?>
                                                                                </div>
                                                                            </div>
                                                                        </a>

                                                                        <div data-room-id="<?php echo ((isset($rooms_vo['id']) && ($rooms_vo['id'] !== ""))?($rooms_vo['id']):'1'); ?>" class="saler-project-view-content-rooms-room-box-shadow js-saler-project-view-content-rooms-room-box-shadow">
                                                                            <div class="saler-project-view-content-rooms-room-box-shadow-info">
                                                                                <span class="saler-project-view-content-rooms-room-box-shadow-info-select">
                                                                                    <input class="saler-project-view-content-rooms-room-select js-saler-project-view-content-rooms-room-box-shadow saler-project-view-content-rooms-room-select-<?php echo ((isset($rooms_vo['id']) && ($rooms_vo['id'] !== ""))?($rooms_vo['id']):'1'); ?>" data-room-id="<?php echo ((isset($rooms_vo['id']) && ($rooms_vo['id'] !== ""))?($rooms_vo['id']):'1'); ?>" type="checkbox" value="1">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>

                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </table>

                                        <div class="block60 room-bottom-block" style="display:none;"></div>
                                    </div>
                                </div>

                                <div class="saler-project-view-content-selected-wrapper js-saler-project-view-content-selected-wrapper">
                                    <div class="saler-project-view-content-selected">
                                        <div class="saler-project-view-content-selected-info">
                                            <div class="saler-project-view-content-selected-num-wrapper">
                                                <span class="saler-project-view-content-selected-num">
                                                    0
                                                </span>
                                            </div>
                                            <div class="saler-project-view-content-selected-contrasts-wrapper">
                                                <div pid="<?php echo ($search_project_id); ?>" class="saler-project-view-content-selected-contrasts js-saler-project-view-content-selected-compare">
                                                    <span class="saler-project-view-content-selected-contrasts-btn">
                                                        开始对比
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            <div class="weui-tabbar1">
                <a href="<?php echo U('DataStatistics/index', array('info' => set_search_ids(array('p' => $search_hd_id))));?>" class="weui-tabbar__item1">
                            <span style="display: inline-block;position: relative;">
                                <i class="fa fa-home weui-tabbar__icon1"></i>
                            </span>
                    <p class="weui-tabbar__label1">首页</p>
                </a>
                <a href="<?php echo U('ChooseAnalysis/index', array('info' => set_search_ids(array('p' => $search_hd_id))));?>" class="weui-tabbar__item1 ">
                            <span style="display: inline-block;position: relative;">
                                    <i class="fa fa-group weui-tabbar__icon1"></i>
                            </span>
                    <p class="weui-tabbar__label1">客户分析</p>
                </a>
                <a href="<?php echo U('RoomAnalysis/index', array('info' => set_search_ids(array('p' => $search_hd_id))));?>" class="weui-tabbar__item1">
							<span style="display: inline-block;position: relative;">
								<i class="fa fa-bar-chart weui-tabbar__icon1"></i>
							</span>
                    <p class="weui-tabbar__label1">装户分析</p>
                </a>
                <a href="<?php echo U('MyReport/index', array('info' => set_search_ids(array('p' => $search_hd_id))));?>" class="weui-tabbar__item1 ">
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
                    if (window.name != "bencalie") {
                        location.reload();
                        window.name = "bencalie";
                    } else {
                        window.name = "";
                    }
                    $(function () {
                        if (window.location.hash.length > 1) {
                            $(".js-saler-project-view-content-search-compare-btn").trigger("click");
                        }
                        var uts=$("#unit_s");
                        if((parseFloat($("#unit_s .saler-project-view-header-unit-info-selected").offset().left)+parseFloat($("#unit_s .saler-project-view-header-unit-info-selected").width()))>= parseFloat(uts.width())){
                            $("#unit_s").perfectScrollbar();
                            $("#unit_s").scrollLeft(parseFloat($("#unit_s .saler-project-view-header-unit-info-selected").offset().left));
                            $("#unit_s").perfectScrollbar('update');
                        }else{
                            $("#unit_s").perfectScrollbar();
                        }
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
                                topOffset: pullDownOffset,
                                onRefresh: function () {
                                    if (pullDownEl.className.match('loading')) {
                                        //pullDownEl.className = '';
                                        //pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新...';
                                    }
                                },
                                onScrollMove: function () {
                                    if (this.y > 5 && !pullDownEl.className.match('flip')) {
                                        pullDownEl.style.display = '';
                                        pullDownEl.className = 'flip';
                                        pullDownEl.querySelector('.pullDownLabel').innerHTML = '松手开始更新...';
                                        this.minScrollY = 0;
                                    } else if (this.y < 5 && pullDownEl.className.match('flip')) {
                                        //pullDownEl.style.display = '';
                                        //pullDownEl.className = '';
                                        //pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新...';
                                        //this.minScrollY = -pullDownOffset;
                                    }
                                    loadingStep = 1;
                                },
                                onScrollEnd: function () {
                                    if (loadingStep == 1) {
                                        if (pullDownEl.className.match('flip')) {
                                            pullDownEl.className = 'loading';
                                            pullDownEl.querySelector('.pullDownLabel').innerHTML = '加载中...';
                                            pullDownAction();
                                        }
                                        if (this.y < (this.maxScrollY + 50)) {
                                            pullDownEl.style.display = 'none';
                                        }
                                        loadingStep = 2;
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
                            get_project_room_list(saler_url.project_index);
                            pullDownEl.style.display = 'none';
                            iscroller_project.refresh();
                            loadingStep = 0;
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