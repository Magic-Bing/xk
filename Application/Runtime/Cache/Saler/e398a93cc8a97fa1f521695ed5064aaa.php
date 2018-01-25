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
		.bi{
			height: 25px;
			margin: 0 0 0 5px;
			border-radius: 5px;
			font-weight: 400;
			font-style: normal;
			font-size: 13px;
			text-decoration: none;
			color: #999999;
			text-align: center;
			border-color: transparent;
			outline-style: none;
			background: url('/public/sales/img/project/search.png') no-repeat scroll 2px 2px/18px 18px;

		}
		#content-tab td{
			vertical-align: middle;
			border-bottom: 3px solid rgb(231, 240, 249);
		}
		.xf-status,.dl-status{
                    padding: 1px 2px;
                    border-radius: 3px;	
		}
                .yxf{
                    color: #ff6058;
                    border: 1px solid #ff6058;
                }
                .ydl{
                    color: #ff6058;
                    border: 1px solid #ff6058;
                }
                .wxf{
                    color:#ffc534;
                    border: 1px solid #ffc534;
                }
                .wdl{
                    color:#33ccff;
                    border: 1px solid #33ccff;
                }
                .call-phone{
                    padding: 5px;
                    z-index: 999999;
                    right: 5%;
                    top: 105px;
                    cursor: pointer;
                }
		.call-phone i{
                        color: #FFF;
                        font-size: 17px;
                        width: 22px;
                        height: 22px;
                        line-height: 22px;
                        text-align: center;
                        background: #09bb07;
                        border-radius: 50%;
		}
		#user-type{
			color: #999999;
			border-color: #fff
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
			<div class="fr wm10 common-header-right" style="padding-top: 3%">
				<div class="common-header-reload">
					<a href="" onclick="window.location.reload()" class="saler-project-header-reload-btn js-saler-project-header-reload-btn saler-project-header-reload-a">
						<i class="icon-refresh  bigger-230 " style="color: #c1c1c1;font-size: 18px"></i>
						<!--<img src="/Public/common/img/refresh.png" style="width: 15px;height: 15px">-->
					</a>
				</div>
			</div>

		</div>
		<div class="fl wm100" style="background-color: #FFF;padding: 5px 0 0 0;">
			<form action="" method="post" id="condition-form">
			<div class="fl">
				<label for="user-type"></label>
				<select name="status" id="user-type" class="wm100" >
                                    <?php if(is_array($tylelist)): foreach($tylelist as $k=>$vo): if($status == $k): ?><option value="<?php echo ($k); ?>" selected ><?php echo ($vo); ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo ($k); ?>"><?php echo ($vo); ?></option><?php endif; endforeach; endif; ?>
				</select>
			</div>
				<input type="hidden" name="info" value="<?php echo ($search_info); ?>">
			<div class="fr wm60">
				<input class="fl border-sizing bi" type="text" name="search"  id="search-user"  placeholder="输入姓名或者电话搜索" style="width: 96%;display: inline;background-color: rgba(193,193,193,0.16);">
			</div>
			</form>
			<table class="fl wm100" style="color: #999999;text-align: center;font-weight: bold;margin-top: 5px;">
				<tr style="border-top: 1px solid #ececec;font-size:13px;height: 30px;">
					<td class="wm40">客户</td>
                                        <td class="wm25">登录状态</td>
					<td class="wm20">选房状态</td>
					<td class="wm15"></td>
				</tr>
			</table>
		</div>
	</div>

		
	<!--用于post提交连接的表单-->
	<form action="/Saler/ChooseAnalysis/user_detail" id="post-user-detail" method="get">
		<input type="hidden" name="project" value="<?php echo ($project_id); ?>">
		<input type="hidden" name="cid"  value="">
	</form>
	<div class="common-content sales-statistics-content" style="background: rgb(231, 240, 249);">
		<div class="saler-statistics-content-wrapper">

			<div id="iscroller-wrapper" class="iscroller-style saler-statistics-list-wrapper" style="bottom:45px;background-color: #fff;top:70px;background: rgb(231, 240, 249);">
				<div id="iscroller-scroller" class="iscroller-scroller-style" style="background: #FFF;">

					<div class="saler-statistics-list-box" >
						<table class="fl wm100" style="color: #6c6c6c;text-align: center;" id="content-tab">
							<?php if(count($user_xf) >= 1): if(is_array($user_xf)): foreach($user_xf as $k=>$vo): ?><tr data-id="<?php echo ($vo["id"]); ?>">
											<td align="left" class="wm40" style="padding-left: 15px">
												<p><?php echo ($vo["customer_name"]); ?></p>
												<p><?php echo rsa_decode($vo['customer_phone'],getChoosekey());?></p>
											</td>
											<td class="wm25"><?php if(($vo["oid"] != null)): ?><span class="xf-status ydl">已登录</span><?php else: ?><span class="xf-status wdl">未登录</span><?php endif; ?></td>
                                                                                        <td class="wm20"><?php if(($vo["rid"] != null) AND ($vo["oid"] != null)): ?><span class="xf-status yxf">已选房</span><?php else: ?><span class="xf-status wxf">未选房</span><?php endif; ?></td>
											<td class="wm15"><a href="tel:<?php echo rsa_decode($vo['customer_phone'],getChoosekey());?>" class="call-phone" data-num="<?php echo rsa_decode($vo['customer_phone'],getChoosekey());?>"><i class="fa fa-phone"></i></a></td>
										</tr><?php endforeach; endif; ?>
								<?php else: ?>
								<tr>
									<td colspan="3" align="center">暂时没有数据...</td>
								</tr><?php endif; ?>
						</table>
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
	<a href="javascript:;" class="weui-tabbar__item1 weui-bar__item_on1">
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
        ut.on("change",function () {
            $("#search-user").val('');
            $.post("<?php echo U('/Saler/ChooseAnalysis/index');?>",$("#condition-form").serialize(),function (data) {
				$(".saler-statistics-list-box").html(data);
            });
//			$("#condition-form").submit();
        });
        $("#search-user").on("input",function () {
                $.post("<?php echo U('/Saler/ChooseAnalysis/index');?>",$("#condition-form").serialize(),function (data) {
                    $(".saler-statistics-list-box").html(data);
                });
        });
		$(document).on("click",'.call-phone',function (event) {
             event.stopPropagation();
      });
		$(document).on("click","#content-tab tr",function () {
			var id=$(this).attr('data-id');
			if(id !=="" && id!==null && id!==undefined)
			    $("input[name='cid']").val(id);
			    $("#post-user-detail").submit();
        });
    });
</script>

	</body>
	
</html>