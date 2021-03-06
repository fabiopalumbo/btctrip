<br>
Order number: <b><?php echo $order['number'] ?></b><br>
Order id: <?php echo $order['_id'] ?><br>
PreOrder id: <?php echo $order['preOrderId'] ?><br>
<br>

<?php  
$outboundRoute = $order['itinerary']['outboundRoute'];
?>
<b>Outbound</b>
<div class="route-1">
	<div class="content-wrapper">
	<?php for ( $s=0; $s < count($outboundRoute['segments']); $s++ ) { ?>
		<?php  if ($s>0) { ?>
		<div class="connection">
			<span class="detail"><?php echo $outboundRoute['segments'][$s]['waitDuration']['formatted'] ?> connection in 
				<?php echo $outboundRoute['segments'][$s]['departure']['location']['city']['description'] ?></span>
		</div>
		<?php  }  ?>
		<div class="segment">
			<ul class="detail">
			<li class="flight">
			<span class="item strecht">Leg <?php echo $s+1 ?> </span>
			<span class="item">-</span>
			<span class="item number">Flight <?php echo $outboundRoute['segments'][$s]['flightNumber'] ?> </span>
			<span class="item">-</span>
			<span class="item class"><?php echo $outboundRoute['segments'][$s]['cabinTypeDescription'] ?></span>
			<span class="item">-</span>
			<span class="item airline">
			<span class="airlines-content">
			<span class="icon">
			</span>
			<span class="name"><?php echo $outboundRoute['segments'][$s]['operatingCarrier']['description'] ?> (<?php echo $outboundRoute['segments'][$s]['operatingCarrier']['code'] ?>) </span>
			</span>
			</span>
			</li>
			<li class="itinerary">
			<span class="location">Leaves from <?php echo $outboundRoute['segments'][$s]['departure']['location']['city']['description'] ?>, 
					<?php echo $outboundRoute['segments'][$s]['departure']['location']['airport']['description'] ?> 
					(<?php echo $outboundRoute['segments'][$s]['departure']['location']['airport']['code'] ?>),</span>
			<span class="date"><?php echo $outboundRoute['segments'][$s]['departure']['date']['formatted'] ?> <?php echo $outboundRoute['segments'][$s]['departure']['hour']['formatted'] ?></span>
			</li>
			<li class="itinerary">
			<span class="location">Arrives to <?php echo $outboundRoute['segments'][$s]['arrival']['location']['city']['description'] ?>, 
					<?php echo $outboundRoute['segments'][$s]['arrival']['location']['airport']['description'] ?> 
					(<?php echo $outboundRoute['segments'][$s]['arrival']['location']['airport']['code'] ?>),</span>
			<span class="date"><?php echo  $outboundRoute['segments'][$s]['arrival']['date']['formatted'] ?> <?php echo $outboundRoute['segments'][$s]['arrival']['hour']['formatted'] ?></span>
			</li>
			</ul>
		</div>
	<?php  }  ?>
	</div>
</div>



<?php
$inboundRoute = $order['itinerary']['inboundRoute'];

