<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">

<head>
	<title>Dashboard | Klorofil - Free Bootstrap Dashboard Template</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="/think-demo/Application/Admin/View/Public/homeList/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/think-demo/Application/Admin/View/Public/homeList/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/think-demo/Application/Admin/View/Public/homeList/vendor/linearicons/style.css">
	<link rel="stylesheet" href="/think-demo/Application/Admin/View/Public/homeList/vendor/chartist/css/chartist-custom.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="/think-demo/Application/Admin/View/Public/homeList/css/main.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="/think-demo/Application/Admin/View/Public/homeList/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="/think-demo/Application/Admin/View/Public/homeList/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/think-demo/Application/Admin/View/Public/homeList/img/favicon.png">

	<!-- <script src="/think-demo/Application/Admin/View/Public/assets/js/bootstrap-table.js"></script>
	    <link href="/think-demo/Application/Admin/View/Public/assets/css/bootstrap-table.css" rel="stylesheet" />
	    <script src="/think-demo/Application/Admin/View/Public/assets/js/bootstrap-table-zh-CN.js"></script> -->
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="index.html"><img src="/think-demo/Application/Admin/View/Public/homeList/img/logo-dark.png" alt="Klorofil Logo" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<form class="navbar-form navbar-left">
					<div class="input-group">
						<input type="text" value="" class="form-control" placeholder="Search dashboard...">
						<span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
					</div>
				</form>
				<div class="navbar-btn navbar-btn-right">
					<a class="btn btn-success update-pro" href="#downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-danger">5</span>
							</a>
							<ul class="dropdown-menu notifications">
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>System space is almost full</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-danger"></span>You have 9 unfinished tasks</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Monthly report is available</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Weekly meeting in 1 hour</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Your request has been approved</a></li>
								<li><a href="#" class="more">See all notifications</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="lnr lnr-question-circle"></i> <span>Help</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="#">Basic Use</a></li>
								<li><a href="#">Working With Data</a></li>
								<li><a href="#">Security</a></li>
								<li><a href="#">Troubleshooting</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="/think-demo/Application/Admin/View/Public/homeList/img/user.png" class="img-circle" alt="Avatar"> <span><?php echo (session('username')); ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="#"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>
								<li><a href="#"><i class="lnr lnr-envelope"></i> <span>Message</span></a></li>
								<li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>
								<li><a href="<?php echo U('Login/loginout');?>"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
							</ul>
						</li>
						<!-- <li>
							<a class="update-pro" href="#downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
						</li> -->
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="<?php echo U('Login/homeList');?>" class="active"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
						<li><a href="elements.html" class=""><i class="lnr lnr-code"></i> <span>Elements</span></a></li>
						<li><a href="charts.html" class=""><i class="lnr lnr-chart-bars"></i> <span>Charts</span></a></li>
						<li><a href="panels.html" class=""><i class="lnr lnr-cog"></i> <span>Panels</span></a></li>
						<li><a href="notifications.html" class=""><i class="lnr lnr-alarm"></i> <span>Notifications</span></a></li>
						<li>
							<a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Pages</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages" class="collapse ">
								<ul class="nav">
									<li><a href="page-profile.html" class="">Profile</a></li>
									<li><a href="page-login.html" class="">Login</a></li>
									<li><a href="page-lockscreen.html" class="">Lockscreen</a></li>
								</ul>
							</div>
						</li>
						<li><a href="tables.html" class=""><i class="lnr lnr-dice"></i> <span>Tables</span></a></li>
						<li><a href="typography.html" class=""><i class="lnr lnr-text-format"></i> <span>Typography</span></a></li>
						<li><a href="icons.html" class=""><i class="lnr lnr-linearicons"></i> <span>Icons</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Weekly Overview</h3>
							<p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p>
						</div>
						<div id='div' class="panel-body">
							<table id="mytable" class="table table-striped">
							<thead>
								<th>账号</th>
								<th>密码</th>
								<th>序列</th>
								<th>操作</th>
							</thead>
							<tbody id='myTableBody'></tbody>
							
							</table>
							
							
						</div>

						<form id="selForm" action="javascript:void(0);" >
							<input type="hidden" id="pageIndex" name="pageIndex" value="1"/>
							<input type="hidden" id="pageSize" name="pageSize" value="10"/>
							<input type="hidden" id="totalSize" name="totalSize"/>
							<input type="hidden" id="totalPage" name="totalPage"/>
							
						</form>

		                <div class="row">
							<ul class="pagination pull-right" >
								<li>
									<p class="pull-left" style="padding-top: 5.5px;font-size: 15px; margin-right: 10px;font-weight:lighter;">
										当前页:&nbsp;&nbsp;<label id="showIndex"></label>&nbsp;&nbsp;/&nbsp;&nbsp;<label id="showTotal"></label>&nbsp;&nbsp;(总页数)
									</p>
								</li>
							  	<li name="first"><a href="javascript:void(0);" title="首页" onclick="javascript:go('first');">&laquo;</a></li>
							  	<li name="pre"><a href="javascript:void(0);" title="上一页" onclick="javascript:go('pre');">上一页</a></li>
							  	<li name="next"><a href="javascript:void(0);" title="下一页" onclick="javascript:go('next');">下一页</a></li>
							  	<li name="last"><a href="javascript:void(0);" title="末页" onclick="javascript:go('last');">&raquo;</a></li>
							  	<li>
							  		<form action="javascript:void(0);" class="form-inline pull-right" style="margin-right: 15px;">
							  			<div class="form-group">
											<div class="col-sm-2">
												<input type="number" class="form-control" min="1" id="jump" name="jump" style="width: 80px;" placeholder="页码">
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-2">
												<button type="button" class="btn btn-primary" onclick="javascript:jumpTo();" title="跳转">
													<span class="glyphicon glyphicon-share-alt">
														跳转
													</span>
												</button>
											</div>
										</div>
							  		</form>
							  	</li>
							</ul>
						</div>


					</div>
				</div>
			</div>
		</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="/think-demo/Application/Admin/View/Public/homeList/vendor/jquery/jquery.min.js"></script>
	<script src="/think-demo/Application/Admin/View/Public/homeList/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="/think-demo/Application/Admin/View/Public/homeList/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="/think-demo/Application/Admin/View/Public/homeList/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="/think-demo/Application/Admin/View/Public/homeList/vendor/chartist/js/chartist.min.js"></script>
	<script src="/think-demo/Application/Admin/View/Public/homeList/scripts/klorofil-common.js"></script>
	<script>
	$(function() {
		
       
        
    	show();
	});

	function show(){  
      	var username = "admin";  
        var password = "123";  
        $.post('<?php echo U("Login/getString");?>',{name:username,pwd:password},function(data) {  
        	console.log(data);
        	
        	
        	datelist(data);  

       	})  
    }  
    function go(method){
    	var totalPage = $('#totalPage').val();//当前页
    	var totalSize = $('#totalSize').val(); //总页数

    	if(method == 'next'){    		
    		console.log(parseInt(totalSize));
    		console.log(parseInt(totalPage));
    		if(parseInt(totalPage) < parseInt(totalSize)){
    			var index = parseInt(totalPage) + 1;    			
    			$.post('<?php echo U("Login/getString");?>',{page:parseInt(index)},function(data) {   				
					console.log(data);
					$('#myTableBody').html("");
					datelist(data);					
    			});
    		}else{
    			alert('最后一页了');
    		}
    	}else if(method == 'pre'){
    		if(parseInt(totalPage) > 1){
    			var index = parseInt(totalPage) - 1;
    			$.post('<?php echo U("Login/getString");?>',{page:parseInt(index)},function(data) {   									
					$('#myTableBody').html("");
					datelist(data);					
    			});
    		}else{
    			alert("以经是第一页了");
    		}
    	}else if(method == 'first'){
    		$.post('<?php echo U("Login/getString");?>',{page:1},function(data) {   									
					$('#myTableBody').html("");
					datelist(data);					
    			});
    	}else if(method == 'last'){

			$.post('<?php echo U("Login/getString");?>',{page:parseInt(totalSize)},function(data) {   									
					$('#myTableBody').html("");
					datelist(data);					
    			});
    	}

    }
    function jumpTo(){
    	if($('#jump').val() == undefined || $('#jump').val() == ''){
			alert("请输页码");
			return;
		}
		var jumpIndex = parseInt($('#jump').val());
		var totalSize = parseInt($('#totalSize').val());
		if(jumpIndex <= 0){
			alert("请输入大于0的页码!");
			return;
		}
		if(jumpIndex > totalSize){
			alert("没有更多的数据了!!");
			return;
		}

		$.post('<?php echo U("Login/getString");?>',{page:jumpIndex},function(data) {   									
			$('#myTableBody').html("");
			datelist(data);					
    	});
    }
    function datelist(list){
    	var str = "";
        var i =1;
    	var data = list;
    	$('#totalPage').val($.parseJSON(data).thisPage);//当前页
        $('#totalSize').val($.parseJSON(data).pageCount);//总页数
        $('#showIndex').text($.parseJSON(data).thisPage);
        $('#showTotal').text($.parseJSON(data).pageCount);
    	$.each($.parseJSON(data).list, function (n, value) {

                str += '<tr>';
        		str += '<td>'+value.username+'</td>';
        		str += '<td>'+value.password+'</td>';
        		str += '<td>'+value.id+'</td>';
        		str += '<td>';
        		str += '<button type="button" class="btn btn-primary btn-sm" style="margin-left:10px;"  onclick="">';	
        		str += '<span class="glyphicon glyphicon-pencil" title="修改"></span>';
        		str += '</button>';
        		str +='</td>';
        		str += '</tr>';
        		i++;
           });
    	 $('#myTableBody').append(str);
    }


	</script>
</body>

</html>