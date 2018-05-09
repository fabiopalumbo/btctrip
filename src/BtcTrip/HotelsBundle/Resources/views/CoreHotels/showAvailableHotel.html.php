<?php $available=$hotelAvailable->availability[0]; ?>
<?php if (count($available->rooms) > 0) { ?>      
    <div class="ux-hotels-detail-fare-container">
        <ul class="price-holder">
            <li class="ux-hotels-detail-fare-description price-box-description" style="">
                <span class="room-name">Room <br><b><?php echo $room_first->result->data->hotel->descripcion ?></b></span> <br>per night

            </li>
            <?php if ($room_first->result->data->hotel->averagePricesPerNight->avgPrice->btc != $room_first->result->data->hotel->averagePricesPerNight->avgDiscountPrice->btc) { ?>
                <li class="ux-hotels-detail-fare-discount BTC" style="">
                    <span class="ux-common-price-linethrough">
                        <span class="currency">BTC</span>
                        <span><em class="common-price-discount"><?php echo $room_first->result->data->hotel->averagePricesPerNight->avgPrice->btc / $cantidad_habitacion; ?></em></span>
                        <span class="strikethrough"></span>
                    </span>
                </li>
                <li class="ux-hotels-detail-fare-price BTC" style="">
                    <span class="currency">BTC</span>
                    <span><em class="commonPrice"><?php echo $room_first->result->data->hotel->averagePricesPerNight->avgDiscountPrice->btc / $cantidad_habitacion ?></em></span>
                </li>

                <li style="display: list-item;" class="ux-hotels-detail-fare-saving BTC">
                    <span>you save</span>
                    <span class="currency">BTC</span>
                    <span class="commonPrice"><?php echo $room_first->result->data->hotel->averagePricesPerNight->avgPrice->btc / $cantidad_habitacion - $room_first->result->data->hotel->averagePricesPerNight->avgDiscountPrice->btc / $cantidad_habitacion ?></span>
                    <span>per night!</span>
                </li>
            <?php } else { ?>
                <li class="ux-hotels-detail-fare-price BTC" style="">
                    <span class="currency">BTC</span>
                    <span><em class="commonPrice"><?php echo $room_first->result->data->hotel->averagePricesPerNight->avgPrice->btc / $cantidad_habitacion ?></em></span>
                </li>
            <?php } ?>
            
              <?php if (ceil($room_first->result->data->hotel->averagePricesPerNight->avgPrice->usd) != ceil($room_first->result->data->hotel->averagePricesPerNight->avgDiscountPrice->usd)) { ?>
                <li class="ux-hotels-detail-fare-discount USD" style="display:none">
                    <span class="ux-common-price-linethrough">
                        <span class="currency">USD</span>
                        <span><em class="common-price-discount"><?php echo ceil($room_first->result->data->hotel->averagePricesPerNight->avgPrice->usd / $cantidad_habitacion); ?></em></span>
                        <span class="strikethrough"></span>
                    </span>
                </li>
                <li class="ux-hotels-detail-fare-price USD" style="display:none">
                    <span class="currency">USD</span>
                    <span><em class="commonPrice"><?php echo ceil($room_first->result->data->hotel->averagePricesPerNight->avgDiscountPrice->usd / $cantidad_habitacion) ?></em></span>
                </li>

                <li  class="ux-hotels-detail-fare-saving USD" style="display:none">
                    <span>you save</span>
                    <span class="currency">USD</span>
                    <span class="commonPrice"><?php echo ceil($room_first->result->data->hotel->averagePricesPerNight->avgPrice->usd / $cantidad_habitacion) - ceil($room_first->result->data->hotel->averagePricesPerNight->avgDiscountPrice->usd / $cantidad_habitacion) ?></span>
                    <span>per night!</span>
                </li>
            <?php } else { ?>
                <li class="ux-hotels-detail-fare-price USD" style="display:none">
                    <span class="currency">USD</span>
                    <span><em class="commonPrice"><?php echo ceil($room_first->result->data->hotel->averagePricesPerNight->avgPrice->usd / $cantidad_habitacion) ?></em></span>
                </li>
            <?php } ?>   

            
             <?php if ($room_first->result->data->hotel->averagePricesPerNight->avgPrice->xdg != $room_first->result->data->hotel->averagePricesPerNight->avgDiscountPrice->xdg) { ?>
                <li class="ux-hotels-detail-fare-discount XDG" style="display:none">
                    <span class="ux-common-price-linethrough">
                        <span class="currency">XDG</span>
                        <span><em class="common-price-discount"><?php echo $room_first->result->data->hotel->averagePricesPerNight->avgPrice->xdg / $cantidad_habitacion; ?></em></span>
                        <span class="strikethrough"></span>
                    </span>
                </li>
                <li class="ux-hotels-detail-fare-price XDG" style="display:none">
                    <span class="currency">XDG</span>
                    <span><em class="commonPrice"><?php echo $room_first->result->data->hotel->averagePricesPerNight->avgDiscountPrice->xdg / $cantidad_habitacion ?></em></span>
                </li>

                <li  class="ux-hotels-detail-fare-saving XDG" style="display:none">
                    <span>you save</span>
                    <span class="currency">XDG</span>
                    <span class="commonPrice"><?php echo $room_first->result->data->hotel->averagePricesPerNight->avgPrice->xdg / $cantidad_habitacion - $room_first->result->data->hotel->averagePricesPerNight->avgDiscountPrice->xdg / $cantidad_habitacion ?></span>
                    <span>per night!</span>
                </li>
            <?php } else { ?>
                <li class="ux-hotels-detail-fare-price XDG" style="display:none">
                    <span class="currency">XDG</span>
                    <span><em class="commonPrice"><?php echo $room_first->result->data->hotel->averagePricesPerNight->avgPrice->xdg / $cantidad_habitacion ?></em></span>
                </li>
            <?php } ?>  
            
            
            
             <?php if ($room_first->result->data->hotel->averagePricesPerNight->avgPrice->ltc != $room_first->result->data->hotel->averagePricesPerNight->avgDiscountPrice->ltc) { ?>
                <li class="ux-hotels-detail-fare-discount LTC" style="display:none">
                    <span class="ux-common-price-linethrough">
                        <span class="currency">LTC</span>
                        <span><em class="common-price-discount"><?php echo $room_first->result->data->hotel->averagePricesPerNight->avgPrice->ltc / $cantidad_habitacion; ?></em></span>
                        <span class="strikethrough"></span>
                    </span>
                </li>
                <li class="ux-hotels-detail-fare-price LTC" style="display:none">
                    <span class="currency">LTC</span>
                    <span><em class="commonPrice"><?php echo $room_first->result->data->hotel->averagePricesPerNight->avgDiscountPrice->ltc / $cantidad_habitacion ?></em></span>
                </li>

                <li  class="ux-hotels-detail-fare-saving LTC" style="display:none">
                    <span>you save</span>
                    <span class="currency">LTC</span>
                    <span class="commonPrice"><?php echo $room_first->result->data->hotel->averagePricesPerNight->avgPrice->ltc / $cantidad_habitacion - $room_first->result->data->hotel->averagePricesPerNight->avgDiscountPrice->ltc / $cantidad_habitacion ?></span>
                    <span>per night!</span>
                </li>
            <?php } else { ?>
                <li class="ux-hotels-detail-fare-price LTC" style="display:none">
                    <span class="currency">LTC</span>
                    <span><em class="commonPrice"><?php echo $room_first->result->data->hotel->averagePricesPerNight->avgPrice->ltc / $cantidad_habitacion ?></em></span>
                </li>
            <?php } ?>  
            
            
            
                
            <li class="ux-hotels-detail-fare-buy">

                <?php if (!$room_first->result->data->hotel->soldOut) { ?>
                    <a href="<?php echo $enviromentPrefix ?>/hotels/book/checkout/<?php echo $available->sessionTicket; ?>/<?php echo $room_first->result->data->hotel->id ?>" class="buscarBtn hotels-button" style="display: inline-block;" rel="nofollow">
                        <span>Book now</span>
                    </a>
                <?php } else { ?>
                    <a class="soldOut hotels-button disabled" >
                        <span>Sold out</span>
                    </a>
                <?php } ?>
            </li>
            
            
        
            <li class="ux-hotels-detail-fare-payments hotel-payment" style="display: none;">
                <span class="message"></span>
            </li>
            <!-- <li class="ux-hotels-detail-fare-payments goToRooms" style="display: inline-block;">
                 <a>See more rooms</a>
             </li>  -->
        </ul>

    </div>
<?php } else { ?>
    <ul class="price-holder">
        <li class="ux-hotels-detail-fare-buy">
            <a class="soldOut hotels-button disabled" >
                <span>Sold out</span>
            </a>
        </li>
    </ul>      
<?php } ?>




