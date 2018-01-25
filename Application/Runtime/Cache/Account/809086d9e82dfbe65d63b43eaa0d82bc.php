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
		
		
<link rel="stylesheet" href="/Public/account/assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="/Public/account/assets/css/chosen.css" />

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
		<a href="<?php echo U('WeixBuyset/index');?>"><?php echo ((isset($classify_name) && ($classify_name !== ""))?($classify_name):''); ?></a>
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
										
	<div class="table-header" style="margin-bottom: 20px">
		添加活动信息
	</div>
<form class="form-horizontal js-choose-order_house-select-box" role="form" id="wx_add_form">

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-project-id"> 
			<i class="icon-asterisk pink"></i> 
			项目名称 
		</label>
		
		<div class="col-sm-9">
			<select class="col-xs-10 col-sm-5   js-choose-order_house-select-project-id js-choose-order_house-add-project-id"
					required="required"
				name="project_id"
				id="form-field-project-id"
				data-placeholder="请选择项目"
				data-first-title="请选择项目"
				data-first-value='0'
			>
				<?php if(is_array($project_list)): foreach($project_list as $key=>$project_list_vo): ?><option value="<?php echo ($project_list_vo['id']); ?>">
						<?php echo ($project_list_vo['company_name']); ?> -- <?php echo ($project_list_vo['name']); ?>
					</option><?php endforeach; endif; ?> 
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-batch-id">
			<i class="icon-asterisk pink"></i>
			项目批次 
		</label>
		
		<div class="col-sm-9">
			<select class="col-xs-10 col-sm-5   js-choose-order_house-select-batch-id js-choose-order_house-add-batch-id"
				name="batch_id" required="required"
				id="form-field-batch-id"
				data-placeholder="请选择项目批次"
				data-first-title="请选择项目批次"
			>
			</select>
		</div>
	</div>

	<div class="space-4"></div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-name"> 
			<i class="icon-asterisk pink"></i> 
			活动名称 
		</label>
		
		<div class="col-sm-9">
			<input type="text" name="name" required value="" id="form-field-name" placeholder="请填写活动名称" class="col-xs-10 col-sm-5 js-choose-order_house-add-name">
			<span class="help-inline col-xs-12 col-sm-7 col-xs-12 col-sm-7">
				<span class="middle">填写活动名称</span>
			</span>
		</div>
	</div>

	

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-start-time"> 
			<i class="icon-asterisk pink"></i> 
			开始时间
		</label>
		
		<div class="col-sm-9">
			<input type="text" 
				name="start_time"
				   required="required"
				value="<?php echo date('Y-m-d H:i:s');?>" 
				id="form-field-start-time" 
				placeholder="请填写活动开始时间" 
				class="col-xs-10 col-sm-5 js-choose-order_house-add-start-time"
				onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'twoer'})"
			>
			<span class="help-inline col-xs-12 col-sm-7">
				<span class="middle">填写活动开始时间</span>
			</span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-end-time">
			<i class="icon-asterisk pink"></i>
			结束时间
		</label>
		
		<div class="col-sm-9">
			<input type="text" 
				name="end_time"
				value=""
				   required="required"
				id="form-field-end-time" 
				placeholder="请填写活动结束时间" 
				class="col-xs-10 col-sm-5 js-choose-order_house-add-end-time"
				onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'twoer'})"
			>
			<span class="help-inline col-xs-12 col-sm-7">
				<span class="middle">填写活动结束时间</span>
			</span>
		</div>
	</div>

	<div class="space-4"></div>
        <div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-maxcount">
			<i class="icon-asterisk pink"></i>
			允许备选房间
		</label>
		
		<div class="col-sm-9">
			<input type="text" name="maxcount" required value="5" id="form-field-maxcount"  class="col-xs-10 col-sm-5 js-choose-order_house-add-maxcount">
                        <span class="help-inline col-xs-12 col-sm-7">
				<span class="left">每人允许添加备选房间数量</span>
			</span>
		</div>
	</div>
        <div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-description"> 
                    <i class="icon-asterisk pink"></i> 
			活动须知
		</label>
		
		<div class="col-sm-9">
			<div class="col-xs-10 col-sm-5 no-padding">
				<textarea class="form-control js-choose-order_house-add-description" required rows="8" name="desc" id="form-field-description" placeholder="填写活动须知"><?php echo ((isset($choose_order_house["description"]) && ($choose_order_house["description"] !== ""))?($choose_order_house["description"]):''); ?></textarea>
			</div>
		</div>
	</div>
	
	<div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-remark"> 
                认筹说明
            </label>

            <div class="col-sm-9">
                <div class="col-xs-10 col-sm-5 no-padding">
                    <textarea class="form-control js-choose-order_house-add-remark" rows="6" name="mark" id="form-field-remark" placeholder="填写选房成功后，认筹办理时间、相应权责及免责申明等备注"><?php echo ((isset($choose_order_house["remark"]) && ($choose_order_house["remark"] !== ""))?($choose_order_house["remark"]):''); ?></textarea>
                </div>
            </div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-login_img">
			<i class="icon-asterisk pink"></i>
			手机登录背景图片
		</label>
		<div class="col-sm-9">
			<input type="file" required accept="image/jpeg,image/png" name="login_img" value="" id="form-field-login_img"  class="col-xs-10 col-sm-5" style="border: 1px solid #d5d5d5;padding: 2px 4px;">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-isysdl">
			是否延时登录
		</label>

		<div class="col-sm-9">
			<label>
				<input name="isysdl" id="form-field-isysdl" class="ace ace-switch ace-switch-4" type="checkbox" checked="checked">
				<span class="lbl"></span>
			</label>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-is_show_discount">
			是否显示优惠后总价
		</label>
		<div class="col-sm-9">
			<label>
				<input name="is_show_discount" id="form-field-is_show_discount" class="ace ace-switch ace-switch-4" type="checkbox">
				<span class="lbl"></span>
			</label>
		</div>
	</div>
        <div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-states">
			<i class="icon-asterisk pink"></i> 
			活动是否开启 
		</label>
		
		<div class="col-sm-9">
			<label>
				<input name="states" id="form-field-states" class="ace ace-switch ace-switch-4 js-choose-order_house-add-states" type="checkbox" checked="checked">
				<span class="lbl"></span>
			</label>
		</div>
	</div>
	<div class="space-4"></div>

	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert">
			<i class="icon-remove"></i>
		</button>

		<strong>注意：</strong>

		“<i class="icon-asterisk pink"></i>”为必填选项，请注意填写。
		<br>
	</div>

	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-info js-choose-order_house-add-save-btn"  data-loading-text="正在提交..." >
				<i class="icon-ok bigger-110"></i>
				提交
			</button>

			<button class="btn" type="reset">
				<i class="icon-undo bigger-110"></i>
				重置
			</button>
		</div>
	</div>
	
