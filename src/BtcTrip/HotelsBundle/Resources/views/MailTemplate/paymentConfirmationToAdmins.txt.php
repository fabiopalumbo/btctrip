<?php 

$array_distribution=explode("!", $order['item']['search']['parameters']['distribution']);
$cantidad_habitacion=count($array_distribution);
//$cantidad_adultos=$array_distribution[0];
$cantidad_adultos=0;
if ($cantidad_habitacion>1){
	foreach($array_distribution as $h){
		$text=explode("-", $h);
		$cantidad_adultos=$cantidad_adultos+$text[0];
	}
}else{
	$cantidad_adultos=$array_distribution[0];
}

?>


<br>
Order number: <b><?php echo $order['number'] ?></b><br>
Order id: <?php echo $order['_id'] ?><br>
PreOrder id: <?php echo $order['preOrderId'] ?><br>
<br>


<?php   $hotel = $order['item']['hotel'];   ?>
<b>Hotel </b>
<div>
	<ul>
		<li>Name: <?php echo $hotel['name'] ?> (<?php echo $hotel['id'] ?>) </li>
		<li>Address: <?php echo $hotel['address'] ?></li>
		<li>Check in:  
		 <?php $date_in = new DateTime($order['item']['search']['parameters']['check_in']);
		  echo date_format($date_in, 'l jS F Y');?>
		</li>
		<li>Check out:  <?php $date_out = new DateTime($order['item']['search']['parameters']['check_out']);
		  echo date_format($date_out, 'l jS F Y');?>
		</li>
		<li>Guests: <?php echo $cantidad_adultos . ' adult' . ($cantidad_adultos>0 ? 's' : '') ?></li>
		<li>Room: <?php echo $hotel['room']['description']?></li>
		<li>Meals: <?php echo $hotel['room']['regimeDescription']?></li>
		<li>Cancelation policy: <?php echo ( $hotel['room']['penalty']['refundable'] ? 'Refundable fee' : 'Non refundable fee' )   ?></li>
		<li>Search link: <a href="<?php echo $order['item']['search']['url'] ?>"><?php echo $order['item']['search']['url'] ?></a> </li>
	</ul>
</div>

<b>Povider</b>
<ul>
  <li> providerId: <?php echo $hotel['room']['providerId'] ?></li>
  <li> providerHotelId: <?php echo $hotel['room']['providerHotelId'] ?></li>
  <li> providerVendorId: <?php echo $hotel['room']['providerVendorId'] ?></li>
</ul>


<b>Prices </b>
<pre><?php echo str_replace(array('Array', '(', ')'), array('', '', ''), print_r($hotel['room']['prices'], true)) ?> </pre>


<?php   $buyerInfo = $order['buyerInfo'];   ?>
<b>Guests </b>
<div>
<?php for ($p=0; $p<count($buyerInfo['passengerDefinitions']); $p++) { ?> 
	<ul>
		<li>First name: <?php echo $buyerInfo['passengerDefinitions'][$p]['firstName'] ?></li>
		<li>Last name: <?php echo $buyerInfo['passengerDefinitions'][$p]['lastName'] ?></li>
	</ul>
<?php  }  ?>	
</div>

<b>Contact </b>
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


<b>Payment </b>
<div class="payment">
	<ul>
	<!--  <li> Voucher: <?php  // echo $buyerInfo['vouchersDefinition']['codes'][0] ?></li>  -->

			<li> Payment gateway: <?php echo $order['invoice']['gateway'] ?> </li>
			<li> Invoice id: <a target="_blank" href="<?php echo $order['invoice']['url'] ?>" ><?php echo $order['invoice']['id'] ?></a></li>
			<li> Base price: <?php echo $order['invoice']['basePrice'] . ' ' . $order['invoice']['baseCurrency'] ?></li>
			<li> Price: <?php echo $order['invoice']['price'] . ' ' . $order['invoice']['currency']  ?> </li>
			<li> Creation time: <?php echo gmdate("d-m-Y H:i:s", $order['invoice']['creationTime']/1000); ?></li>
			
	</ul>
</div>

