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
        .saler-statistics-content-unit-info {
            padding-top: 20px;
        }
        .saler-statistics-content-unit-box {
            position: relative;
            height: 130px;
        }
        .saler-statistics-content-price-title {
            padding: 15px 5px 20px 5px;
            margin-bottom: 10px;
        }
		#content-tab{
			padding: 0 10px;
		}
		h1{
			    padding: 10px 0 5px 0;
                            font-size: 16px;
                            font-weight: bold;
                            margin-top: 10px;
                            margin-bottom: 5px;
                            border-bottom: 1px solid #f4f4f4;
                            border-top: 4px solid #ececec;
                            width: 95%;
		}
                .saler-statistics-list-box h1:first-child{
                     padding: 5px 0 5px 0;
                     border-top: 0px;
                }
		h2{
			font-size: 15px;
			font-weight: bold;
			margin-top: 5px;
		}
		h1 .xf-zt{
			border: 1px solid #ff6058;
			padding: 1px 3px;
			border-radius: 3px;
			color: #ff6058;
			font-weight: normal;
			font-size: 12px;
                        float: right;
                        /*margin-right: 5%;*/
		}
                .call-phone{
                    position: fixed;
                    padding: 10px;
                    z-index: 999999;
                    right: 5%;
                    top: 105px;
                }
		.call-phone i{
                        color: #FFF;
                        cursor: pointer;
                        font-size: 17px;
                        width: 22px;
                        height: 22px;
                        line-height: 22px;
                        text-align: center;
                        background: #09bb07;
                        border-radius: 50%;
		}
		#user-info{
			width: 95%;
			margin-top: 5px;
			margin-bottom: 5px;
		}
		#room-tab{
			 width: 95%;
			 margin-top: 10px;
			 margin-bottom: 10px;
		 }
		#room-tab tr{
			margin-bottom:10px;
		}
		#user-info td{
			text-align: left;
			font-weight: bold;
                        font-size:13px;
		}
		#user-info i{
			color: #999999;
		}
		.hs{
			color: #999999;
			padding-left: 5px;
			font-weight: normal!important;
		}
		hr{
			width: 95%;
			background-color: rgba(193,193,193,0.3);
			border-color: rgba(193,193,193,0.3);
			margin-top: 5px;
		}
		.font-hs{
			color: #999999;
			font-size: 12px;
		}
		.sm-font{
			font-size: 12px;
		}
		.hot-one{
			display: inline-block;
			width: 8px;
			height: 8px;
			background-color: rgba(255, 67, 52, 0.69);
		}
		.hot-two{
			display: inline-block;
			width: 8px;
			height: 8px;
			background-color: rgba(255, 159, 98, 0.69);
		}
		.hot-three{
			display: inline-block;
			width: 8px;
			height: 8px;
			background-color: rgba(255, 188, 23, 0.69);
		}
		.hot-four{
			display: inline-block;
			width: 8px;
			height: 8px;
			background-color: rgba(45, 202, 94, 0.53);
		}
		.hot-five{
			display: inline-block;
			width: 8px;
			height: 8px;
			background-color: rgba(56, 156, 13, 0.73);
		}
		.ft{

		}
                .endtr{
                    margin-bottom: 10px;
                }
                .scgs{
                    float:right;margin-right: 2px;
                }
                .ired{
                    color:#ff6058;
                }
                .iyellow{
                    color:#f8a659;
                }
                .igreen{
                    color:#0ba1b4;
                }
                html{
                    color:#999999;
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
					<span class="common-header-content-box-name">客户详情</span>
				</span>
			</div>
			<div class="fr wm10 common-header-right" style="padding-top: 3%">
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
			<div id="iscroller-wrapper" class="iscroller-style saler-statistics-list-wrapper" style="bottom:43px;background-color: #fff;">
				<div id="iscroller-scroller" class="iscroller-scroller-style" >
					<div class="saler-statistics-list-box" >
						<div class="fl wm100" id="content-tab">
							<div class="fl wm100">
								<h1><!--<i class="fa fa-user iyellow"> </i>--> <?php echo ($user_info["cname"]); ?> <?php if(($user_info["rid"] != null) AND ($user_info["oid"] != null)): ?><span class="xf-zt">已选房</span><?php else: ?><span class="xf-zt">未选房</span><?php endif; ?>  
                                                                    <a href="tel:<?php echo rsa_decode($user_info['cphone'],getChoosekey());?>" class="call-phone" data-num="<?php echo rsa_decode($user_info['cphone'],getChoosekey());?>"><i class="fa fa-phone"></i></a>
                                                                </h1>
								<table id="user-info">
									<tr>
										<td class="wm20" style="width:60px">手机号码</td>
										<td class="hs"><?php echo rsa_decode($user_info['cphone'],getChoosekey());?></td>
									</tr>
									<tr>
										<td>证件号码</td>
										<td class="hs"><?php echo rsa_decode($user_info['cardno'],getChoosekey());?></td>
									</tr>
									<tr>
										<td>认筹单号</td>
										<td class="hs"><?php echo ($user_info['cyjno']); ?></td>
									</tr>
									<tr>
										<td>置业顾问</td>
										<td class="hs"><?php echo ($user_info['ywy']?$user_info['ywy']:'无'); ?></td>
									</tr>
									<tr>
										<td>登录时间</td>
										<td class="hs"><?php echo ($user_info['logintime']?date('Y-m-d h:i:s',$user_info['logintime']):'未登录'); ?></td>
									</tr>
								</table>
								<h1><i class="fa fa-envelope-open-o ired"> </i> 所选房间</h1>
								<?php if(($user_info["rid"] != null) AND ($user_info["oid"] != null)): ?><a href="<?php echo U('room/index', array('id' =>$user_info['rid'],'hid'=> $project_id));?>" style="color:#999999">
                                                                        <h2><?php echo ($user_info["bname"]); ?>-<?php echo ($user_info["unit"]); ?>单元-<?php echo ($user_info["room"]); ?></h2>
                                                                        <p  class="font-hs" >房间信息：￥<?php echo number_format($user_info['total'],2);?>元  &nbsp;&nbsp;&nbsp;      <?php if($user_info['hx'] != null): ?>(<?php echo ($user_info["hx"]); ?>)<?php endif; echo ($user_info["area"]); ?>㎡</p>
                                                                        <p class="font-hs" >选房时间：<?php echo date('Y-m-d h:i:s',$user_info['log_time']);?></p>
                                                                    </a>
								<?php else: ?>
                                                                    <p style="font-size: 14px;color: #ff6058;margin: 5px 0;">还没有选择房间...</p><?php endif; ?>
								
								<h1><i class="fa fa-list-ol igreen"> </i> 收藏房源(<?php echo count($sc_room); ?>)</h1>
								<table id="room-tab">
									<?php if(count($sc_room) > 0): if(is_array($sc_room)): foreach($sc_room as $k=>$vo): ?><tr>
											<td>
                                                                                              <a href="<?php echo U('room/index', array('id' =>$vo['id'],'hid'=> $project_id));?>" style="color:#999999">
												<p class="fl wm100 sm-font">
													<?php if($vo["first_count"] >= 3): ?><span class="hot-one"></span> 热度：高
														<?php elseif($vo["first_count"] == 2): ?>
														<span class="hot-two"></span> 热度：中高
														<?php elseif($vo["first_count"] == 1): ?>
														<span class="hot-three"></span> 热度：中
														<?php elseif(($vo["first_count"] > 0) AND ($vo["sc_count"] >= 3)): ?>
														<span class="hot-four"></span> 热度：中低
														<?php else: ?>
														<span class="hot-five"></span> 热度：低<?php endif; ?>
													<span class="fr">第<?php echo ($k+1); ?>意向</span>
												</p>
												<h2><?php echo ($vo["bname"]); ?>-<?php echo ($vo["unit"]); ?>单元-<?php echo ($vo["room"]); ?></h2>
												<p class="font-hs endtr"><?php echo ($vo["hxmx"]); ?> / <?php echo ($vo["area"]); ?>㎡ / <?php echo number_format($vo['total']);?> 元  <span class="scgs"> <i class="fa fa-heart-o"></i> <?php echo ($vo["sc_count"]); ?> &nbsp;<span class="ft">①</span> <?php echo ($vo["first_count"]); ?></span></p>
                                                                                              </a>
											</td>
										</tr><?php endforeach; endif; ?>
										<?php else: ?>
										<tr>
											<td align="center" style="color: red">
												没有收藏房间...
											</td>
										</tr><?php endif; ?>
								</table>
							</div>
						</div>
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
	<a href="<?php echo U('DataStatistics/index', array('info' => set_search_ids(array('p' => $project_id))));?>" class="weui-tabbar__item1">
                            <span style="display: inline-block;position: relative;">
                                <i class="fa fa-home weui-tabbar__icon1"></i>
                            </span>
		<p class="weui-tabbar__label1">首页</p>
	</a>
	<a href="<?php echo U('ChooseAnalysis/index', array('info' => set_search_ids(array('p' => $project_id))));?>" class="weui-tabbar__item1 weui-bar__item_on1">
                            <span style="display: inline-block;position: relative;">
                                    <i class="fa fa-group weui-tabbar__icon1"></i>
                            </span>
		<p class="weui-tabbar__label1">客户分析</p>
	</a>
	<a href="<?php echo U('RoomAnalysis/index', array('info' => set_search_ids(array('p' => $project_id))));?>" class="weui-tabbar__item1">
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
<script>
    $(document).ready(function() {
        var ut=$("#user-type");
        ut.val("<?php echo ($status); ?>");
        ut.on("change",function () {
			$("#search-user").val('');
			$("#condition-form").submit();
        });
        $("#condition-form").on("input",function () {
            $("#condition-form").submit();
        });
        
	/*$(".call-phone").on("click",function (event) {
            event.stopPropagation();
			var phone=$(this).attr("data-num");
			window.location.href='tel:' + phone;
        });*/	
      
    });
</script>

	</body>
	
</html>