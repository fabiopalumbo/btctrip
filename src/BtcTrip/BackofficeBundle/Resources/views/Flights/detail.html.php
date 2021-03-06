<?php $view->extend('BtcTripBackofficeBundle::layout.html.php') ?>

<?php $view['slots']->start('page_body') ?>

<div class="row">

	<article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

			<div id="resultSuccess" class="alert alert-block alert-success hide">
				<a class="close" data-dismiss="alert" href="#">x</a>
				<p id="successMessage">Updated!</p>
			</div>

			<div id="resultError" class="alert alert-block alert-danger hide">
				<a class="close" data-dismiss="alert" href="#">x</a>
				<p id="errorMessage">Error</p>
			</div>
			
			<div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-1" data-widget-editbutton="false" role="widget">

					<header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="#" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-resize-full "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div>
						<span class="widget-icon"> <i class="fa fa-inbox"></i> </span>
						<h2>Order number: <?php echo $order['number'] ?></h2>
					<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
		
					<!-- widget div-->
					<div role="content">
		
						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->
		
						</div>
						<!-- end widget edit box -->
						
				
		
						<!-- widget content -->
						<div class="widget-body no-padding">
		
		
							<div class="well">
								<?php /* // if ($isSamePrice) { ?>
							<pre>
									Mismo precio. <a href="">Reservar</a>
								<?php // } else { ?>
									Cambio el precio.
							</pre>
								<?php // } */ ?>
						
								<?php  
								$outboundRoute = $order['itinerary']['outboundRoute'];
								?>
								<b>Outbound</b>
								<div class="route-1">
									<div class="content-wrapper">
									<?php for ( $s=0; $s < count($outboundRoute['segments']); $s++ ) { ?>
										<?php  if ($s>0) { ?>
										<div class="connection">
											&nbsp;&nbsp;&nbsp;&nbsp;<span class="detail"><?php echo $outboundRoute['segments'][$s]['waitDuration']['formatted'] ?> connection in 
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
											&nbsp;&nbsp;&nbsp;&nbsp;<span class="detail"><?php echo $inboundRoute['segments'][$s]['waitDuration']['formatted'] ?> connection in 
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
										<?php if (isset($buyerInfo['passengerDefinitions'][$p]['nationality'])) { ?>
										<li> Nationality: <?php echo $buyerInfo['passengerDefinitions'][$p]['nationality'] ?></li>
										<li> Document type: <?php echo $buyerInfo['passengerDefinitions'][$p]['documentDefinition']['type'] ?></li>
										<li> Document number: <?php echo $buyerInfo['passengerDefinitions'][$p]['documentDefinition']['number'] ?></li>
										<?php } ?>
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
								
										<li> Payment gateway: <?php echo $order['invoice']['gateway'] ?> </li>
										<li> Invoice id: <a target="_blank" href="<?php echo $order['invoice']['url'] ?>" ><?php echo $order['invoice']['id'] ?></a></li>
										<li> Base price: <?php echo $order['invoice']['basePrice'] . ' ' . $order['invoice']['baseCurrency'] ?></li>
										<li> Price: <?php echo $order['invoice']['price'] . ' ' . $order['invoice']['currency']  ?> </li>
										<li> Creation time: <?php echo gmdate("d-m-Y H:i:s", $order['invoice']['creationTime']/1000); ?></li>
										
									</ul>
								</div>

								<b>Extra information</b>
								<div>
									<ul>
										<li>Order id: <?php echo $order['_id'] ?></li>
										<li>PreOrder id: <?php echo $order['preOrderId'] ?></li>
										<li> Search url: <a target="_blank" href="<?php echo $order['itinerary']['search']['url'] ?>"><?php echo $order['itinerary']['search']['url'] ?></a></li>
										<li> Ticket: <?php echo $order['itinerary']['metadata']['ticket']['id'] ?></il>
										<li> ItineraryId: <?php echo $order['itinerary']['id'] ?></li>
									</ul>
								</div>
								
							<?php 
							// echo print_r($order['itinerary']['itenerariesBoxPriceInfoList'], true);
							// echo print_r($retval->flights->priceInfo, true);
							?>
							
							</div>
						</div>
		
						<div class="btn-group article-bottom">
						
							<a class="btn btn-default" onclick="javascript:postThis('<?php echo $view['router']->generate('confirm_order_price', array('orderId' => $order['_id'])) ?>');">Chequear precio</a>
							<a class="btn btn-default" onclick="javascript:postThis('<?php echo $view['router']->generate('update_flight_availability', array('orderId' => $order['_id'])) ?>');">Actualizar vuelo</a>
							<a class="btn btn-default" onclick="javascript:postThis('<?php echo $view['router']->generate('book', array('orderId' => $order['_id'])) ?>');">Reservar</a>
						<!-- 	<a class="btn btn-default" href="">Enviar eTicket</a>   -->
						
						</div>
		
						</div>
						<!-- end widget content -->
		
					</div>
					<!-- end widget div -->
		
	</article>


	
</div>


<?php $view['slots']->stop() ?>

<?php $view['slots']->start('javascripts') ?>
	<script  type="text/javascript"> 
	
		$(document).ajaxStop($.unblockUI); 
	
		function postThis(url) {
			  $.blockUI({ css: { 
		            border: 'none', 
		            padding: '15px', 
		            backgroundColor: '#000', 
		            '-webkit-border-radius': '10px', 
		            '-moz-border-radius': '10px', 
		            opacity: .5, 
		            color: '#fff' 
		        } });
			   
			  var posting = $.get( url );
			 
			  // Put the results in a div
			  posting.done(function( data ) {
				  var jsonData = JSON.parse(data);

				  if (jsonData.result.code == 'SUCCESS') {
					  $("#resultSuccess").removeClass('hide');
					  $("#successMessage").empty().append( jsonData.result.message );
				  } else {
					  $("#resultError").removeClass('hide');
					  $("#errorMessage").empty().append( jsonData.result.message );
				  }				  
			  });
		}
		
	</script>
<?php $view['slots']->stop() ?>





