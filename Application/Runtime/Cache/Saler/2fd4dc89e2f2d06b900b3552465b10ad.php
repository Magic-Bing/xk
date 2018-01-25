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
		
    <script src="/Public/account/assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/Public/common/css/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="/Public/account/assets/css/bootstrap.min.css">
    <style>
        body{
            font-size: 13px;
            overflow: hidden;
            background-color: #e7f0f9;
        }
        #ul-list
        {
            position: absolute;
            top:45%;
            left:50%;
            text-align: center;
            transform: translate(-50%, -50%);
            /*height:calc(100% - 45px);*/
        }
        .weui-tabbar__label1{
                margin: 0;
        }
        a:hover{text-decoration:none;}
        .djbtn
        {
            padding:10px 10px;
            line-height:40px;
            background: #33ccff;
            color: #FFF;
            border-radius: 10px;
        }
        .bkdiv{
            display: block;top:0px;background-color: #d6e9c6;height: 100%;width: 100%;
        }
        .btn-primary {
            background-color: #3cf;
            border-color: #3cf;
        }
        .a-logout {
            top: 15px;
            right: 15px;
        }
    </style>
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="" id="update_user">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">修改密码</h4>
                </div>
                <div class="modal-body">
                    <table style="width: 100%; line-height: 60px;">
                        <tr>
                            <td style="text-align: right"> <label for="in1" style="margin-bottom: 0px;">原密码</label></td>
                            <td style="text-align: center"><input type="password" name="old_pwd" required placeholder="请输入原密码" id="in1" style="height:30px"></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"> <label for="in2" style="margin-bottom: 0px;">新密码</label></td>
                            <td style="text-align: center"><input type="password" name="new_pwd" required placeholder="请输入新密码" id="in2" style="height:30px"></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"> <label for="in3" style="margin-bottom: 0px;">确认新密码</label></td>
                            <td style="text-align: center"><input type="password" required placeholder="请再次输入新密码" id="in3" style="height:30px"></td>
                        </tr>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary">确认修改</button>
                </div>
                </form>
            </div>
        </div>
    </div>

		
    <div class="bkdiv" >
        <img id="bjimg" src="/Public/sales/img/saler/salerbk.jpg" original="/Public/sales/img/saler/salerbk.jpg" style="width:100%;height:100%;"> 
        <div class="fl wm20 ">
              <span >
                   <a href="/saler/logging/logout.html" class="a-logout" style="color:#3cf;font-size:14px;border: 1px solid #3cf;">
                       <i class="fa fa-sign-out" ></i>
                       注销
                   </a>
              </span>
        </div>
        <ul class="wm100" id="ul-list" style="line-height: 50px;font-size: 14px;">
            <li >
               <i class="fa fa-user-circle-o" style="font-size: 70px;color: #33ccff"></i>
            </li>
             <li style="line-height: 40px;">
                 <span style="color:#33ccff;font-size:18px;font-weight: 700;"><?php echo ($user['name']); ?></span>
            </li>
             <li style="line-height: 25px;">
                 <div style="float:left;margin-left:calc(50% - 72px); width:calc(50% + 72px);color: #777;">
                  <div style="text-align: left;"><span>用户账号</span><span style="margin-left:10px"> <?php echo ($user['code']); ?></span></div>
                  <div style="text-align: left;"><span>用户手机</span><span style="margin-left:10px"> <?php echo ($user['mobile']); ?></span></div>
                 </div>
            </li>
            <li data-toggle="modal" data-target=".bs-example-modal-sm" style="float:left; width:50%;margin-top: 20%;">
                <span class="djbtn" ><i class="fa fa-edit" ></i> 修改密码</span>
            </li>
            <?php if(count($user_project_list) > 1): ?><li style="float:left; width:50%;margin-top: 20%;">
                    <a href="/Saler/index/index.html">
                        <span class="djbtn"><i class="fa fa-reply-all" ></i> 活动切换</span>
                    </a>
                </li>
            <?php else: ?>
                <li style="float:left; width:50%;margin-top: 20%;">
                    <span class="djbtn" style="background:#ddd"><i class="fa fa-reply-all" ></i> 活动切换</span>
                </li><?php endif; ?>
        </ul>
    </div>

                
    <div class="weui-tabbar">
        <div class="weui-tabbar1">
            <a href="<?php echo U('DataStatistics/index', array('info' => set_search_ids(array('p' => $search_hd_id))));?>" class="weui-tabbar__item1">
                            <span style="display: inline-block;position: relative; color:#999999">
                                <i class="fa fa-home weui-tabbar__icon1"></i>
                            </span>
                <p class="weui-tabbar__label1">首页</p>
            </a>
            <a href="<?php echo U('ChooseAnalysis/index', array('info' => set_search_ids(array('p' => $search_hd_id))));?>" class="weui-tabbar__item1 ">
                            <span style="display: inline-block;position: relative;color:#999999">
                                    <i class="fa fa-group weui-tabbar__icon1"></i>
                            </span>
                <p class="weui-tabbar__label1">客户分析</p>
            </a>
            <a href="<?php echo U('RoomAnalysis/index', array('info' => set_search_ids(array('p' => $search_hd_id))));?>" class="weui-tabbar__item1">
							<span style="display: inline-block;position: relative;color:#999999">
								<i class="fa fa-bar-chart weui-tabbar__icon1"></i>
							</span>
                <p class="weui-tabbar__label1">装户分析</p>
            </a>
            <a href="javascript:;" class="weui-tabbar__item1 weui-bar__item_on1">
                            <span style="display: inline-block;position: relative;color:#09BB07" >
                                <i class="fa fa-user-circle weui-tabbar__icon1"></i>
                                <span class="weui-badge weui-badge_dot" style="position: absolute;top: 2px;right: 0px;display:none;"></span>
                            </span>
                <p class="weui-tabbar__label1">我的</p>
            </a>
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
                
		
    
    <script>
        $(function () {
            //验证2次密码是否相同
            $("#in3").on("blur",function () {
               if($(this).val()!=$('#in2').val()){
                    layer_alert("2次密码输入不相同，请重新输入！");
                    $(this).val('');
               }
            });

            //密码修改
            $("#update_user").on("submit",function () {
                $.ajax({
                    type:"post",
                    url:"/Saler/MyReport/update_user",
                    data:$(this).serialize(),
                    success:function (data) {
                        if(data=="false1"){
                            layer_alert("原密码填写错误，请重新填写！");
                        }else if(data=="false2"){
                            layer_alert("密码未改变！");
                        }else{
                            layer_tip("密码修改成功，请重新登录.");
                            window.location.reload();
                        }
                    }
                });
               return false;
            });
        });
    </script>

	</body>
	
</html>