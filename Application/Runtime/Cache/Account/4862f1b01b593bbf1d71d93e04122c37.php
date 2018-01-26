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

#tagscontent .table_td th, #tagscontent #sample-table-room th {
    background: #f2f2f2;
    text-align: center;
    font-size:13px;
    border: 1px solid #DDD;
}
#tagscontent th {
    color: #707070;
}

#tagscontent td {
    font-size: 13px;
    color: #1B4670;
    border: 1px solid #e8eef6;
}
.search {
    text-align: left;
    background: #fcf9f4;
    /*height: 38px;*/
    line-height: 38px;
    float:right;
    margin-right: 10px
}

.search_content {
    margin-top: 0px;
    color: #393939;
    padding-left: 20px;
    font-size:12px;
    background: #eff3f8;
}


/* 通用分页 */
.page-container {
	text-align: right;
	background: #eff3f8;
        padding-top: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #DDD;
}
.page-container .num,
.page-container .prev,
.page-container .next,
.page-container .first,
.page-container .end,
.page-container .rows,
.page-container .current
{
	padding: 5px;
	display: inline-block;
        padding: 6px 12px;
        background: #fafafa;
        color: #0076cf;
        font-size: 12px;
        border: 1px solid #ddd;
        margin-left: -1px;
}
.page-container .current
{
    background: #6faed9;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
}
.page-container .num:hover,
.page-container .prev:hover,
.page-container .next:hover,
.page-container .first:hover,
.page-container .end:hover,
.page-container .rows:hover,
.page-container .current:hover
{
    cursor: pointer;
}
form{
    display: inline;
}

.button {
    /* background: url('/Public/account/img/buttom_bg.gif') right bottom no-repeat; */
    height: 24px;
    line-height: 18px;
    cursor: pointer;
    text-align: center;
    padding: 2px 10px;
    border: 1px solid #c4d9e9;
    background: #ffffff;
    color: #1f74bd;
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
    background: url('/Public/account/img/buttom_bg.gif') right bottom no-repeat;
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

.xzblddiv{
width: 60px;
margin-left: 40px;
color:#FFF;
border:1px solid #FFF;
background:rgb(220, 45, 14);
border-radius:5px;
padding:2px 0;
font-weight:bold;
cursor:pointer;
line-height:20px
}
a{
cursor:pointer;
}

.row-fluid
{
position:absolute;
width:260px;
height:300px;
background:blue;
margin-left:400px;
margin-top:100px;
}

/* 房间列表 */
.room-title-project {
	font-size: 13px;
	font-weight: bold;
}

.room-nav-edit {
	clear: both;
	margin: 0;
	padding: 0;
}
.room-nav-edit .room-nav-edit-btn {
	    list-style: none;
            display: inline-block;
            padding: 4px 7px;
            background: #428bca;
}
.room-export-btn {
	width:66px;
	color:#FFF;
	font-size: 13px;
}
.room-export-btn:link {
	color:#FFF;
}
.room-export-icon-in {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
	display: inline-block;
	background: url(/Public/account/img/dr01.png) no-repeat scroll 0 2px/14px 14px;
	width: 15px;
	height: 15px;
}
.room-export-icon-out {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
	display: inline-block;
	background: url(/Public/account/img/dr01.png) no-repeat scroll 0 2px/14px 14px;
	width: 15px;
	height: 15px;
}
.room-export-icon-refresh {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
	display: inline-block;
	background: url(/Public/account/img/sx01.png) no-repeat scroll 0 2px/18px 15px;
	width: 20px;
	height: 17px;
}
.room-project {
	/*padding-top: 10px;
	margin: 5px 0;*/
	background: #f5f5f5;
	border-left: 2px solid #e4d7c1;
}
.a_tb_bg{
    width: 20px;
    background: #D45C36;
    padding: 3px 5px;
    margin-left: 5px;
}

#sample-table-room>tbody>tr:nth-child(odd)>td{
    background-color: #f9f9f9;
}
.search_content label input{
    width:100px;
    padding: 3px 4px;
}
.pagerow{
    padding-top: 12px;
    padding-bottom: 12px;
    background-color: #eff3f8;
    border-bottom: 1px solid #DDD;
}
</style>
<div class="row">
    <div class="col-xs-12">
    <div class="table-header">
	<span>房间列表</span>
        
	
	<div style="float:right;margin-right:10px;height: 31px;">

	</div>
</div>

