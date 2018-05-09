<div>


    <div id="order" class="order" >
		<div class="result-availability-legend">
			<h4><?php echo $hotels->result->data->paginationSummary->itemCount; ?> available hotels in <?php echo $sFromName ?></h4>
		</div>

        <form class="order-form">
            <ul>


                <li class="currency">
                    <label for="currency">
                        <span class="currencyTitle">Currency</span>
                        <select name="currency" id="currency" class="currency-change flights-select">
                            <option value="BTC" selected="">Bitcoin</option>
                            <option value="XDG">Dogecoin</option>
                            <option value="LTC">Litecoin</option>
                            <option value="USD">US Dolar</option>
                        </select>
                    </label>
                </li>

            </ul>
        </form>
    </div>
    <div id="hotelResults" class="ux-hotels-cluster-v2-and-above ux-hotels-list-grid v4"> 

        <?php
        $total = 20;

        $cantidad_paginas = 1;
        $cantidad_resultados = $hotels->result->data->paginationSummary->itemCount;
        if ($cantidad_resultados > 0) {

            if ($cantidad_resultados < 21) {
                $total = $cantidad_resultados;
            } else {
                $cantidad_total = $cantidad_resultados;
                $cantidad_paginas = $cantidad_resultados / 21;
                $cantidad_paginas_up = ceil($cantidad_paginas);
                $cantidad_paginas_down = floor($cantidad_paginas);

                $diff_up = $cantidad_paginas - $cantidad_paginas_up;
                $diff_down = $cantidad_paginas - $cantidad_paginas_down;

                if ($diff_up > 0) {
                    $cantidad_paginas = $cantidad_paginas_up;
                } else {
                    $cantidad_paginas = $cantidad_paginas_down;
                }
                //$cantidad_paginas=$cantidad_paginas+1;
            }

            foreach ($hotels->result->data->items as $hotel_data) {
                $hotel = $hotel_data->availability->hotel;
//                 $price = $hotel_data->availability;
                ?>


                <div class="span3  first  ">
                    <div id="<?php echo $hotel->id; ?>" name="<?php echo $hotel->hotel->name; ?>" class="ux-hotels-cluster-list hotel">
                        <div class="ux-hotels-cluster-module-img-cont">
                            <img class="ux-hotels-cluster-module-img" src="http://media.staticontent.com/media/pictures/<?php echo $hotel->hotel->pictureName ?>/232x138" alt="<?php echo $hotel->hotel->name ?>"
                                 onError="this.onerror=null;this.src='/bundles/btctriphotels/images/hotelPlaceHolder.jpg?';" >
                        </div>
                        <div class="ux-hotels-cluster-container">
                            <div class="ux-hotels-cluster-list-main">
                                <div class="ux-hotels-cluster-list-colprice">
                                    <div class="ux-hotels-cluster-price">
                                        <div class="ux-hotels-cluster-price-box">
                                            <div class="ux-hotels-cluster-price-box-center">
                                                <div class="ux-hotels-cluster-price-label">
                                                    <span class="ux-cluster-price-label-arrow"></span>Room per night from
                                                </div>
                                                <div class="ux-hotels-cluster-prices">
                                                   
                                                    <span  class="ux-hotels-cluster-price-overline USD currencyContainer" data-currency="USD" style="display:none">
                                                        <span class="ux-hotels-cluster-price-before ">
                                                              <?php if (ceil($hotel->avgPriceWithoutTax) != ceil($hotel->avgDiscountPriceWithoutTax)) { ?>
                                                                <em>USD </em><?php echo ceil($hotel->avgPriceWithoutTax); ?>
                                                                <span class="strikethrough"></span><br/>
                                                              <?php } ?>
                                                        </span>
                                                    </span>
                                                    <span  class="ux-hotels-cluster-price-now USD currencyContainer" data-currency="USD" style="display:none">
                                                        USD <em><?php echo ceil($hotel->avgDiscountPriceWithoutTax); ?></em>
                                                    </span>

                                                    
                                               <?php foreach ($hotel_data->availability->cryptoPrices as $cryptoPrice) {  ?>
                                                    
                                                     <span   class="ux-hotels-cluster-price-overline <?php echo $cryptoPrice->currency; ?> currencyContainer" data-currency="<?php echo $cryptoPrice->currency; ?>" 
                                                     	style="display:<?php echo ($cryptoPrice->currency == 'BTC' ? 'block' : 'none')?>"  >
                                                        <span class="ux-hotels-cluster-price-before">
                                                            <?php if ($cryptoPrice->avgPriceWithoutTax != $cryptoPrice->avgDiscountPriceWithoutTax) { ?>
                                                                <em><?php echo $cryptoPrice->currency; ?>&nbsp;</em><?php echo $cryptoPrice->avgPriceWithoutTax; ?>
                                                                <span class="strikethrough"></span>
                                                            <?php } ?>
                                                        </span>
                                                    </span>
                                                    <span  class="ux-hotels-cluster-price-now <?php echo $cryptoPrice->currency; ?> currencyContainer" data-currency="<?php echo $cryptoPrice->currency; ?>"
                                                     	style="display:<?php echo ($cryptoPrice->currency == 'BTC' ? 'block' : 'none')?>"><?php echo $cryptoPrice->currency; ?>&nbsp;<em><?php echo $cryptoPrice->avgDiscountPriceWithoutTax; ?></em>
                                                    </span>
                                                    
                                                <?php  }  ?>

                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ux-hotels-cluster-list-coldescription">
                                    <div class="ux-hotels-cluster-list-colinfo">
                                        <div class="ux-hotels-cluster-list-info">
                                            <a class="hotelNameLink hotelDetailLink upatracker" title="<?php echo $hotel->hotel->name ?>" hotel-data="{rowId: '1-1', stars: '4'}" onclick="omnitureDataCollector.setRankingHotel('1-1');
                                                    trackGAEvent('Link Nombre Hotel', 'Item Hotel', 'Link Nombre Hotel');" href="<?php echo $enviromentPrefix ?>/hotels/show/<?php echo $hotel->id ?>/<?php echo (!empty($checkinDate)) ? $checkinDate . '/' : '' ?><?php echo (!empty($checkoutDate)) ? $checkoutDate . '/' : '' ?><?php echo $distribution; ?><?php echo (empty($checkoutDate)) ? '/' . $hotel->hotel->name : '' ?>">
                                                <h4 class="ux-hotels-cluster-name"><?php echo $hotel->hotel->name; ?></h4>
                                            </a>
                                            <div class="ux-hotels-cluster-stars">
                                                <?php for ($r = 0; $r < $hotel->hotel->starRating; $r++) { ?>
                                                    ★ 
                                                <?php } ?>
                                            </div>
                                            <div class="ux-hotels-cluster-infolist ux-hotels-cluster-infolist-address">
                                                <span class="ux-hotels-cluster-infolist-icon"><span class="ux-hotels-results-icon-marker-map"></span></span>
                                                <div class="ux-hotels-cluster-infolist-detail">
                                                    <p>
                                                        <span title="Estrada Da Usina, 300">
                                                            <?php echo $hotel->hotel->address; ?>
                                                        </span>
                                                    </p>
                                                    <p>
                                                        <!-- <a class="hotelMap" id="show-map-trigger-330762" onclick="trackGAEvent('Link Ver en Mapa', 'Item Hotel','Link Ver en Mapa');">
                                                             ver en mapa
                                                         </a>-->
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="ux-hotels-cluster-hover">
                                                <div class="ux-hotels-cluster-description">
                                                    <div class="ux-hotels-cluster-desc-text">
                                                        <div class="ux-mixins-ellipsis-invisible"></div>
                                                        <?php
                                                        $hotelDescription = $hotel->hotel->description;
                                                        if (strlen($hotel->hotel->description) >= 300) {
                                                            $hotelDescription = substr($hotel->hotel->description, 0, 300);

                                                            // sacando la ultima palabra truncada
                                                            $hotelDescription = substr($hotelDescription, 0, strrpos($hotelDescription, ' '));
                                                            $hotelDescription .= '...';
                                                        }
                                                        ?>
                                                        <p><?php echo $hotelDescription ?><a class="see-more" href="<?php echo $enviromentPrefix ?>/hotels/show/<?php echo $hotel->id ?>/<?php echo (!empty($checkinDate)) ? $checkinDate . '/' : '' ?><?php echo (!empty($checkoutDate)) ? $checkoutDate . '/' : '' ?><?php echo $distribution; ?><?php echo (empty($checkoutDate)) ? '/' . $hotel->hotel->name : '' ?>" >see more »</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class="ux-hotels-cluster-views">
                                                <p class="ux-hotels-cluster-views-payments">
                                                    <span class="providers" style="display:none">
                                                        PayAtDestination,PayInAdvance] - 18
                                                    </span>
                                                    <em class="small">¡Pague en el hotel o <br> hasta en 18 pagos!</em>
                                                </p>
                                            </div>-->
                                        </div>
                                        <ul class="ux-hotels-cluster-infolist">
                                            <li class="ux-hotels-cluster-infolist-item-rate">
                                                <span class="ux-hotels-cluster-infolist-icon"><span class="ux-hotels-results-icon-ok"></span></span>
                                                <div class="ux-hotels-cluster-infolist-detail ux-hotels-cluster-infolist-rate">
                                                    <?php $overall_rating = $hotel->hotel->reviewSummary->overallRating; ?>


                                                    <p class="ux-hotels-cluster-infolist-rate"><em>

                                                            <?php echo ((strlen($overall_rating) == 3) ? substr($overall_rating, 0, 2) : substr($overall_rating, 0, 1) . "." . substr($overall_rating, 1, 1) ); ?></em> 

                                                        <?php
                                                        if (($overall_rating < 70)) {
                                                            $condicion = "";
                                                        }
                                                        ?>
                                                        <?php
                                                        if (($overall_rating >= 70) && ($overall_rating <= 80)) {
                                                            $condicion = "Confort";
                                                        }
                                                        ?>
                                                        <?php
                                                        if (($overall_rating > 80) && ($overall_rating < 90)) {
                                                            $condicion = "Very good";
                                                        }
                                                        ?>
                                                        <?php
                                                        if (($overall_rating >= 90) && ($overall_rating <= 100)) {
                                                            $condicion = "Excellent";
                                                        }
                                                        ?>
                                                        <?php echo $condicion; ?></p>
                                                </div>
                                            </li>
                                            <li class="ux-hotels-cluster-infolist-item-comments ux-hotels-cluster-infolist-item-first">

                                                <div class="ux-hotels-cluster-infolist-detail ux-hotels-cluster-infolist-comments">
                                                    <a style="display: inline-block;" onclick="omnitureDataCollector.setRankingHotel('1-1');" hotel-data="{rowId: '1-1', stars: '4'}" comment-data="{&quot;descriptionComment&quot;: &quot;&quot;, &quot;commenter&quot;: &quot;&quot;, &quot;profileId&quot;: &quot;&quot;}" class="hotelComments upatracker" href="<?php echo $enviromentPrefix ?>/hotels/show/<?php echo $hotel->id ?>/<?php echo (!empty($checkinDate)) ? $checkinDate . '/' : '' ?><?php echo (!empty($checkoutDate)) ? $checkoutDate . '/' : '' ?><?php echo $distribution; ?><?php echo (empty($checkoutDate)) ? '/' . $hotel->hotel->name : '' ?>"><?php echo $hotel->hotel->reviewSummary->commentsCount ?> comments </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        <?php } ?>
    </div>




    <div class="pagination" id="pagination">
        <ul>
            <?php
            if (!isset($page)) {
                $page = 1;
            }
            ?>

            <?php if ($cantidad_paginas > 1) { ?>
                <?php if ($page == 1) { ?> 
                    <li class="active"> 
                        <a class="trackable"  onclick="aplicarPaginado('1')" ab="filter|pagination-1">1</a>
                    </li>
                    <?php if ($page + 1 < $cantidad_paginas) { ?>
                        <li class="ajaxResultCall">
                            <a class="trackable"  onclick="aplicarPaginado('<?php echo $page + 1; ?>')" ab="filter|pagination-<?php echo $page + 1; ?>"><?php echo $page + 1; ?></a>
                        </li>
                    <?php } ?>
                    <?php if ($page + 2 < $cantidad_paginas) { ?>
                        <li class="ajaxResultCall">
                            <a class="trackable"  onclick="aplicarPaginado('<?php echo $page + 2; ?>')" ab="filter|pagination-<?php echo $page + 2; ?>"><?php echo $page + 2; ?></a>
                        </li>
                    <?php } ?>
                    <li class="dots">
                        <a>...</a>
                    </li>
                    <li class="ajaxResultCall">
                        <a class="trackable" onclick="aplicarPaginado('<?php echo $cantidad_paginas; ?>')" ab="filter|pagination-<?php echo $cantidad_paginas; ?>"><?php echo $cantidad_paginas; ?></a>
                    </li>
                <?php } ?>

                <?php if (($page > 1) && ($page < $cantidad_paginas)) { ?> 

                    <?php if ($page - 3 == 1) { ?>
                        <li class="ajaxResultCall">
                            <a class="trackable"  onclick="aplicarPaginado('<?php echo $page - 3; ?>')" ab="filter|pagination-<?php echo $page - 3; ?>"><?php echo $page - 3; ?></a>
                        </li>
                    <?php } else { ?>
                        <li class="ajaxResultCall">
                            <a class="trackable"  onclick="aplicarPaginado('1')" ab="filter|pagination-1">1</a>
                        </li>  

                        <?php if (($page - 1 > 1) && ($page - 2 > 1) && ($page - 3 > 1)) { ?>
                            <li class="dots">
                                <a>...</a>
                            </li>

                        <?php } ?>

                    <?php } ?>



                    <?php if ($page - 2 > 1) { ?>
                        <li class="ajaxResultCall">
                            <a class="trackable"  onclick="aplicarPaginado('<?php echo $page - 2; ?>')" ab="filter|pagination-<?php echo $page - 2; ?>"><?php echo $page - 2; ?></a>
                        </li>
                    <?php } ?>
                    <?php if ($page - 1 > 1) { ?>
                        <li class="ajaxResultCall">
                            <a class="trackable"  onclick="aplicarPaginado('<?php echo $page - 1; ?>')" ab="filter|pagination-<?php echo $page - 1; ?>"><?php echo $page - 1; ?></a>
                        </li>
                    <?php } ?>  
                    <li class="active">
                        <a class="trackable"  onclick="aplicarPaginado(<?php echo $page ?>)" ab="filter|pagination-1"><?php echo $page ?> </a>

                    </li>
                    <?php if ($page + 1 < $cantidad_paginas) { ?>
                        <li class="ajaxResultCall">
                            <a class="trackable"  onclick="aplicarPaginado('<?php echo $page + 1; ?>')" ab="filter|pagination-<?php echo $page + 1; ?>"><?php echo $page + 1; ?></a>
                        </li>
                    <?php } ?>
                    <?php if ($page + 2 < $cantidad_paginas) { ?>
                        <li class="ajaxResultCall">
                            <a class="trackable"  onclick="aplicarPaginado('<?php echo $page + 2; ?>')" ab="filter|pagination-<?php echo $page + 2; ?>"><?php echo $page + 2; ?></a>
                        </li>
                    <?php } ?>
                    <?php if ($page + 3 == $cantidad_paginas) { ?>
                        <li class="ajaxResultCall">
                            <a class="trackable"  onclick="aplicarPaginado('<?php echo $page + 3; ?>')" ab="filter|pagination-<?php echo $page + 3; ?>"><?php echo $page + 3; ?></a>
                        </li>
                    <?php } else { ?>
                        <?php if (($page + 1 < $cantidad_paginas) && ($page + 2 < $cantidad_paginas) && ($page + 3 < $cantidad_paginas)) { ?>
                            <li class="dots">
                                <a>...</a>
                            </li>

                        <?php } ?>

                        <li class="ajaxResultCall">
                            <a class="trackable" onclick="aplicarPaginado('<?php echo $cantidad_paginas; ?>')" ab="filter|pagination-<?php echo $cantidad_paginas; ?>"><?php echo $cantidad_paginas; ?></a>
                        </li>
                    <?php } ?>


                <?php } ?>


                <?php if ($page == $cantidad_paginas) { ?> 
                    <li class="ajaxResultCall">
                        <a class="trackable"  onclick="aplicarPaginado('1')" ab="filter|pagination-1">1</a>
                    </li>  
                    <li class="dots">
                        <a>...</a>
                    </li>

                    <?php if ($page - 3 > 1) { ?>
                        <li class="ajaxResultCall">
                            <a class="trackable"  onclick="aplicarPaginado('<?php echo $page - 3; ?>')" ab="filter|pagination-<?php echo $page - 3; ?>"><?php echo $page - 3; ?></a>
                        </li>
                    <?php } ?>

                    <?php if ($page - 2 > 1) { ?>
                        <li class="ajaxResultCall">
                            <a class="trackable"  onclick="aplicarPaginado('<?php echo $page - 2; ?>')" ab="filter|pagination-<?php echo $page - 2; ?>"><?php echo $page - 2; ?></a>
                        </li>
                    <?php } ?>
                    <?php if ($page - 1 > 1) { ?>
                        <li class="ajaxResultCall">
                            <a class="trackable"  onclick="aplicarPaginado('<?php echo $page - 1; ?>')" ab="filter|pagination-<?php echo $page - 1; ?>"><?php echo $page - 1; ?></a>
                        </li>
                    <?php } ?>  
                    <li class="active">
                        <a class="trackable"  onclick="aplicarPaginado(<?php echo $page ?>)" ab="filter|pagination-1"><?php echo $page ?> </a>

                    </li>
                <?php } ?>       

            <?php } else { ?> 
                <li class="active">
                    <a class="trackable"  onclick="aplicarPaginado(1)" ab="filter|pagination-1">1 </a>

                </li>
            <?php } ?>
            <input id="pageNumber" name="page" value="2" type="hidden">
        </ul>
    </div>
</div>

<script>
    function changeCurrencyVisibility(visibleCurrency) {
    	$('.BTC').hide();
    	$('.XDG').hide();
    	$('.LTC').hide();
    	$('.USD').hide();
    	$('.' + visibleCurrency).show();
    }
    
    $('#currency').change( function() {
    	changeCurrencyVisibility($('#currency').val());
    	amplify.store('preferedCurrency', $('#currency').val());
    });

	if (amplify.store('preferedCurrency')) {
		changeCurrencyVisibility(amplify.store('preferedCurrency'));
		$('#currency').val(amplify.store('preferedCurrency'));
	} 
    
</script>    




