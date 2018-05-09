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
		

		<?php  $view['slots']->output('stylesheets') ?>

<?php $view['slots']->stop() ?>

<?php $view['slots']->start('layout_body') ?>

<div class="row">
	<div class="span12">
	
		<div class="header" id="header">
		<!--header-html-->
			<div class="header-container">
				<div class="logo-and-contact-container">
					<div class="logo-container">
						<a href="/"><img src="/bundles/btctrip/images/logo.gif" class="logo"></a>
					</div>
					<div class="best-price-container">
					 	<a ><img src="/bundles/btctrip/images/transp.png" id="best-price-clickeable"></a>   
					</div>

					<div class="social-links span6 offset2">
						<div class="exchange-rate">
							<?php $allXchgRates = $view->container->get('exchange_rate')->getLastExchangeRatesCurrencyIndexed() ?>
							<span class="title">USD/BTC</span>&nbsp;<span class="price"><?php echo $allXchgRates['BTC'] ?></span>
							<span class="title">USD/XDG</span>&nbsp;<span class="price"><?php echo $allXchgRates['XDG'] ?></span>
							<span class="title">USD/LTC</span>&nbsp;<span class="price"><?php echo $allXchgRates['LTC'] ?></span>
						</div>
						<div class="social-button">
                            <a class="btn btn-medium-light btn-sm btn-circle" href="https://twitter.com/btctrip" target="_blank">
                              <i class="fa-icon-twitter"></i>
                            </a>
                            <a class="btn btn-medium-light btn-sm btn-circle" href="http://www.facebook.com/pages/BtcTrip/204523923004550" target="_blank">
                              <i class="fa-icon-facebook"></i>
                            </a>
                         </div>
                     </div>
				
				</div>
			
			</div>
			<!--header-html END-->
		</div>
	</div>
</div>


<div class="row social-breadcrumbs">
	<div class=" span4">
		<?php  $view['slots']->output('breadcrumb') ?>
	</div>
</div>


<div class="row">

		<?php  $view['slots']->output('mainContent') ?>

</div>


<?php  $view['slots']->output('secondContent') ?>

<div class="row span10 footer">
		<div class="span12">&copy 2014 BTCTrip | <a href="https://www.weusecoins.com" target="_blank">What is Bitcoin?</a> 
		| <a href="http://howtobuybitcoins.info" target="_blank">How to buy Bitcoins?</a> 
		| <a href="mailto:investors@btctrip.com"  >Investors</a> 
		| <a href="mailto:contact@btctrip.com"  >Contact</a>
		| <a href="<?php echo $view['router']->generate('btc_trip_about_us') ?>"> About us</a>
		</div>
</div>

<div class="popUpNew" id="popupTellafriend" >
	<div class="opaqueDiv"></div>
	<div class="popUpContainer">
		<span class="topRightIndicator"></span>
		<div class="commonSprite closePopUp closeBlueIcon"></div>
			<div class="popUpBestPriceHeader">
				<h3>BTCTrip: the leading crypto-currency agency that offers the best prices.</h3>
			</div>
			<div class="popUpContent">
				We work on a daily basis to help you save your time and money when you travel.
				We want you to rest assure that every time you make a purchase on BTCTrip you find the best available prices.
				That is why we now guarantee that BtcTrip will offer the best prices in flights and hotels.
				If you find a better deal we will beat it and process a credit in your favor.
				We will also offer a discount in your next Hotel reservation. <br><br>
				
				<a href="mailto:support@btctrip.com">Best Price Guaranteed</a>
			 
			</div>
	</div>
</div>
 
<?php $view['slots']->stop() ?>


<?php $view['slots']->start('layout_javascripts') ?>

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
	
