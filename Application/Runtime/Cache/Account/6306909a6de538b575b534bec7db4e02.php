<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="keywords" content="<?php echo ((isset($seo_keywords) && ($seo_keywords !== ""))?($seo_keywords):'销控管理系统'); ?>"/>
		<meta name="description" content="<?php echo ((isset($seo_description) && ($seo_description !== ""))?($seo_description):'销控管理系统'); ?>"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<meta name="apple-mobile-web-app-capable" content="yes"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>
			<?php echo ((isset($seo_title) && ($seo_title !== ""))?($seo_title):'销控管理'); ?>
			
				<?php if(!empty($website)): ?>- <?php echo ((isset($website) && ($website !== ""))?($website):'销控管理系统'); endif; ?>
			
		</title>
		<!-- basic styles -->
		
			<link href="/Public/account/assets/css/bootstrap.min.css" rel="stylesheet" />
			<link href="/Public/account/assets/css/font-awesome.min.css" rel="stylesheet" />
			<!--[if IE 7]>
				<link href="/Public/account/assets/css/font-awesome-ie7.min.css" rel="stylesheet" />
			<![endif]-->
		
		<!-- page specific plugin styles -->
		
			<link rel="stylesheet" href="/Public/account/assets/css/jquery.gritter.css" />
		
		
		<!-- ace styles -->
		
			<link href="/Public/account/assets/css/ace.min.css" rel="stylesheet" />
			<link href="/Public/account/assets/css/ace-rtl.min.css" rel="stylesheet" />
			<link href="/Public/account/assets/css/ace-skins.min.css" rel="stylesheet" />
			<!--[if lte IE 8]>
				<link rel="stylesheet" href="/Public/account/assets/css/ace-ie.min.css" />
			<![endif]-->
			<link href="/Public/account/css/theme.css" type="text/css" rel="stylesheet"/>
			<link href="/Public/account/css/account.css" type="text/css" rel="stylesheet"/>
		
		
		<!-- inline styles related to this page -->
		<!-- ace settings handler -->
		
			<script src="/Public/account/assets/js/ace-extra.min.js"></script>
			<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
				<script src="/Public/account/assets/js/html5shiv.js"></script>
				<script src="/Public/account/assets/js/respond.min.js"></script>
			<![endif]-->
		
		
		
		
			<script type="text/javascript">
var choose_user_url = {
	index: '<?php echo U("ChooseUser/index");?>',
	add: '<?php echo U("ChooseUser/add");?>',
	delete: '<?php echo U("ChooseUser/delete");?>',
	delete_all: '<?php echo U("ChooseUser/delete_all");?>',
	edit: '<?php echo U("ChooseUser/edit");?>',
    check_user: '<?php echo U("ChooseUser/check_user");?>',
	import: '<?php echo U("ChooseUser/import");?>',
	export: '<?php echo U("ChooseUser/export");?>',
    add_room: '<?php echo U("ChooseUser/add_room");?>',
    update_yd: '<?php echo U("ChooseUser/update_yd");?>',
    update_qx: '<?php echo U("ChooseUser/update_qx");?>',
};
var choose_fast_activity_url = {
	index: '<?php echo U("ChooseFastActivity/index");?>',
	add: '<?php echo U("ChooseFastActivity/add");?>',
};
var choose_activity_url = {
	index: '<?php echo U("ChooseActivity/index");?>',
	add: '<?php echo U("ChooseActivity/add");?>',
	delete: '<?php echo U("ChooseActivity/delete");?>',
	delete_all: '<?php echo U("ChooseActivity/delete_all");?>',
	edit: '<?php echo U("ChooseActivity/edit");?>',
};
var choose_log_url = {
	index: '<?php echo U("ChooseLog/index");?>',
	delete: '<?php echo U("ChooseLog/delete");?>',
	delete_all: '<?php echo U("ChooseLog/delete_all");?>',
	
	//移除
	redelete: '<?php echo U("ChooseLog/redelete");?>',
	resave: '<?php echo U("ChooseLog/resave");?>',
};

var SpeedBuy_fast_url = {
	index: '<?php echo U("SpeedBuyfast/index");?>',
	add: '<?php echo U("SpeedBuyfast/add");?>',
};
var order_house ={
    index : '<?php echo U("index");?>',
    add : '<?php echo U("add");?>',
    edit : '<?php echo U("edit");?>',
    delete : '<?php echo U("remove");?>'
};
var Jcsj_room_url = {
	delroom: '<?php echo U("Jcsjroom/delroom");?>',
        saveroom: '<?php echo U("Jcsjroom/saveroom");?>',
        index: '<?php echo U("Jcsjroom/room");?>',
        eidt: '<?php echo U("Jcsjroom/eidt");?>',
};
var user_url = {
        index: '<?php echo U("Yhqxuser/index");?>',
        saveuser: '<?php echo U("Yhqxuser/saveuser");?>',
        deluser: '<?php echo U("Yhqxuser/deluser");?>',
        pldeluser: '<?php echo U("Yhqxuser/pldeluser");?>',
};
var xsgl_url={
    update_off: '<?php echo U("Xsgllog/update_off");?>',
    update_zt: '<?php echo U("Xsgllog/update_zt");?>',
};
var hx_url={
    add_hx: '<?php echo U("Hxset/add_hx");?>',
    delete_hx: '<?php echo U("Hxset/delete_hx");?>',
    update_hx: '<?php echo U("Hxset/update_hx");?>',
};
var station={
    delete_station:'<?php echo U("/Account/Yhqxstation/delete_station");?>'
};
var sign={
    user_list:'<?php echo U("/Account/CstSign/user_list");?>',
    sign:'<?php echo U("/Account/CstSign/sign");?>',
    check_excel:'<?php echo U("/Account/CstSign/check_excel");?>'
}

