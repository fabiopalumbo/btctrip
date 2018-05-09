
<div id="itinerary" class="itinerary">

<div class="route outbound-route">
<span class="type">
<span class="text">
Outbound
</span>
</span>
<ul class="data">

<li class="item date" id="departure-date-0">
<?php echo ucwords($outboundRoute['departureDateTime']['formatted']['date']) ?>
</li>
<li class="item">
<span class="number" id="flight-number-0">
Flight: <?php echo $outboundRoute['segments'][0]['flightNumber'] ?>
</span>
<span class="separator">-</span>
<span class="cabyn-type">
<?php echo $outboundRoute['segments'][0]['cabinTypeDescription'] ?>
</span>
</li>
<li class="item">
<span class="stops">
<!-- class="number" data-index="1" id="stops-quantity-0" -->
<a   href="#" >
<?php if ($outboundRoute['stopCount'] == 0) {
	echo 'Direct'; 
} else if ($outboundRoute['stopCount'] == 1) {  
	echo $outboundRoute['stopCount'] . ' stop';
} else {
	echo $outboundRoute['stopCount'] . ' stops';
} ?>
</a>
</span>
<span class="separator">-</span>
<span class="duration" id="duration-0">
<?php echo $outboundRoute['totalDuration']['formatted'] ?>
</span>
</li>
<li class="item outbound" id="outbound-0">
Depart from <?php echo $outboundRoute['segments'][0]['departure']['location']['city']['description'] ?> at 
<?php echo $outboundRoute['departureDateTime']['formatted']['time'] ?>hs.
</li>
<li class="item inbound" id="inbound-0">
Arrive to <?php echo $outboundRoute['segments'][count($outboundRoute['segments'])-1]['arrival']['location']['city']['description'] ?> at 
<?php echo $outboundRoute['arrivalDateTime']['formatted']['time'] ?>hs.
</li>
</ul>
</div>


<?php if (isset($inboundRoute)) {  ?>
<div class="route inbound-route">
<span class="type">
<span class="text">
Inbound
</span>
</span>
<ul class="data">

<li class="item date" id="departure-date-1">
<?php echo ucwords($inboundRoute['departureDateTime']['formatted']['date']) ?>
</li>
<li class="item">
<span class="number" id="flight-number-1">
Flight: <?php echo $inboundRoute['segments'][0]['flightNumber'] ?>
</span>
<span class="separator">-</span>
<span class="cabyn-type">
<?php echo $inboundRoute['segments'][0]['cabinTypeDescription'] ?>
</span>
</li>
<li class="item">
<span class="stops">
<a   href="#" >
<?php if ($inboundRoute['stopCount'] == 0) {
	echo 'Direct'; 
} else if ($inboundRoute['stopCount'] == 1) {  
	echo $inboundRoute['stopCount'] . ' stop';
} else {
	echo $inboundRoute['stopCount'] . ' stops';
} ?>
</a>
</span>
<span class="separator">-</span>
<span class="duration" id="duration-1">
<?php echo $inboundRoute['totalDuration']['formatted'] ?>
</span>
</li>
<li class="item outbound" id="outbound-1">
Depart from <?php echo $inboundRoute['segments'][0]['departure']['location']['city']['description'] ?> at 
<?php echo $inboundRoute['departureDateTime']['formatted']['time'] ?>hs.
</li>
<li class="item inbound" id="inbound-1">
Arrive to <?php echo $inboundRoute['segments'][count($inboundRoute['segments'])-1]['arrival']['location']['city']['description'] ?> at 
<?php echo $inboundRoute['arrivalDateTime']['formatted']['time'] ?>hs.
</li>
</ul>
</div>
<?php } ?>

</div>