<div class="show_content_m_t2">
 <div style="width:100%;overflow-x:hidden;overflow-y:hidden"> 
     <div style="background: #eff3f8;height: 43px;">   
     <div style="display:block;float:left;line-height: 38px;">
         <form method="post" id="selectproj" name="selectproj" action="room" >
            <font style="margin-left:10px;">项目</font>
            <select id= "projlist" name="projid" style="height:25px;padding: 1px 10px;" >
            <?php if($selectedproj['id'] > 0): if(is_array($projlist)): foreach($projlist as $key=>$projlist_vo): if($selectedproj['id'] == $projlist_vo['id']): ?><option value="<?php echo ($projlist_vo['id']); ?>" selected>
                            <?php echo ($projlist_vo['company_name']); ?>--<?php echo ($projlist_vo['name']); ?>  
                      </option>
                    <?php else: ?>		 
                      <option value="<?php echo ($projlist_vo['id']); ?>">
                            <?php echo ($projlist_vo['company_name']); ?>--<?php echo ($projlist_vo['name']); ?>
                      </option><?php endif; endforeach; endif; ?> 
            <?php else: ?>
                    <option value="0" selected></option>
                     <?php if(is_array($projlist)): foreach($projlist as $key=>$projlist_vo): ?><option value="<?php echo ($projlist_vo['id']); ?>">
                            <?php echo ($projlist_vo['company_name']); ?>--<?php echo ($projlist_vo['name']); ?> 
                       </option><?php endforeach; endif; endif; ?>
            </select>
            </form>
        </div>
	<div class="search"> 
		<div class="search_content">	 
			<form method="post"  action="room" id="form-b">
				<input type="hidden" name="projid" value="<?php echo ((isset($projid) && ($projid !== ""))?($projid):''); ?>" style="display:none;">
                <input type="hidden" name="p" value="<?php echo ((isset($p) && ($p !== ""))?($p):1); ?>">
                <input type="hidden" name="r" value="<?php echo ((isset($listRows) && ($listRows !== ""))?($listRows):15); ?>">
                <input type="hidden" name="excel" value="0">
				<label style="font-size: 13px;">
				   楼栋
				   <input type="text" name="buildname" value="<?php echo ((isset($buildname) && ($buildname !== ""))?($buildname):''); ?>"> 
				</label>
			   
			   &nbsp;
				<label>
					单元
					<input type="text" name="unit" value="<?php echo ((isset($unit) && ($unit !== ""))?($unit):''); ?>"> 
				</label>
				&nbsp;
				<label>
					户型
					<input type="text" name="hx" value="<?php echo ((isset($hx) && ($hx !== ""))?($hx):''); ?>">  
				</label>
               
				&nbsp;
				<label style="font-size: 13px;">
					房号
					<input type="text" name="room" value="<?php echo ((isset($room) && ($room !== ""))?($room):''); ?>">    
				</label>
				
				<input type="submit" value="提交查询" class="button room-search-button">  
			</form>
		</div>
	</div>
     </div>
	
    <div class="tags" style="width:100%; padding: 0;border:0;">
      	<div id="tagstitle"></div>
        <div id="tagscontent">
           <div id="con_one_1">
             <div class="table_td" >
              <!--<form method="post" action="">-->
                  <table border="0" cellspacing="2" id="sample-table-room" cellpadding="4" class="table table-striped table-bordered table-hover dataTable" >
                    <thead>
                      <tr>
                        <th width="60px">
                            <label>
                                <input type="checkbox" class="ace">
                                <span class="lbl"></span>
                            </label>
                        </th>
						<th align="center">房间名称</th>
						<th align="center">户型</th>
						<th align="center">建筑面积</th>
                        <th align="center">建筑单价</th>
						<th align="center">套内面积</th> 
						<th align="center">套内单价</th>
						<th align="center">标准总价</th>
						<th align="center">优惠后总价</th>
						<th align="center">销售状态</th>
                        <th align="center" style="width:100px">
						操作
						</th>
                      </tr>
                    </thead> 
                     <tbody id="roomlisttb">
                      <?php if(is_array($roomlist)): foreach($roomlist as $key=>$roomlist_vo): ?><tr class="s_out" onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff"> 
                        <td align="center" >
                            <label>
                                <input type="checkbox"  data-id="<?php echo ($roomlist_vo['id']); ?>"  <?php if($roomlist_vo['is_xf'] == 1): ?>class="ace" disabled<?php else: ?>class="ace delete-bs"<?php endif; ?>>
                                <span class="lbl"></span>
                            </label>
                        </td>
						<td align="left">
                                                    <a href="<?php echo U('jcsjroom/edit', array('id' => $roomlist_vo['id']));?>" style="text-decoration: underline;">
                                                            <?php echo ($roomlist_vo['projname']); ?>-<?php echo ($roomlist_vo['buildname']); ?>-<?php echo ($roomlist_vo['unit']); ?>-<?php echo ($roomlist_vo['room']); ?>
                                                    </a>
						</td> 
                        <td align="center"><?php echo ($roomlist_vo['hx']); ?></td> 
                        <td align="right"> <?php echo ($roomlist_vo['area']); ?> </td> 
                        <td align="right"><?php echo number_format($roomlist_vo['price'],2);?></td> 
						<td align="right"> <?php echo ($roomlist_vo['tnarea']); ?> </td> 
                        <td align="right"><?php echo number_format($roomlist_vo['tnprice'],2);?></td>
						<td align="right"><?php echo number_format($roomlist_vo['total'],2);?></td> 
						<td align="right"><?php echo number_format($roomlist_vo['discount'],2);?></td>
						<?php if($roomlist_vo['is_xf'] == 0): ?><td align="center">待售</td>	
						<?php else: ?>
						<td align="center">已售</td><?php endif; ?>
                        <td align="center">
                        	<a href="<?php echo U('jcsjroom/edit', array('id' => $roomlist_vo['id']));?>" >
                                                            <span class="" style="padding: 3px 3px;background-color: #6fb3e0;color: #FFF;" title="修改">
								<i class="icon-edit bigger-120"></i>
                                                            </span>
							</a>
                            <?php if($roomlist_vo['is_xf'] == 0): ?><a href="javascript:void(0);" class="a_tb_bg js-del-room" roomid="<?php echo ($roomlist_vo['id']); ?>" title="删除">
                                                            <span class="white">
								<i class="icon-trash bigger-120"></i> 
                                                            </span>
                                                        </a>
                                <?php else: ?>
                                &nbsp;
                                &nbsp;
                                &nbsp;
                                &nbsp;<?php endif; ?>
                        </td> 
                      </tr><?php endforeach; endif; ?> 
                     <tr>
                        <td class="center">
                            <div class="action-buttons" id="delete-batch" title="批量删除" style="border-style: none">
                                <a>
                                <i class="icon-trash bigger-130" style="margin: 0;color:#dd5a43;"></i>
                                </a>
                            </div>
                        </td>
                        <td colspan="10">
                        <ul class="room-nav-edit" >
                                <li class="room-nav-edit-btn">
                                        <a class="room-export-btn js-room-excel-import" href="javascript:void(0);">
                                                <i class="icon-cloud-upload bigger-110"></i>
                                                导入数据
                                        </a>
                                </li>
                                <li class="room-nav-edit-btn">
                                    <a class="room-export-btn" href="/Account/Jcsjroom/exportfj/projid/<?php echo ($selectedproj['id']); ?>.html">
                                                <i class="icon-cloud-download bigger-110"></i>
                                                导出房间模板
                                        </a>
                                </li>
                                 <li class="room-nav-edit-btn">
                                        <a class="room-export-btn" href="/Account/Jcsjroom/exportcw/projid/<?php echo ($selectedproj['id']); ?>.html">
                                                <i class="icon-cloud-download bigger-110"></i>
                                                导出车位模板
                                        </a>
                                </li>
                            <li class="room-nav-edit-btn" style="float: right;
    margin-right: 18px;">
                                <a class="room-export-btn" id="check-room" href="javascript:;">
                                    <i class="icon-cloud-download bigger-110"></i>
                                    导出房间数据
                                </a>
                            </li>
                        </ul>
                        </td>     
                     </tr>
                    </tbody> 

                  </table>
                <div class="row pagerow">
                    <div class="col-sm-6">
                            <div class="dataTables_info" id="sample-table-2_info">
                            &nbsp;&nbsp;第 <input id="newpage" type="tel" value="<?php echo ((isset($p) && ($p !== ""))?($p):1); ?>" style="width:30px" class="tzpage"> 页/ <?php echo ((isset($total_pages) && ($total_pages !== ""))?($total_pages):1); ?> 页，每页<input id="newrows"  type="tel" value="<?php echo ((isset($listRows) && ($listRows !== ""))?($listRows):15); ?>" style="width:30px"  class="tzrows"> 条/共 <?php echo ((isset($count) && ($count !== ""))?($count):1); ?> 条
                            </div>
                    </div> 
                    <div class="col-sm-6">
                            <div class="dataTables_paginate paging_bootstrap"> 
                                    <?php echo ((isset($page_show) && ($page_show !== ""))?($page_show):''); ?>
                            </div>
                    </div>
		</div>
				
            </div>
           </div>
        </div>
    </div>    
  </div> 
