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
var admission={
    user_list:'<?php echo U("/Account/Admission/user_list");?>',
    admission:'<?php echo U("/Account/Admission/sign");?>',
    check_excel:'<?php echo U("/Account/Admission/check_excel");?>'
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

	
	<style>
		#error{
			float: right;
			margin-right: 10px;
			color:#FFF;
                        cursor: pointer;
		}
		#error div{
			border: 1px solid #FFF;
			width: 11px;
			height: 11px;
			border-radius:5px ;
			float: right;
			margin: 13px;
		}
		#error div div{
			width: 7px;
			height: 7px;
			border-radius:4px ;
			float: right;
			margin: 1px;
		}
		.table thead>tr>th, .table tbody>tr>th, .table tfoot>tr>th, .table thead>tr>td, .table tbody>tr>td, .table tfoot>tr>td {
			padding: 8px;
			line-height: 1.428571429;
			vertical-align: middle;
		}
		#pl-off,#pl-open{
			margin-left: 3px;
		}
		a:link{
			text-decoration: none;
		}
		#form-p,#form-b{
			display: inline;
		}
                .btn-xs {
                    border-width: 1px;
                }
		#sample-table-2_length label{
			margin-left: 10px;
		}
	</style>
	<li class="active">客户信息</li>

	
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
										
	<!--预定房间模态框-->
	<div class="modal fade" id="yd_room" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">预定房间</h4>
				</div>
				<div class="modal-body" style="text-align: center">
					<span id="pid" style="display: none"></span>
					<span id="bid" style="display: none"></span>
					<input type="hidden" id="user_id">
					<p id="oldyd" style="display: none;font-size: 14px;width:233px;text-align:left;margin-left:146px;color: gray">原预订房：<span></span></p>
					<p id="dqyd" style="display: none;font-size: 14px;width:233px;text-align:left;margin-left:146px;color: gray">当前选择：<span></span></p>
					<label ><span id="croomtitle">选择房间</span>：<input type="text" placeholder="请输入房间号查询" id="q_room_id" style="width:170px;"></label>
					<ul style="display: none;list-style: none;border: 1px solid #eee;width: 170px;margin-top: -5px;margin-left: 212px" id="q_room_list">
					</ul>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                        <button type="button" class="btn btn-default" id="update_qx" style="float: left;">取消预定</button>
					<button type="button" class="btn btn-primary" id="update_yd">提交</button>
				</div>
			</div>
		</div>
	</div>
	<!--预定房间模态框-->
