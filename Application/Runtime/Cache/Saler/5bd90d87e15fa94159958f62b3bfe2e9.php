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
		
	<link href="/Public/common/js/jquery/circliful/css/jquery.circliful.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/Public/common/css/font-awesome-4.7.0/css/font-awesome.css">
	<script src="/Public/common/js/jquery/circliful/js/jquery.circliful.js"></script>
    <style>
        .saler-statistics-list-box{
                padding: 0 0px 5px 0px;
        }
        .saler-statistics-content-unit-info {
            padding-top: 20px;
        }
        .saler-statistics-content-unit-box {
            position: relative;
            height: 130px;
        }
        .saler-saled-lottery-prize-title-box
        {
            background: #f8f8f8;
        }
        .saler-statistics-content-price-title {
            padding: 15px 5px 20px 5px;
            margin-bottom: 10px;
        }
		#fd{
			color: #fff;
			border-top: 1px solid #fff;
			margin-left: 5%;
		}
		#fd table td{
			height: 30px;
		}
		#gd{
			padding:5px 0 7px;
			width: 90%;
			position: absolute;
			background-color: #FFF;
			margin-left: calc(5% - 3px);
			top:158px;
			color: black;
		}
		#user-info{
			background-color: #FFF;
			margin-top: 8px;
			padding: 10px;
			font-size: 14px;
		}
		#user-info table td{
			background-color: #f8f8f8;
			padding-left:15px;
                        /*text-align: center;*/
		}
		#user-info table{
			margin-top: 5px;
		}
		#user-info table th{
			background-color: #fff;
			width: 5px;
		}
		#user-info table span{
			font-weight: bold;
		}
		#hx-rank{
			background-color: #FFF;
			margin-top: 8px;
			padding: 10px;
		}
		#hx-rank p{
			font-size: 14px;
			margin-bottom: 5px;
		}
		.saler-saled-content-rate-list1 table td{
			/*color: #FFF;*/
		}
		.saler-saled-content-rate-content-title{
			color: #eb5858!important;
		}
		.saler-saled-content-rate-list1{
			/*background-color: #8f74bb;*/
		}
		.saler-saled-content-rate-list2{
			/*background-color: #74bb9e!important;*/
		}
		.saler-saled-content-rate-list2 table td{
			/*color: #FFF;*/
		}
		.saler-saled-content-rate-list3{
			/*background-color: #bb9b74!important;*/
		}
		.saler-saled-content-rate-list3 table td{
			/*color: #FFF;*/
		}
		.saler-saled-content-rate-list4{
			/*background-color: #bb7495!important;*/
		}
		.saler-saled-content-rate-list4 table td{
			/*color: #FFF;*/
		}
		.saler-saled-content-rate-list5{
			/*background-color: #74abbb!important;*/
		}
		.saler-saled-content-rate-list5 table td{
			/*color: #FFF;*/
		}
		#gw-rank{
			background-color: #FFF;
			margin-top: 8px;
			padding: 10px;
		}
		#gw-rank p{
			font-size: 14px;
			margin-bottom: 5px;
		}
                .hxyspmli{
                    border-bottom:1px dashed #ececec;
                }
                .hxyspmli:last-child{
                    border-bottom:0;
                }
                .topcircli .circle-text{
                    color:#FFF;
                    font-size:18px !important;;
                }
                body{
                    color:#515151;
                }
    </style>
	<div class="common-header-wrapper">
		<div class="clearfix common-header sales-statistics-header">
			<div class="fl wm25 arrow-left common-header-return">
				<span class="common-header-return-box return-btn">
					<a href="javascript:void(0);" class="common-header-return-btn">返回</a>
				</span>
			</div>
			<div class="fl wm50 common-header-content js-common-header-content">
				<span class="common-header-content-box-no-arrow">
					<span class="common-header-content-box-name"><?php echo ($projinfo["pname"]); ?></span>
				</span>
			</div>
			<div class="fr wm10 common-header-right" style="padding-top: 3%;">
                                <div class="common-header-reload">
					<a href="" onclick="window.location.reload()" class="saler-project-header-reload-btn js-saler-project-header-reload-btn saler-project-header-reload-a">
						<i class="icon-refresh  bigger-230 " style="color: #c1c1c1;font-size: 18px"></i>
						<!--<img src="/Public/common/img/refresh.png" style="width: 15px;height: 15px">-->
					</a>
				</div>
                        </div>
		</div>
	</div>

		
	<div class="common-content sales-statistics-content">
		<div class="saler-statistics-content-wrapper">
			<div id="iscroller-wrapper" class="iscroller-style saler-statistics-list-wrapper" style="bottom:43px;">
				<div id="iscroller-scroller" class="iscroller-scroller-style" >
					<div class="saler-statistics-list-box" >
						<!--房源状况-->
                                                 <a href="<?php echo U('project/index', array('info' => set_search_ids(array('p' => $search_hd_id))));?>" >
						<div class="clearfix saler-saled-content-rate-list" style="background-color: #26c1df;padding:  5px 0 0 0 ;height: 160px;">
							<p style="margin-left: 5%;color: #fff;font-size:13px;font-weight:500;">推售总房源 <?php echo ($household['zgs']); ?> 套</p>
							<div class="fl wm35 saler-saled-content-rate-img" style=" position: absolute;left: 50%;transform: translate(-50%);">
								<div class="rate-state topcircli"
									 data-dimension="100"
									 data-text="<?php echo ((isset($household["percent"]) && ($household["percent"] !== ""))?($household["percent"]):0); ?>%"
									 data-info=""
									 data-width="10"
									 data-fontsize="14"
									 data-fontcolor="#fff"
									 data-percent="<?php echo ((isset($household["percent"]) && ($household["percent"] !== ""))?($household["percent"]):0); ?>"
									 data-bgcolor="#fff"
									 data-fgcolor="#eb5858"
								>
								</div>
							</div>
							<div class="fl wm65 saler-saled-content-rate-content" style="width:100%;padding-top: 25px;">
								<div class="saler-saled-content-rate-content-table-wrapper">
									<table class="saler-saled-content-rate-table" >
										<tr class="saler-saled-content-rate-tr">
											<th class="wm50 saler-saled-content-rate-td" style="color: #fff;text-align: center;">
												已售
											</th>
											<th class="wm50 saler-saled-content-rate-td" style="color: #fff;text-align: center;">
												未售
											</th>

										</tr>
                                                                                <tr class="saler-saled-content-rate-tr">
											<td class="wm50 saler-saled-content-rate-td" style="color: #fff;text-align: center;font-size:25px;font-weight: 700;">
												<?php echo ((isset($household["selt"]) && ($household["selt"] !== ""))?($household["selt"]):0); ?>
											</td>
											<td class="wm50 saler-saled-content-rate-td" style="color: #fff;text-align: center;font-size:25px;font-weight: 700;">
												<?php echo ($household['zgs']-$household['selt']); ?>
											</td>

										</tr>
									</table>
								</div>
							</div>
							<div class="fl wm90" id="fd" style="position: absolute;margin-top: 100px;">
								<table class="wm100">
									<tr>
										<td align="center" >
                                                                                    <div style="float:left;width:50%;line-height: 18px;text-align: left;">
                                                                                        销售额<br/>
                                                                                        <span style="font-size:16px;"><?php echo number_format($saled_hx['sold_price']*10000);?></span>
                                                                                    </div>
                                                                                    <div style="float:left;width:50%;line-height: 18px;text-align: right;">
                                                                                        总货值<br/>
                                                                                        <span style="font-size:16px;"><?php echo number_format($saled_hx['tatol_price']*1000);?></span>
                                                                                    </div>
                                                                                </td>
									</tr>
								</table>
							</div>
							
						</div>
                                                </a>
						<!--用户选房情况和登录情况-->
						<div class="clearfix saler-saled-content-rate-list" id="user-info">
                                                        <p style="color:#e46c0a;padding-left: 5px;font-size:16px;font-weight: 700;border-bottom: 1px solid #ddd;">
                                                            <i class="fa fa-user" aria-hidden="true"></i>&nbsp;客户状态分布
                                                        </p>
							<table class="wm100">
								<tr style="height: 46px;">
									<td colspan="3" align="center" class="all-user">客户总数<span><?php echo ($user_xf["zrs"]); ?></span>人，选房转化率<span><?php echo round($user_xf['yxf']/$user_xf['zrs']*100,2);?></span>%</td>
								</tr>
								<tr>
									<td colspan="3" style="height: 5px;background-color: #fff"></td>
								</tr>
								<tr>
									<td class="not-login" style="padding-top: 5px" >未登录</td>
									<th></th>
									<td class="login" style="padding-top: 5px" >已登录</td>
								</tr>
								<tr>
									<td class="not-login"><span><?php echo ((isset($user_xf["wdl"]) && ($user_xf["wdl"] !== ""))?($user_xf["wdl"]):'0'); ?>人</span></td>
									<th></th>
									<td class="login"><span><?php echo ((isset($user_xf["ydl"]) && ($user_xf["ydl"] !== ""))?($user_xf["ydl"]):'0'); ?>人</span></td>
								</tr>
								<tr>
									<td colspan="3" style="height: 5px;background-color: #fff"></td>
								</tr>
								<tr >
									<td style="padding-top: 5px" class="login-not-xf">已登录未选</td>
									<th></th>
									<td style="padding-top: 5px" class="login-xf">已登录已选</td>
								</tr>
								<tr>
									<td class="login-not-xf"><span><?php echo ((isset($user_xf["wxf"]) && ($user_xf["wxf"] !== ""))?($user_xf["wxf"]):'0'); ?>人</span></td>
									<th></th>
									<td class="login-xf"><span><?php echo ((isset($user_xf["yxf"]) && ($user_xf["yxf"] !== ""))?($user_xf["yxf"]):'0'); ?>人</span></td>
								</tr>
							</table>
						</div>
						<!--户型销售排名-->
						<div class="clearfix saler-saled-content-rate-list" id="hx-rank">
                                                        <p style="color:#eb5858;padding-left: 5px;font-size:16px;font-weight: 700;border-bottom: 1px solid #ddd;">
							<!--<p style="color: #ffffff;background: #eb5858;">-->
                                                            <i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;房间户型销售排名
                                                        </p>

							<?php if(is_array($rates)): $rates_k = 0; $__LIST__ = $rates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rates_vo): $mod = ($rates_k % 2 );++$rates_k;?><div class="clearfix saler-saled-content-rate-list hxyspmli saler-saled-content-rate-list<?php echo ((isset($rates_k) && ($rates_k !== ""))?($rates_k):1); ?>">
									<div class="fl wm35 saler-saled-content-rate-img">
										<div class="rate-state saler-saled-content-rate-state"
											 data-dimension="100"
											 data-text="<?php echo ((isset($rates_vo["percent"]) && ($rates_vo["percent"] !== ""))?($rates_vo["percent"]):100); ?>%"
											 data-info=""
											 data-width="10"
											 data-fontsize="14"
											 data-percent="<?php echo ((isset($rates_vo["percent"]) && ($rates_vo["percent"] !== ""))?($rates_vo["percent"]):100); ?>"
											 data-bgcolor="#ddd"
											 data-fgcolor="#eb5858"
										>
										</div>
									</div>
									<div class="fl wm65 saler-saled-content-rate-content">
										<div class="saler-saled-content-rate-content-title">
											户型：<?php echo ((isset($rates_vo["hx"]) && ($rates_vo["hx"] !== ""))?($rates_vo["hx"]):'户型'); ?>
										</div>
										<div class="saler-saled-content-rate-content-table-wrapper">
											<table class="saler-saled-content-rate-table">
												<tr class="saler-saled-content-rate-tr">
													<td class="wm20 saler-saled-content-rate-td">
														已售
													</td>
													<td class="saler-saled-content-rate-td">
														<?php echo ((isset($rates_vo["saled_total"]) && ($rates_vo["saled_total"] !== ""))?($rates_vo["saled_total"]):'0'); ?>套(<?php echo ((isset($rates_vo["saled_price"]) && ($rates_vo["saled_price"] !== ""))?($rates_vo["saled_price"]):'0'); ?>万)
													</td>

												</tr>
												<tr class="saler-saled-content-rate-tr">
													<td class="wm20 saler-saled-content-rate-td">
														待售
													</td>
													<td class="saler-saled-content-rate-td">
														<?php echo ((isset($rates_vo["nosaled_total"]) && ($rates_vo["nosaled_total"] !== ""))?($rates_vo["nosaled_total"]):'0'); ?>套(<?php echo ((isset($rates_vo["nosaled_price"]) && ($rates_vo["nosaled_price"] !== ""))?($rates_vo["nosaled_price"]):'0'); ?>万)
													</td>
												</tr>
											</table>
										</div>
									</div>
								</div><?php endforeach; endif; else: echo "" ;endif; ?>

						</div>
						<!--置业顾问销售排名，根据权限判断是否显示-->
						<?php if($res != null): ?><div class="clearfix saler-saled-content-rate-list" id="gw-rank">
                                                                <p style="padding-left: 5px;font-size:16px;font-weight: 700;border-bottom: 1px solid #ddd;">
                                                                    <i class="fa fa fa-id-badge" aria-hidden="true"></i>&nbsp;置业顾问销售排名
                                                                </p>
								<?php if(is_array($res)): $prizes_k = 0; $__LIST__ = $res;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($prizes_k % 2 );++$prizes_k;?><div class="saler-saled-lottery-prizes-list saler-saled-lottery-prizes-list<?php if(($prizes_k) <= "5"): echo ($prizes_k); else: echo ($prizes_k-5); endif; ?>">
										<div class="saler-saled-lottery-prize">
											<div class="saler-saled-lottery-prize-title">
												<div class="saler-saled-lottery-prize-title-box">
										<span class="saler-saled-lottery-prize-title-square">
											<span class="saler-saled-lottery-prize-title-square-info"></span>
										</span>
													<span class="saler-saled-lottery-prize-title-info">
										<?php if($val["czusername"] == '()'): ?>其他
											<?php else: ?>
											<?php echo ($val["czusername"]); endif; ?>

										</span>
												</div>
											</div>
											<div class="clearfix saler-saled-lottery-prize-content">
												<div class="fl wm32 saler-saled-lottery-prize-jackpot">
													<div class="saler-saled-lottery-prize-content-title saler-saled-lottery-prize-jackpot-title">
														套数
													</div>
													<div class="saler-saled-lottery-prize-content-info saler-saled-lottery-prize-jackpot-info">
														<?php echo ($val["cou"]); ?>
													</div>
												</div>
												<div class="fl wm36 saler-saled-lottery-prize-send">
													<div class="saler-saled-lottery-prize-content-title saler-saled-lottery-prize-send-title">
														金额（万）
													</div>
													<div class="saler-saled-lottery-prize-content-info saler-saled-lottery-prize-send-info">
														<?php echo ($val["mon"]); ?>
													</div>
												</div>
												<div class="fl wm32 saler-saled-lottery-prize-residual">
													<div class="saler-saled-lottery-prize-content-title saler-saled-lottery-prize-residual-title">
														销售占比
													</div>
													<div class="saler-saled-lottery-prize-content-info saler-saled-lottery-prize-residual-info">
														<?php echo round(($val['cou']/$ct)*100,2)."%"; ?>
													</div>
												</div>
											</div>
										</div>
									</div><?php endforeach; endif; else: echo "" ;endif; ?>
							</div><?php endif; ?>

					</div>

				</div>
			</div>

		</div>
	</div>

                
                    <div class="weui-tabbar1">
                        <a href="<?php echo U('statistics/index', array('info' => set_search_ids(array('p' => $project_id))));?>" class="weui-tabbar__item1 btnsy">
                            <span style="display: inline-block;position: relative;">
                                <i class="fa fa-home weui-tabbar__icon1"></i>
                            </span>
                            <p class="weui-tabbar__label1">首页</p>
                        </a>
                        <a href="<?php echo U('project/index', array('info' => set_search_ids(array('p' => $project_id))));?>" class="weui-tabbar__item1 btnsec">
                            <span style="display: inline-block;position: relative;">
                                    <i class="fa fa-list weui-tabbar__icon1"></i>
                            </span>
                            <p class="weui-tabbar__label1">房源列表</p>
                        </a>
                        <a href="<?php echo U('MyReport/index', array('info' => set_search_ids(array('p' => $project_id))));?>" class="weui-tabbar__item1 btnthree">
                            <span style="display: inline-block;position: relative;">
                                <i class="fa fa-user-o weui-tabbar__icon1"></i>
                                <span class="weui-badge weui-badge_dot" style="position: absolute;top: 2px;right: 0px;display:none;"></span>
                            </span>
                            <p class="weui-tabbar__label1">我的</p>
                        </a>
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
                
		
<script src="/Public/common/js/jquery/iscroll/iscroll.js"></script>
<script>
var iscroller_statistics;
function loaded() {
	setTimeout(function() {
		iscroller_statistics = new iScroll("iscroller-wrapper", {
			bounce: true,
			checkDOMChanges: true,
			onBeforeScrollStart: function (e) {
				var target = e.target;
				while (target.nodeType != 1) {
					target = target.parentNode;
				}

				if (target.tagName != 'SELECT' 
					&& target.tagName != 'INPUT' 
					&& target.tagName != 'TEXTAREA'
				) {
					e.preventDefault();
				}
			},
		});
	}, 100);
}

