<?php
// REDIRECT PAGE IF POST DATA IS SENT FROM FORM DATA * SHOULD REWRITE IN THE FUTURE
if(count($_POST)!=0 && !headers_sent() && !isset($_POST['noget']))
{
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}

	if(stripos(strrev($pageURL), strrev('/')) === 0)
		$pageURL .= 'index.php';

	$pageURL = preg_replace('~(\?|&)submitresult=[^&]*~','',$pageURL);
	$pageURL = preg_replace('~(\?|&)debugmessage=[^&]*~','',$pageURL);

	if(!$_POST['submitresult'])
		$_POST['submitresult'] = '0';

	header("Location: " .$pageURL);

	// if it's function page
	if (strpos($pageURL,'?') !== false)
	{
		$pieces = explode('&submitresult', $pageURL);
		$pageURL = $pieces[0].'&submitresult='.$_POST['submitresult'];
		if(isset($_POST['debugmessage']))
			$pageURL .= '&debugmessage='.$_POST['debugmessage'];
		header("Location: " .$pageURL);
		exit();
	}
	else // if it's normal page
	{
		$pieces = explode('?submitresult', $pageURL);
		$pageURL = $pieces[0].'?submitresult='.$_POST['submitresult'];
		if(isset($_POST['debugmessage']))
			$pageURL .= '&debugmessage='.$_POST['debugmessage'];
		header("Location: " .$pageURL);
		exit();
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo Config::sysCustomer; ?>'s System</title>

	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<link rel="icon" href="<? echo ROOT_URL.'/conf'; ?>/logo.png" type="image/x-icon" />
	<meta name="robots" content="noindex">

	<?php
	// add css
	$cssArr = array(
		// bootstrap
		'bootstrap.min.css',
		'bootstrap-theme.min.css',

		// loading page
		'pace.css',

		// alertify
		'alertify.core.css',
		'alertify.bootstrap.css',

		// lightbox
		'lightbox.css',

		// select
		'bootstrap-select.css',

		// tag input
		'bootstrap-tagsinput.css',
		'bootstrap-tagsinput-typeahead.css',

		// datatable
		'dataTables.bootstrap.css',

		// wysiwyg
		'bootstrap-wysihtml5.css',

		// animate
		'animate.css',

		// font awesome
		'font-awesome.min.css',

		// thailand address autocomplete
		'jquery.Thailand.min.css',

		// default
		'default.css',

		// medal
		'medal.css',
		);
	foreach ($cssArr as &$value)
		echo '<link href="'.ROOT_URL.'/src/css/'.$value.'" rel="stylesheet">';

	?>

	<!-- Theme -->
	<?php
	include '../../src/theme/css.php';
	?>
</script>
</head>
<body class="fixed-header ">

	<?php
	function showMenuBar($selected) { ?>
	<!-- BEGIN SIDEBPANEL-->
	<nav class="page-sidebar" data-pages="sidebar">
		<!-- BEGIN SIDEBAR MENU HEADER-->
		<div class="sidebar-header">
			<?php echo Config::sysCustomer; ?>
			<div class="sidebar-header-controls">
				<button type="button" class="btn btn-link visible-lg-inline" data-toggle-pin="sidebar">
					<i class="fa fs-12"></i>
				</button>
			</div>
		</div>
		<!-- END SIDEBAR MENU HEADER-->

		<!-- START SIDEBAR MENU -->
		<div class="sidebar-menu">
			<!-- BEGIN SIDEBAR MENU ITEMS-->
			<ul class="menu-items">

				<?php
				// dev
				$permission = array("Guardian","Dev");
				if (in_array(User::getCurrentUserRole(), $permission)) {
					$code = 'dev'; $file = ROOT_URL.'/sys/dev'; $name='Dev';
					echo "<li class='m-t-30'>
					<a href='". $file ."' id='sys-dev'>
					<span class='title'>". $name ."</span>
					</a>
					<span class='icon-thumbnail";
					if($selected===$code)
						echo " bg-success";
					echo "'><i class='fa fa-code' aria-hidden='true'></i></span>
					</li>";
				}

				// core
				$permission = array("Guardian");
				if (in_array(User::getCurrentUserRole(), $permission)) {
					$code = 'core'; $file = ROOT_URL.'/sys/core'; $name='Core';
					echo "<li>
					<a href='". $file ."' id='sys-core'>
					<span class='title'>". $name ."</span>
					</a>
					<span class='icon-thumbnail";
					if($selected===$code)
						echo " bg-success";
					echo "'><i class='fa fa-microchip' aria-hidden='true'></i></span>
					</li>";
				}

				// module
				$permission = array("Guardian","Dev","Admin");
				if (in_array(User::getCurrentUserRole(), $permission)) {
					$funclist = Func::getFunction();
					if($funclist!=null)
					{
						$permission = array("Guardian","Dev","Admin","Mod");
						if (in_array(User::getCurrentUserRole(), $permission)) {
							$code = 'function'; $name='System';
							$func = $funclist[0];
							echo "<li>
							<a href='".ROOT_URL."/". Info::$moduleFile[$func["module"]] ."/index.php?c=". $func['code'] ."' id='sys-system'>
							<span class='title'>". $name ."</span>
							</a>
							<span class='icon-thumbnail";
							if($selected===$code)
								echo " bg-success";
							echo "'><i class='fa fa-bookmark' aria-hidden='true'></i></span>
							</li>";
						}
					}
				}

				$permission = array("Mod");
				if (in_array(User::getCurrentUserRole(), $permission)) {
					$userpermissionlist = User::getUserPermission();

					$funclist = Func::getFunction();
					if($funclist!=null && $userpermissionlist!=null)
					{
						$gotpermission = false;

						foreach($funclist as $func)
						{
							foreach($userpermissionlist as $userpermission)
							{
								if($userpermission['functionid']==$func['id'] && $userpermission['userid']==User::getcurrentUserID())
									$gotpermission = true;

								if($gotpermission) break;
							}
							if($gotpermission) break;
						}

						if($gotpermission)
						{
							$code = 'function'; $name='System';
							echo "<li class='m-t-30'>
							<a href='".ROOT_URL."/". Info::$moduleFile[$func["module"]] ."/index.php?c=". $func['code'] ."' id='sys-system'>
							<span class='title'>". $name ."</span>
							</a>
							<span class='icon-thumbnail";
							if($selected===$code)
								echo ' bg-success';
							echo "'><i class='fa fa-bookmark' aria-hidden='true'></i></span>
							</li>";
						}
					}
				}

				// user
				$permission = array("Guardian");
				if (in_array(User::getCurrentUserRole(), $permission)) {
					$code = 'user'; $file = ROOT_URL.'/mod_sys/User'; $name='User';
					echo "<li>
					<a href='". $file ."' id='sys-user'>
					<span class='title'>". $name ."</span>
					</a>
					<span class='icon-thumbnail";
					if($selected===$code)
						echo ' bg-success';
					echo "'><i class='fa fa-users' aria-hidden='true'></i></span>
					</li>";
				}

				// edit profile
				$code = 'userself'; $name='Settings';
				echo "<li>
				<a href='".ROOT_URL."/sys/userself' id='sys-setting'>
				<span class='title'>". $name ."</span>
				</a>
				<span class='icon-thumbnail";
				if($selected===$code)
				echo ' bg-success';
				echo "'><i class='fa fa-cog' aria-hidden='true'></i></span>
				</li>";

				// logout
				$name='Logout';
				echo "<li>
				<a href='".ROOT_URL."/sys/login/index.php?ca=true' id='sys-logout'>
				<span class='title'>". $name ."</span>
				</a>
				<span class='icon-thumbnail";
				echo "'><i class='pg-power' aria-hidden='true'></i></span>
				</li>";
				?>
			</ul>
			<div class="clearfix"></div>
		</div>
		<!-- END SIDEBAR MENU -->
	</nav>
	<!-- END SIDEBPANEL-->

	<!-- START PAGE-CONTAINER -->
	<div class="page-container ">
		<!-- START HEADER -->
		<div class="header ">
			<!-- START MOBILE CONTROLS -->
			<div class="container-fluid relative">
				<!-- LEFT SIDE -->
				<div class="pull-left full-height visible-sm visible-xs">
					<!-- START ACTION BAR -->
					<div class="header-inner">
						<a href="#" class="btn-link toggle-sidebar visible-sm-inline-block visible-xs-inline-block padding-5" data-toggle="sidebar" id="sys-sm-sidenav-toggle">
							<span class="icon-set menu-hambuger"></span>
						</a>
					</div>
					<!-- END ACTION BAR -->
				</div>
				<div class="pull-center hidden-md hidden-lg">
					<div class="header-inner">
						<div class="brand inline">
							<?php echo Config::sysCustomer; ?>
						</div>
					</div>
				</div>
			</div>
			<!-- END MOBILE CONTROLS -->
			<div class=" pull-left sm-table hidden-xs hidden-sm">
				<div class="header-inner">
					<div class="brand inline">
						<?php echo Config::sysCustomer; ?>
					</div>
					<!-- START NOTIFICATION LIST -->
					<ul class="notification-list no-margin hidden-sm hidden-xs b-grey b-l b-r no-style p-l-30 p-r-20">
						<?php

						$permission = array("Guardian","Dev");
						if (in_array(User::getCurrentUserRole(), $permission)) {
							$code = 'activity'; $file = ROOT_URL.'/sys/logactivity';
							echo "<li class='p-r-15 inline";
							if($selected===$code)
								echo " active'";
							echo "'><a href='". $file ."' id='sys-log-activity'>Activity </span> <span class='badge'>". Log::countActionLog() ."</span></a>
							</li>";
						}

						$permission = array("Guardian","Dev");
						if (in_array(User::getCurrentUserRole(), $permission)) {
							$code = 'sql'; $file = ROOT_URL.'/sys/logsql';
							echo "<li class='p-r-15 inline";
							if($selected===$code)
								echo " active'";
							echo "'><a href='". $file ."' id='sys-log-sql'>SQL </span> <span class='badge'>". Log::countSQLLog() ."</span></a>
							</li>";
						}

						?>
					</ul>
					<!-- END NOTIFICATIONS LIST -->
				</div>
			</div>

			<div class=" pull-right">
				<!-- START User Info-->
				<div class="visible-lg visible-md m-t-10">
					<div class="dropdown pull-right">
						<button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
								<span class="semi-bold"><?php echo User::getcurrentUserName() ?></span>
							</div>
							<span class="thumbnail-wrapper d32 circular inline m-t-5">
								<img src="http://akomanet.com/assets/img/default.png?v=72b23dc25b" width="32" height="32">
							</span>
						</button>
					</div>
				</div>
				<!-- END User Info-->
			</div>
		</div>
		<!-- END HEADER -->

		<!-- START PAGE CONTENT WRAPPER -->
		<div class="page-content-wrapper ">
			<!-- START PAGE CONTENT -->
			<div class="content ">
				<!-- START CONTAINER FLUID -->
				<div class="container-fluid container-fixed-lg">
					<!-- BEGIN PlACE PAGE CONTENT HERE -->
					<?php } ?>

					<?php
					function showFunctionMenuBar($selected) { ?>
					<?php
					$i=0;
					$funclist = Func::getFunction();
					if(count($funclist)>1)
					{
						?>
						<div class="container">
							<div class="row">
								<div class="col-xs-12">
									<nav class="navbar navbar-default">

										<div class="navbar-header">
											<a class="navbar-brand" href="#"><i class="glyphicon glyphicon-tags"></i> &nbsp;Module List</a>
										</div>

										<ul class="nav navbar-nav">
											<?php
											$permission = array("Guardian","Dev","Admin");
											if (in_array(User::getCurrentUserRole(), $permission)) {
												foreach($funclist as $func)
												{
													if(file_exists('../../'.Info::$moduleFile[$func['module']].'/index.php'))
													{
														if($selected==$func["code"])
															echo "<li class='active'>";
														else
															echo "<li>";
														echo "<a href='../../" . Info::$moduleFile[$func["module"]] ."/index.php?c=". $func['code'] ."'>". $func["name"] ."</a>";
														echo "</li>";
													}
												}
											}

											$permission = array("Mod");
											if (in_array(User::getCurrentUserRole(), $permission)) {
												$userpermissionlist = User::getUserPermission();
												$funclist = Func::getFunction();

												foreach($funclist as $func)
												{
													foreach($userpermissionlist as $userpermission)
													{
														if($userpermission['functionid']==$func['id'] && $userpermission['userid']==User::getcurrentUserID())
														{
															if(file_exists('../../'.Info::$moduleFile[$func['module']]))
															{
																if($selected==$func["code"])
																	echo "<li class='active'>";
																else
																	echo "<li>";
																echo "<a href='../../". Info::$moduleFile[$func["module"]] ."/index.php?c=". $func['code'] ."'>". $func["name"] ."</a>";
																echo "</li>";
															}
														}
													}
												}

											}
											?>
										</ul>
									</nav>
								</div>
							</div>
						</div>
						<?php
					}
					?>
					<?php } ?>

					<div style="padding-top: 30px;"></div>