if ( isset($inboundRoute) ) {
?>
<b>Inbound</b>
<div class="route-1">
	<div class="content-wrapper">
	<?php for ( $s=0; $s < count($inboundRoute['segments']); $s++ ) { ?>
		<?php  if ($s>0) { ?>
		<div class="connection">
			<span class="detail"><?php echo $inboundRoute['segments'][$s]['waitDuration']['formatted'] ?> connection in 
				<?php echo $inboundRoute['segments'][$s]['departure']['location']['city']['description'] ?></span>
		</div>
		<?php  }  ?>
		<div class="segment">
			<ul class="detail">
			<li class="flight">
			<span class="item strecht">Leg <?php echo $s+1 ?> </span>
			<span class="item">-</span>
			<span class="item number">Flight <?php echo $inboundRoute['segments'][$s]['flightNumber'] ?> </span>
			<span class="item">-</span>
			<span class="item class"><?php echo $inboundRoute['segments'][$s]['cabinTypeDescription'] ?></span>
			<span class="item">-</span>
			<span class="item airline">
			<span class="airlines-content">
			<span class="icon">
			</span>
			<span class="name"><?php echo $inboundRoute['segments'][$s]['operatingCarrier']['description'] ?> (<?php echo $inboundRoute['segments'][$s]['operatingCarrier']['code'] ?>) </span>
			</span>
			</span>
			</li>
			<li class="itinerary">
			<span class="location">Leaves from <?php echo $inboundRoute['segments'][$s]['departure']['location']['city']['description'] ?>, 
					<?php echo $inboundRoute['segments'][$s]['departure']['location']['airport']['description'] ?> 
					(<?php echo $inboundRoute['segments'][$s]['departure']['location']['airport']['code'] ?>),</span>
			<span class="date"><?php echo $inboundRoute['segments'][$s]['departure']['date']['formatted'] ?> <?php echo $inboundRoute['segments'][$s]['departure']['hour']['formatted'] ?></span>
			</li>
			<li class="itinerary">
			<span class="location">Arrives to <?php echo $inboundRoute['segments'][$s]['arrival']['location']['city']['description'] ?>, 
					<?php echo $inboundRoute['segments'][$s]['arrival']['location']['airport']['description'] ?> 
					(<?php echo $inboundRoute['segments'][$s]['arrival']['location']['airport']['code'] ?>),</span>
			<span class="date"><?php echo $inboundRoute['segments'][$s]['arrival']['date']['formatted'] ?> <?php echo $inboundRoute['segments'][$s]['arrival']['hour']['formatted'] ?> </span>
			</li>
			</ul>
		</div>
	<?php  }  ?>
	</div>
</div>
<?php } ?>

<?php 
$buyerInfo = $order['buyerInfo'];
?>
<b>Passenger information</b>
<div>
<?php for ($p=0; $p<count($buyerInfo['passengerDefinitions']); $p++) { ?> 
	<ul>
		<li>First name: <?php echo $buyerInfo['passengerDefinitions'][$p]['firstName'] ?></li>
		<li> Last name: <?php echo $buyerInfo['passengerDefinitions'][$p]['lastName'] ?></li>
		<li> Birthday: <?php echo $buyerInfo['passengerDefinitions'][$p]['birthday']['day'] ?>/<?php echo $buyerInfo['passengerDefinitions'][$p]['birthday']['month'] ?>/<?php echo $buyerInfo['passengerDefinitions'][$p]['birthday']['year'] ?></li>	
		<li> Gender: <?php echo $buyerInfo['passengerDefinitions'][$p]['gender'] ?></li>
	</ul>
<?php  }  ?>	
</div>

<b>Contact information</b>
<div>
	<ul>
	<li> Email: <?php echo $buyerInfo['contactDefinition']['email'] ?></il>
	<li> Phones:
		<ul>
	<?php for ($p=0; $p<count($buyerInfo['contactDefinition']['phoneDefinitions']); $p++) { ?>
		<li> <?php echo $buyerInfo['contactDefinition']['phoneDefinitions'][$p]['type'] ?>
			<?php echo $buyerInfo['contactDefinition']['phoneDefinitions'][$p]['countryCode'] ?> -
			<?php echo $buyerInfo['contactDefinition']['phoneDefinitions'][$p]['areaCode'] ?> -
			<?php echo $buyerInfo['contactDefinition']['phoneDefinitions'][$p]['number'] ?>
		 </li>
	<?php  }  ?>
		</ul>
	</li>
	</ul>
</div>


<b>Payment information</b>
<div class="payment">
	<ul>
		<li> Voucher: <?php echo $buyerInfo['vouchersDefinition']['codes'][0] ?></li>

		<li> Bitpay invoice id: <?php echo $order['bitpayInfoId'] ?></li>
		<li> Bitpay id: <a href="<?php echo $bitpayInvoice['url'] ?>" ><?php echo $bitpayInvoice['id'] ?></a></li>
		<li> Bitcoin amount: <?php echo $bitpayInvoice['btcPrice'] ?></li>
		<li> Currency amount: <?php echo $bitpayInvoice['price'] ?> <?php echo $bitpayInvoice['currency'] ?></li>
		<li> Invoice time: <?php echo gmdate("d-m-Y H:i:s", $bitpayInvoice['invoiceTime']/1000); ?></li>
		
	</ul>
</div>