</script>

		
		

	</head>
	<!--左边的菜单栏固定-->
	
		<body class="breadcrumbs-fixed navbar-fixed">
		<!--密码修改模态框-->
		<div class="modal fade" tabindex="-1" role="dialog" id="update-model"  aria-labelledby="myModalLabel" >
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">账号密码修改</h4>
					</div>
					<form action="" id="update-password">
						<div class="modal-body">
							<input type="hidden" name="user_id" value="<?php echo ($user_info['id']); ?>">
							<div class="form-group" style="height: 30px">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-p1"  style="text-align: right"> 用户名： </label>
								<div class="col-sm-9">
									<input type="text" readonly="" id="form-field-p1" value=" <?php echo ($user_info['name']); ?>" placeholder="请输入用户名" required="" disabled name="username" class="col-xs-10 col-sm-5" style="width: 80%">
								</div>
							</div>
							<div class="form-group" style="height: 30px">
								<label class="col-sm-3 control-label no-padding-right" for="oldpwd"  style="text-align: right"> 原密码： </label>
								<div class="col-sm-9">
									<input type="password" id="oldpwd" placeholder="请输原密码" autocomplete="off" name="oldpwd" required class="col-xs-10 col-sm-5" style="width: 80%">
								</div>
							</div>
							<div class="form-group" style="height: 30px">
								<label class="col-sm-3 control-label no-padding-right" for="newpwd-1"  style="text-align: right"> 新密码： </label>
								<div class="col-sm-9">
									<input type="password" id="newpwd-1" placeholder="请输入新密码" autocomplete="off" required class="col-xs-10 col-sm-5" style="-webkit-appearance: none;width: 80%">
								</div>
							</div>
							<div class="form-group" style="height: 30px">
								<label class="col-sm-3 control-label no-padding-right" for="newpwd" style="text-align: right"> 重复新密码： </label>
								<div class="col-sm-9">
									<input type="password" id="newpwd" placeholder="请再次输入新密码" autocomplete="off" required name="newpwd" class="col-xs-10 col-sm-5" style="-webkit-appearance: none;width: 80%">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
							<button  class="btn btn-primary">提交</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		
				<div class="navbar navbar-default navbar-fixed-top" id="navbar"><!--头部固定-->

	<script src="/Public/common/js/jquery/jquery-2.1.1.min.js"></script>
	<script src="/Public/common/js/jquery/jquery-ui-1.12.0.custom/jquery-ui.js"></script>
	<script src="/Public/common/js/layer/layer.js"></script>

	<script type="text/javascript">
            try{ace.settings.check('navbar' , 'fixed')}catch(e){}
          
            $(function() {
                $(document).on("click",".light-blue",function () {
                    var pd=$(this).attr("on");
                    if(Number(pd)==0){
                        $("#sh").show();
                       $(this).attr("on","1");
					}else{
                        $("#sh").hide();
                        $(this).attr("on","0");
					}

                });
				//验证2次密码是否相同
				$(document).on("blur","#newpwd",function () {
					if($(this).val() !== $("#newpwd-1").val()){
					    layer_alert("2次密码输入不一致，请重新输入！");
                        $(this).val("");
                        return false;
					}
                });
				//修改密码
                $("#update-password").on("submit",function(){
                    $.ajax({
						url:'<?php echo U("index/editpwd");?>',
						data: $(this).serialize(),
						type: 'POST',
						dataType: 'JSON',
						success: function (data, status) {
						    console.log(data);
							if (data.status===0) {
								layer_alert(data.info);
								return false;
							}else{
                                layer_msg(data.info);
                                setTimeout(function () {
									window.location.reload();
                                },2000);
							}


						},
						error: function (data, status, e) {
								layer_alert('提交连接失败！');
						}
					});
                    return false;
				});

			});
	</script>


	<div class="navbar-container" id="navbar-container">
		<div class="navbar-header pull-left">
			<a href="#" class="navbar-brand">
				<small>
					<i class="icon-leaf"></i>
					云销控管理系统
				</small>
			</a><!-- /.brand -->
		</div><!-- /.navbar-header -->

		<div class="navbar-header pull-right" role="navigation">
			<ul class="nav ace-nav">
				
				
					<li class="purple">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">
							<i class="icon-bell-alt icon-animated-bell"></i>
							<span class="badge badge-important">
								<?php echo ((isset($log_noread_count) && ($log_noread_count !== ""))?($log_noread_count):0); ?>
							</span>
						</a>

						<ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
							<?php if($log_noread_count > 0): ?><li class="dropdown-header">
									<i class="icon-warning-sign"></i>
									<?php echo ((isset($log_noread_count) && ($log_noread_count !== ""))?($log_noread_count):0); ?> 
									条信息
								</li>

								<!--<li>
									<a href="<?php echo U('ChooseLog/index');?>">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-pink icon-comment"></i>
												新增竞价记录
											</span>
											<span class="pull-right badge badge-info">+<?php echo ((isset($log_noread_count) && ($log_noread_count !== ""))?($log_noread_count):0); ?></span>
										</div>
									</a>
								</li>-->

								<li>
									<a href="<?php echo U('ChooseLog/index');?>">
										查看所有记录
										<i class="icon-arrow-right"></i>
									</a>
								</li>
							<?php else: ?>
								<li class="dropdown-header">
									<i class="icon-warning-sign"></i>
									没有信息记录
								</li><?php endif; ?>
						</ul>
					</li>
				

				
                                    <li class="light-blue" on="0">
                                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                            <i class="icon-user" style="font-size: 28px;border: 1px solid white;border-radius: 50%;width: 35px;height: 35px;line-height: 35px;margin-top: 5px;"></i>
                                            <!--<img class="nav-user-photo" src="/Public/account/assets/avatars/user.jpg" alt="Jason's Photo" />-->
                                            <span class="user-info" title="<?php echo (strip_tags((isset($user_info['name']) && ($user_info['name'] !== ""))?($user_info['name']):'销控管理员')); ?>">
                                                <small>欢迎你</small>
                                                <?php echo ((isset($user_info['name']) && ($user_info['name'] !== ""))?($user_info['name']):'销控管理员'); ?>
                                            </span>

                                            <i class="icon-caret-down"></i>
                                        </a>

                                        <ul class="user-menu pull-right dropdown-menu showmenu dropdown-caret dropdown-close" id="sh">
                                            <li style="margin-top: 10px;" data-toggle="modal" data-target="#update-model">
                                                 <a href="javascript:void(0);" class="open_pwd_edit" style="background: #fff;color: #000;">
                                                    <i class="icon-cog"></i>
                                                    修改密码
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="<?php echo U('login/logout');?>" style="background: #fff;color: #000;">
                                                    <i class="icon-off"></i>
                                                    退出
                                                </a>
                                            </li>
                                        </ul>
                                        
                                    </li>
                                    
				

			</ul><!-- /.ace-nav -->

		</div><!-- /.navbar-header -->

	</div><!-- /.container -->