</div>
 
</div>
</div>
<div class="js-choose-user-excel-import-tpl" style="display:none;">
	<form method="post" id="choose-user-excel-import-tpl-form" class="choose-user-excel-import-tpl-form" name="import-form" action="<?php echo U('upload');?>" enctype="multipart/form-data" >
		<div class="choose-user-excel-import-tpl">
			<div class="choose-user-excel-import-tpl-title">
				提交EXECL数据文件
			</div>
			<div class="choose-user-excel-import-tpl-input">
				<input type="file" class="choose-excel-import-tpl-file upload" name="excel" value="" />
			</div>
			<div class="choose-user-excel-import-tpl-btns center">
				<button class="btn btn-sm btn-purple js-choose-room-excel-import-tpl-btn">
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
			

			<!-- ace scripts -->
			
				<script src="/Public/account/assets/js/ace-elements.min.js"></script>
				<script src="/Public/account/assets/js/ace.min.js"></script>
			
			
			
			<!-- inline scripts related to this page -->
			
<script type="text/javascript">
    var c_num="<?php echo ($p); ?>";
$(function() {
    //批量删除
    $("#delete-batch").on("click",function () {
        var cd=$(".delete-bs:checked");
        var id_arr=[];
       for(var i=0;i<cd.length;i++){
           id_arr[i]=cd.eq(i).attr("data-id");
       }
       if(id_arr.length===0){
           gritter_alert('请至少选中一条数据！');
           return false;
       }
       var data={"sz":id_arr};
        var callback = function() {
            ajax_post_callback("<?php echo U('/Account/Jcsjroom/delete_batch');?>", data, function(data, status) {
                console.log(data);
                if (data['status'] != 1) {
                    gritter_alert(data['info']);
                    return false;
                } else {
                    gritter_alert_success('删除成功！');

                    setTimeout(function() {
                       window.location.reload();
                    }, 1000);
                }
            });
        };
        layer_confirm('确认删除吗，删除后将不能恢复？', callback);

    });
    $("#form-b input").on("keyup",function () {
       if(event.keyCode ===13){
           $("#form-b input[name='p']").val("1");
           $("#form-b").submit();
       }
    });
    $("#check-room").on("click",function () {
        $("#form-b input[name='excel']").val("1");
        $("#form-b").submit();
    });
    $("#projlist").change(function(){
            $("#selectproj").submit();
      });  

      $(".js-del-room").on('click', function(){
          var $id=$(this).attr("roomid");
          if ($id==0)
            {
                    layer_alert("数据异常，请稍后重试");
                    return false;
            }
            var callback = function() {
			var $url = Jcsj_room_url.delroom;			
			var $data = {
				id: $id,
			}
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					gritter_alert(data['info']);
					return false;
				} else {
					gritter_alert_success('删除成功！');
					
					window.location.reload();
				}			
			});
		}
		
		layer_confirm('是否删除此房间？！', callback);
      });	
	
        //房间 - 导入excel - 提示
	$(".js-room-excel-import").on('click', function() {
		var $html = $(".js-choose-user-excel-import-tpl").html();
		
		layer_html($html);
		
		return false;
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
    //全选和全不选
    $("#sample-table-room input:first").click(function () {
        if($(this).prop("checked")===true){
            $("#sample-table-room .delete-bs").prop("checked",true);
        }else{
            $("#sample-table-room .delete-bs").prop("checked",false);
        }
    });


    //设置每页显示条数
    $(".tzrows").keypress(function(e) {
        if (e.which == 13)
        {
            $zcount=parseInt("<?php echo ($count); ?>",10);//总条数
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
});
function checkall()
            { 
                    var $checkinfo = $('#chkall').is(':checked');
                    if($checkinfo ==  true){
                            $("input[name='id[]']").prop("checked",true); 
                    }else{
                            $("input[name='id[]']").prop("checked",false); 
                    } 
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