document.addEventListener('touchmove', function (e) { 
	e.preventDefault(); 
}, false);
document.addEventListener('DOMContentLoaded', function () { 
	setTimeout(loaded, 200); 
}, false);
</script>

<div class="weui-tabbar1">
                        <a href="javascript:;" class="weui-tabbar__item1 weui-bar__item_on1">
                            <span style="display: inline-block;position: relative;">
                                <i class="fa fa-home weui-tabbar__icon1"></i>
                            </span>
                            <p class="weui-tabbar__label1">首页</p>
                        </a>
                        <a href="<?php echo U('ChooseAnalysis/index', array('info' => set_search_ids(array('p' => $search_hd_id))));?>" class="weui-tabbar__item1">
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
                        <a href="<?php echo U('MyReport/index', array('info' => set_search_ids(array('p' => $search_hd_id))));?>" class="weui-tabbar__item1">
                            <span style="display: inline-block;position: relative;">
                                <i class="fa fa-user-circle-o weui-tabbar__icon1"></i>
                                <span class="weui-badge weui-badge_dot" style="position: absolute;top: 2px;right: 0px;display:none;"></span>
                            </span>
                            <p class="weui-tabbar__label1">我的</p>
                        </a>
                    </div>
<script>
    $(function() {
        //圆形统计
        $('.rate-state').circliful();
        
	$(".all-user").on("click",function () {
            window.location.href="<?php echo U('/Saler/ChooseAnalysis/index/info/p'.$search_hd_id.'/status/1');?>";
        });
        $(".login").on("click",function () {
            window.location.href="<?php echo U('/Saler/ChooseAnalysis/index/info/p'.$search_hd_id.'/status/3');?>";
        });
        $(".not-login").on("click",function () {
            window.location.href="<?php echo U('/Saler/ChooseAnalysis/index/info/p'.$search_hd_id.'/status/2');?>";
        });
        $(".login-not-xf").on("click",function () {
            window.location.href="<?php echo U('/Saler/ChooseAnalysis/index/info/p'.$search_hd_id.'/status/4');?>";
        });
        $(".login-xf").on("click",function () {
            window.location.href="<?php echo U('/Saler/ChooseAnalysis/index/info/p'.$search_hd_id.'/status/5');?>";
        });
    });
</script>

	</body>
	
</html>