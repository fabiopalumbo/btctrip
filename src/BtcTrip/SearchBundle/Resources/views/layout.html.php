<?php $view->extend('BtcTripSearchBundle::base.html.php') ?>

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
					
					<div class="social-links span10 offset7">
                            <a class="btn btn-medium-light btn-sm btn-circle" href="https://twitter.com/btctrip" target="_blank">
                              <i class="fa-icon-twitter"></i>
                            </a>
                            <a class="btn btn-medium-light btn-sm btn-circle" href="http://www.facebook.com/pages/BtcTrip/204523923004550" target="_blank">
                              <i class="fa-icon-facebook"></i>
                            </a>
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

<div class="row footer">
		<div class="span12">&copy 2013 BTCTrip | <a href="https://www.weusecoins.com" target="_blank">What is Bitcoin?</a> 
		| <a href="http://howtobuybitcoins.info" target="_blank">How to buy Bitcoins?</a> 
		| <a href="mailto:investors@btctrip.com"  >Investors</a> 
		| <a href="mailto:contact@btctrip.com"  >Contact</a>
		| <a href="<?php echo $view['router']->generate('btc_trip_about_us') ?>"> About us</a>
		</div>
</div>

<?php /*
<div class="popUpNew" id="popupTellafriend" >
	<div class="opaqueDiv"></div>
	<div class="popUpContainer">
		<div class="commonSprite closePopUp closeBlueIcon"></div>
		<span class="bottomIndicator"></span>
		<div class="popUpContent">

		<form class="offerform" id="tellafriendForm">
			<input type="text" name="yourname" placeholder="Your name..."  >
			<input type="text" name="youremail" placeholder="Your E-Mail..."  >
			<input type="text" name="friendsname" placeholder="Your friend's name..."  >
			<input type="text" name="friendsemail" placeholder="Your friend's E-Mail..."  >
			
			<input type="submit" class="btn btn-medium btn-warning submit" value="Send!">
		</form>		
		
		</div>
	</div>
</div>
 */ ?>
	
<?php $view['slots']->stop() ?>


<?php $view['slots']->start('layout_javascripts') ?>

		<script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/require-2.0.6.min.js') ?>"></script>
<?php /*		<script>
			$('#tellafriendLink').click( function(){
				var popup = $('#popupTellafriend');
				popup.hide();
				popup.css('top', $(this).closest('#tellafriendLink').position().top - popup.height() - 12);
				popup.css('left', $(this).position().left + 15 );
				if($.browser.msie && ($.browser.version < '8')){
					popup.hide();
					popup.show();
				}else{
					popup.fadeOut();
					popup.fadeIn();
				}
				
			});
			$('#popupTellafriend .closePopUp, #popupTellafriend .cancel').click (function(){
				(($.browser.msie && ($.browser.version < '8')) ? $('#popupTellafriend').hide() : $('#popupTellafriend').fadeOut());
				return false;
			});
			$('#popupTellafriend .submit').click(function() {
				$.post('<?php echo $view['router']->generate('_tellafriend') ?>', $('form#tellafriendForm').serialize());
    			(($.browser.msie && ($.browser.version < '8')) ? $('#popupTellafriend').hide() : $('#popupTellafriend').fadeOut());

				return false;
			});
			
		</script>   */ ?>
		
	<?php  $view['slots']->output('javascripts') ?>
	
<?php $view['slots']->stop() ?>
	
