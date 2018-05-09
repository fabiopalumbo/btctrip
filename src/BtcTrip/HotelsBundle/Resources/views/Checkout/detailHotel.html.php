
<fieldset class="section additionals" id="additionals">
	<span class="description">Your booking details</span>

	<div class="ux-common-checkout-thanks-hotel">
		<div class="ux-common-checkout-thanks-pic">
	  		<img id="hotelPicture" width="65" height="65"  src="http://media.staticontent.com/media/pictures/<?php echo $info['hotel']['pictureName']?>/100x100?truncate=true">
		</div>
		<div id="hotel-name" class="ux-common-checkout-thanks-description">
			<p class="ux-hotel-name"><?php echo $info['hotel']['name']?>
				<span id="hotel-stars" class="starsRating">
				<?php for ($s=0; $s<$info['hotel']['starRating']; $s++) { 
					echo '★';
				} ?>
				</span>
			</p>
			<p id="hotel-address" class="capitalize"><?php echo $info['hotel']['address']?> </p>
		</div>
	</div>
	
	<div class="ux-common-checkout-hotel-details">
		<div><span class="detail-title">Check in:</span>  
		 <?php $date_in = new DateTime($searchParameters['check_in']);
		  echo date_format($date_in, 'l jS F Y');?>
		</div>
		<div><span class="detail-title">Check out: </span>  <?php $date_out = new DateTime($searchParameters['check_out']);
		  echo date_format($date_out, 'l jS F Y');?>
		</div>
		<div><span class="detail-title">Guests: </span><?php echo $cantidad_adultos . ' adult' . ($cantidad_adultos>0 ? 's' : '') ?></div>
		<div><span class="detail-title">Room: </span><?php echo $room['description']?></div>
		<div><span class="detail-title">Meals: </span><?php echo $room['regimeDescription']?></div>
		<div><span class="detail-title">Cancelation policy: </span><?php echo ( $room['penalty']['refundable'] ? 'Refundable fee' : 'Non refundable fee' )   ?></div>
		
		</div>
</fieldset>