<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<head>
	<title>Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="keywords" content="Colored Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- bootstrap-css -->
	<link rel="stylesheet" href="{{asset('/backend/css/bootstrap.css')}}">
	{{-- animate-css --}}
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
	{{-- dataTable --}}
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"/>
	<!-- Selectpicker -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
	<!-- Custom CSS -->
	<link href="{{asset('/backend/css/style.css')}}" rel='stylesheet' type='text/css' />
	<!-- font CSS -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<!-- font-awesome icons -->
	<link rel="stylesheet" href="{{asset('/backend/css/font.css')}}" type="text/css"/>
	<link href="{{asset('/backend/css/font-awesome.css')}}" rel="stylesheet"> 
	<!-- font-awesome icons -->
	<!-- charts -->
	<link rel="stylesheet" href="{{asset('/backend/css/morris.css')}}">
	<!-- //charts -->
	{{-- alert1 --}}
	{{-- <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script> --}}
	{{-- alert2 --}}
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="dashboard-page">
	@include('sweetalert::alert')

	{{-- <script>
		var theme = $.cookie('protonTheme') || 'default';
		$('body').removeClass (function (index, css) {
			return (css.match (/\btheme-\S+/g) || []).join(' ');
		});
		if (theme !== 'default') $('body').addClass(theme);
	</script> --}}
	<nav class="main-menu">
		<ul>
			<li>
				<a href="{{URL::to('/admin/dashboard')}}">
					<i class="fa fa-home nav_icon"></i>
					<span class="nav-text">
						Dashboard
					</span>
				</a>
			</li>
			<li>
				<a href="{{URL::to('/admin/questions')}}">
					<i class="fa fa-question nav-icon"></i>
					<span class="nav-text">
						Question Library
					</span>
					<i class="icon-angle-right"></i><i class="icon-angle-down"></i>
				</a>
				<ul>
					<li>
						<a class="subnav-text" href="{{URL::to('/admin/skills')}}">
							Skills Manage
						</a>
					</li>
					<li>
						<a class="subnav-text" href="{{URL::to('/admin/parts')}}">
							Part Manage
						</a>
					</li>
					<li>
						<a class="subnav-text" href="{{URL::to('/admin/levels')}}">
							Level Manage
						</a>
					</li>
					<li>
						<a class="subnav-text" href="{{URL::to('/admin/topics')}}">
							Topic Manage
						</a>
					</li>
					<li>
						<a class="subnav-text" href="{{URL::to('/admin/questions')}}">
							Question Manage
						</a>
					</li>
				</ul>
			</li>
			@hasrole(['Admin'])
			<li>
				<a href="{{ URL::to('/admin/structures') }}">
					<i class="fa fa-align-center nav_icon"></i>
					<span class="nav-text">
						Structure Manage
					</span>
					<i class="icon-angle-right"></i><i class="icon-angle-down"></i>
				</a>
				<ul>
					<li>
						<a class="subnav-text" href="{{ URL::to('/admin/lessons') }}">
							Lesson Manage
						</a>
					</li>
					<li>
						<a class="subnav-text" href="{{ URL::to('/admin/routes') }}">
							Route Manage
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="{{ URL::to('/admin/students') }}">
					<i class="glyphicon glyphicon-education nav-icon"></i>
					<span class="nav-text">
						Students Manage
					</span>
				</a>
			</li>
			<li>
				<a href="{{ URL::to('/admin/staff') }}">
					<i class="fa fa-user nav-icon"></i>
					<span class="nav-text">
						Staff Manage
					</span>
				</a>
			</li>
			@endhasrole
			@imper
			<li>
				<a href="{{ URL::to('/admin/stop-imper') }}">
					<i class="glyphicon glyphicon-arrow-left"></i>
					<span class="nav-text">
						Stop using user
					</span>
				</a>
			</li>
			@endimper
		</ul>
		<ul class="logout">
			<li>
				<a href="{{ URL::to('/admin/logout') }}">
					<i class="icon-off nav-icon"></i>
					<span class="nav-text">
						Logout
					</span>
				</a>
			</li>
		</ul>
	</nav>
	<section class="wrapper scrollable">
		<nav class="user-menu">
			<a href="javascript:;" class="main-menu-access">
				<i class="icon-proton-logo"></i>
				<i class="icon-reorder"></i>
			</a>
		</nav>
		<section class="title-bar">
			<div class="logo">
				<h1><a href="index.html"><img src="images/logo.png" alt="" />Admin</a></h1>
			</div>
			{{-- <div class="full-screen">
				<section class="full-top">
					<button id="toggle"><i class="fa fa-arrows-alt" aria-hidden="true"></i></button>	
				</section>
			</div>
			<div class="w3l_search">
				<form action="#" method="post">
					<input type="text" name="search" value="Search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}" required="">
					<button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
				</form>
			</div> --}}
			<div class="header-right">
				<div class="profile_details_left">
					{{-- <div class="header-right-left">
						<!--notifications of menu start -->
						<ul class="nofitications-dropdown">
							<li class="dropdown head-dpdn">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i><span class="badge">3</span></a>
								<ul class="dropdown-menu anti-dropdown-menu w3l-msg">
									<li>
										<div class="notification_header">
											<h3>You have 3 new messages</h3>
										</div>
									</li>
									<li><a href="#">
										<div class="user_img"><img src="images/1.png" alt=""></div>
										<div class="notification_desc">
											<p>Lorem ipsum dolor amet</p>
											<p><span>1 hour ago</span></p>
										</div>
										<div class="clearfix"></div>	
									</a></li>
									<li class="odd"><a href="#">
										<div class="user_img"><img src="images/2.png" alt=""></div>
										<div class="notification_desc">
											<p>Lorem ipsum dolor amet </p>
											<p><span>1 hour ago</span></p>
										</div>
										<div class="clearfix"></div>	
									</a></li>
									<li><a href="#">
										<div class="user_img"><img src="images/3.png" alt=""></div>
										<div class="notification_desc">
											<p>Lorem ipsum dolor amet </p>
											<p><span>1 hour ago</span></p>
										</div>
										<div class="clearfix"></div>	
									</a></li>
									<li>
										<div class="notification_bottom">
											<a href="#">See all messages</a>
										</div> 
									</li>
								</ul>
							</li>
							<li class="dropdown head-dpdn">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue">3</span></a>
								<ul class="dropdown-menu anti-dropdown-menu agile-notification">
									<li>
										<div class="notification_header">
											<h3>You have 3 new notifications</h3>
										</div>
									</li>
									<li><a href="#">
										<div class="user_img"><img src="images/2.png" alt=""></div>
										<div class="notification_desc">
											<p>Lorem ipsum dolor amet</p>
											<p><span>1 hour ago</span></p>
										</div>
										<div class="clearfix"></div>	
									</a></li>
									<li class="odd"><a href="#">
										<div class="user_img"><img src="images/1.png" alt=""></div>
										<div class="notification_desc">
											<p>Lorem ipsum dolor amet </p>
											<p><span>1 hour ago</span></p>
										</div>
										<div class="clearfix"></div>	
									</a></li>
									<li><a href="#">
										<div class="user_img"><img src="images/3.png" alt=""></div>
										<div class="notification_desc">
											<p>Lorem ipsum dolor amet </p>
											<p><span>1 hour ago</span></p>
										</div>
										<div class="clearfix"></div>	
									</a></li>
									<li>
										<div class="notification_bottom">
											<a href="#">See all notifications</a>
										</div> 
									</li>
								</ul>
							</li>	
							<li class="dropdown head-dpdn">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-tasks"></i><span class="badge blue1">15</span></a>
								<ul class="dropdown-menu anti-dropdown-menu agile-task">
									<li>
										<div class="notification_header">
											<h3>You have 8 pending tasks</h3>
										</div>
									</li>
									<li><a href="#">
										<div class="task-info">
											<span class="task-desc">Database update</span><span class="percentage">40%</span>
											<div class="clearfix"></div>	
										</div>
										<div class="progress progress-striped active">
											<div class="bar yellow" style="width:40%;"></div>
										</div>
									</a></li>
									<li><a href="#">
										<div class="task-info">
											<span class="task-desc">Dashboard done</span><span class="percentage">90%</span>
											<div class="clearfix"></div>	
										</div>
										<div class="progress progress-striped active">
											<div class="bar green" style="width:90%;"></div>
										</div>
									</a></li>
									<li><a href="#">
										<div class="task-info">
											<span class="task-desc">Mobile App</span><span class="percentage">33%</span>
											<div class="clearfix"></div>	
										</div>
										<div class="progress progress-striped active">
											<div class="bar red" style="width: 33%;"></div>
										</div>
									</a></li>
									<li><a href="#">
										<div class="task-info">
											<span class="task-desc">Issues fixed</span><span class="percentage">80%</span>
											<div class="clearfix"></div>	
										</div>
										<div class="progress progress-striped active">
											<div class="bar  blue" style="width: 80%;"></div>
										</div>
									</a></li>
									<li>
										<div class="notification_bottom">
											<a href="#">See all pending tasks</a>
										</div> 
									</li>
								</ul>
							</li>	
							<div class="clearfix"> </div>
						</ul>
					</div> --}}	
					<div class="profile_details">		
						<ul>
							<li class="dropdown profile_details_drop">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<div class="profile_img">	
										<span class="prfil-img"><i class="fa fa-user" aria-hidden="true"></i></span> 
										<div class="clearfix"></div>	
									</div>	
								</a>
								<ul class="dropdown-menu drp-mnu"> 
									<li> <a href="{{ URL::to('/admin/profile/'.Auth::id()) }}"><i class="fa fa-user"></i> Profile</a> </li> 
									<li> <a href="{{ URL::to('/admin/logout') }}"><i class="fa fa-sign-out"></i> Logout</a> </li>
								</ul>
							</li>
						</ul>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
			<div class="clearfix"> </div>
		</section>
		<div class="main-grid">

			@yield('admin_content')

		</div>
		<!-- footer -->
		<div class="footer">
			<p>© All Rights Reserved . Design by <a href="http://w3layouts.com/">English Club</a></p>
		</div>
		<!-- //footer -->
	</section>

	<script>
		$(function () {
			$('#supported').text('Supported/allowed: ' + !!screenfull.enabled);
			if (!screenfull.enabled) {
				return false;
			}

			$('#toggle').click(function () {
				screenfull.toggle($('#container')[0]);
			});	
		});
	</script>
	<script src="{{asset('/backend/js/jquery2.0.3.min.js')}}"></script>
	<script src="{{asset('/backend/js/modernizr.js')}}"></script>
	<script src="{{asset('/backend/js/jquery.cookie.js')}}"></script>
	<script src="{{asset('/backend/js/screenfull.js')}}"></script>
	<script src="{{asset('/backend/js/raphael-min.js')}}"></script>
	<script src="{{asset('/backend/js/morris.js')}}"></script>
	<!--skycons-icons-->
	<script src="{{asset('/backend/js/skycons.js')}}"></script>
	<!--//skycons-icons-->
	<script src="{{asset('/backend/js/bootstrap.js')}}"></script>
	<script src="{{asset('/backend/js/proton.js')}}"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	{{-- tinymce --}}
	<script src="https://cdn.tiny.cloud/1/988pi62n14j4hn23yklqejb4lc4dymdxaedxt127biudf5w4/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<!-- Selectpicker -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

	@yield('javascript')

</body>
</html>