<div class="row">

	<div class="col-xs-12">
	
		<div class="table-header">
			客户信息列表
			<?php if($search_uid == 0): ?><div id="error" data-zt="0">只显示置业顾问异常
					<div></div>
				</div>
				<?php else: ?>
				<div id="error" data-zt="1">只显示置业顾问异常
					<div >
						<div style="background-color: #FFF"></div>
					</div>
				</div><?php endif; ?>

		</div>
		<div class="table-responsive dataTables_wrapper">
			<div class="row">
				<div class="col-sm-12">
					<div id="sample-table-2_length" class="dataTables_length">
						<form action="<?php echo U('/Account/ChooseUser/index');?>" method="post" id="form-p" >
						<label>
							项目 
							<select name="project_id" class="choose-user-project-id js-choose-user-project-id" style="width: auto;">
								<?php if(!empty($search_project_id)): ?><option value="">全部</option>
									<?php if(is_array($project_list)): foreach($project_list as $key=>$project_list_vo): if($search_project_id == $project_list_vo['id']): ?><option value="<?php echo ($project_list_vo['id']); ?>" selected>
												<?php echo ($project_list_vo['company_name']); ?> -- <?php echo ($project_list_vo['name']); ?>
											</option>
										<?php else: ?>		 
											<option value="<?php echo ($project_list_vo['id']); ?>">
												<?php echo ($project_list_vo['company_name']); ?> -- <?php echo ($project_list_vo['name']); ?>
											</option><?php endif; endforeach; endif; ?> 
								<?php else: ?>
									<option value="0" selected>全部</option>
									<?php if(is_array($project_list)): foreach($project_list as $key=>$project_list_vo): ?><option value="<?php echo ($project_list_vo['id']); ?>">
											<?php echo ($project_list_vo['company_name']); ?> -- <?php echo ($project_list_vo['name']); ?>
										</option><?php endforeach; endif; endif; ?>
							</select> 
						</label>
						</form>
						<form action="<?php echo U('/Account/ChooseUser/index');?>" method="post" id="form-b" >
						<label>							
							批次 
							<select name="batch_id" class="choose-user-batch-id js-choose-user-batch-id" style="width: auto;">
								<?php if(count($batch_list) != 1): ?><option value="">全部</option><?php endif; ?>
								<?php if(is_array($batch_list)): foreach($batch_list as $key=>$batch_list_vo): if($bid == $batch_list_vo['id']): ?><option value="<?php echo ($batch_list_vo['id']); ?>" selected>
										<?php echo ($batch_list_vo['name']); ?>
									</option>
									<?php else: ?>
									<option value="<?php echo ($batch_list_vo['id']); ?>" >
										<?php echo ($batch_list_vo['name']); ?>
									</option><?php endif; endforeach; endif; ?> 
							</select> 
						</label>

						<label>
							选房状态
							<select name="zt" class="choose-user-is-xf js-choose-user-is-xf" style="width: auto;" id="z_t">
								<option value="">全部</option>
								<?php if($zt == 1): ?><option value="1" selected>已选房</option>
									<?php else: ?>
									<option value="1" >已选房</option><?php endif; ?>
								<?php if($zt == 2): ?><option value="2" selected>未选房</option>
									<?php else: ?>
									<option value="2">未选房</option><?php endif; ?>

							</select>

						</label>

							<label>
							用户状态
							<select name="status" class="choose-user-is-xf" style="width: auto;" id="c_status">
								<option value="">全部</option>
								<?php if($status == '1'): ?><option value="1" selected>启用</option>
									<?php else: ?>
									<option value="1" >启用</option><?php endif; ?>
								<?php if($status == '0'): ?><option value="0" selected>未启用</option>
									<?php else: ?>
									<option value="0">未启用</option><?php endif; ?>
							</select>
						</label>
							<div class="nav-search" id="sample-table-2_filter" style="top:0;">
								<label class="input-icon">
									<input type="text" name="word" value="<?php echo ((isset($search_word) && ($search_word !== ""))?($search_word):''); ?>" class="nav-search-input js-choose-user-word" placeholder="姓名、手机、身份证">
									<i class="icon-search nav-search-icon" style="cursor: pointer;left:6px;" id="likeUsers"></i>
								</label>
							</div>
							<input type="hidden" name="project_id" value="<?php echo ($search_project_id); ?>">
							<input type="hidden" name="p" value="<?php echo ((isset($p) && ($p !== ""))?($p):1); ?>">
							<input type="hidden" name="uid" value="<?php echo ($search_uid); ?>">
							<input type="hidden" name="r" value="<?php echo ((isset($listRows) && ($listRows !== ""))?($listRows):10); ?>">
						</form>
					</div>
				</div>


			</div>
			
			<table id="sample-table-choose" class="table table-striped table-bordered table-hover dataTable">
				<thead>
					<tr>
						<th class="center hidden-480" style="min-width: 80px">
							<label>
								<input type="checkbox" class="ace">
								<span class="lbl"></span>
							</label>
						</th>
						<th class="hidden-480">项目</th>
						<th>客户姓名</th>
						<th >
							<i class="icon-phone bigger-110 hidden-480"></i>
							客户手机
						</th>
						<!--<th>
							<i class="icon-jpy bigger-110 hidden-480"></i>
							诚意金金额(元)
						</th>-->
						<th >身份证号码</th>
						<th>诚意金编号</th>
						<th>置业顾问</th>
						<th class="hidden-480">
							已选房源
						</th>
						<!--<th class="hidden-480">状态</th>-->
						<th class="hidden-480">预定房间</th>
						<th class="hidden-480">状态</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($choose_list)): $choose_key = 0; $__LIST__ = $choose_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$choose_vo): $mod = ($choose_key % 2 );++$choose_key;?><tr class="choose-user-item choose-user-item-<?php echo ((isset($choose_vo["id"]) && ($choose_vo["id"] !== ""))?($choose_vo["id"]):'0'); ?>">
							<td class="center hidden-480">
								<label>
									<?php if((empty($choose_vo['room'])) AND (empty($choose_vo['room_id']))): ?><input type="checkbox" class="ace choose-user-item-id" data-id="<?php echo ((isset($choose_vo["id"]) && ($choose_vo["id"] !== ""))?($choose_vo["id"]):'0'); ?>" delete="true">
										<?php else: ?>
										<input type="checkbox" class="ace choose-user-item-id" data-id="<?php echo ((isset($choose_vo["id"]) && ($choose_vo["id"] !== ""))?($choose_vo["id"]):'0'); ?>" delete="false"><?php endif; ?>
									<span class="lbl"></span>
								</label>
							</td>
							<td class="hidden-480">
								<nobr>
								<span>
									<?php echo ((isset($choose_vo["project_name"]) && ($choose_vo["project_name"] !== ""))?($choose_vo["project_name"]):''); ?>
								</span>
						
								<?php if(!empty($choose_vo["batch_name"])): ?><span class="label label-primary arrowed arrowed-right" style="margin-right: 2px;margin-left: 4px;"><?php echo ($choose_vo["batch_name"]); ?></span><?php endif; ?>
								</nobr>
							</td>
							<td><?php echo ((isset($choose_vo["customer_name"]) && ($choose_vo["customer_name"] !== ""))?($choose_vo["customer_name"]):''); ?></td>
							<td ><div style="width: 90px;word-wrap:break-word"><?php echo rsa_decode($choose_vo['customer_phone'],getChoosekey());?></div></td>
							<td><div style="width: 140px;word-wrap:break-word"><?php echo rsa_decode($choose_vo['cardno'],getChoosekey());?></div></td>
							<td><?php echo ((isset($choose_vo["cyjno"]) && ($choose_vo["cyjno"] !== ""))?($choose_vo["cyjno"]):''); ?></td>
							<td><?php echo ((isset($choose_vo["ywy"]) && ($choose_vo["ywy"] !== ""))?($choose_vo["ywy"]):''); ?></td>
							<td>
								<?php if(!empty($choose_vo['buildname'])): ?><nobr><?php echo ($choose_vo["buildname"]); ?>-<?php echo ($choose_vo["unit"]); ?>单元-<?php echo ($choose_vo["floor"]); ?>层-<?php echo ($choose_vo["rm"]); ?></nobr><?php endif; ?>
							</td>
							<!--<td class="hidden-480">
								<?php if(!empty($choose_vo['add_time'])): echo (date("Y-m-d H:i:s",$choose_vo["add_time"])); endif; ?>
							</td>-->
							<!--<td>
								<?php if(!empty($choose_vo['room_id'])): ?><nobr>已选房</nobr>
									<?php else: ?>
									<nobr>未选房</nobr><?php endif; ?>
							</td>-->
							<td>
								<?php if(empty($choose_vo['room'])): if(empty($choose_vo['room_id'])): ?><button class="update_y" pid="<?php echo ($choose_vo["project_id"]); ?>"  bid="<?php echo ($choose_vo["batch_id"]); ?>" data-id="<?php echo ($choose_vo["id"]); ?>" style="border-style: none;color: #FFF;font-weight: bold;background-color: #3babbe" data-toggle="modal" data-target="#yd_room">选择</button><?php endif; ?>
									<?php else: ?>
									<span  class="update_y" pid="<?php echo ($choose_vo["project_id"]); ?>" bid="<?php echo ($choose_vo["batch_id"]); ?>" style="cursor: pointer;color: #3babbe" data-id="<?php echo ($choose_vo["id"]); ?>" data-rid="<?php echo ($choose_vo["room"]); ?>" data-room="<?php echo ($choose_vo["rm_one"]); ?>" <?php if(empty($choose_vo['room_id'])): ?>data-toggle="modal" data-target="#yd_room"<?php endif; ?> ><?php echo ($choose_vo["buildname_one"]); ?>-<?php echo ($choose_vo["unit_one"]); ?>单元-<?php echo ($choose_vo["floor_one"]); ?>层-<?php echo ($choose_vo["rm_one"]); ?></span><?php endif; ?>
							</td>
							<td class="hidden-480">
								<?php if(($choose_vo['status']) == "1"): ?><span style="cursor: pointer" class="label label-sm label-success click-status" data-id="<?php echo ($choose_vo["id"]); ?>" data-s="1">启用</span>
								<?php else: ?>
									<span style="cursor: pointer" class="label label-sm label-warning click-status" data-id="<?php echo ($choose_vo["id"]); ?>" data-s="0">关闭</span><?php endif; ?>
							</td>
							<td>

								<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
									<nobr>
									<a href="<?php echo U('edit', 'id='.$choose_vo['id']);?>" class="btn btn-xs btn-info js-choose-user-edit-btn" title="修改">
										<i class="icon-edit bigger-120"></i>
									</a>
									<?php if((empty($choose_vo['room'])) AND (empty($choose_vo['room_id']))): ?><button data-id="<?php echo ($choose_vo["id"]); ?>" class="btn btn-xs btn-danger js-choose-user-delete-btn" title="删除">
											<i class="icon-trash bigger-120"></i>
										</button><?php endif; ?>
									</nobr>
								</div>
								
								<div class="visible-xs visible-sm hidden-md hidden-lg">
									<div class="inline position-relative">
										<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
											<i class="icon-cog icon-only bigger-110"></i>
										</button>

										<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
											<li>
												<a href="<?php echo U('edit', 'id='.$choose_vo['id']);?>" 
													class="tooltip-success js-choose-user-edit-btn"
													data-rel="tooltip" 
													data-original-title="修改"
												>
													<span class="green">
														<i class="icon-edit bigger-120"></i>
													</span>
												</a>
											</li>

											<li>
												<a href="javascript:void(0);" class="tooltip-error js-choose-user-delete-btn"
													title="" 
													data-id="<?php echo ($choose_vo["id"]); ?>"
													data-rel="tooltip" 
													data-original-title="删除"
												>
													<span class="red">
														<i class="icon-trash bigger-120"></i>
													</span>
												</a>
											</li>
										</ul>

									</div>
								</div>	
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					
					<tr>
						<td class="center hidden-480">
							<div class="action-buttons">

								<?php if($status == '1'): ?><a class=" js-choose-user-delete-all-btn" href="javascript:void(0);" title="批量删除" style="padding: 4px 6px">
										<i class="icon-trash bigger-130" style="margin: 0 0 0 3px;color:#dd5a43;" ></i>
									</a>
									<a class="" id="pl-off" href="javascript:void(0);" title="批量关闭">
										<i class="icon-eye-close bigger-130" style="margin: 0 0 0 3px;color:#dd5a43;" ></i>
									</a>
									<?php elseif($status == '0'): ?>
									<a class=" js-choose-user-delete-all-btn" href="javascript:void(0);" title="批量删除" style="padding: 4px 6px">
										<i class="icon-trash bigger-130" style="margin: 0 0 0 3px;color:#dd5a43;" ></i>
									</a>
									<a class="" id="pl-open" href="javascript:void(0);" title="批量启用">
										<i class="icon-eye-open bigger-130" style="margin: 0 0 0 3px;color:#dd5a43;" ></i>
									</a>
									<?php else: ?>
									<a class=" js-choose-user-delete-all-btn" href="javascript:void(0);" title="批量删除" >
										<i class="icon-trash bigger-130" style="margin: 0;color:#dd5a43; " ></i>
									</a><?php endif; ?>
							</div>
						</td>
						<td colspan="11">
							<div class="pull-left">
								<a href="<?php echo U('add');?>" class="btn btn-xs btn-pink js-choose-user-add">
									<i class="icon-file bigger-110"></i>
									<span class="bigger-110 no-text-shadow">添加客户</span>
								</a>

								<button class="btn btn-xs btn-primary js-choose-user-excel-export">
									<i class="icon-cloud-download bigger-110"></i>
									<span class="bigger-110 no-text-shadow">导出模板</span>
								</button>

								<button class="btn btn-xs btn-primary js-choose-user-excel-import">
									<i class="icon-cloud-upload bigger-110"></i>
									<span class="bigger-110 no-text-shadow">导入数据</span>
								</button>
							</div>
							<button class="btn btn-xs btn-primary" style="float: right" id="check_user1">
								<i class="icon-cloud-download bigger-110"></i>
								<span class="bigger-110 no-text-shadow">导出客户数据</span>
							</button>
						</td>
					</tr>
				</tbody>

			</table>
			
			<div class="row">
				<div class="col-sm-6">
					<div class="dataTables_info" id="sample-table-2_info">
						第 <input id="newpage" type="tel" value="<?php echo ((isset($p) && ($p !== ""))?($p):1); ?>" style="width:30px" class="tzpage"> 页/ <?php echo ((isset($total_pages) && ($total_pages !== ""))?($total_pages):1); ?> 页，每页<input id="newrows"  type="tel" value="<?php echo ((isset($listRows) && ($listRows !== ""))?($listRows):10); ?>" style="width:30px"  class="tzrows"> 条/共 <?php echo ((isset($choose_count) && ($choose_count !== ""))?($choose_count):1); ?> 条
					</div>
				</div> 
				<div class="col-sm-6">
					<div class="dataTables_paginate paging_bootstrap"> 
						<?php echo ((isset($page_show) && ($page_show !== ""))?($page_show):''); ?>
					</div>
				</div>
			</div>
		</div><!-- /.table-responsive -->

	</div><!-- /span -->

