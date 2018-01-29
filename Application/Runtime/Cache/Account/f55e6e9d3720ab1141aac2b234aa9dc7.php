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
	form{display: inline}
	#sample-table-2_length label{
		margin-left: 10px;
	}
	</style>
	<li>
		<a href="<?php echo U('Xsgllog/index');?>"><?php echo ((isset($classify_name) && ($classify_name !== ""))?($classify_name):''); ?></a>
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
										
<div class="row">
	<div class="col-xs-12">
		<div class="table-header">
			交易记录列表
		</div>
		<div class="table-responsive dataTables_wrapper">
			<div class="row">
				<div class="col-sm-12">
					<div id="sample-table-2_length" class="dataTables_length">
						<form action="<?php echo U('/Account/Xsgllog/index');?>" method="post" id="form-p">
						<label>
							项目 
							<select name="project_id" class="trade-project-id js-trade-project-id" style="width: auto;">
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
						<form action="<?php echo U('/Account/Xsgllog/index');?>" method="post" id="form-b">
						<label>							
							批次 
							<select name="batch_id" class="trade-batch-id js-trade-batch-id" style="width: auto;">
							<?php if(count($batch_list) != 1): ?><option value="0">全部</option><?php endif; ?>
						
								<?php if(is_array($batch_list)): foreach($batch_list as $key=>$batch_list_vo): if($batch_list_vo['id'] == $search_batch_id): ?><option value="<?php echo ($batch_list_vo['id']); ?>" selected>
										<?php echo ($batch_list_vo['name']); ?>
									</option>
										<?php else: ?>
										<option value="<?php echo ($batch_list_vo['id']); ?>">
											<?php echo ($batch_list_vo['name']); ?>
										</option><?php endif; endforeach; endif; ?> 
							</select> 
						</label>

						<label>
							状态
							<select name="pd" class="trade-zt-id js-trade-zt-id" style="width: auto;">


								<?php if($pd == 1): ?><option value="0">激活</option>
									<option value="1" selected>关闭</option>
									<?php else: ?>
									<option value="0">激活</option>
									<option value="1" >关闭</option><?php endif; ?>>
							</select>
						</label>
						<div class="nav-search" id="sample-table-2_filter" style="top:0;">
							<label class="input-icon">
								<input type="text" name="word" value="<?php echo ((isset($search_word) && ($search_word !== ""))?($search_word):''); ?>" class="nav-search-input js-choose-jy-word" id="zt_cx" placeholder="房间、客户、手机">
								<i class="icon-search nav-search-icon" style="cursor: pointer;left:6px;" id="likeUsers"></i>
							</label>
						</div>
							<input type="hidden" name="project_id" value="<?php echo ($search_project_id); ?>">
							<input type="hidden" name="p" value="<?php echo ((isset($p) && ($p !== ""))?($p):1); ?>">
						</form>
					</div>
				</div>

			</div>
			
			<table id="sample-table-choose" class="table table-striped table-bordered table-hover dataTable">
				<thead>
					<tr>
						<th class="center hidden-480">
							<label>
								<input type="checkbox" class="ace">
								<span class="lbl"></span>
							</label>
						</th>
						<th class="hidden-480">项目</th>
                                                <th class="hidden-480">房间</th>
						<th>客户名称</th>
						<th>
							<i class="icon-phone bigger-110 hidden-480"></i>
							客户手机
						</th>
						<!--<th>
							<i class="icon-jpy bigger-110 hidden-480"></i>
							诚意金金额(元)
						</th>-->
                                                <th>来源</th>
                                                <th>交易状态</th>
                                                <th class="hidden-480">
							<i class="icon-time bigger-110 hidden-480"></i>
							交易时间
						</th>
                                                <th>置业顾问</th>
						<th>
							<i class="icon-jpy bigger-110 hidden-480"></i>
							售价(元)
						</th>
						<th class="hidden-480">认购码</th>
						<th>操作</th>
					</tr>
				</thead>

				<tbody>
					<?php if(is_array($tradelist)): $list_key = 0; $__LIST__ = $tradelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list_vo): $mod = ($list_key % 2 );++$list_key;?><tr class="choose-user-item choose-user-item-<?php echo ((isset($choose_vo["id"]) && ($choose_vo["id"] !== ""))?($choose_vo["id"]):'0'); ?>">
							<td class="center hidden-480">
								<label>
									<input type="checkbox" class="ace choose-user-item-id" data-id="<?php echo ((isset($list_vo["id"]) && ($list_vo["id"] !== ""))?($list_vo["id"]):'0'); ?>">
									<span class="lbl"></span>
								</label>
							</td>
							<td class="hidden-480">
								<span>
									<?php echo ((isset($list_vo["project_name"]) && ($list_vo["project_name"] !== ""))?($list_vo["project_name"]):''); ?>
								</span>
						
								<?php if(!empty($list_vo["batch_name"])): ?><span class="label label-primary arrowed arrowed-right"><?php echo ($list_vo["batch_name"]); ?></span><?php endif; ?>
							</td>
                                                        <td><?php echo ($list_vo["bld_name"]); ?>-<?php echo ($list_vo["unit"]); ?>单元-<?php echo ($list_vo["floor"]); ?>层-<?php echo ($list_vo["room"]); ?></td>
							<td><?php echo ((isset($list_vo["cst_name"]) && ($list_vo["cst_name"] !== ""))?($list_vo["cst_name"]):''); ?></td>
							<td><?php echo rsa_decode($list_vo['cst_phone'],getChoosekey());?></td>
                                                        <td><?php echo ((isset($list_vo["source"]) && ($list_vo["source"] !== ""))?($list_vo["source"]):''); ?></td>
                                                        <td class="hidden-480">
								<?php if($list_vo["status"] == '签约'): ?><span class="label label-sm label-success update_zt" style="cursor: pointer" data-id="<?php echo ($list_vo["id"]); ?>">签约</span><?php endif; ?>
								<?php if($list_vo["status"] == '认购'): ?><span class="label label-sm label-warning update_zt" style="cursor: pointer" data-id="<?php echo ($list_vo["id"]); ?>">认购</span><?php endif; ?>
                                                                <?php if($list_vo["status"] == '选房'): ?><span class="label label-sm label-purple update_zt" style="cursor: pointer" data-id="<?php echo ($list_vo["id"]); ?>">选房</span><?php endif; ?>
							</td>
                                                        <td class="hidden-480">
								<?php if(!empty($list_vo['trade_time'])): echo (date("Y-m-d H:i:s",$list_vo["trade_time"])); endif; ?>
							</td>
                                                        <td><?php echo ((isset($list_vo["ywy"]) && ($list_vo["ywy"] !== ""))?($list_vo["ywy"]):''); ?></td>
							<td style="text-align:right;"><?php echo number_format($list_vo[total], 2);?></td>
							
							<td class="hidden-480"><?php echo ((isset($list_vo["code"]) && ($list_vo["code"] !== ""))?($list_vo["code"]):''); ?></td>
							<td>
								<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
									<!--<a href="<?php echo U('edit', 'id='.$choose_vo['id']);?>" class="btn btn-xs btn-info js-choose-user-edit-btn" title="修改">-->
										<!--<i class="icon-edit bigger-120"></i>-->
									<!--</a>-->
									<?php if($list_vo['isyx'] == 1): ?><button data-id="<?php echo ($list_vo["id"]); ?>" class="js-choose-user-circle-btn" title="作废" style="border-style: none;background-color: #ffb752;padding: 3px 7px">
										<i class="icon-ban-circle bigger-120" style="color: #FFF"> </i>
									</button>
										<?php else: ?>
										<button style="border-style: none;color: #FFF;background-color: grey;font-weight: bold" disabled>已关闭</button><?php endif; ?>
								</div>
								
								<!--<div class="visible-xs visible-sm hidden-md hidden-lg">-->
									<!--<div class="inline position-relative">-->
										<!--<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">-->
											<!--<i class="icon-cog icon-only bigger-110"></i>-->
										<!--</button>-->

										<!--<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">-->
											<!--&lt;!&ndash;<li>&ndash;&gt;-->
												<!--&lt;!&ndash;<a href="<?php echo U('edit', 'id='.$choose_vo['id']);?>" &ndash;&gt;-->
													<!--&lt;!&ndash;class="tooltip-success js-choose-user-edit-btn"&ndash;&gt;-->
													<!--&lt;!&ndash;data-rel="tooltip" &ndash;&gt;-->
													<!--&lt;!&ndash;data-original-title="修改"&ndash;&gt;-->
												<!--&lt;!&ndash;&gt;&ndash;&gt;-->
													<!--&lt;!&ndash;<span class="green">&ndash;&gt;-->
														<!--&lt;!&ndash;<i class="icon-edit bigger-120"></i>&ndash;&gt;-->
													<!--&lt;!&ndash;</span>&ndash;&gt;-->
												<!--&lt;!&ndash;</a>&ndash;&gt;-->
											<!--&lt;!&ndash;</li>&ndash;&gt;-->

											<!--<li>-->
												<!--<a href="javascript:void(0);" class="tooltip-error js-choose-user-delete-btn"-->
													<!--title="" -->
													<!--data-id="<?php echo ($choose_vo["id"]); ?>"-->
													<!--data-rel="tooltip" -->
													<!--data-original-title="作废"-->
												<!--&gt;-->
													<!--<span class="red">-->
														<!--<i class="icon-ban-circle bigger-120"></i>-->
													<!--</span>-->
												<!--</a>-->
											<!--</li>-->

										<!--</ul>-->

									<!--</div>-->
								<!--</div>	-->
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					
					<!--<tr>
						<td class="center hidden-480">
							<div class="action-buttons">
								
							</div>
						</td>
						<td colspan="10">
							<div class="pull-left">
								<a href="<?php echo U('add');?>" class="btn btn-xs btn-pink js-choose-user-add">
									<i class="icon-file bigger-110"></i>
									<span class="bigger-110 no-text-shadow">新增交易</span>
								</a>
							</div>
						</td>
					</tr>-->
				</tbody>

			</table>
			
			<div class="row">
				<div class="col-sm-6">
					<div class="dataTables_info" id="sample-table-2_info">
						第 <?php echo ((isset($p) && ($p !== ""))?($p):1); ?> / <?php echo ((isset($total_pages) && ($total_pages !== ""))?($total_pages):1); ?> 页，共 <?php echo ((isset($count) && ($count !== ""))?($count):1); ?> 条
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
				<input type="file" class="choose-excel-import-tpl-file upload" name="excel" value="" />
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
				<script src="/Public/account/assets/js/bootstrap.min.js"></script>
				<script src="/Public/account/assets/js/typeahead-bs2.min.js"></script>
			
			
			<!-- page specific plugin scripts -->
			
<script src="/Public/account/assets/js/jquery.dataTables.min.js"></script>
<script src="/Public/account/assets/js/jquery.dataTables.bootstrap.js"></script>
	<script src="/Public/account/js/My97DatePicker/WdatePicker.js"></script>


			<!-- ace scripts -->
			
				<script src="/Public/account/assets/js/ace-elements.min.js"></script>
				<script src="/Public/account/assets/js/ace.min.js"></script>
			
			
			
			<!-- inline scripts related to this page -->
			
<script type="text/javascript">
    var c_num="<?php echo ($p); ?>";
	jQuery(function($) {
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