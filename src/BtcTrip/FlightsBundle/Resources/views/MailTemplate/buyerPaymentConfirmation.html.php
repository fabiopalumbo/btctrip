<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
  <head>
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
    <title>Confirmation Email</title>
  </head>
  <body bgcolor="#EBEBEB">
    <table bgcolor="#EBEBEB" width="650" border="0" cellpadding="0" cellspacing="0">
      <tbody>
        <tr>
          <td style="BORDER-RIGHT: #ebebeb 20px solid; BORDER-TOP: #ebebeb 20px solid; BORDER-LEFT: #ebebeb 20px solid; BORDER-BOTTOM: #ebebeb 20px solid"
            width="650">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tbody>
              
                <tr>
                  <td align="left"
                    valign="top"
                    >
                    <table style="BACKGROUND-COLOR: white;" width="100%" border="0" cellpadding="0" cellspacing="0" >
                      <tbody>
                        <tr>
                          <td style="BACKGROUND-COLOR: white;" >
                            <!--begin content area-->
                            <table bgcolor="white" border="0" cellpadding="0" cellspacing="0" style="width:100%">
                              <tbody>
                                <!--begin intro-->
                                <tr>
                                  <td style="FONT-SIZE: 12px; PADDING-BOTTOM: 10px; FONT-FAMILY: Arial, Helvetica, sans-serif; color:#333333;" >
                                    <table width="100%" border="0" cellpadding="0"
                                      cellspacing="0">
                                      <tbody>
                                        <tr>
                                        	<td style="PADDING-top:15px; PADDINg-BOTTOM:15px; PADDING-left: 20px;" bgcolor="#000000">
                                            <img src="https://btctrip.com/bundles/btctrip/images/logo.gif" width="116" height="52"/>
                                            </td>
                                        </tr>
                                        <tr>
                                          <td style="PADDING-RIGHT: 20px; PADDING-LEFT: 20px; FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif; color:#333333;" valign="top" width="325"><br>
                                            <strong><?php print_r($order['buyerInfo']['passengerDefinitions'][0]['firstName']) ?>,</strong><br>
                                            <br>
                                            Thank you for booking your travel with BTCTrip.<br>
                                            <br>
                                            Your BTCTrip booking number is <b><?php echo $order['number'] ?></b>. 
                                            In less than 24hs you will receive the e-ticket.
                                            <br>
                                            <br>
                                            If you have any doubts just email us: support@btctrip.com.
                                          </td>
                                       
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                                <!--end intro-->
                              
                              
                                <!--begin Itinerary -->
                                <!--begin Flights-->
                                <tr>
                                  <td style="FONT-SIZE: 12px; PADDING-TOP: 20px; FONT-FAMILY: Arial, Helvetica, sans-serif; color:#333333;"
                                    width="100%">
                                    <table width="100%" border="0" cellpadding="0"
                                      cellspacing="0">
                                      <tbody>
                                        <tr>
                                          <td style="PADDING-RIGHT: 5px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 5px; COLOR: #003366; PADDING-TOP: 5px; FONT-FAMILY: Arial, Helvetica, sans-serif; BACKGROUND-COLOR: #f7f7f7"
                                            width="100%">
                                            <h4 style="MARGIN: 0px; COLOR: #ff6600">
                                              <strong>Reservation</strong> details</h4>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="PADDING-RIGHT: 20px; PADDING-LEFT: 20px; FONT-SIZE: 12px; PADDING-BOTTOM: 0px; PADDING-TOP: 15px; FONT-FAMILY: Arial, Helvetica, sans-serif; color:#333333;">
                                          
                                            <?php $buyerInfo = $order['buyerInfo'] ?>

                                            <b>Passenger<?php echo ( count($buyerInfo['passengerDefinitions'])>1 ? 's' : '' )?></b><br>
												
											<?php for ($p=0; $p<count($buyerInfo['passengerDefinitions']); $p++) { ?> 
												<br>
												<span style="padding-left:25px; text-transform:uppercase;"> <?php echo $buyerInfo['passengerDefinitions'][$p]['lastName'] ?></span>,
												<?php echo $buyerInfo['passengerDefinitions'][$p]['firstName'] ?>

											<?php  }  ?>	
                                          <br><br>
										