</div>
	
<div class="js-choose-user-excel-export-tpl" style="display:none;">
	<div class="choose-user-excel-export-tpl">
		<div class="choose-user-excel-export-tpl-title">
			你确认要导出该项目模板吗？
		</div>
		<div class="choose-user-excel-export-tpl-btns center">
			<button class="btn btn-sm btn-success js-choose-user-excel-export-tpl-btn">
				<i class="icon-cloud-download bigger-110"></i>
				导出模板
			</button>
		</div>
	</div>
</div>

<div class="js-choose-user-excel-import-tpl" style="display:none;">
	<form method="post" id="choose-user-excel-import-tpl-form" class="choose-user-excel-import-tpl-form" name="import-form" action="<?php echo U('import');?>" enctype="multipart/form-data" >
		<div class="choose-user-excel-import-tpl">
			<div class="choose-user-excel-import-tpl-title">
				提交客户信息文件
			</div>
			<div class="choose-user-excel-import-tpl-input">
				<input type="file" class="choose-excel-import-tpl-file upload" name="excel"  id="in_excel" />
			</div>
			<div class="choose-user-excel-import-tpl-btns center">
				<button class="btn btn-sm btn-purple js-choose-user-excel-import-tpl-btn">
					<i class="icon-cloud-upload align-top bigger-110"></i>
					导入数据
				</button>
			</div>
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
				<script src="/Public/common/js/jquery/jquery-2.1.1.min.js"></script><!--这个jq引入很关键，不引入在ipad pro 类型的机型上bootstrap模态框会报错-->
				<script src="/Public/account/assets/js/bootstrap.min.js"></script>
				<script src="/Public/account/assets/js/typeahead-bs2.min.js"></script>
			
			
			<!-- page specific plugin scripts -->
			
