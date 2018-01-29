<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en" class="login-content" data-ng-app="materialAdmin">
 <head>
  <meta charset="UTF-8"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>用户登录</title>
  <link href="/Public/login/css/material-design-iconic-font/css/material-design-iconic-font.min.css" rel="stylesheet" type="text/css">
  <!-- CSS -->
  <link href="/Public/login/css/app.min.1.css" rel="stylesheet" type="text/css">
  <style>
  .bqsy-sm{
    bottom: 10px;
    padding: 5px;
    text-align: center;
    position: absolute;
    font-size: 80%;
    font-weight: bold;
    width: 100%;
    color: rgb(67, 67, 67);
    z-index: 999;	
}
.bqsy-title{
    top: 15px;
    left: 83px;
    text-align: left;
    position: absolute;
    font-size: 140%;
    font-weight: bold;
    color: #FFF;
    z-index: 999;	
}

.bqsy-title-tb {
	position: absolute;
    top: 5px;
    left: 5px;
    width: 100px;
    height: 60px;
    background: url(/public/login/img/yun1.png) no-repeat scroll 0 0/80px 45px;
    z-index: 999;
}
.bt_login
{
	top: 50%;
    margin-top: -25px;
    right: -25px;
    position: absolute!important;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    line-height: 45px!important;
	background: rgba(255,0,0,0.4);
    border: 0px;
}

  </style>
 </head>
 <body class="login-content" data-ng-controller="loginCtrl as lctrl">
	<i class="bqsy-title-tb"></i><div class="bqsy-title">云销控</div>
    <div class="lc-block" id="l-login" data-ng-class="{'toggled':lctrl.login === 1}">
    	<h1 class="lean">登录</h1>

    	<div class="input-group m-b-20">
    		<span class="input-group-addon">
    			<i class="zmdi zmdi-account"></i>
    		</span>
    		<div class="fg-line">
    			<input type="text"  tabindex="1" class="form-control codeinput" placeholder="用户代码或手机号码" regex="^\w{3,16}$"/>
    		</div>
    	</div>
		<form action="" id="form-login">
        <div class="input-group m-b-20">
    		<span class="input-group-addon">
    			<i class="zmdi zmdi-male"></i>
    		</span>
    		<div class="fg-line">
    			<input type="password"  tabindex="2" class="form-control pwdinput" placeholder="密码" regex="^\w+"/>
    		</div>
    	</div>
    	
    	<div class="clearfix"></div>
    	
    	<div class="checkbox">
    		<label>
    			<input type="checkbox" value="" />
    			<i class="input-helper">
    				保持登录状态
    			</i>
    		</label>
    	</div>
        
    	<a  onclick="login()" class="btn btn-login btn-danger btn-float">
    		<i class="zmdi zmdi-arrow-forward"></i>
    	</a>
		<input tabindex="3" type="button" class="bt_login" value="" onclick="login()"/>
		</form>
    </div>
	<div class="bqsy-sm">
	©2016成都链商科技有限公司 蜀ICP备16013196号-2&nbsp;&nbsp;<a target="_blank" href="http://www.yun-xk.com" style="text-decoration:underline;color:rgb(67, 67, 67);">产品介绍</a> 
	</div>
 </body>
 	
 	<script src="/Public/common/js/jquery/jquery-2.1.1.min.js"></script>
	
	<!-- Angular -->
	<script src="/Public/login/js/bower_components/angular/angular.min.js"></script>
	<script src="/Public/login/js/bower_components/angular-resource/angular-resource.min.js"></script>
	<script src="/Public/login/js/bower_components/angular-animate/angular-animate.min.js"></script>
	
	<!-- Angular Modules -->
	<script src="/Public/login/js/bower_components/angular-ui-router/release/angular-ui-router.min.js"></script>
	<script src="/Public/login/js/bower_components/angular-loading-bar/src/loading-bar.js"></script>
	<script src="/Public/login/js/bower_components/oclazyload/dist/ocLazyLoad.min.js"></script>
	<script src="/Public/login/js/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
	
	<!-- Common js -->
	<script src="/Public/login/js/bower_components/angular-nouislider/src/nouislider.min.js"></script>
	<script src="/Public/login/js/bower_components/ng-table/dist/ng-table.min.js"></script>
	
	<!-- Placeholder for IE9 -->
	<!--[if IE 9 ]>
	    <script src="js/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
	<![endif]-->
	<!-- App level -->
	<script src="/Public/login/js/app.js"></script>
	<script src="/Public/login/js/controllers/main.js"></script>
	<script src="/Public/login/js/controllers/ui-bootstrap.js"></script>
	
	
	<!-- Template Modules -->
	<script src="/Public/login/js/modules/form.js"></script>
	<script src="/Public/common/js/layer/layer.js"></script>
	<script src="/Public/common/js/functions.js"></script>
	<script src="/Public/common/js/pc/functions.js"></script>
	<script src="/Public/xk/js/functions.js"></script>
	
	<script type="text/javascript">
	$(function(){
	    //阻止表单提交
		$("#form-login").on('submit',function () {
			return false;
        });
        //改为可以回车登录
        $(document).on("keyup",".codeinput",function () {
            if(event.keyCode === 13 ){
                $(this).blur();
                var vo=$(this).val();
                if(vo === '' || vo ===undefined){
                    layer_alert('用户名不能为空！');
                }  else{
                    login();
                }

            };
        });
        $(document).on("keyup",".pwdinput",function () {
            if(event.keyCode === 13 ){
                $(this).blur();
                var vo=$(this).val();
                if(vo === '' || vo ===undefined){
                    layer_alert('密码不能为空！');
                }  else{
                    login();
                }
            };
        });
        //找到文本框，并注册得到焦点事件
        $(".bt_login").focus(function(){
            //让当前得到焦点的文本框改变其背景色
            $(this).css("background","rgba(255,0,0,0.01)");
        });
        //找到文本框，并注册失去焦点事件
        $(".bt_login").blur(function(){
            //让当前失去焦点的文本框背景色变为白色
            $(this).css("background","rgba(255,0,0,0.4)");
        });
    });
	
	
	function login()
	{
		var $name = $(".codeinput").val();
		var $password = $(".pwdinput").val();
		var login_url = {
					index: '../room/index.html',
					login: '<?php echo U("login/check");?>',
				}
		
		var $url = login_url.login;
		var $data = {
			name: $name,
			pwd: $password,
		};
		
		ajax_post_callback($url, $data, function(data) {
			if (data.status == 0) {
				layer_alert(data['info']);
			} else {
					location.href = data['info'];			
			}
		});
	}
	</script>
</html>