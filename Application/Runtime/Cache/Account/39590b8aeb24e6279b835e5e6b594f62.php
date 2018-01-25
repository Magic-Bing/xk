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
    font-size: 13px;
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
    /*background: url('../../Public/admin/images/buttom_bg.gif') right bottom no-repeat;*/
    background: #d6487e;
    cursor: pointer;
    text-align: center;
    padding: 3px 6px;
    /*border: 1px solid #c4d9e9;*/
    overflow: hidden;
    font-size: 14px;
}
.selectpc {
background:rgba(255, 165, 0, 0.12);
font-weight:bold;
}

a{
  cursor:pointer;
}
 #userlisttb td
{
    font-size:13px;
}

#userlisttb tr
{
    width:240px;
    border-bottom: 1px solid #eff3f8;
    cursor: pointer;
}
.xzuserdiv{
    color:#FFF;
    background:rgb(135, 184, 127);
    border-radius:5px;
    padding:3px 5px;
    font-weight:bold;
    cursor:pointer;
    margin-top: -2px;
    display: inline;
}
.adduserlist_div
{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-20%,-20%);
    width: 40%;
    height: 460px;
    /*overflow-y: hidden;
    overflow-x: hidden;*/
    box-shadow: rgb(136, 136, 136) -5px 5px 15px;
    background: rgb(255, 255, 255);
    z-index: 999;
    display:none;
     animation: showdiv1 0.3s;
    -moz-animation: showdiv1 0.3s;	/* Firefox */
    -webkit-animation: showdiv1 0.3s;	/* Safari 和 Chrome */
    -o-animation: showdiv1 0.3s;	/* Opera */
    -webkit-animation-fill-mode:forwards; /*运行后停留在最后的地方*/
}
.adduserlist_title
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
.adduserlist_sec_title{
    width:240px;background:rgba(158, 158, 158, 0.45);
}
.adduserlist_div table{
    width:100%;
}
.adduserlist_div table th,.adduserlist_div table td{
    text-align:center;
    color:#000;
}
 .user_bottom 
{
    position: absolute;
    bottom: 0px;
    width: 100%;
    text-align: center;
    background: #eff3f8;
    color: #FFF;
    height: 50px;
}
.user_bottom input{
    float: right;
    margin-right: 10px;
    margin-top: 10px;
    width: 20%;
    border: 0;
    background: #abbac3;
    color: #FFF;
    padding: 6px 0;
}
.user_bottom .save{
    background-color: #428bca;
}
.user_edit_div{ 
    width:40%;
    height:320px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-20%); 
    box-shadow:rgb(136, 136, 136) -5px 5px 15px;
    background: rgb(255, 255, 255);
    display:none;
    z-index: 999;
    
    animation: showdiv1 0.3s;
    -moz-animation: showdiv1 0.3s;	/* Firefox */
    -webkit-animation: showdiv1 0.3s;	/* Safari 和 Chrome */
    -o-animation: showdiv1 0.3s;	/* Opera */
    -webkit-animation-fill-mode:forwards; /*运行后停留在最后的地方*/
}
.user_edit_div table{
    line-height: 40px;
    margin-top: 20px;
}
.user_edit_div table .left{
    width: 35%;
    text-align: right;
    padding-right: 10px;
    font-weight: bold;
}
.tr_c{
    cursor: pointer;
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
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="table-header">
            <div class="adduserlist_div" id="userlistdiv">
                <div class="adduserlist_title">岗位权限设置</div>
                <div id="usersinfodiv" style="height: 360px;overflow-y: auto;">
                    <table>
                        <thead class="adduserlist_sec_title" style="background: rgba(232, 232, 232, 0.45);">
                            <tr >
                                <th style="width:20%"><input type="checkbox"   id="chkall" name="chkall" onclick="checkall()" ></th>
                                <th style="width:45%;font-size:13px">项目名称</th>
                                <th style="width:35%;font-size:13px">开盘批次</th>
                            </tr>
                        </thead>	
                        <tbody id="userlisttb">

                        </tbody>
                    </table>
                </div>
                <div class="user_bottom">
                    <input  id="addqz" style="line-height: normal;" class="save"  type="button" value="确定" onclick="stationaddpc()"/>
                    <input  style="line-height: normal;"  type="button" value="取消" onclick="ycdiv()"/>
                </div>
            </div>
            <span style="">岗位权限列表</span>
            <div style="display:block;float:left;">
                
            </div>
        </div>
        
        <div class="show_content_m_t2">
            <div style="display:block;float:left;line-height: 38px;background: #eff3f8;width:100%;padding:0 0 3px 0">
                <font style="margin-left:10px;">公司</font>
                <select id= "companylist" name="companylist" style="padding: 1px 10px;height: 25px;" >
                    <?php if($selectedcomp['id'] > 0): if(is_array($companylist)): foreach($companylist as $key=>$companylist_vo): if($selectedcomp['id'] == $companylist_vo['id']): ?><option value="<?php echo ($companylist_vo['id']); ?>" selected>
                                   <?php echo ($companylist_vo['compname']); ?>
                                </option>
                                <?php else: ?>		 
                                <option value="<?php echo ($companylist_vo['id']); ?>">
                                    <?php echo ($companylist_vo['compname']); ?>
                                </option><?php endif; endforeach; endif; ?> 
                        <?php else: ?>
                        <option value="0" selected></option>
                        <?php if(is_array($companylist)): foreach($companylist as $key=>$companylist_vo): ?><option value="<?php echo ($companylist_vo['id']); ?>">
                                <?php echo ($companylist_vo['compname']); ?>
                            </option><?php endforeach; endif; endif; ?>
                </select>
                <form method="post" id="selectcomp"  action="<?php echo U('/Account/Yhqxproj/index');?>"   style="display:none">
                    <input type="text" id="compid" name="compid" value=""> 
                    <input type="submit" value="提交查询" class="button">  
                </form>
            </div>
            <div style="float:left;width:41%;overflow-x:hidden;overflow-y:hidden">
                <div class="tags" style="width:100%">
                    <div id="tagstitle"></div>
                    <div id="tagscontent">
                        <div id="con_one_1">
                            <div class="table_td" style="">
                                <table border="0" cellspacing="2" cellpadding="4" class="list" name="pctable" id="pctable" width="100%">
                                    <thead>
                                        <tr>
                                            <th align="center" style="width:65%">岗位名称</th>
                                            <th align="center" style="width:30%;min-width:106px">操作</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                    <?php if(is_array($stationlist)): foreach($stationlist as $i=>$station_vo): if($i == 0): if(!empty($station_vo['projname']) and empty($station_vo['id'])): ?><tr class="tr_x" onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='#ffffff';" bgcolor="#ffffff" stationid="<?php echo ($station_vo['id']); ?>" data_id="<?php echo ($i); ?>" projid="<?php echo ($station_vo['proj_id']); ?>">
                                                    <td align="left" colspan="2" height="35px">
                                                        <label class="plusshow">-</label> <?php echo ($station_vo['projname']); ?>
                                                    </td>
                                                </tr>
                                                    <?php else: ?>
                                                <tr class="tr_c selectpc" onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='#ffffff';" bgcolor="#ffffff" stationid="<?php echo ($station_vo['id']); ?>" data_id="<?php echo ($i); ?>" projid="<?php echo ($station_vo['proj_id']); ?>">
                                                    <td align="left"  style="padding: 0 0 0 25px;">
                                                        <?php echo ($station_vo['name']); ?>
                                                    </td>
                                                    <td align="center" style="height:35px">
                                                        <a style="margin-right: 5px;" class="edit_station_btn" href="javascript:void(0);" title="编辑" >
                                                        <span style="padding: 3px 3px;background-color: #6fb3e0;color: #FFF;">
								<i class="icon-edit bigger-120"></i>
                                                         </span>
                                                        </a>
                                                        <a data-id="<?php echo ($station_vo['id']); ?>" class="delete-station" title="删除">
                                                    <span style="padding:3px 3px 3px 5px;margin-right:5px;background-color: #d15b47;color: #FFF;">
                                                        <i class="icon-trash bigger-120"></i>
                                                    </span>
                                                        </a>
                                                        <div class="xzuserdiv"  onclick="xzprojpc(<?php echo ($station_vo['id']); ?>,<?php echo ($station_vo['cp_id']); ?>,<?php echo ((isset($station_vo['proj_id']) && ($station_vo['proj_id'] !== ""))?($station_vo['proj_id']):'0'); ?>)" >授 权</div>
                                                    </td>
                                                </tr><?php endif; ?>
                                            <?php else: ?>
                                            <?php if(!empty($station_vo['projname']) and empty($station_vo['id'])): ?><tr class="tr_x" onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='#ffffff';" bgcolor="#ffffff" stationid="<?php echo ($station_vo['id']); ?>" data_id="<?php echo ($i); ?>" projid="<?php echo ($station_vo['proj_id']); ?>">
                                                    <td align="left"  colspan="2" height="35px">
                                                        <label class="plusshow">-</label> <?php echo ($station_vo['projname']); ?>
                                                    </td>
                                                </tr>
                                                    <?php else: ?>
                                                <tr class="tr_c" onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='#ffffff';" bgcolor="#ffffff" stationid="<?php echo ($station_vo['id']); ?>" data_id="<?php echo ($i); ?>" projid="<?php echo ($station_vo['proj_id']); ?>">
                                                    <td align="left" style="padding: 0 0 0 25px;">
                                                        <?php echo ($station_vo['name']); ?>
                                                    </td>
                                                    <td align="center" style="height:35px">
                                                        <a style="margin-right: 5px;" class="edit_station_btn" href="javascript:void(0);" title="编辑" >
                                                        <span style="padding: 3px 3px;background-color: #6fb3e0;color: #FFF;">
								<i class="icon-edit bigger-120"></i>
                                                         </span>
                                                        </a>
                                                        <a data-id="<?php echo ($station_vo['id']); ?>" class="delete-station" title="删除">
                                                    <span style="padding:3px 3px 3px 5px;margin-right:5px;background-color: #d15b47;color: #FFF;">
                                                        <i class="icon-trash bigger-120"></i>
                                                    </span>
                                                        </a>
                                                        <div class="xzuserdiv"  onclick="xzprojpc(<?php echo ($station_vo['id']); ?>,<?php echo ($station_vo['cp_id']); ?>,<?php echo ((isset($station_vo['proj_id']) && ($station_vo['proj_id'] !== ""))?($station_vo['proj_id']):'0'); ?>)" >授 权</div>
                                                    </td>
                                                </tr><?php endif; endif; endforeach; endif; ?> 
                                    </tbody> 
                                </table>
                                <div class="blank20"></div>  
                                <?php if($selectedcomp['id'] > 0): ?><div>
                                        <div style="margin-top:10px;line-height: 18px; float:left;margin-bottom:5px;">
                                            <a href="javascript:void(0);" class="delurl add_station_btn" style="color:#FFF;">
                                                <i class="icon-file bigger-110"></i> 新增岗位</a>
                                        </div>
                                    </div><?php endif; ?>				
                            <div class="blank20"></div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        <div style="float:left;width:55%;margin-left:4%;overflow-x:hidden;overflow-y:hidden;"> 
            <div class="tags" style="width:100%">
                <div id="tagstitle"></div>
                <div id="tagscontent">
                    <div id="con_one_1">
                        <div class="table_td" style="">
                            <table border="0" cellspacing="2" cellpadding="4" class="list" name="table1" id="table1" width="100%">
                                <thead>
                                    <tr>
                                      <th align="center" style="width:40%">项目名称</th>
                                      <th align="center" style="width:35%">开盘批次</th> 
                                      <th align="center" style="width:25%">操作</th>
                                    </tr>
                                </thead> 
                               <tbody id="bldtb" name="bldtb" >
                                    <?php if(is_array($pclist)): foreach($pclist as $key=>$pclist_vo): ?><tr class="s_out"  bgcolor="#ffffff" id="trid_<?php echo ($pclist_vo['id']); ?>"> 
                                        <td align="center"><?php echo ($pclist_vo['projname']); ?></td> 
                                        <td align="center"> <?php echo ($pclist_vo['pcname']); ?> </td> 
                                        <td align="center" style="height: 35px;">
                                            <a onclick="stationdelpc(<?php echo ($pclist_vo['station_id']); ?>,<?php echo ($pclist_vo['id']); ?> )" title="删除">
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
<div class="user_edit_div">
    <form method="post" name="form1" action="">
        <div> <div  class="adduserlist_title">编辑岗位</div>
            <table border="0" cellspacing="2" cellpadding="4" class="list" name="table" id="table" width="100%">
                <tbody>
                    <tr onmouseover="this.bgColor = '#F5F5F5';" onmouseout="this.bgColor = 'ffffff';" bgcolor="ffffff">
                        <td class="left">岗位名称</td>
                        <td>
                            <input type="hidden" name="stationid" id="stationid" value="" > 
                            <input type="text" placeholder="请输入岗位名称" name="stationname" id="stationname" value="" class="skey" style="width:150px;">
                        </td>
                    </tr>
                    <tr onmouseover="this.bgColor = '#F5F5F5';" onmouseout="this.bgColor = 'ffffff';" bgcolor="ffffff">
                        <td class="left">项目选择</td>
                        <td>
                            <select name="proj_id" id="proj_id" style="width: 150px">
                                <option value="">请选择一个项目</option>
                                <?php if(is_array($pro)): foreach($pro as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr onmouseover="this.bgColor = '#F5F5F5';" onmouseout="this.bgColor = 'ffffff';" bgcolor="ffffff">
                        <td class="left">所属公司</td>
                        <td>
                            <?php echo ($selectedcomp['name']); ?>
                            <input type="hidden" name="company_id" id="company_id" value=" <?php echo ($selectedcomp['id']); ?>" > 
                        </td>
                    </tr>
                </tbody> 
            </table>
        </div>
        <div class="blank20"></div>
        <div class="user_bottom">
            <input type="button" class="save" value="保存" onclick="savestation()"> 
            <input type="button" value="取消" onclick="ycdiv();"> 
        </div>
    </form>
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
    //选择公司
    $("#companylist").change(function(){
            $("#compid").val($("#companylist option:selected").val());
        $("#selectcomp").submit();
      });
    $(".tr_x").click(function(){
        $(this).find(".plusshow");
        $projid=$(this).attr("projid");
        $trlist=$(this).parent().find(".tr_c");
        if( $(this).find(".plusshow").text()=="-")
        {
            if($trlist.length>0)
            {
                for(var i=0;i<$trlist.length;i++)
                {
                    if($projid==$trlist.eq(i).attr("projid"))
                    {
                        $trlist.eq(i).hide();
                    }
                }
            }
            $(this).find(".plusshow").text("+")
        }else
        {
            if($trlist.length>0)
            {
                for(var i=0;i<$trlist.length;i++)
                {
                    if($projid==$trlist.eq(i).attr("projid"))
                    {
                        $trlist.eq(i).show();
                    }
                }
            }
            $(this).find(".plusshow").text("-")
        }
    });
     //点击行事件
      $(".tr_c").click(function(){
	if($(this).hasClass("selectpc"))
	{
		//alert(11);
	}
	else{
		var $trlist=$("#pctable").find("tr");
		for (var $i=0;$i<$trlist.length;$i++)
		{
			$trlist.eq($i).removeClass("selectpc");
		}
		$(this).addClass("selectpc");
		
		var $compid=$("#companylist option:selected").val();
		showpclist($(this).attr("stationid"),$compid);
	}
    });
      //显示岗位批次列表
      function showpclist($stationid,$compid)
        {
              $("#bldtb").html("");
              $.ajax({
                      url: '<?php echo U("getprojpclist");?>',
                      data: {
                              station_id: $stationid ,
                              cp_id: $compid ,
                              type: "zj",
                      },
                      type: 'POST',
                      dataType: 'JSON',
                      success: function (data, status) {
//                          console.log(data);
//                                return false;
                              if (typeof(data.status) == 'undefined') {
                                      layer_alert('请求失败，请重试！');
                                      return false;
                              } 
                              if (data.status == false) {
                                  layer_alert(data.info);
                                      return false;
                              }
                              var $pclist = data.info;
                              var $temphtml="";
                              if ($pclist.length > 0) {

                                              for (var $i = 0; $i < $pclist.length; $i ++) {
                                                      $temphtml+="<tr class='s_out'  bgcolor='#ffffff' id='trid_"+ $pclist[$i].id +"' >";
                                                      $temphtml+="<td align='center'>" + $pclist[$i].projname + "</td> ";
                                                      $temphtml+="<td align='center'>" + $pclist[$i].pcname + "</td> ";
                                                      $temphtml+="<td align='center' style='height: 35px;'>";
                                                      $temphtml+="<a onclick='stationdelpc(" + $pclist[$i].station_id + "," +$pclist[$i].id + ")' ><span style='padding: 3px 5px;background-color: #dc2d0e;color: #FFF;'><i class='icon-trash bigger-120'></i></span></a>";
                                                      $temphtml+="</td></tr> ";
                                              }
                                              $("#bldtb").html($temphtml);
                              } 	
                      },
                      error: function (data, status, e) {
                              layer_alert('提交连接失败！');
                      }
              }); 
        }
 
            //删除岗位用户
            function stationdelpc($stationid,$id)
            {
                    if ($id==0||$id=="")
                    {
                            layer_alert("数据异常，请稍后重试");
                            return false;
                    }
		
                    if (!confirm("是否从岗位中移除此项目批次权限？！"))
                                    return false;

                    var project_url = {stationdelpc: '<?php echo U("stationdelpc");?>',}		
                    $.ajax({
                            url: project_url.stationdelpc,
                            data: {
                                    stationid: $stationid ,
                                    id: $id ,
                            },
                            type: 'POST',
                            dataType: 'JSON',
                            success: function (data, status) {
                                    if (typeof(data.status) == 'undefined') {
                                            layer_alert('请求失败，请重试！');
                                            return false;
                                    } 
                                    if (data.status == false) {
                                            alert(data.info);
                                            return false;
                                    }
                                    layer_alert("操作成功");
                                    $("#trid_"+ $id).remove();
                                    //window.location.reload();
                            },
                            error: function (data, status, e) {
                                    layer_alert('提交连接失败！');
                            }
                    }); 
            }
	
            //岗位选择批次界面
            function xzprojpc($station_id,$cp_id,pid)
            {
                    var project_url = {getuserist: '<?php echo U("getprojpclist");?>',}		
                    $.ajax({
                            url: project_url.getuserist,
                            data: {
                                    station_id: $station_id ,
                                    cp_id: $cp_id ,
                                    type:"all",
                                    pid: pid
                            },
                            type: 'POST',
                            dataType: 'JSON',
                            success: function (data, status) {
//                                console.log(data);
//                                return false;
                                    if (typeof(data.status) == 'undefined') {
                                            layer_alert('请求失败，请重试！');
                                            return false;
                                    } 
                                    if (data.status == false) {
                                            alert(data.info);
                                            return false;
                                    }
                                    var $pclist = data.info;
                                    var $temphtml="";
                                    if ($pclist.length > 0) {

                                                    for (var $i = 0; $i < $pclist.length; $i ++) {
                                                            $temphtml+="<tr id='userid_"+ $pclist[$i].id +"' class='trcb'>";
                                                            $temphtml+="<td style='width:20%'><input type='checkbox'  class='selectpc' name='id[]' sprojid='"+ $pclist[$i].proj_id +"' value='" + $pclist[$i].id + "'></td> ";
                                                            $temphtml+="<td align='left' style='width:45%;font-size:12px'>" + $pclist[$i].projname + "</td> ";
                                                            $temphtml+="<td align='left' style='width:35%;font-size:12px'>" + $pclist[$i].name + "</td> ";
                                                            $temphtml+="</tr> ";
                                                    }
                                                    $("#addqz").attr("station_id",$station_id);
                                                    $("#addqz").attr("cp_id",$cp_id);
                                                    $("#userlisttb").html("").html($temphtml);
                                                     $("#userlistdiv").css("height","75vh").show();
                                                    $allheight=$("#userlistdiv").height();
                                                    $("#usersinfodiv").css("height",$allheight -100)
                                                    $("#zz_div").show();
                                    }
                                    else
                                    {
                                            layer_alert('无可供选择的项目批次！');
                                    }				
				
                            },
                            error: function (data, status, e) {
                                    layer_alert('提交连接失败！');
                            }
                    }); 
            }
	
            //岗位增加项目批次权限
            function stationaddpc()
            {
                    var $station_id=$("#addqz").attr("station_id");
                    var $cp_id=$("#addqz").attr("cp_id");
                    var $pclist="";
                    var $allpc=$("#userlisttb").find(".selectpc")
		
                    for(var i=0;i<$allpc.length;i++)
                    {
                            if ($allpc.eq(i).is(':checked')) 
				$pclist+=$allpc.eq(i).val() + "]" + $allpc.eq(i).attr('sprojid') + "|";
                    }
		
                    if ($pclist=="")
                    {
                            layer_alert('请选择项目批次！');
                            return false;
                    }
                    else{
                            $pclist=$pclist.substring(0,$pclist.length-1);
                    }
		
                    var project_url = {stationaddpc: '<?php echo U("stationaddpc");?>',}	
                    $.ajax({
                            url: project_url.stationaddpc,
                            data: {
                                    station_id: $station_id ,
                                    pclist:$pclist,
                            },
                            type: 'POST',
                            dataType: 'JSON',
                            success: function (data, status) {
                                    if (typeof(data.status) == 'undefined') {
                                            layer_alert('请求失败，请重试！');
                                            return false;
                                    } 
                                    if (data.status == false) {
                                            alert(data.info);
                                            return false;
                                    }
                                    $("#userlistdiv").hide();
                                    $("#zz_div").hide();
                                    layer_alert("操作成功");
                                    showpclist($station_id,$cp_id);
                            },
                            error: function (data, status, e) {
                                    layer_alert('提交连接失败！');
                            }
                    }); 
            }
            
            //岗位信息编辑页面
            $(".edit_station_btn").on('click', function(){
                var $station_id=$(this).parent().parent().attr("stationid");
                var station_url = {editstation: '<?php echo U("editstation");?>', }
                $.ajax({
                        url: station_url.editstation,
                        data: {
                            id: $station_id,
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
                            var $stationinfo = data.info;
                            $(".adduserlist_title").text("编辑岗位信息");
                            $("#stationid").val($stationinfo.id);
                            $("#stationname").val($stationinfo.name);
                            $("#proj_id").val($stationinfo.proj_id);
                            $("#company_id").val($stationinfo.id);
                            $("#zz_div").show();
                            $(".user_edit_div").show();
                        },
                        error: function (data, status, e) {
                            layer_alert('提交连接失败！');
                        }
                    });
            });
             $(".add_station_btn").on('click', function(){
                 $(".adduserlist_title").text("新增岗位");
                 $("#stationname").val('');
                 $("#proj_id").val('');
                 $("#zz_div").show();
                 $(".user_edit_div").show();
             });
            //保存岗位
            function savestation()
            {
                var $id = $("#stationid").val();
                var $name = $("#stationname").val();
                var proj_id = $("#proj_id").val();
                var $compid = $("#company_id").val();
                if ($name=="")
                {
                        layer_alert("名称不能为空");
                        return false;
                }


                var project_url = {savestation: '<?php echo U("savestation");?>',}

                $.ajax({
                        url: project_url.savestation,
                        data: {
                                id: $id,
                                compid: $compid,
                                name: $name,
                                proj_id: proj_id,
                        },
                        type: 'POST',
                        dataType: 'JSON',
                        success: function (data, status) {
                                if (typeof(data.status) == 'undefined') {
                                        layer_alert('请求失败，请重试！');
                                        return false;
                                } 
                                if (data.status == false) {
                                        layer_alert(data.info);
                                        return false;
                                }
                               
                                //layer_alert('更改成功！');
                                $("#zz_div").hide();
                                $(".user_edit_div").hide();
                                window.location.reload();
                        },
                        error: function (data, status, e) {
                                layer_alert('提交连接失败！');
                        }
                }); 
            }
            
            
            function checkall()
            { 
                    var $checkinfo = $('#chkall').is(':checked');
                    if($checkinfo ==  true){
                            $("input[name='id[]']").prop("checked",true); 
                    }else{
                            $("input[name='id[]']").prop("checked",false); 
                    } 
            }
	
            function ycdiv()
            {
                $("#userlistdiv").hide();
                $(".user_edit_div").hide();
                $("#zz_div").hide();
            }
            
             $(".adduserlist_div table").on("click",".trcb",function(){
                if ($(this).first().find("input").prop("checked"))
                    $(this).first().find("input").prop("checked", false);
                else
                    $(this).first().find("input").prop("checked", true);
            });
            
            $(".adduserlist_div table").on("click",".selectpc",function(){
                if ($(this).prop("checked"))
                    $(this).prop("checked", false);
                else
                    $(this).prop("checked", true);
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