<script src="/Public/account/assets/js/jquery.dataTables.min.js"></script>
<script src="/Public/account/assets/js/jquery.dataTables.bootstrap.js"></script>


			<!-- ace scripts -->
			
				<script src="/Public/account/assets/js/ace-elements.min.js"></script>
				<script src="/Public/account/assets/js/ace.min.js"></script>
			
			
			
			<!-- inline scripts related to this page -->
			
<script type="text/javascript">

	var c_num="<?php echo ($p); ?>";
	jQuery(function($) {
        //用户信息 - 批量关闭
        $("#pl-off").on('click', function() {
            var $ids = [];
            var $item_list = $(".choose-user-item");
            for (var $i = 0; $i < $item_list.length; $i ++) {
                var $id = $($item_list[$i]).find(".choose-user-item-id:checked").attr("data-id");
                if ($id !== undefined) {
                    $ids.push($id);
                }
            }
            if ($ids.length <= 0) {
                gritter_alert('请选择要关闭的用户信息！');
                return false;
            }
            var callback = function() {
                var $url = "<?php echo U('/Account/ChooseUser/plOff');?>";
                var $data = {
                    ids: $ids,
                };
                ajax_post_callback($url, $data, function(data, status) {
                    if (data['status'] != 1) {
                        gritter_alert(data['info']);
                        return false;
                    } else {
                        gritter_alert_success('批量关闭成功！');

                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                });
            };

            layer_confirm('确认批量关闭吗？', callback);
        });

        //批量启用
		$("#pl-open").on('click', function() {
        var $ids = [];
        var $item_list = $(".choose-user-item");
        for (var $i = 0; $i < $item_list.length; $i ++) {
            var $id = $($item_list[$i]).find(".choose-user-item-id:checked").attr("data-id");
            if ($id !== undefined) {
                $ids.push($id);
            }
        }
        if ($ids.length <= 0) {
            gritter_alert('请选择要启用的用户信息！');
            return false;
        }
        var callback = function() {
            var $url = "<?php echo U('/Account/ChooseUser/plOpen');?>";
            var $data = {
                ids: $ids,
            };
            ajax_post_callback($url, $data, function(data, status) {
                if (data['status'] != 1) {
                    gritter_alert(data['info']);
                    return false;
                } else {
                    gritter_alert_success('批量启用成功！');
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }
            });
        };

        layer_confirm('确认批量启用吗？', callback);
    });

		//单个点击启用，或者禁用用户
		$(".click-status").on("click",function () {
			var pd=$(this).attr("data-s");
			var id=$(this).attr("data-id");
			var t=$(this);
			var vo=0;
			if(Number(pd)===1){
                vo=0;
			}else{
                vo=1;
			}
			$.post("<?php echo U('/Account/ChooseUser/updateStatus');?>",{status:vo,id:id},function (data) {
//                layer_confirm('确认删除吗，删除后将不能恢复？', callback);
				if(data==='false'){
                    layer.alert('操作失败，请刷新重试！');
				}else{
				    var p=$("#c_status").val();
				    if(p==="" || p===undefined){
                        if(vo===0){
                            t.removeClass("label-success").addClass("label-warning").attr("data-s",vo).text('关闭');
                            layer.msg('操作成功！');
                        }else{
                            t.removeClass("label-warning").addClass("label-success").attr("data-s",vo).text('启用');
                            layer.msg('操作成功！');
                        }
					}else{
                        layer.msg('操作成功！');
						t.parents("tr").remove();
                    }
				}
            });
        });
	    //查看异常数据
	    $("#error").on('click',function () {
			var pd=$(this).attr('data-zt');
//            var $project_id = $(".js-choose-user-project-id").val();
//            var $batch_id = $(".js-choose-user-batch-id").val();
//            var word=$(".js-choose-user-word").val();
//            var zt=$("#z_t").val();
//            var status=$("#c_status").val();
            var uid=0;
            if(Number(pd)===0){
                uid=1
			}
            $("#form-b input[name='uid']").val(uid);
            $("#form-b").submit();
//            var h= window.location.host;
//            window.location.href="http://"+h+"/Account/ChooseUser/index.html?project_id="+ $project_id+"&zt="+zt+"&word="+word+"&bid="+$batch_id+"&uid="+uid+"&status="+status;
        });

		$('table th input:checkbox').on('click' , function(){
			var that = this;
			$(this).closest('table').find('tr > td:first-child input:checkbox')
			.each(function(){
				this.checked = that.checked;
				$(this).closest('tr').toggleClass('selected');
			});
		});

		$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

		function tooltip_placement(context, source) {
			var $source = $(source);
			var $parent = $source.closest('table')
			var off1 = $parent.offset();
			var w1 = $parent.width();
			var off2 = $source.offset();
			var w2 = $source.width();
			if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
			return 'left';
		}
	});
		//分页跳转
		$(".pagination li").on("click",function () {
			var tx=$(this).attr("data-tx");
			if(tx !==undefined){
			    if(tx ==="上一页"){
                    $("#form-b input[name='p']").val(Number(c_num)-1);
				}else if(tx ==="下一页"){
                    $("#form-b input[name='p']").val(Number(c_num)+1);
				}else if(tx ==="首页"){
                    $("#form-b input[name='p']").val(1);
                } else if(tx ==="尾页"){
                    $("#form-b input[name='p']").val("<?php echo ((isset($total_pages) && ($total_pages !== ""))?($total_pages):1); ?>");
                }else{
                    $("#form-b input[name='p']").val(tx);
				}
                $("#form-b").submit();
			}
        });

        //设置每页显示条数
        $(".tzrows").keypress(function(e) {
            if (e.which == 13)
            {
                $zcount=parseInt("<?php echo ($choose_count); ?>",10);//总条数
                $oldcount=parseInt("<?php echo ($listRows); ?>",10);//旧的的显示条数
                $newcount=parseInt($("#newrows").val(),10);//新的显示条数
                if($newcount<=$zcount &&$newcount>0)
                {
                    $("#form-b input[name='r']").val($newcount);
                    $("#form-b input[name='p']").val("1");
                    $("#form-b").submit();
                }
            }
        });
        
        //直接跳转到第N页
        $(".tzpage").keypress(function(e) {
            if (e.which == 13)
            {
                $zpage=parseInt("<?php echo ($total_pages); ?>",10);
                $newpage=parseInt($("#newpage").val(),10);
                //$dqpage=parseInt($(".pagination .current a").text(),10);
                $dqpage=parseInt("<?php echo ($p); ?>",10);
                if($dqpage != $newpage && $newpage<=$zpage &&$newpage>0)
                {
                    $("#form-b input[name='p']").val($newpage);
                    $("#form-b").submit();
//                     var $count=0;
//                     $oldhref=window.location.href.replace("http://",'');
//                     if ($oldhref.indexOf("/p/")>-1)
//                     {
//                        if ($dqpage>0 && $dqpage<10)
//                        {
//                            $count=4;
//                        }
//                        else
//                        {
//                            $count=5;
//                        }
//                        $bthstr=$oldhref.substr($oldhref.indexOf("/p/"),$count);
//                        window.location.href="http://"+ $oldhref.replace($bthstr,'/p/'+$newpage);
//                     }
//                     else
//                     {
//                          window.location.href="http://"+ $oldhref.replace(".html",'/p/'+$newpage+".html");
//                     }
                }
            }


        });
        
         //导出用户数据到EXCEL
	$("#check_user1").on("click",function () {
        var pid = $(".js-choose-user-project-id").val();
        var bid = $(".js-choose-user-batch-id").val();
        var word=$(".js-choose-user-word").val();
        var status=$("#c_status").val();
        var zt=$("#z_t").val();
        window.location.href = choose_user_url.check_user + '?project_id=' + pid+"&bid="+bid+"&zt="+zt+"&word="+word+"&satus="+status;
		return false;
    });

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