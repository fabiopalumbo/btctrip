<?php $view->extend('BtcTripMainBundle::base.html.php') ?>

<?php $view['slots']->start('layout_stylesheets') ?>
		<script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/base.js') ?>"></script>
		<script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/jquery-1.7.1.min.js') ?>"></script>
		
		<!--header-css--> 
		<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/bootstrap.css') ?>"/>
		<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/main.css') ?>"/>
		<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/font-awesome.css') ?>"/>
		<!--header-css END-->
		<!--socialmedia-css-->
		<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/socialmedia.css') ?>"/>
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

	</div>
<!-- \\ authorize \\-->

<header id="top">
	<div class="header-a">
		<div class="wrapper-padding">			
			<div class="header-phone"><span>BTCTRIP</span>
			<?php $allXchgRates = $view->container->get('exchange_rate')->getLastExchangeRatesCurrencyIndexed() ?>
			<span style="font-weight: normal">USD/BTC &nbsp; <?php echo $allXchgRates['BTC'] ?></span>
			<span style="font-weight: normal">USD/LTC &nbsp; <?php echo $allXchgRates['LTC'] ?></span></div>
			<div class="header-social">
				<a href="https://twitter.com/btctrip" class="social-twitter" target="_blank"></a>
			

			</div>
			<div class="header-viewed">
				<a href="#" class="header-viewed-btn"></a>
				<!-- // viewed drop // -->

				<!-- \\ viewed drop \\ -->
			</div>
			<div class="header-lang">
				<a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/en.gif') ?>" /></a>

			</div>
			<div class="header-curency">
				<a href="https://www.bitstamp.net" target="_blank" >BUY BITCOINS</a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="header-b">
		<!-- // mobile menu // -->
			<div class="mobile-menu">
				<nav>
					<ul>
						<li><a class="has-child" href="https://www.bitstamp.net" target="_blank" >BUY BITCOINS</a>
						</li>
				

					</ul>
				</nav>	
			</div>
		<!-- \\ mobile menu \\ -->
			
		<div class="wrapper-padding">
			<div class="header-logo"><a href="/"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/logo-white.png') ?>" /></a></div>
				<nav class="header-nav">

				<!-- // tab content tickets // -->
				

				<!-- // tab content tickets // -->		


					<ul>
						<li>
						<img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/since2013b.png') ?>" />

						
						</li>

					</ul>
				</nav>
			<div class="header-right">
				<div class="hdr-srch-devider"></div>
				<a href="#" class="menu-btn"></a>

			</div>
			<div class="clear"></div>
		</div>
	</div>	
</header>
<!--header-html END-->




		<?php  $view['slots']->output('breadcrumb') ?>





		<?php  $view['slots']->output('mainContent') ?>




<?php  $view['slots']->output('secondContent') ?>

 
<?php $view['slots']->stop() ?>


<?php $view['slots']->start('layout_javascripts') ?>
		<!-- // scripts // -->
  <!--  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/jquery-1.11.3.min.js') ?>"></script> -->

  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/idangerous.swiper.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/slideInit.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/owl.carousel.min.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/bxSlider.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/jqeury.appear.js') ?>"></script>  
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/custom.select.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/jquery-ui.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/twitterfeed.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/script2.js') ?>"></script>
<!-- \\ scripts \\ --> 
		<script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/require-2.0.6.min.js') ?>"></script>
		<script>
			$('#best-price-clickeable').click( function() {
				var clickeable = $('#best-price-clickeable');
				var popup = $('#popupTellafriend');
				if (popup.is(':visible')) {
					popup.hide();
				} else {
					popup.hide();
					popup.css('top', $(this).closest('#best-price-clickeable').position().top + clickeable.height() + 15);
					popup.css('left', $(this).position().left - 271 );
					if($.browser.msie && ($.browser.version < '8')){
						popup.hide();
						popup.show();
					}else{
						popup.fadeOut();
						popup.fadeIn();
					}
				}
				
			});
			$('#popupTellafriend .closePopUp, #popupTellafriend .cancel').click (function(){
				(($.browser.msie && ($.browser.version < '8')) ? $('#popupTellafriend').hide() : $('#popupTellafriend').fadeOut());
				return false;
			});
			
		</script>  
		
	<?php  $view['slots']->output('javascripts') ?>
	
<?php $view['slots']->stop() ?>
	
