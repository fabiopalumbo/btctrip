<!DOCTYPE html>
<html lang="en-us">
<head>
<meta charset="utf-8">
<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

<title>BTCTrip - Backoffice</title>
<meta name="description" content="">
<meta name="author" content="">

<!-- Use the correct meta names below for your web application
Ref: http://davidbcalhoun.com/2010/viewport-metatag

		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">-->

<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<?php foreach ($view['assetic']->stylesheets( 
				array('bundles/btctripbackoffice/css/*'), array('cssrewrite') 
			) as $url): ?>
    	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $view->escape($url) ?>">
		<?php endforeach; ?>
		

<!-- FAVICONS -->
<link rel="shortcut icon"
	href="<?php echo $view['assets']->getUrl('favicon.ico') ?>"
	type="image/x-icon">
<link rel="icon"
	href="<?php echo $view['assets']->getUrl('favicon.ico') ?>"
	type="image/x-icon">

<!-- GOOGLE FONT -->
<link rel="stylesheet"
	href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

</head>
<body class="">
	<!-- possible classes: minified, fixed-ribbon, fixed-header, fixed-width-->

	<!-- HEADER -->
	<header id="header">
		<div id="logo-group">

			<!-- PLACE YOUR LOGO HERE -->
			<span id="logo" style="font-size: 18px;" ><b><span style="color:red">BTC</span><span style="color:orange">Trip</span></b> <!--  img src="img/logo.png" alt="BTCTrip" -->
			</span>
			<!-- END LOGO PLACEHOLDER -->

		</div>

		<!-- pulled right: nav area -->
		<div class="pull-right">

			<!-- collapse menu button -->
			<div id="hide-menu" class="btn-header pull-right">
				<span> <a href="javascript:void(0);" title="Collapse Menu"><i
						class="fa fa-reorder"></i></a>
				</span>
			</div>
			<!-- end collapse menu -->

			<!-- logout button -->
			<div id="logout" class="btn-header transparent pull-right">
				<span> <a href="login.html" title="Sign Out"><i
						class="fa fa-sign-out"></i></a>
				</span>
			</div>
			<!-- end logout button -->

		</div>
		<!-- end pulled right: nav area -->

	</header>
	<!-- END HEADER -->

	<!-- Left panel : Navigation area -->
	<!-- Note: This width of the aside area can be adjusted through LESS variables -->
	<aside id="left-panel">


		<!-- NAVIGATION : This navigation is also responsive

							To make this navigation dynamic please make sure to link the node
							(the reference to the nav > ul) after page load. Or the navigation
							will not initialize.
							-->
		<nav>
			<!-- NOTE: Notice the gaps after each icon usage <i></i>..
							Please note that these links work a bit different than
							traditional hre="" links. See documentation for details.
							-->

			<ul>
				<li><a href="<?php echo $view['router']->generate('dashboard') ?>" title="Dashboard">
					<i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
				</li>
<!-- 				<li><a href="orders"> -->
<!-- 					<i class="fa fa-lg fa-fw fa-inbox"></i> <span class="menu-item-parent">Orders</span></a></li> -->
				<li><a href="<?php echo $view['router']->generate('accounting_form') ?>" title="Accounting">
					<i class="fa fa-lg fa-fw fa-book"></i> <span class="menu-item-parent">Accounting</span></a></li>
			</ul>
		</nav>
		<span class="minifyme"> <i class="fa fa-arrow-circle-left hit"></i>
		</span>

	</aside>
	<!-- END NAVIGATION -->

	<!-- MAIN PANEL -->
	<div id="main" role="main">

		<!-- RIBBON -->
		<div id="ribbon">

			<!-- breadcrumb -->
			<ol class="breadcrumb">
				<li>Dashboard</li>
				<li><?php $view['slots']->output('breadcrumb', '') ?></li>
				
			</ol>
			<!-- end breadcrumb -->

			<!-- You can also add more buttons to the
						ribbon for further usability

						Example below:

						<span class="ribbon-button-alignment pull-right">
						<span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
						<span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
								<span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
				</span> -->

		</div>
		<!-- END RIBBON -->

		<!-- MAIN CONTENT -->
		<div id="content">

			<?php $view['slots']->output('page_body')?>


		</div>
		<!-- END MAIN CONTENT -->

	</div>
	<!-- END MAIN PANEL -->


	<!--================================================== -->



	<!-- JS TOUCH : include this plugin for mobile drag / drop touch events
		<script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->

	<?php foreach ($view['assetic']->javascripts(
				array('@BtcTripBackofficeBundle/Resources/public/js/jquery-2.0.2.min.js',
						'@BtcTripBackofficeBundle/Resources/public/js/jquery-ui-1.10.3.min.js',
						'@BtcTripBackofficeBundle/Resources/public/js/bootstrap.min.js', 
						'@BtcTripBackofficeBundle/Resources/public/js/jarvis.widget.min.js', 
						'@BtcTripBackofficeBundle/Resources/public/js/*')) as $url): ?>
    	<script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
	<?php endforeach; ?>
	

	<!--[if IE 7]>

		<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

		<![endif]-->


	<!-- PAGE RELATED PLUGIN(S)
		<script src="..."></script>-->


	<script type="text/javascript">
		// DO NOT REMOVE : GLOBAL FUNCTIONS!
		$(document).ready(function() {
			pageSetUp();
		})
	</script>
	
	<?php  $view['slots']->output('javascripts') ?>
	
</body>

</html>