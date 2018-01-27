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

	
	<li>
		<a href="<?php echo U('Yhqxuser/index');?>"><?php echo ((isset($classify_name) && ($classify_name !== ""))?($classify_name):''); ?></a>
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
    .role-checked{
        float: left;
        margin-left: 1%;
        border-style: none;
        width: 100px;
        padding: 5px 23px;
        background-color: rgba(255, 165, 0, 0.12) ;
        font-weight: bold;
    }
    .role-not-checked{
        float: left;
        margin-left: 1%;
        border-style: none;
        width: 100px;
        padding: 5px 23px;
        background-color: #FFF;
    }
    #update-mk{
        float: right;
        background-color: rgb(135, 184, 127);
        color: #FFF;
        font-weight: bold;
        border: 0;
        padding: 5px 20px;
        margin: 0 20px;
        margin: 0 20px 20px 20px;
    }
    #role-ul{
        width: 100%;
        padding: 0;
        margin-top: 0px;
    }
    #role-ul li{
        width: 100%;
        float: left;
        color: #1B4670;
        list-style: none;
        margin: 0 0 0 -25px;
        padding: auto 0;
        border-bottom: 1px solid #e8eef6;
        cursor: pointer;
        line-height: 25px;
    }
    .role-not-checked:hover{
       background-color:  rgb(245, 245, 245);
    }
    .tr_x{
        cursor: pointer;
        padding: 3px 3px;
    }
    .plusshow{
        background: #6fb3e0;
        color: #FFF;
        font-size: 18px;
        font-weight: 700;
        text-align: center;
        line-height: 15px;
        height: 17px;
        width: 17px;
        border-radius: 3px;
    }
    .minushide{
        color: #DDD;
        font-size: 18px;
        font-weight: 700;
        text-align: center;
        line-height: 15px;
        height: 16px;
        width: 16px;
        border:1px solid #ddd;
        border-radius: 3px;
    }
    .lt{
        text-align: left;
    }
    .isaction
    {
        border: 1px solid #6fb3e0;
        padding: 3px 5px;
    }
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="table-header">
            岗位权限列表
        </div>
        <div class="table-header" style="background-color:#e8eef6;margin-bottom: 1px;color: black">
            <form action="index" id="post-company" method="post">
                <label for="f-company" >公司</label>
                <select name="compid" id="f-company" style="padding: 1px 10px;height: 25px">
                   <?php if(is_array($companys)): foreach($companys as $k=>$vo): if($vo["id"] == $compid): ?><option value="<?php echo ($vo["id"]); ?>" selected><?php echo ($vo["compname"]); ?></option>
                           <?php else: ?>
                           <option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["compname"]); ?></option><?php endif; endforeach; endif; ?>
                </select>
            </form>
        </div>
        <div  style="border:1px solid #e8eef6;width: 25%;float: left;height:75vh; padding: 4px 6px;">
            <div style="width: 100%;padding:0;text-align: center" id="role">
                <div style="line-height: 35px;height: 35px;background: #f2f2f2;color: #707070;font-weight: 700;border-bottom: 1px solid #ddd;">岗位名称</div>
                <ul id="role-ul">
                <?php if(is_array($stationlist)): foreach($stationlist as $i=>$station_vo): if($i == 0): ?><!--<li rid="<?php echo ($value["id"]); ?>" <?php if($k == 0): ?>class="role-checked" <?php else: ?>class="role-not-checked"<?php endif; ?>>-->
                        <!--<?php echo ($value["name"]); ?>-->
                        <!--</li>-->
                        <?php if(!empty($station_vo['projname']) and empty($station_vo['id'])): ?><li class="tr_x lt"  data_id="<?php echo ($i); ?>" pid="<?php echo ($station_vo['proj_id']); ?>">
                                    <label class="plusshow">-</label> <?php echo ($station_vo['projname']); ?>
                            </li>
                            <?php else: ?>
                            <li class="role-checked js-role lt"  rid="<?php echo ($station_vo['id']); ?>" data_id="<?php echo ($i); ?>" pid="<?php echo ($station_vo['proj_id']); ?>">
                                    <?php echo ($station_vo['name']); ?>
                            </li><?php endif; ?>
                        <?php else: ?>
                        <?php if(!empty($station_vo['projname']) and empty($station_vo['id'])): ?><li class="tr_x lt"   data_id="<?php echo ($i); ?>" pid="<?php echo ($station_vo['proj_id']); ?>">
                                    <label class="plusshow">-</label> <?php echo ($station_vo['projname']); ?>
                            </li>
                            <?php else: ?>
                            <li class="role-not-checked js-role lt" rid="<?php echo ($station_vo['id']); ?>" data_id="<?php echo ($i); ?>" pid="<?php echo ($station_vo['proj_id']); ?>">
                                    <?php echo ($station_vo['name']); ?>
                            </li><?php endif; endif; endforeach; endif; ?>
                </ul>
            </div>
        </div>
        <div style="border:1px solid #e8eef6;width: 72%;height: 75vh;float: left;margin-left: 3%;padding: 4px 6px;">
            <div style="line-height: 35px;height: 35px;background: #f2f2f2;color: #707070;font-weight: 700;border-bottom: 1px solid #ddd;text-align: center;">功能权限</div>
            <div style="width: 100%;padding: 10px 0" id="fun">
                <?php if(is_array($one_mk)): foreach($one_mk as $k=>$vo): ?><label style="margin-left: 1%;display: block; margin-bottom: 10px;">
                        <input type="checkbox" class="ace one_mk" fid="<?php echo ($vo["id"]); ?>">
                        <span class="lbl" style=" font-weight: 700;">&nbsp;&nbsp;&nbsp;<?php echo ($vo["name"]); ?></span>
                    </label>
                    <?php if(is_array($two_mk)): foreach($two_mk as $ks=>$val): if($val["parent_id"] == $one_mk[$k]['id']): ?><label style="margin-left: 35px; margin-bottom: 20px;">
                                <input disabled type="checkbox" class="ace two_mk" fid="<?php echo ($val["id"]); ?>" pid="<?php echo ($one_mk[$k]['id']); ?>">
                                <?php if($val['is_fun'] == 1): ?><span class="lbl ">&nbsp;&nbsp;&nbsp;<?php echo ($val["name"]); ?></span>
                                <?php else: ?>
                                <span class="lbl isaction">&nbsp;&nbsp;&nbsp;<?php echo ($val["name"]); ?></span><?php endif; ?>
                            </label><?php endif; endforeach; endif; endforeach; endif; ?>
                <hr>
                <button  id="update-mk"  rid="<?php echo ($stationlist[0]['id']); ?>">授权</button>
            </div>
        </div>
    </div>
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
        <?php if(is_array($mk_checked)): foreach($mk_checked as $k=>$vo): ?>$(".one_mk[fid="+<?php echo ($vo["fun_id"]); ?>+"]").prop("checked",true);
                $(".two_mk[pid="+<?php echo ($vo["fun_id"]); ?>+"]").prop("disabled",false);
                $(".two_mk[fid="+<?php echo ($vo["fun_id"]); ?>+"]").prop("checked",true);<?php endforeach; endif; ?>
        //一级模块选中才能操作二级模块
        $(document).on("click",".one_mk",function () {
            var id=$(this).attr("fid");
            if($(this).is(":checked")) $(".two_mk[pid="+id+"]").prop("disabled",false); else $(".two_mk[pid="+id+"]").prop("checked",false).prop("disabled",true);
        });
        //切换角色，改变样式和修改按钮的角色id值
        $("#role-ul .js-role").on("click",function () {
            var id=$(this).attr("rid");
            $("#update-mk").attr("rid",id);
            $("#role-ul .js-role").removeClass("role-checked").addClass("role-not-checked");
            $(this).removeClass("role-not-checked").addClass("role-checked");
            $.post("<?php echo U('Yhqxfun/getFun');?>",{sid:id},function (data) {
                $("#fun input").prop("checked",false);
                $(".two_mk").prop("disabled",true);
                for(var i=0;i<data.length;i++){
                    $(".one_mk[fid="+data[i]['fun_id']+"]").prop("checked",true);
                    $(".two_mk[pid="+data[i]['fun_id']+"]").prop("disabled",false);
                    $(".two_mk[fid="+data[i]['fun_id']+"]").prop("checked",true);
                }
            },"json");
        });

        $(".tr_x").on("click",function () {
            var pid=$(this).attr("pid");
            if($.trim($(this).find("label").text()) ==='-'){
                $(".js-role[pid='"+pid+"']").hide();
                $(this).find("label").text('+');
            }else{
                $(".js-role[pid='"+pid+"']").show();
                $(this).find("label").text('-');
            }
        });
        $("#update-mk").on("click",function () {
           var input_checked=$("#fun input:checked");
           var rid=$(this).attr("rid");
           if(input_checked.length===0){
                layer_alert("请至少选中一个模块再提交");
           }else{
               var arr=[];
               for(var i=0;i<input_checked.length;i++){
                    arr[i]={"fun_id":input_checked.eq(i).attr("fid"),"station_id":rid};
               }
//               console.log(arr);return false;
               $.post("<?php echo U('Yhqxfun/updateFun');?>",{funs:arr},function (data) {
                   layer_alert(data);
//                   window.location.reload();
               });
           }
        });
        $("#f-company").on("change",function () {
           $("#post-company").submit();
        });
        //提交选中的模块到后台
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