<?php $view->extend('BtcTripMainBundle::layout.html.php') ?>

<?php $view['slots']->set('bodyClass', 'checkout') ?>

<?php $view['slots']->start('stylesheets') ?>
	<link href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/common.css') ?>" rel="stylesheet">
	<link href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/checkout.css') ?>" rel="stylesheet">
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('mainContent') ?>

<div class=" success">

<div class="purchase-form  span8 " >

	<fieldset class="section form-title">
		<span class="description">Thank you for booking with bitcoins!</span>
	</fieldset>

	<div class="information-container section fields " >
		<p>Your BTCTrip booking number is <b><?php echo $order['number'] ?></b></p>
		
		<p>In less than 24hs you will receive the voucher in your contact email address.</p>
		
		<p>If you have any doubts just email us: support@btctrip.com.</p>
		
		<p>Do you need to <a href="<?php echo $order['item']['search']['url'] ?>">book another hotels</a>? </p>
	</div>
	
	<fieldset class="section form-title">
		<span class="description">Guests</span>
	</fieldset>
	
	<div class="information-container section fields " >
		<?php  $buyerInfo = $order['buyerInfo'];		?>
		<div>
		
			<table border="0">
			<tr>
				<th class="passengers-column" >First name</th><th class="passengers-column">Last name</th>
			</tr>
			
			<?php for ($p = 0; $p < count($buyerInfo['passengerDefinitions']); $p++) { ?> 
			<tr>
				<td><?php echo $buyerInfo['passengerDefinitions'][$p]['firstName'] ?></td>
				<td><?php echo $buyerInfo['passengerDefinitions'][$p]['lastName'] ?></td>
			</tr>
			<?php  }  ?>	
			</table>
		
		</div>
	</div>

</div>

<div class="purchase-info form span4 omega " >

<!-- 	<fieldset class="section form-title">
		<span class="description">Your booking</span>
	</fieldset>   -->

	<div class="detail" id="detail">
	
		<div class="content">

			<?php echo $view->render('BtcTripHotelsBundle:Checkout:detailHotel.html.php',
					array('info' => $order['item'], 'searchParameters' => $order['item']['search']['url'], 
						'room' => $order['item']['hotel']['room'], 'cantidad_adultos' => $cantidad_adultos)) ?>

		</div>
	
	</div>
	
</div>

</div>


<?php $view['slots']->stop() ?>