<?php  
$outboundRoute = $order['itinerary']['outboundRoute'];
?>
<b>Outbound</b>
<div class="route-1">
	<div class="content-wrapper">
	<?php for ( $s=0; $s < count($outboundRoute['segments']); $s++ ) { ?>
		<?php  if ($s>0) { ?>
		<div class="connection">
			<span style="padding-left:25px;"><?php echo $outboundRoute['segments'][$s]['waitDuration']['formatted'] ?> connection in 
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
			<span style="padding-left:25px;"><?php echo $inboundRoute['segments'][$s]['waitDuration']['formatted'] ?> connection in 
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
												
                                          
							</td>
                                        </tr>
                                      
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                           
                                <!--begin Pricing-->
                                <tr>
                                  <td style="FONT-SIZE: 12px; PADDING-TOP: 20px; FONT-FAMILY: Arial, Helvetica, sans-serif; color:#333333;"
                                    width="100%">
                                    <table width="100%" border="0" cellpadding="0"
                                      cellspacing="0">
                                      <tbody>
                                        <tr>
                                        <td style="PADDING-RIGHT: 5px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 5px; COLOR: #003366; PADDING-TOP: 5px; FONT-FAMILY: Arial, Helvetica, sans-serif; BACKGROUND-COLOR: #f7f7f7"
                                            width="100%">
                                            <h4 style="MARGIN: 0px; COLOR: #ff6600"><strong>Payment</strong></h4>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; FONT-SIZE: 12px; PADDING-BOTTOM: 0px; PADDING-TOP: 10px; FONT-FAMILY: Arial, Helvetica, sans-serif; color:#333333;"><div>
                                            <ul>
                                                <li>Total fare: <?php echo $order['invoice']['basePrice'] . ' ' . $order['invoice']['baseCurrency'] ?></li>
                                                <li>Cryptocurrency amount: <?php echo $order['invoice']['price'] . ' ' . $order['invoice']['currency']  ?></li>
                                                <li>Invoice: <a target="_blank" href="<?php echo $order['invoice']['url'] ?>" ><?php echo $order['invoice']['id'] ?></a></li>
                                                
                                            </ul>
                                          </div></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                                <!--/end Pricing-->
                            
                            
                            
                               <tr>
                                  <td style="padding:20px 0px;font-size:12px;font-family:Arial,Helvetica,sans-serif;color:rgb(51,51,51)" width="100%">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="padding:5px 5px 5px 10px;font-size:14px;color:rgb(0,51,102);font-family:Arial,Helvetica,sans-serif;background-color:rgb(247,247,247)" width="100%">

                                            <h4 style="margin:0px;color:rgb(255,102,0)">
                                              <b>Additional information</b></h4>
                                          </td>
                                     
                                        </tr>
                                    
                                        <tr>
                                          <td style="padding:15px 5px 0px 10px;font-size:12px;font-family:Arial,Helvetica,sans-serif;color:rgb(51,51,51)">
                                             <table border="0" cellpadding="0" cellspacing="0">
                                              <tbody>
                                                <tr>
                                                  <td style="font-size:12px;padding-bottom:10px;font-family:Arial,Helvetica,sans-serif;color:rgb(51,51,51)">
                                                    <p><b>Policies</b></p>
                                                    <ul>
                                                      <li><span style="font-size:12px;font-family:Arial,Helvetica,sans-serif;color:rgb(51,51,51)">Tickets cannot be refunded
                                                    or transferred unless otherwise noted. Name changes are not permitted. </span></li>
                                                      <li><span style="font-size:12px;font-family:Arial,Helvetica,sans-serif;color:rgb(51,51,51)"> Valid,
                                                      government-issued ID is mandatory for <span class="il">you</span> to get through security and board your flight. </span></li>
                                                      <li><span style="font-size:12px;font-family:Arial,Helvetica,sans-serif;color:rgb(51,51,51)"> Initial prices subject to
                                                    change before final payment. Post-purchase increases of government-imposed taxes or fees may apply.</span></li>
                                                      <li><span style="font-size:12px;font-family:Arial,Helvetica,sans-serif;color:rgb(51,51,51)"> Prices do not include any
                                                    applicable baggage
                                                      fees.</span></li>
                                                      <li><span style="font-size:12px;font-family:Arial,Helvetica,sans-serif;color:rgb(51,51,51)"> International flights may be
                                                    treated with insecticides.</span></li>
                                                    <li><span style="font-size:12px;font-family:Arial,Helvetica,sans-serif;color:rgb(51,51,51)">In case a refund needs to be issued, 
                                                    the amount of USD will be processed at the current Bitpay exchange rate at the moment that refund is generated.</span></li>
                                                    </ul>
                                                   </td>
                                                 </tr>
                                               </tbody>
                                             </table>
                                           </td></tr>
                                           </tbody>
                                        </table>
                                  </td>
                                 </tr>
                                  
                                  
                              </tbody>
                            </table>
                            <!--                           /end content area -->
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <!--begin bottom background rounded corners-->
               
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>