</form>

										
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
			
<script src="/Public/account/assets/js/chosen.jquery.min.js"></script>
<script src="/Public/account/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="/Public/account/js/My97DatePicker/WdatePicker.js"></script>


			<!-- ace scripts -->
			
				<script src="/Public/account/assets/js/ace-elements.min.js"></script>
				<script src="/Public/account/assets/js/ace.min.js"></script>
			
			
			
			<!-- inline scripts related to this page -->
			
<script src="/Public/account/js/jquery/jquery.cxSelect-1.4.1/jquery.cxselect.min.js"></script>
<script type="text/javascript">	
$(function() {	
	//多级联动
	var $project_json = '<?php echo ($project_json); ?>';
	var $project_json = $.parseJSON($project_json);
	$('.js-choose-order_house-select-box').cxSelect({
		data: $project_json,                
		selects: ['js-choose-order_house-select-project-id', 'js-choose-order_house-select-batch-id'],
		jsonName: 'n',         
		jsonValue: 'v',
		jsonSub: 's',
		emptyStyle: 'display'
	});
});
</script>

<script type="text/javascript">	
$(function() {	
	$(".js-choose-order_house-select-project-id").chosen({
		no_results_text: "没有找到",
		allow_single_de: true	
	}).change(function() {
		setTimeout(function() {
			$(".js-choose-order_house-select-batch-id").trigger("chosen:updated");
		}, 500);;
	}); 
	/*$(".js-choose-order_house-select-batch-id").chosen({
		no_results_text: "没有找到",
		allow_single_de: true	
	}); */	
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