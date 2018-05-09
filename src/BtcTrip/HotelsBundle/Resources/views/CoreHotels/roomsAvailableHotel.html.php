<!-- Titulo -->
<?php $available = $hotelAvailable->availability[0]; ?>

<?php if (isset($rooms->result->data->room) && count($rooms->result->data->room) > 0) { 
		  $rooms = $rooms->result->data->room;
	?>

    <span class="ux-hotels-detail-common-title">
        <?php echo count($rooms) ?> Available rooms at this hotel
    </span>
    <!-- Resultados -->
    <p class="ux-hotels-detail-common-paragraph">
        Results for
        <strong class="ux-hotels-detail-common-highlight">
            <?php echo $cantidad_adultos ?>  adults
        </strong>
        from <strong class="ux-hotels-detail-common-highlight"><?php
            $date_from = new DateTime($checkinDate);
            echo date_format($date_from, 'D j M');
            ?> </strong> to <strong class="ux-hotels-detail-common-highlight"><?php
            $date_to = new DateTime($checkoutDate);
            echo date_format($date_to, 'D j M Y');
            ?></strong>
    </p>
    <div id="rooms">

        <?php
        $indice = 0;
        $item_actual = '';
      
        foreach ($rooms as $key => $value) {
            //$r=$value[0]; 
            ?>  
            <?php
            // print_r(json_encode($value));
            $item_actual = $value->typeCode;
            //echo $item_actual;
            //die;
            ?>
            <div class="ux-hotels-detail-rooms-item-container cluster ux-hotels-detail-rooms-item-container-secondary ">
                <div class="ux-hotels-detail-rooms-item">
                    <div class="ux-common-grid-row">
                        <div class="ux-common-grid-col5 ux-common-grid-col12-small">
                            <?php
                            if (!empty($value->pictures)) {
                                $pictures = $value->pictures;
                                ?>
                                <div class="ux-hotels-detail-rooms-carousel">
                                    <div class="ux-hotels-detail-shadow"></div>
                                    <div class="ux-hotels-detail-rooms-img" >
                                        <img id='imagen_<?php echo $value->id; ?>' src="http://media.staticontent.com/media/pictures/<?php echo $pictures[0] ?>/270x250?truncate=true">                                                                        
                                    </div>
                                    <div class="ux-hotels-detail-rooms-title"><?php echo $value->description; ?></div>
                                    <!--<a class="ux-common-slidernav ux-common-slidernav-prev">‹</a>-->
                                    <!--<a class="ux-common-slidernav ux-common-slidernav-next active">›</a>-->
                                </div>
                            <?php } else { ?>
                                <div class="ux-hotels-detail-rooms-plain">
                                    <div class="ux-hotels-detail-rooms-title"><?php echo $value->description; ?></div>

                                </div>
                            <?php } ?>
                        </div>
                        <div class="ux-common-grid-col7 ux-common-grid-col12-small ux-common-grid-first-small">
                            <?php if (!empty($value->pictures)) { ?>  
                                <ul class="ux-hotels-detail-rooms-thumbs">

                                    <?php foreach ($pictures as $p) { ?>
                                        <li  onclick="javascript:changeImageDetail('<?php echo $p ?>', '<?php echo $value->id ?>')">
                                            <img src="http://media.staticontent.com/media/pictures/<?php echo $p ?>/40x40?truncate=true">                                                                        
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>     

                            <div class="ux-hotels-detail-rooms-pricebox-container">

                                <div class="ux-hotels-detail-rooms-pricebox " data-cluster-info="{'typeCode': '22', 'clusterId': 0,'roomPackIds':'3','bestPaymentQuantity': 0,'prices':{'ARS':7825.9849480969,'USD':1004.6193771626},'priceRank':'1-3','pfAB': ''}">
                                    <div class="ux-hotels-detail-rooms-pricebox-detail">
                                        <ul>
                                            <li><b><?php echo $value->regimeDescription ?></b>
                                                <span class="providers" style="display: none;">BRC</span><br>
                                            </li>
                                            <li>
                                                <?php echo $value->discountText ?>
                                            </li>
                                        </ul>  
                                            <ul>
                                        <?php if (!empty($value->availableRooms)) { ?>
                                                <li>
                                                    <?php if ($value->availableRooms < 3) { ?>
                                                        <span class="ux-hotels-detail-rooms-remaining"></span>

                                                        ¡There are only <?php echo $value->availableRooms ?> rooms!
                                                    <?php } else { ?>
                                                        <?php echo $value->availableRooms ?> rooms left
                                                    <?php } ?>

                                                </li>
                                        <?php } ?>
                                                <li>
                                                    <br> 
                                                    <span class="penalty"><i><?php echo ( $value->refundable ? 'Refundable fare' : 'Non refundable fare' ) ?></i></span>
                                                </li>
                                            </ul>
                                    </div>
                                    <div class="ux-hotels-detail-rooms-pricebox-price">
                                        <ul class="price-holder">
                                        <?php foreach (array('BTC', 'XDG', 'LTC') as $currency) { 
                                        		$lcur = strtolower($currency); ?>
                                            <?php if ($value->prices->averagePricesPerNight->avgPrice->$lcur != $value->prices->averagePricesPerNight->avgDiscountPrice->$lcur) { ?>
                                                <li class="ux-hotels-detail-pricebox-before <?php echo $currency ?>"  style="display:<?php echo $currency=='BTC' ? 'block' : 'none' ?>" >
                                                    <span><?php echo $currency ?> <em><?php echo $value->prices->averagePricesPerNight->avgPrice->$lcur / $cantidad_habitacion; ?></em></span>
                                                </li>
                                                <li class="ux-hotels-detail-pricebox-amount <?php echo $currency ?>"  style="display:<?php echo $currency=='BTC' ? 'block' : 'none' ?>" >
                                                    <?php echo $currency ?> <em><?php echo $value->prices->averagePricesPerNight->avgDiscountPrice->$lcur / $cantidad_habitacion; ?></em>
                                                </li>
                                            <?php } else { ?>
                                                <li class="ux-hotels-detail-pricebox-amount <?php echo $currency ?>"  style="display:<?php echo $currency=='BTC' ? 'block' : 'none' ?>" >
                                                    <?php echo $currency ?> <em><?php echo $value->prices->averagePricesPerNight->avgPrice->$lcur / $cantidad_habitacion; ?></em>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                              <?php if (ceil($value->prices->averagePricesPerNight->avgPrice->usd) != ceil($value->prices->averagePricesPerNight->avgDiscountPrice->usd)) { ?>
                                                <li class="ux-hotels-detail-pricebox-before USD" style="display:none">
                                                    <span>USD <em><?php echo ceil($value->prices->averagePricesPerNight->avgPrice->usd / $cantidad_habitacion); ?></em></span>
                                                </li>
                                                <li class="ux-hotels-detail-pricebox-amount USD" style="display:none">
                                                    USD <em><?php echo ceil($value->prices->averagePricesPerNight->avgDiscountPrice->usd / $cantidad_habitacion); ?></em>
                                                </li>
                                            <?php } else { ?>
                                                <li class="ux-hotels-detail-pricebox-amount USD" style="display:none">
                                                    USD <em><?php echo ceil($value->prices->averagePricesPerNight->avgPrice->usd / $cantidad_habitacion); ?></em>
                                                </li>
                                            <?php } ?>
                                            <!-- Buy Button -->
                                            <li class="ux-hotels-detail-fare-buy">
                                                <?php //print_r($val['availableRooms']);  ?>
                                                <?php if (!$value->soldOut) { ?>
                                                    <a href="<?php echo $enviromentPrefix ?>/hotels/book/checkout/<?php echo $available->sessionTicket; ?>/<?php echo $value->id ?>" class="ux-hotels-detail-pricebox-button 1503"    rel="nofollow">
                                                        <span>Book</span>
                                                    </a>
                                                <?php } else { ?>
                                                    <a class="soldOut hotels-button disabled" >
                                                        <span>Sold out</span>
                                                    </a>
                                                <?php } ?>
                                            </li>



                                        </ul>
                                    </div>
                                </div>


                            </div>
                            <?php ?>
                            <?php if (!empty($value->amenities)) { ?>
                                <p class="ux-hotels-detail-rooms-promo ux-hotels-detail-rooms-clear"></p>
                                <p class="ux-hotels-detail-rooms-secondary-title">Amenities</p>
                                <p>
                                    <?php //print_r($r['amenities']);?>

                                    <?php $amenities = $value->amenities; ?>
                                    <?php
                                    $coma = '';
                                    foreach ($amenities as $a) {
                                        echo $coma . $a->description;
                                        $coma = ', ';
                                    }
                                    ?>
                                </p>
                            <?php } ?>   
                        </div>
                    </div>
                </div>

                <!-- contenedor item habitacion -->
            </div>

        <?php } ?>                                                                                                         <!-- contenedor item habitacion -->
    </div>
<?php } ?>