</div>

			
			
                                <div id="zz_div" style="width: 100%;height: 100%;background: rgba(0, 0, 0, 0.3);position: absolute;top: 0px;left: 0px;z-index: 998;display: none;"></div>
				<div class="main-container" id="main-container">
					<script type="text/javascript">
						try{ace.settings.check('main-container' , 'fixed')}catch(e){}
					</script>

					<div class="main-container-inner">

						<a class="menu-toggler" id="menu-toggler" href="#">
							<span class="menu-text"></span>
						</a>

						
							<div class="sidebar sidebar-fixed" id="sidebar">
								<script type="text/javascript">
                                    try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
								</script>

								<div class="sidebar-shortcuts" id="sidebar-shortcuts">
									<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
										<button class="btn btn-info">
											专
										</button>
										<button class="btn btn-success">
											注
										</button>
										<button class="btn btn-warning">
											开
										</button>

										<button class="btn btn-danger">
											盘
										</button>
									</div>

									<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
										<span class="btn btn-success"></span>
										<span class="btn btn-info"></span>
										<span class="btn btn-warning"></span>
										<span class="btn btn-danger"></span>
									</div>
								</div><!-- #sidebar-shortcuts -->

								<ul class="nav nav-list">
									<li>
									<a href="<?php echo U('index/index');?>">
										<i class="icon-dashboard"></i>
										<span class="menu-text"> 桌面 </span>
									</a>
									</li>
									<?php if(is_array($fun)): foreach($fun as $k=>$vo): if(($vo["parent_id"] == 0) AND ($vo["is_enable"] == 1)): ?><li fid="<?php echo ($vo["id"]); ?>">
												<a href="/Account/<?php echo ($vo["url"]); ?>">
													<i class="<?php echo ($vo["icon"]); ?>"></i>
													<span class="menu-text"> <?php echo ($vo["name"]); ?></span>
												</a>
											</li>
											<?php elseif(($vo["parent_id"] == 0) AND ($vo["is_enable"] == 0)): ?>
											<li>
												<a href="javascript:;" class="dropdown-toggle">
													<i class="<?php echo ($vo["icon"]); ?>"></i>
													<span class="menu-text"> <?php echo ($vo["name"]); ?></span>
													<b class="arrow icon-angle-down"></b>
												</a>
												<ul class="submenu">
													<?php if(is_array($fun)): foreach($fun as $kv=>$val): if($val["parent_id"] == $fun[$k]['id']): ?><li fid="<?php echo ($val["id"]); ?>" pid="<?php echo ($val["parent_id"]); ?>">
																<a href="/Account/<?php echo ($val["url"]); ?>" <?php if($val["id"] == 31): ?>target="view_window"<?php endif; ?>>
																	<i class="icon-double-angle-right"></i>
																	<?php echo ($val["name"]); ?>
																</a>
															</li><?php endif; endforeach; endif; ?>
												</ul>
											</li><?php endif; endforeach; endif; ?>

								</ul><!-- /.nav-list -->

								<div class="sidebar-collapse" id="sidebar-collapse">
									<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>

								</div>

								<script type="text/javascript">
                                    try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
								</script>
							</div>

						

						<div class="main-content">
							<!-- 面包屑固定 -->
							<div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
								<script type="text/javascript">
									try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
								</script>

								<!-- 面包屑导航 -->
								
									<ul class="breadcrumb">
	<li>
		<i class="icon-home home-icon"></i>
		<a href="<?php echo U('index/index');?>">首页</a>
	</li>

	
        <li>
            <a href="<?php echo U('Jcsjroom/room');?>"><?php echo ((isset($classify_name) && ($classify_name !== ""))?($classify_name):''); ?></a>
        </li>
        <li class="active"><?php echo ((isset($seo_title) && ($seo_title !== ""))?($seo_title):''); ?></li>
    
	
