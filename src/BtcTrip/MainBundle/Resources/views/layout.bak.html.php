<?php $view->extend('BtcTripMainBundle::base.html.php') ?>

<?php $view['slots']->start('layout_stylesheets') ?>
		<script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/base.js') ?>"></script>
		<script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/jquery-1.7.1.min.js') ?>"></script>
		
		<!--header-css--> 
		<!--<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/bootstrap.css') ?>"/>-->
		<!--<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/main.css') ?>"/>-->
		<!--<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/font-awesome.css') ?>"/>-->
		<!--header-css END-->
		<!--socialmedia-css-->
		<!--<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/socialmedia.css') ?>"/>-->

		<!--socialmedia-css END-->
		  <link rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/jquery-ui.css') ?>"> 
		  <link rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/owl.carousel.css') ?>">
		  <link rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/idangerous.swiper.css') ?>">
		  <link rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/style.css') ?>" />
		  <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		  <link href='https://fonts.googleapis.com/css?family=Lora:400,400italic' rel='stylesheet' type='text/css'>
		  <link href='https://fonts.googleapis.com/css?family=Raleway:300,400,500,700' rel='stylesheet' type='text/css'>  
		  <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css'>	
		  <link href='https://fonts.googleapis.com/css?family=Lato:400,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css'>

		<?php  $view['slots']->output('stylesheets') ?>

<?php $view['slots']->stop() ?>

<?php $view['slots']->start('layout_body') ?>

<!--header-html-->
<!-- // authorize // -->
	<div class="overlay"></div>
	<div class="autorize-popup">
		<div class="autorize-tabs">
			<a href="#" class="autorize-tab-a current">Sign in</a>
			<a href="#" class="autorize-tab-b">Register</a>
			<a href="#" class="autorize-close"></a>
			<div class="clear"></div>
		</div>
		<section class="autorize-tab-content">
			<div class="autorize-padding">
				<h6 class="autorize-lbl">Welocome! Login in to Your Accont</h6>
				<input type="text" value="" placeholder="Name">
				<input type="text" value="" placeholder="Password">
				<footer class="autorize-bottom">Login</button>
					<a href="#" class="authorize-forget-pass">Forgot your password?</a>
					<div class="clear"></div>
				</footer>
			</div>
		</section>
		<section class="autorize-tab-content">
			<div class="autorize-padding">
				<h6 class="autorize-lbl">Register for Your Account</h6>
				<input type="text" value="" placeholder="Name">
				<input type="text" value="" placeholder="Password">
				<footer class="autorize-bottom">
					<button class="authorize-btn">Registration</button>
					<div class="clear"></div>
				</footer>
			</div>
		</section>
	</div>
<!-- \\ authorize \\-->

<header id="top">
	<div class="header-a">
		<div class="wrapper-padding">			
			<div class="header-phone"><span>BTCTRIP</span></div>
			<div class="header-account">
				<a href="#">My account</a>
			</div>
			<div class="header-social">
				<a href="#" class="social-twitter"></a>
				<a href="#" class="social-facebook"></a>
				<a href="#" class="social-vimeo"></a>
				<a href="#" class="social-pinterest"></a>
				<a href="#" class="social-instagram"></a>
			</div>
			<div class="header-viewed">
				<a href="#" class="header-viewed-btn">recently viewed</a>
				<!-- // viewed drop // -->
					<div class="viewed-drop">
						<div class="viewed-drop-a">
							<!-- // -->
							<div class="viewed-item">
								<div class="viewed-item-l">
									<a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/v-item-01.jpg') ?>" /></a>
								</div>
								<div class="viewed-item-r">
								</div>
								<div class="clear"></div>
							</div>
							<!-- \\ -->
							<!-- // -->
						
							<!-- \\ -->
							<!-- // -->

							<!-- \\ -->
						</div>
					</div>
				<!-- \\ viewed drop \\ -->
			</div>
			<div class="header-lang">
				<a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/en.gif') ?>" /></a>
				<div class="langs-drop">
					<div><a href="#" class="langs-item en">english</a></div>
					<div><a href="#" class="langs-item fr">francais</a></div>
					<div><a href="#" class="langs-item de">deutsch</a></div>
					<div><a href="#" class="langs-item it">italiano</a></div>
				</div>
			</div>
			<div class="header-curency">
				<a href="#">BTC</a>
				<div class="curency-drop">
					<div><a href="#">BTC</a></div>
					<div><a href="#">USD</a></div>
					<div><a href="#">LTC</a></div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="header-b">
		<!-- // mobile menu // -->
			<div class="mobile-menu">
				<nav>
					<ul>
						<li><a class="has-child" href="#">BUY BITCOINS</a>				
						</li>
				
						<li><a class="has-child" href="/Flights">Flights</a>
							<ul>
								<li><a href="/Flights">Flights</a></li>
							</ul>
						</li>
					
						<li><a href="/about-us">About Us</a></li>
                        			<li><a href="/contact-us">Contact Us</a></li>
					</ul>
				</nav>	
			</div>
		<!-- \\ mobile menu \\ -->
			
		<div class="wrapper-padding">
			<div class="header-logo"><a href="/"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/logo-white.png') ?>" /></a></div>
			<div class="header-right">
				<div class="hdr-srch">
					<a href="#" class="hdr-srch-btn"></a>
				</div>
				<div class="hdr-srch-overlay">
					<div class="hdr-srch-overlay-a">
						<input type="text" value="" placeholder="Start typing...">
						<a href="#" class="srch-close"></a>
						<div class="clear"></div>
					</div>
				</div>	
				<div class="hdr-srch-devider"></div>
				<a href="#" class="menu-btn"></a>
				<nav class="header-nav">
					<ul>
						<li><a href="#">BUY BITCOINS</a>
						</li>
						<li><a href="/Flights">Flights</a>
							<ul>
								<li><a href="/Flights">Coming Soon...</a></li>
							</ul>
						</li>

						<li><a href="/about-us">About Us</a></li>
                        <li><a href="/contact-us">Contact Us</a></li>
					</ul>
				</nav>
			</div>
			<div class="clear"></div>
		</div>
	</div>	
</header>
<!--header-html END-->


		<?php  $view['slots']->output('mainContent') ?>



<?php  $view['slots']->output('secondContent') ?>
 
<?php $view['slots']->stop() ?>



<?php $view['slots']->start('layout_javascripts') ?>

<?php $view['slots']->stop() ?>
	
