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
                                            <i>Thank you for choosing BTCTrip!</i><br>
                                            <br>
                                            Your BTCTrip booking number is <b><?php echo $order['number'] ?>.</b><br><br> 
                                            In less than 24hs you will receive your voucher.
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
                                              <strong>Hotel</strong></h4>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="PADDING-RIGHT: 20px; PADDING-LEFT: 20px; FONT-SIZE: 12px; PADDING-BOTTOM: 0px; PADDING-TOP: 15px; FONT-FAMILY: Arial, Helvetica, sans-serif; color:#333333;">
                                          	<img style="float:left" id="hotelPicture" width="170" height="170"  src="http://media.staticontent.com/media/pictures/<?php echo $order['item']['hotel']['pictureName']?>/150x150?truncate=true">
                                            <div style="padding-left:190px;">
                                       		   	<span style="display:block;font-weight: bold;color: grey;">Adult in charge of the booking</span>
                                     	     	<span style="display:block;"><?php echo $order['buyerInfo']['passengerDefinitions'][0]['firstName'] . ' ' . $order['buyerInfo']['passengerDefinitions'][0]['lastName']  ?></span>
                                          		<br>
                                          	   	<span style="display:block;font-weight: bold;color: grey;">Hotel</span>
                                     	     	<span style="display:block;"><?php echo $order['item']['hotel']['name'] ?>
														<span style="color: #fc3;">
															<?php for ($s=0; $s<$order['item']['hotel']['starRating']; $s++) { echo '★'; } ?>
														</span>
                                     	     	</span>
                                                <span style="display:block;"><?php echo $city ?></span>
                                     	     	<span style="display:block;"><?php echo $order['item']['hotel']['address'] ?></span>
                                     	     	<br>
                                     	     	<span style="display:block;font-weight: bold;color: grey;">Check in</span>  
												<span style="display:block;"> <?php $date_in = new DateTime($order['item']['search']['parameters']['check_in']);
												  echo date_format($date_in, 'l jS F Y');?> </span><br>
												<span style="display:block;font-weight: bold;color: grey;">Check out </span>  
												<span style="display:block;"><?php $date_out = new DateTime($order['item']['search']['parameters']['check_out']);
												  echo date_format($date_out, 'l jS F Y');?> </span>
												  
                                            </div>
                                            
                                            
										</td>
                                        </tr>
                                      
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
 
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
                                              <strong>Room</strong> </h4>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="PADDING-RIGHT: 20px; PADDING-LEFT: 20px; FONT-SIZE: 12px; PADDING-BOTTOM: 0px; PADDING-TOP: 15px; FONT-FAMILY: Arial, Helvetica, sans-serif; color:#333333;">
                                          		<?php $room = $order['item']['hotel']['room'] ?>
												<span style="display:block;font-weight: bold;color: grey;">Meals</span>
												<span style="display:block;padding-left:20px;"><?php echo $room['regimeDescription'] ?></span>
												<br>
												<span style="display:block;font-weight: bold;color: grey;">Type<?php echo (count($room['roomsDetail']) > 0 ? 's' : '' )  ?></span>
											<?php for ($p=0; $p<count($room['roomsDetail']); $p++) { ?> 
												<span style="display:block;padding-left:20px; "> <?php echo $room['roomsDetail'][$p]['description'] ?></span>
											<?php  }  ?>	
											
											<span > <?php //   Guests:   echo $room['roomsDetail'][$p]['capacity']['maxAdults'] ?></span>
											
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
                                          <td style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; FONT-SIZE: 12px; PADDING-BOTTOM: 0px; PADDING-TOP: 10px; FONT-FAMILY: Arial, Helvetica, sans-serif; color:#333333;">
                                            <div> 
                                            	<ul>
	                                                <li>Total fare: <?php echo $order['invoice']['basePrice'] . ' ' . $order['invoice']['baseCurrency'] ?></li>
	                                                <li>Cryptocurrency amount: <?php echo $order['invoice']['price'] . ' ' . $order['invoice']['currency']  ?></li>
	                                                <li>Invoice: <a target="_blank" href="<?php echo $order['invoice']['url'] ?>" ><?php echo $order['invoice']['id'] ?></a></li>
                                            	</ul>
                                            </div>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                                <!--/end Pricing-->

                                
                                <tr>
                                  <td style="FONT-SIZE: 12px; PADDING-TOP: 10px; FONT-FAMILY: Arial, Helvetica, sans-serif; color:#333333;"
                                    width="100%">
                                    <table width="100%" border="0" cellpadding="0"
                                      cellspacing="0">
                                      <tbody>
                                        <tr>
                                        <td style="PADDING-RIGHT: 5px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 5px; COLOR: #003366; PADDING-TOP: 5px; FONT-FAMILY: Arial, Helvetica, sans-serif; BACKGROUND-COLOR: #f7f7f7"
                                            width="100%">
                                            <h4 style="MARGIN: 0px; COLOR: #ff6600"><strong>Cancelation policies</strong></h4>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="PADDING-RIGHT: 20px; PADDING-LEFT: 20px; FONT-SIZE: 12px; PADDING-BOTTOM: 20px; PADDING-TOP: 10px; FONT-FAMILY: Arial, Helvetica, sans-serif; color:#333333;">
                                            This booking is <i><?php echo ( $room['penalty']['refundable'] ? 'refundable' : 'non refundable' )   ?></i>
                                            <p>
                                            	<?php echo preg_replace('/- /', '<br>- ', preg_replace('/\. ([A-Za-z])/', '.<br>\1', $room['penalty']['description'])) ?>
                                            </p>
                                            <p>
                                            In case a refund needs to be issued, the amount of USD will be processed at the current Bitpay exchange rate at the moment that refund is generated.
                                            </p>
                                          </td>
                                        </tr>
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