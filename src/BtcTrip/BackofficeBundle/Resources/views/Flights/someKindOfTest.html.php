<?php $view->extend('BtcTripBackofficeBundle::layout.html.php') ?>

<?php $view['slots']->start('page_body') ?>

<div class="row">
	<div class="well">
	<pre>
		<?php if ($isSamePrice) { ?>
			Mismo precio. <a href="">Reservar</a>
		<?php } else { ?>
			Cambio el precio.
		<?php } ?>
	</pre>
	
	<pre>
	<?php 
	echo print_r($order['itinerary']['itenerariesBoxPriceInfoList'], true);
	?>
	</pre>
	
	<br><br>
	
	<pre>
	<?php 
	echo print_r($retval->flights->priceInfo, true);
	?>
	</pre>
	
	</div>
</div>

<?php $view['slots']->stop() ?>