</ul><!-- .breadcrumb -->

								
								
								<!-- 导航搜索 -->
							</div>

							<div class="page-content">

								<!-- .page-header -->
								<!-- /.page-header -->
						
								<div class="row">
									<div class="col-xs-12">
										<!-- PAGE CONTENT BEGINS -->
										
										<!-- .page-content -->
										
											
										

										<!-- .page-content -->
										
        <style type="text/css">
            #tagscontent {
                border-top: none;
                height: auto;
                /* font-size: 12px; */
                color: #1B4670;
                text-align: left;
            }

            #tagscontent tr {
                line-height: 20px;
                height: auto;
                clear: both;
            }

            #tagscontent .table_td th, #tagscontent #table th {
                background: #f2f2f2;
                text-align: center;
                font-size:13px;
                border: 1px solid #DDD;
                padding: 5px 0;
            }
            #tagscontent th {
                color: #707070;
            }

            #tagscontent td {
                font-size: 13px;
                color: #1B4670;
                border: 1px solid #DDD;
            }
            .search {
                text-align: left;
                background: #fcf9f4;
                height: 38px;
                line-height: 38px;
            }

            .search_content {
                margin-top: 10px;
                color: #666;
                padding-left: 20px;
                font-size:12px
            }

            .show_page {
                width: 500px;
                text-align: center;
                float: right;
            }

            #tagscontent .show_page a {
                padding: 2px 9px;
                background: #d1cfd6;
            }


            #tagscontent .show_page a.current {
                padding: 2px 9px;
                background:rgb(255, 102, 0);
                color: #fff;
            }

            .button {
                /* background: url('../images/buttom_bg.gif') right bottom no-repeat; */
                height: 24px;
                line-height: 18px;
                cursor: pointer;
                text-align: center;
                padding: 2px 10px;
                border: 1px solid #c4d9e9;
                color: #395366;
                overflow: hidden;
                margin-left: 20px;
                font-size:12px;
            }
            .showtop_t {
                font-weight: bold;
                text-align: left;
                color: #0086ae;
                padding-left: 20px;
                padding-top: 5px;
            }
            .show_content_m_t2 {
                width: 100%;
                border-left: 1px solid #fff;
                border-right: 1px solid #fff;
                background-color: #fff;
            }

            .select_page {
                width: 400px;
                margin-left: 20px;
                float: left;
            }

            a:link {
                color: #0076cf;
                text-decoration: none;
                /*font-weight:bold;*/
            }

            .delurl {
                background: url('../../Public/admin/images/buttom_bg.gif') right bottom no-repeat;
                line-height: 22px;
                cursor: pointer;
                text-align: center;
                padding: 5px 10px;
                border: 1px solid #c4d9e9;
                color: #395366;
                overflow: hidden;
                margin-left: 20px;
                font-size: 14px;
            }
            .selectpc {
                background:rgba(255, 165, 0, 0.1);
            }

            #bldlisttb td
            {
                font-size:13px;
            }

            #bldlisttb tr
            {
                width:240px;
            }
            .xzblddiv{
                color: #FFF;
                background: rgb(135, 184, 127);
                border-radius: 5px;
                font-weight: bold;
                cursor: pointer;
                margin-top: -2px;
                display: inline;
                padding:3px 5px;
            }
            a{
                cursor:pointer;
            }
            .addbldlist_div
            {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(15%,-16%);
                width: 40%;
                height: 460px;
                /*overflow-y: auto;
                overflow-x: hidden;*/
                box-shadow: rgb(136, 136, 136) -5px 5px 15px;
                background: rgb(255, 255, 255);
                display:none;
                z-index:999;
                
                animation: showdiv1 0.3s;
                -moz-animation: showdiv1 0.3s;	/* Firefox */
                -webkit-animation: showdiv1 0.3s;	/* Safari 和 Chrome */
                -o-animation: showdiv1 0.3s;	/* Opera */
                -webkit-animation-fill-mode:forwards; /*运行后停留在最后的地方*/
            }
            .addbldlist_title
            {
                width: 100%;
                height: 50px;
                text-align: left;
                background: #ec5858;
                color: #FFF;
                line-height: 50px;
                padding: 0 20px;
                border-bottom: 1px solid #ccc;
                font-size:18px;
            }
            .addbldlist_sec_title{
                width:240px;
                background: rgba(232, 232, 232, 0.45);
            }
            .addbldlist_div table{
                width:100%;
            }
            .addbldlist_div table th,.addbldlist_div table td{
                text-align:center;
                color:#000;
            }

            .bld_bottom 
            {
                position: absolute;
                bottom: 0px;
                width: 100%;
                text-align: center;
                background: #eff3f8;
                color: #FFF;
                height: 50px;
            }
            .bld_bottom input{
                float: right;
                margin-right: 10px;
                margin-top: 10px;
                width: 20%;
                border: 0;
                background: #abbac3;
                color: #FFF;
                padding: 6px 0;
            }
            .bld_bottom .save{
                background-color: #428bca;
            }
            .pc_edit_btn{
                /*float:left;width:48%;*/
                margin-right:5px;
            }
            .bld_edit_btn{
                margin-right: 5px;
            }
            .pc_edit_div,.bld_edit_div{ 
                width:40%;
                height:370px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%,-20%); 
                box-shadow:rgb(136, 136, 136) -5px 5px 15px;
                background: rgb(255, 255, 255);
                z-index:999;
                display:none;
                
                animation: showdiv1 0.3s;
                -moz-animation: showdiv1 0.3s;	/* Firefox */
                -webkit-animation: showdiv1 0.3s;	/* Safari 和 Chrome */
                -o-animation: showdiv1 0.3s;	/* Opera */
                -webkit-animation-fill-mode:forwards; /*运行后停留在最后的地方*/
            }
            .bld_edit_div table{
                line-height: 40px;
                margin-top: 20px;
            }
            .bld_edit_div table .left{
                width: 35%;
                text-align: right;
                padding-right: 10px;
                font-weight: bold;
            }
            
            .pc_edit_div table{
                line-height: 40px;
                margin-top: 20px;
            }
            .pc_edit_div table .left{
                width: 35%;
                text-align: right;
                padding-right: 10px;
                font-weight: bold;
            }
            
            #bldlisttb>tr{
                cursor: pointer;
                border-bottom: 1px solid #eff3f8;
            }
            .tr_c{
                cursor: pointer;
            }
            .showImg{
                text-decoration: underline!important;
            }
            #hx-img{
                position: absolute;
                /*background-color: #ff4334;*/
                z-index: 100;
                display: none;
            }
            #hx-img img{
                width: 200px;

            }
        </style>
        <div id="hx-img">
            <img src="" alt="无图片">
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-header">
                    <div class="addbldlist_div" id="bldlistdiv">
                        <div  class="addbldlist_title">选择楼栋</div>
                        <div id="bldsinfodiv" style="height: 360px;overflow-y: auto;">
                        <table style="background-color: #FFF;">
                            <thead class="addbldlist_sec_title">
                                <tr>
                                    <th style="width:20%" ><input type="checkbox"   id="chkall"  name="chkall"></td>
                                    <th style="width:40%;font-size:13px">楼栋名称</td>
                                    <th style="width:40%;font-size:13px">楼栋编号</td>
                                </tr>
                            </thead>	
                            <tbody id="bldlisttb">

                            </tbody>
                        </table>
                         </div>    
                        <div class="bld_bottom">
                            <input style="line-height: normal;" class="addbld_btn save" id="addqz" type="button" value="确定" onclick="pcaddbld()"/>
                            <input style="line-height: normal;" class="addbld_btn" type="button" value="取消" onclick="ycdiv()"/>
                        </div>
                    </div>

                    <span >批次楼栋列表</span>            
                </div>
                <div class="show_content_m_t2">
                    <div style="display:block;float:left;line-height: 38px;background: #eff3f8;width:100%;padding:0 0 3px 0">
                            <font style="margin-left:10px;">项目</font>
                            <select id= "projectlist" name="projectlist" style="padding: 1px 10px;height: 25px;" >
                                <?php if($selectedproj['id'] > 0): if(is_array($projectlist)): foreach($projectlist as $key=>$projectlist_vo): if($selectedproj['id'] == $projectlist_vo['id']): ?><option value="<?php echo ($projectlist_vo['id']); ?>" selected>
                                                <?php echo ($projectlist_vo['company_name']); ?>--<?php echo ($projectlist_vo['name']); ?> 
                                            </option>
                                            <?php else: ?>		 
                                            <option value="<?php echo ($projectlist_vo['id']); ?>">
                                                <?php echo ($projectlist_vo['company_name']); ?>--<?php echo ($projectlist_vo['name']); ?>
                                            </option><?php endif; endforeach; endif; ?> 
                                    <?php else: ?>
                                    <option value="0" selected></option>
                                    <?php if(is_array($projectlist)): foreach($projectlist as $key=>$projectlist_vo): ?><option value="<?php echo ($projectlist_vo['id']); ?>">
                                            <?php echo ($projectlist_vo['company_name']); ?>--<?php echo ($projectlist_vo['name']); ?> 
                                        </option><?php endforeach; endif; endif; ?>
                            </select>

                            <form method="post" id="selectproj" name="selectproj" action="index"  style="display:none">
                                <input type="text" id="projid" name="projid" value=""> 
                                <input type="submit" value="提交查询" class="button">  
                            </form>
                    </div>
                    <div style="float:left;width:55%;overflow-x:hidden;overflow-y:hidden">  
                        <div class="tags" style="width:100%">
                            <div id="tagstitle"></div>
                            <div id="tagscontent">
                                <div id="con_one_1">
                                    <div class="table_td" >
                                        <table border="0" cellspacing="2" cellpadding="4" class="list" name="pctable" id="pctable" width="100%">
                                            <thead>
                                                <tr>
                                                    <th align="center" style="width:20%">批次</th>
                                                    <th align="center" style="width:20%">状态</th>
                                                    <th align="center" style="width:20%">当前批次</th>
                                                    <th align="center" style="width:20%">平面图</th>
                                                    <th align="center" style="width:20%">操作</th>
                                                </tr>
                                            </thead> 
                                            <tbody>
                                            <?php if(is_array($kppclist)): foreach($kppclist as $i=>$kppc_vo): if($i == 0): ?><tr class="tr_c selectpc pctr_<?php echo ($kppc_vo['id']); ?>" onmouseover="this.bgColor = '#F5F5F5';" onmouseout="this.bgColor = '#ffffff';" bgcolor="#ffffff" pcid="<?php echo ($kppc_vo['id']); ?>" data_id="<?php echo ($i); ?>">   
                                                        <td align="center"><?php echo ($kppc_vo['name']); ?></td> 
                                                        <td align="center"><?php echo ($kppc_vo['zt']); ?></td>
                                                    <?php if($kppc_vo['is_dq'] == 0): ?><td align="center">否</td>
                                                        <?php else: ?>
                                                        <td align="center">是</td><?php endif; ?>
                                                        <td align="center">
                                                            <a href="#" class="showImg" data-url="<?php echo ($kppc_vo['plan']); ?>">预览</a>
                                                        </td>
                                                    <td align="center" style="height:35px"> 
                                                        <a class="pc_edit_btn"  href="javascript:void(0);"  title="编辑">
                                                             <span class="" style="padding: 3px 3px;background-color: #6fb3e0;color: #FFF;">
								<i class="icon-edit bigger-120"></i>
                                                            </span>
                                                        </a>
                                                        <div class="xzblddiv" >选楼栋</div>
                                                    </td> 
                                                    </tr>
                                                <?php else: ?>
                                                    <tr class="tr_c  pctr_<?php echo ($kppc_vo['id']); ?>" onmouseover="this.bgColor = '#F5F5F5';" onmouseout="this.bgColor = '#ffffff';" bgcolor="#ffffff" pcid="<?php echo ($kppc_vo['id']); ?>" data_id="<?php echo ($i); ?>">   
                                                        <td align="center"><?php echo ($kppc_vo['name']); ?></td> 
                                                        <td align="center"><?php echo ($kppc_vo['zt']); ?></td>
                                                    <?php if($kppc_vo['is_dq'] == 0): ?><td align="center">否</td>
                                                        <?php else: ?>
                                                        <td align="center">是</td><?php endif; ?>
                                                    <td align="center">
                                                        <a href="#" class="showImg" data-url="<?php echo ($kppc_vo['plan']); ?>">预览</a>
                                                    </td>
                                                    <td align="center" style="height:35px"> 
                                                        <a class="pc_edit_btn"  href="javascript:void(0);"  title="编辑">
                                                            <span class="" style="padding: 3px 3px;background-color: #6fb3e0;color: #FFF;">
								<i class="icon-edit bigger-120"></i>
                                                            </span>
                                                        
                                                        </a>
                                                        <div class="xzblddiv" >选楼栋</div>
                                                    </td> 
                                                    </tr><?php endif; endforeach; endif; ?> 
                                            <?php if($selectedproj['id'] > 0): if(count($kppclist) > 0): ?><tr class="tr_c" onmouseover="this.bgColor = '#F5F5F5';" onmouseout="this.bgColor = '#ffffff';" bgcolor="#ffffff" pcid="999" data_id="999">   
                                                        <td align="center" style="font-weight: bold;color: red;">未分配批次楼栋</td> 
                                                        <td align="center"></td>
                                                        <td align="center"></td>
                                                        <td align="center"></td>
                                                        <td align="center" style="height:35px"></td>
                                                    </tr><?php endif; endif; ?>
                                            </tbody> 
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
                <div style="float:left;width:41%;margin-left:4%;overflow-x:hidden;overflow-y:hidden;"> 
                    <div class="tags" style="width:100%">
                        <div id="tagstitle"></div>
                        <div id="tagscontent">
                            <div id="con_one_1">
                                <div class="table_td">
                                    <table border="0" cellspacing="2" cellpadding="4" class="list" name="table1" id="table1" width="100%">
                                        <thead>
                                            <tr>
                                                <th align="center" style="width:30%">楼栋名称</th>
                                                <th align="center" style="width:30%">楼栋编号</th> 
                                                <th align="center" style="width:30%">操作</th>
                                            </tr>
                                        </thead> 
                                        <tbody id="bldtb" name="bldtb" >
                                        <?php if(is_array($kppclist[0][0])): foreach($kppclist[0][0] as $key=>$bldlist_vo): ?><tr class="s_out"  bgcolor="#ffffff" pcid="<?php echo ($bldlist_vo['pc_id']); ?>" id="trid_<?php echo ($bldlist_vo['id']); ?>"> 
                                                <td align="center"><?php echo ($bldlist_vo['buildname']); ?></td> 
                                                <td align="center"> <?php echo ($bldlist_vo['buildcode']); ?> </td> 
                                                <td align="center" style="height:35px">
                                                     <a class="bld_edit_btn"  href="javascript:void(0);"  title="编辑" bldid="<?php echo ($bldlist_vo['id']); ?>">
                                                        <span style="padding: 3px 3px;background-color: #6fb3e0;color: #FFF;">
                                                           <i class="icon-edit bigger-120"></i>
                                                       </span>
                                                    </a>
                                                    <a onclick="pcdelbld(<?php echo ($bldlist_vo['pc_id']); ?>,<?php echo ($bldlist_vo['id']); ?>)" title="删除">
                                                       <span style="padding: 3px 5px;background-color: #d15b47;color: #FFF;">
                                                            <i class="icon-trash bigger-120"></i>
                                                        </span>
                                                    </a> 
                                                </td>
                                            </tr><?php endforeach; endif; ?> 
                                        </tbody> 
                                    </table>
                                    <div class="blank20"></div> 	
                                    <div class="blank20"></div>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div> 
            </div>
        </div>
        <div class="pc_edit_div">
            <form method="post" name="form1" action="" enctype="multipart/form-data" id="update-pc">
                <div> <div  class="addbldlist_title">编辑批次信息</div>
                    <table border="0" cellspacing="2" cellpadding="4" class="list" name="table" id="table" width="100%" >
                        <tbody>
                            <tr onmouseover="this.bgColor = '#F5F5F5';" onmouseout="this.bgColor = 'ffffff';" bgcolor="ffffff">
                                <td class="left">批次名称</td>
                                <td><input type="text" name="name" id="pcname" value="<?php echo ($pcinfo[0]['name']); ?>" class="skey" style="width:150px;"> </td>
                            </tr>
                            <tr onmouseover="this.bgColor = '#F5F5F5';" onmouseout="this.bgColor = 'ffffff';" bgcolor="ffffff">
                                <td class="left">开盘时间</td>
                                <td><input type="text" name="kptime" id="kptime" value="<?php echo ($pcinfo[0]['kptime']); ?>" class="skey" style="width:150px;"</td>
                            </tr>
                            <tr onmouseover="this.bgColor = '#F5F5F5';" onmouseout="this.bgColor = 'ffffff';" bgcolor="ffffff">
                                <td class="left">当前批次</td>
                                <td>
                        <?php if($pcinfo[0]['is_dq'] == 1): ?><input type="radio" id="dq_yes" name="is_dq"  value="1" class="skey" checked>
                           <label for="dq_yes" style="margin: -8px 10px 0 0;">是</label>
                           <input type="radio" id="dq_no" name="is_dq"  value="0" class="skey" >
                           <label for="dq_no" style="margin: -8px 10px 0 0;">否</label>
                            <?php else: ?>
                            <input type="radio" id="dq_yes" name="is_dq"  value="1" class="skey" >
                            <label for="dq_yes" style="margin: -8px 10px 0 0;">是</label>
                            <input type="radio" id="dq_no" name="is_dq"  value="0" class="skey" checked>
                            <label for="dq_no" style="margin: -8px 10px 0 0;">否</label><?php endif; ?>
                        </td>
                        </tr>
                        <tr onmouseover="this.bgColor = '#F5F5F5';" onmouseout="this.bgColor = 'ffffff';" bgcolor="ffffff">
                            <td class="left">是否启用</td>
                            <td>
                        <?php if($pcinfo[0]['is_yx'] == 1): ?><input type="radio" id="yx_yes" name="is_yx"  value="1" class="skey" checked>
                            <label for="yx_yes" style="margin: -8px 10px 0 0;">是</label>
                            <input type="radio" id="yx_no" name="is_yx"  value="0" class="skey" >
                            <label for="yx_no" style="margin: -8px 10px 0 0;">否</label>
                            <?php else: ?>
                            <input type="radio" id="yx_yes" name="is_yx"  value="1" class="skey" >
                            <label for="yx_yes" style="margin: -8px 10px 0 0;">是</label>
                            <input type="radio" id="yx_no" name="is_yx"  value="0" class="skey" checked>
                            <label for="yx_no" style="margin: -8px 10px 0 0;">否</label><?php endif; ?>
                        </td>
                        </tr>
                            <tr onmouseover="this.bgColor = '#F5F5F5';" onmouseout="this.bgColor = 'ffffff';" bgcolor="ffffff">
                                <td class="left">上传图片</td>
                                <td>
                                    <input type="file" name="plan"  accept="image/jpeg,image/png" style="line-height: 100%;">
                                </td>
                            </tr>
                        </tbody> 
                    </table>
                </div>
                <div class="blank20"></div>
                <div class="bld_bottom">
                    <input class="save" type="button" value="保存" onclick="savekppc()"> 
                    <input type="button" value="取消" onclick="ycdiv();"> 
                </div>
            </form>
        </div>
        
        <div class="bld_edit_div" >
            <form method="post" name="form2" action="">
                <div> <div  class="addbldlist_title">编辑楼栋信息</div>
                    <table border="0" cellspacing="2" cellpadding="4" class="list" name="table" id="table" width="100%" >
                        <tbody>
                            <tr onmouseover="this.bgColor = '#F5F5F5';" onmouseout="this.bgColor = 'ffffff';" bgcolor="ffffff">
                                <td class="left">楼栋名称</td>
                                <td><input type="text" name="bldname" id="bldname" value="<?php echo ($bldinfo[0]['bulidname']); ?>" class="skey" style="width:150px;"> </td>
                            </tr>
                            <tr onmouseover="this.bgColor = '#F5F5F5';" onmouseout="this.bgColor = 'ffffff';" bgcolor="ffffff">
                                <td class="left">楼栋编号</td>
                                <td><input type="text" name="bldcode" id="bldcode" value="<?php echo ($bldinfo[0]['bulidcode']); ?>" class="skey" style="width:150px;"</td>
                            </tr>
                            <tr onmouseover="this.bgColor = '#F5F5F5';" onmouseout="this.bgColor = 'ffffff';" bgcolor="ffffff">
                                <td class="left">楼栋属性</td>
                                <td>
                        <?php if($pcinfo[0]['bldtype'] == 1): ?><input type="radio" id="blda" name="bldtype"  value="0" class="skey" checked><label for="blda" style="margin: -8px 10px 0 0;">住宅</label>
                            <input type="radio" id="bldb"  name="bldtype"  value="1" class="skey" ><label for="bldb" style="margin: -8px 10px 0 0;">车位</label>
                            <?php else: ?>
                            <input type="radio" id="blda"  name="bldtype"  value="0" class="skey" ><label for="blda" style="margin: -8px 10px 0 0;">住宅</label>
                            <input type="radio" id="bldb"  name="bldtype"  value="1" class="skey" checked><label for="bldb" style="margin: -8px 10px 0 0;">车位</label><?php endif; ?>
                        </td>
                        </tr>
                        </tbody> 
                    </table>
                </div>
                <div class="blank20"></div>
                <div class="bld_bottom">
                    <input class="save" type="button" value="保存" onclick="savebld()"> 
                    <input type="button" value="取消" onclick="ycdiv();"> 
                </div>
            </form>
        </div>
    
										
										<!-- PAGE CONTENT ENDS -->
									</div><!-- /.col -->
								</div><!-- /.row -->
								
								
									
								
								
							</div><!-- /.page-content -->
						</div><!-- /.main-content -->

						
					</div><!-- /.main-container-inner -->

					<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
						<i class="icon-double-angle-up icon-only bigger-110"></i>
					</a>
				</div><!-- /.main-container -->
			
			
			
			<!-- basic scripts -->
			
				<!--[if !IE]> -->
					<!--<script src="/Public/account/assets/js/jquery-2.1.1.min.js"></script>-->
				<!-- <![endif]-->
				<!--[if IE]>
					<!--<script src="/Public/account/assets/js/jquery-1.10.2.min.js"></script>-->
				<!--<![endif]&ndash;&gt;-->

				<!--[if !IE]> -->
					<!--<script type="text/javascript">-->
						<!--window.jQuery || document.write("<script src='/Public/account/assets/js/jquery-2.1.1.min.js'>"+"<"+"script>");-->
					<!--</script>-->
				<!-- <![endif]-->
				<!--[if IE]>
					<!--<script type="text/javascript">-->
						<!--window.jQuery || document.write("<script src='/Public/account/assets/js/jquery-1.10.2.min.js'>"+"<"+"script>");-->
					<!--</script>-->
				<!--<![endif]&ndash;&gt;-->

				<script type="text/javascript">
					if("ontouchend" in document) document.write("<script src='/Public/account/assets/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
				</script>
				<script src="/Public/account/assets/js/bootstrap.min.js"></script>
				<script src="/Public/account/assets/js/typeahead-bs2.min.js"></script>
			
			
			<!-- page specific plugin scripts -->
			

			<!-- ace scripts -->
			
				<script src="/Public/account/assets/js/ace-elements.min.js"></script>
				<script src="/Public/account/assets/js/ace.min.js"></script>
			
			
			
			<!-- inline scripts related to this page -->
			
        <script type="text/javascript">

            //展示预览图
            $(document).on("mouseover","#pctable .showImg",function () {
                var obj=$(this).offset();
                var img=$("#hx-img");
                var url=$.trim($(this).attr("data-url"));
                img.css({'top':(obj.top-80),'left':(obj.left-160)});
                img.find("img").attr("src",url);
                img.show();
            });
            $(document).on("mouseout","#pctable .showImg",function () {
                var img=$("#hx-img");
                img.hide();
            });
            $("#projectlist").change(function(){
                $("#projid").val($("#projectlist option:selected").val());
                $("#selectproj").submit();
            });
            $(".tr_c").click(function(){
            if (!$(this).hasClass("selectpc"))
            {
            var $trlist = $("#pctable").find("tr");
            for (var $i = 0; $i < $trlist.length; $i++)
            {
            $trlist.eq($i).removeClass("selectpc");
            }
            $(this).addClass("selectpc");
            var $projid = $("#projectlist option:selected").val();
            showbldist($(this).attr("pcid"), $projid);
            }

            });

            //获取对应的楼栋
            function showbldist($pcid, $projid)
            {
            $("#bldtb").html("");
            var pcset_url = {getbldlist: '<?php echo U("getbldlist");?>', }
            $.ajax({
            url: pcset_url.getbldlist,
                    data: {
                    pcid: $pcid,
                            projid: $projid,
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (data, status) {
                    if (typeof (data.status) == 'undefined') {
                    layer_alert('请求失败，请重试！');
                    return false;
                    }
                    if (data.status == false) {
                    alert(data.info);
                    return false;
                    }
                    var $bldlist = data.info;
                    var $temphtml = "";
                    if ($bldlist.length > 0) {

                    for (var $i = 0; $i < $bldlist.length; $i ++) {
                    $temphtml += "<tr class='s_out'  bgcolor='#ffffff'id='trid_" + $bldlist[$i].id + "' >";
                    $temphtml += "<td align='center'>" + $bldlist[$i].buildname + "</td> ";
                    $temphtml += "<td align='center'>" + $bldlist[$i].buildcode + "</td> ";
                    $temphtml += "<td align='center' style='height:35px'>";
                    $temphtml += "<a class='bld_edit_btn'  href='javascript:void(0);'  title='编辑' bldid='" + $bldlist[$i].id + "'>";
                    
                    $temphtml += "  <span style='padding: 3px 3px;background-color: #6fb3e0;color: #FFF;'>";
                    $temphtml += "	<i class='icon-edit bigger-120'></i>";
                    $temphtml += "  </span></a>";
                    if ($bldlist[$i].pc_id > 0) 
                    {
                        $temphtml += "<a onclick='pcdelbld(" + $bldlist[$i].pc_id + "," + $bldlist[$i].id + ")' ><span style='padding: 3px 5px;background-color: #dc2d0e;color: #FFF;' title='删除'><i class='icon-trash bigger-120'></i></span></a>";
                    }
                    $temphtml += "</td></tr> ";
                    }
                    $("#bldtb").html($temphtml);
                    }

                    },
                    error: function (data, status, e) {
                    layer_alert('提交连接失败！');
                    }
            });
            }

            function pcdelbld($pcid, $id)
            {
            if ($pcid == 0 || $pcid == "")
            {
            layer_alert("数据异常，请稍后重试");
            return false;
            }
            var pcset_url = {pcdelbld: '<?php echo U("pcdelbld");?>', }
            $.ajax({
            url: pcset_url.pcdelbld,
                    data: {
                    pcid: $pcid,
                            id: $id,
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (data, status) {
                    if (typeof (data.status) == 'undefined') {
                    layer_alert('请求失败，请重试！');
                    return false;
                    }
                    if (data.status == false) {
                    alert(data.info);
                    return false;
                    }
                    layer_alert("操作成功");
                    $("#trid_" + $id).remove();
                    //window.location.reload();
                    },
                    error: function (data, status, e) {
                    layer_alert('提交连接失败！');
                    }
            });
            }

            //编辑批次信息
            $(".pc_edit_btn").on('click', function(){
            var $pcid = $(this).parent().parent().attr("pcid");
            var pcset_url = {editkppc: '<?php echo U("editkppc");?>', }
                $.ajax({
                url: pcset_url.editkppc,
                        data: {
                            pcid: $pcid,
                            },
                            type: 'POST',
                            dataType: 'JSON',
                            success: function (data, status) {
                            if (typeof (data.status) == 'undefined') {
                            layer_alert('请求失败，请重试！');
                            return false;
                        }
                        if (data.status == false) {
                            layer_alert(data.info);
                            return false;
                        }
                        var $pcinfo = data.info;
                        $(".pc_edit_div").attr('pc_id', $pcinfo[0].id);
                        $("#pcname").val($pcinfo[0].name);
                        $("#kptime").val($pcinfo[0].kptime);
                        if ($pcinfo[0].is_dq == 1)
                        {
                            $("input:radio[name='is_dq']").eq(0).prop("checked", true);
                        }
                        else
                        {
                            $("input:radio[name='is_dq']").eq(1).prop("checked", true);
                        }
                        if ($pcinfo[0].is_yx == 1)
                        {
                            $("input:radio[name='is_yx']").eq(0).prop("checked", true);
                        }
                        else
                        {
                            $("input:radio[name='is_yx']").eq(1).prop("checked", true);
                        }
                            $(".pc_edit_div").show();
                            $("#zz_div").show();
                        },
                        error: function (data, status, e) {
                            gritter_alert('提交连接失败！');
                        }
                });
            });

            function savekppc()
            {
                var $proj_id = $("#projectlist option:selected").val();
                var $id = $(".pc_edit_div").attr('pc_id');
                var $name = $("#pcname").val();
                var $is_yx = $('input[name="is_yx"]:checked').val();
                var $is_dq = $('input[name="is_dq"]:checked').val();
                var $kptime = $("#kptime").val();
                var obj=new FormData($("#update-pc")[0]);
                obj.append('id',$id);
                obj.append('proj_id',$proj_id);
                if ($proj_id == 0)
                {
                layer_alert("数据异常，请重试");
                return false;
                }
                var kppc_url = {kppcedit: '<?php echo U("savekppc");?>', }
                $.ajax({
                url: kppc_url.kppcedit,
                    data: obj,
                    type: 'POST',
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
//                    dataType: 'JSON',
                    success: function (data, status) {
//                        alert(data);
//                        console.log(data);
//                        return false;
                        if (typeof (data.status) == 'undefined') {
                            layer_alert('请求失败，请重试！');
                            return false;
                        }
                        if (data.status == false) {
                            layer_alert(data.info);
                            return false;
                        }
                        $("#zz_div").hide();
                        $(".pc_edit_div").hide();
                        $onepc=$(".pctr_"+$id).find("td");
                        $onepc.eq(0).text($name);
                        if ($is_yx==1)
                        {
                            $onepc.eq(1).text("开启");
                        }
                        else
                        {
                            $onepc.eq(1).text("关闭");
                        }
                        if ($is_dq==1)
                        {
                            $onepc.eq(2).text("是");
                        }
                        else
                        {
                            $onepc.eq(2).text("否");
                        }
                        
                        layer_alert('更改成功！');
                        window.location.reload();
                    },
                    error: function (data, status, e) {
                        layer_alert('提交连接失败！');
                        window.location.reload();
                    }
                });
            }

            $(".xzblddiv").on('click', function(){
            var $projid = $("#projectlist option:selected").val();
            var $pcid = $(this).parent().parent().attr("pcid");
            var pcset_url = {getbldlist: '<?php echo U("getbldlist");?>', }
            $.ajax({
            url: pcset_url.getbldlist,
                    data: {
                    pcid: 999,
                            projid: $projid,
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (data, status) {
                    if (typeof (data.status) == 'undefined') {
                    layer_alert('请求失败，请重试！');
                    return false;
                    }
                    if (data.status == false) {
                    alert(data.info);
                    return false;
                    }
                    var $bldlist = data.info;
                    var $temphtml = "";
                    if ($bldlist.length > 0) {
                    for (var $i = 0; $i < $bldlist.length; $i ++) {
                    $temphtml += "<tr id='pcbldid_" + $bldlist[$i].id + "' class='trcb' >";
                    $temphtml += "<td class='tdcb'><input type='checkbox' class='selectbuild' name='subBox'   value='" + $bldlist[$i].id + "'></td> ";
                    $temphtml += "<td>" + $bldlist[$i].buildname + "</td> ";
                    $temphtml += "<td>" + $bldlist[$i].buildcode + "</td> ";
                    $temphtml += "</tr> ";
                    }
                    $("#addqz").attr("addpc_id", $pcid);
                    $("#addqz").attr("addproj_id", $projid);
                    $("#bldlisttb").html("").html($temphtml);
                    $("#bldlistdiv").css("height","75vh").show();
                    $allheight=$("#bldlistdiv").height();
                    $("#bldsinfodiv").css("height",$allheight -100)
                    $("#zz_div").show();
                    }
                    else
                    {
                    layer_alert('楼栋已分配完');
                    }

                    },
                    error: function (data, status, e) {
                    layer_alert('提交连接失败！');
                    }
            });
            });
            function pcaddbld()
            {
            var $pcid = $("#addqz").attr("addpc_id");
            var $projid = $("#addqz").attr("addproj_id");
            var $bldlist = "";
            var $allbld = $("#bldlisttb").find(".selectbuild")

                    for (var i = 0; i < $allbld.length; i++)
            {
            if ($allbld.eq(i).is(':checked'))
                    $bldlist += $allbld.eq(i).val() + "|";
            }

            if ($bldlist == "")
            {
            layer_alert('请选择楼栋！');
            return false;
            }
            else{
            $bldlist = $bldlist.substring(0, $bldlist.length - 1);
            }

            var pcset_url = {pcaddbld: '<?php echo U("pcaddbld");?>', }
            $.ajax({
            url: pcset_url.pcaddbld,
                    data: {
                    pcid: $pcid,
                            projid: $projid,
                            bldlist:$bldlist,
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (data, status) {
                    if (typeof (data.status) == 'undefined') {
                    layer_alert('请求失败，请重试！');
                    return false;
                    }
                    if (data.status == false) {
                    alert(data.info);
                    return false;
                    }
                    $("#bldlistdiv").hide();
                    $("#zz_div").hide();
                    layer_alert("操作成功");
                    showbldist($pcid, $projid);
                    },
                    error: function (data, status, e) {
                    layer_alert('提交连接失败！');
                    }
            });
            }

            $("#chkall").click(function() {
            $('input[name="subBox"]').prop("checked", this.checked);
            });
            $("#bldlisttb").on('selectbuild click', function(){
            $subBox = $('input[name="subBox"]');
            $("#chkall").prop("checked", $subBox.length == $("input[name='subBox']:checked").length ? true : false);
            });
            
            //隐藏编辑图层及内容
            function ycdiv()
            {
                $("#bldlistdiv").hide();
                $(".pc_edit_div").hide();
                $(".bld_edit_div").hide();
                $("#zz_div").hide();
            }
            
            $(".addbldlist_div table").on("click",".trcb",function(){
                if ($(this).first().find("input").prop("checked"))
                    $(this).first().find("input").prop("checked", false);
                else
                    $(this).first().find("input").prop("checked", true);
            });
            
            $(".addbldlist_div table").on("click",".selectbuild",function(){
                if ($(this).prop("checked"))
                    $(this).prop("checked", false);
                else
                    $(this).prop("checked", true);
            });
            
            
            //编辑楼栋信息
           $("#table1").on('click','.bld_edit_btn',function(){
            //$(".bld_edit_btn").on('click',function(){
            var $bldid = $(this).attr("bldid");
            var bldset_url = {editbld: '<?php echo U("editbld");?>', }
            $.ajax({
            url: bldset_url.editbld,
                    data: {
                    bldid: $bldid,
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (data, status) {
                        if (typeof (data.status) == 'undefined') {
                        layer_alert('请求失败，请重试！');
                        return false;
                        }
                        if (data.status == false) {
                        layer_alert(data.info);
                        return false;
                        }
                        var $bldinfo = data.info;
                        $(".bld_edit_div").attr('bld_id', $bldinfo[0].id);
                        $("#bldname").val($bldinfo[0].buildname);
                        $("#bldcode").val($bldinfo[0].buildcode);
                        if ($bldinfo[0].bldtype == 1)
                        {
                            $("input:radio[name='bldtype']").eq(1).prop("checked", true);
                        }
                        else
                        {
                            $("input:radio[name='bldtype']").eq(0).prop("checked", true);
                        }
                        $(".bld_edit_div").show();
                        $("#zz_div").show();
                    },
                    error: function (data, status, e) {
                        gritter_alert('提交连接失败！');
                    }
            });
            });
            
            function savebld()
            {
                var $proj_id = $("#projectlist option:selected").val();
                var $id = $(".bld_edit_div").attr('bld_id');
                var $name = $("#bldname").val();
                var $code = $("#bldcode").val();
                var $bldtype = $('input[name="bldtype"]:checked').val();
                if ($proj_id == 0)
                {
                layer_alert("数据异常，请重试");
                return false;
                }
                var bld_url = {savebld: '<?php echo U("savebld");?>', }
                $.ajax({
                url: bld_url.savebld,
                        data: {
                            id: $id,
                            proj_id: $proj_id,
                            buildname: $name,
                            buildcode: $code,
                            bldtype: $bldtype,
                        },
                        type: 'POST',
                        dataType: 'JSON',
                        success: function (data, status) {
                            if (typeof (data.status) == 'undefined') {
                                layer_alert('请求失败，请重试！');
                                return false;
                            }
                            if (data.status == false) {
                                layer_alert(data.info);
                                return false;
                            }
                            $("#zz_div").hide();
                            $(".bld_edit_div").hide();
                            $onebld=$("#trid_"+$id).find("td");
                            $onebld.eq(0).text($name);
                            $onebld.eq(1).text($code);
                            layer_alert('更改成功！');
                        },
                        error: function (data, status, e) {
                            layer_alert('提交连接失败！');
                        }
                });
            }

        </script>
    

			
				<script src="/Public/account/assets/js/jquery.gritter.min.js"></script>
				<script src="/Public/account/js/layer/layer.js"></script>
				<script src="/Public/account/js/pc/layer.js"></script>
				<script src="/Public/account/js/pc/functions.js"></script>
				<script src="/Public/account/js/functions.js"></script>
				<script src="/Public/account/js/account.js"></script>
			
			
		</body>
	
	
</html>
<script>
        //控制一级模块选中后的样式
        var nav_li=$('.nav-list>li');
        var o_count=0;
        for(var i=0;i<nav_li.length;i++){
            var tx=$.trim(nav_li.eq(i).find('a').find("span").text());
            if( tx==='<?php echo ($classify_name); ?>'){
//		    alert();
                if(tx==='客户信息'){
                    nav_li.eq(i).addClass("active");
                    break;
                }else if(tx==='客户签到'){
                    nav_li.eq(i).addClass("active");
                    break;
                }else if(tx==='交易管理'){
                    nav_li.eq(i).addClass("active");
                    break;
                }
                else{
                    nav_li.eq(i).addClass("open active");
                    break;
                }
            }else{
                if('<?php echo ($classify_name); ?>'==='控制台'){
                    nav_li.eq(0).addClass("active");
                    break;
                }else if('<?php echo ($classify_name); ?>'==='客户信息'){
                    if(o_count===(nav_li.length-1)){
                        window.location.href="<?php echo U('/Account/Base/error_page');?>";
                    }
                }else if('<?php echo ($classify_name); ?>'==='客户签到'){
                    if(o_count===(nav_li.length-1)){
                        window.location.href="<?php echo U('/Account/Base/error_page');?>";
                    }
                }else if('<?php echo ($classify_name); ?>'==='交易管理'){
                    if(o_count===(nav_li.length-1)){
                        window.location.href="<?php echo U('/Account/Base/error_page');?>";
                    }
                }
                o_count++;
            }
        }
    //控制二级模块选中后的样式
        if('<?php echo ($classify_name); ?>' !=="客户信息" && '<?php echo ($classify_name); ?>' !=="控制台" && '<?php echo ($classify_name); ?>' !=="客户签到" && '<?php echo ($classify_name); ?>' !=="交易管理" && '<?php echo ($classify_name); ?>' !==""){
        var two_nav_li=$('.nav-list>li>ul>li');
        var m_count=0;
        for(var i=0;i<two_nav_li.length;i++){
            var tx=$.trim(two_nav_li.eq(i).find('a').text());
            if( tx==='<?php echo ($seo_title); ?>'){
                two_nav_li.eq(i).addClass("active");
                break;
            }else{
                                if(m_count===(two_nav_li.length-1)){
                        window.location.href="<?php echo U('/Account/Base/error_page');?>";
                                }
                m_count++;
            }
        }
        }

</script>