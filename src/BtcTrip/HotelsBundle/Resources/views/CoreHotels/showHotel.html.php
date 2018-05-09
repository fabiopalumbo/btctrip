<?php $view->extend('BtcTripMainBundle::layout.html.php') ?>

<?php $view['slots']->set('bodyClass', '') ?>

<?php $view['slots']->start('stylesheets') ?>

<?php foreach ($view['assetic']->stylesheets( 
    array( '@BtcTripHotelsBundle/Resources/public/css/showHotels.css',
           '@BtcTripHotelsBundle/Resources/public/css/formSearchHotels.css','@BtcTripHotelsBundle/Resources/public/css/popups.css'), array('cssrewrite') 
    ) as $url): ?>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $view->escape($url) ?>">
<?php endforeach; ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" language="javascript" src="<?php  echo $view['assets']->getUrl('bundles/btctriphotels/js/hotelMap.js') ?>"></script>
<script type="text/javascript" language="javascript" src="<?php  echo $view['assets']->getUrl('bundles/btctrip/javascript/amplify-1.1.0.min.js') ?>"></script>


<?php $view['slots']->stop() ?>

<?php $view['slots']->start('mainContent') ?>
 


<div id="opaque" class="opaque"></div>
<div class="span12">
    <a class="ux-common-back-to-top" title="Ir a las habitaciones" style="display: none;"><p class="widget-navigator">›</p></a>
       
<div class="ux-common-grid-row">
    <div class="ux-common-grid-col3 ux-hotels-detail-sidebar">
                <!-- ####################################################### --> 
                                 
                      <div class="ux-common-detail-search-summary">
                                <h4 class="ux-common-detail-search-summary-title">
                                    <a id="soldOutLink" class="backToSearch" href="<?php echo $enviromentPrefix?>/hotels/result/<?php echo $hotel->cityId?>/<?php echo (!empty($checkinDate))? $checkinDate.'/' : '' ?><?php echo (!empty($checkoutDate))? $checkoutDate.'/' : '' ?><?php echo $distribution?>/1">« Back to your search</a>
                                </h4>
                                <div id="searchboxCollapsed" class="ux-common-detail-search-summary-list searchboxCollapsed">
                                <ul class="ux-common-detail-search-summary-list">
                                    <li>
                                        <span class="ux-common-detail-search-summary-icon">
                                            <span class="ux-common-icon-marker"></span>
                                        </span>
                                        <?php echo $hotel->name?>, <?php echo $hotel->address->fullAddress; ?>
                                    </li>
                                    <li>
                                        <span class="ux-common-detail-search-summary-icon">
                                            <span class="ux-common-icon-calendar"></span>
                                        </span>
                                        <?php $date_from = new DateTime($checkinDate);
                                              $date_to = new DateTime($checkoutDate);
                                              
                                              $day_from=date_format($date_from, 'd');
                                              $mes_from=date_format($date_from, 'm');
                                              $anio_from=date_format($date_from, 'Y');
                                              $day_to= date_format($date_to, 'd');
                                              $mes_to= date_format($date_to, 'm');
                                              $anio_to= date_format($date_to, 'Y');
                                              $cant_day=$day_to-$day_from;
                                              //calculo timestam de las dos fechas
                                              $timestamp1 = mktime(0,0,0,$mes_from,$day_from,$anio_from);
                                              $timestamp2 = mktime(4,12,0,$mes_to,$day_to,$anio_to);
                                              //resto a una fecha la otra
                                              $segundos_diferencia = $timestamp1 - $timestamp2;
                                              //echo $segundos_diferencia;
                                              //convierto segundos en días
                                              $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
                                              //obtengo el valor absoulto de los días (quito el posible signo negativo)
                                              $dias_diferencia = abs($dias_diferencia);
                                              //quito los decimales a los días de diferencia
                                              $dias_diferencia = floor($dias_diferencia);
                                        ?>
                                        <?php echo $dias_diferencia?> night (<?php echo date_format($date_from, 'M j');?> - <?php echo date_format($date_to, 'M j');?>)
                                    </li>
                                <li>
                                    <span class="ux-common-detail-search-summary-icon">
                                      <span class="ux-common-icon-person"></span>
                                    </span>
                                    <?php echo $cantidad_adultos?> adult
                                </li>
                                <li>
                                    <span class="ux-common-detail-search-summary-icon">
                                        <span class="ux-common-icon-bed"></span>
                                    </span>
                                    <?php echo $cantidad_habitacion?> rooms.
                                </li>
                            </ul>
                            
                          </div>
                        <!--  ###########################################################3-->
 		              </div>
                <!--  ########################## Google Map #################################################### -->
                <div class="ux-hotels-detail-map">
                    <?php $latitude=$hotel->geoLocation->latitude; 
                          $longitude=$hotel->geoLocation->longitude;  
                    ?>     
                   <div class="ux-common-map showMapTrigger">
                        <img class="hotelMap staticMap" height="276px" width="100%" src="http://maps.staticontent.com/search/maps/static/GOO/276/276/<?php echo $latitude?>/<?php echo $longitude?>/15?lang=en&version=v4">
                        <a class="ux-common-map-zoom ux-common-results-icon-big-map"  onClick="showHotelMap('<?php echo $latitude?>','<?php echo $longitude?>');" href="#mapModal" data-toggle="modal"><span></span>Enlarge Map</a>
                        <div class='modal hide' id='mapModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                            <div class='opaque-div'></div>
                                <div class='modal-inner'>
                                    <!-- Titulo -->
                                    <div class='modal-header'>
                                        <a class="close clickover-close-button" onclick="cerrar();"  title="Cerrar" data-dismiss="modal"> &#215; </a>
                                        <div class="modal-title">
                                            <span class="modal-title-emphasize"><?php echo $hotel->address->fullAddress?></span>
                                        </div>
                                    </div>
                                    <!-- Contenido -->
                                    <div class="modal-body">
                                        <div class="hotelCanvasMap hotelMapDisplayNone" id="map_canvas"></div>
                                        <div class="hotel-map-reference">
                                            <span class="mainSprite hotel-marker-mini"></span><?php echo $hotel->name;?>&nbsp;
                                            <!--    <span class="mainSprite hotel-marker-point"></span>Point of Interest    -->
                                        </div>
                                    </div>
                               </div>
                        </div>
                        <p class="static-map-marker">
                            <span class="text"><?php echo $hotel->address->fullAddress?></span>
                            <span class="shadow"></span>
                            <span class="sharp"></span>
                        </p>
                        </div>
                     </div>
                <!--  ###################################Fin google map #######################################-->
                <!-- -##################### Cominenzo de punto de interes -->
                <?php $puntos = $hotelPoint->data;  ?>         

                <?php if (isset($puntos) && count($puntos) > 0) { ?>
                    <div class="ux-common-points-interest poi-main-container">
                        <h3>Places of interest</h3>
                        <ul>
                            <?php foreach($puntos as $p){?>
                                    <li>
                                        <span title="<?php echo $p->name ?>"><?php echo $p->name?></span>
                                        <em><?php //echo $p->distance?><?php echo number_format($p->distance,2) ?> km </em>
                                    </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
           <!--############################# fin de punto de interes -->
           
    </div>
    <div class="ux-common-grid-col9">
    	<div class="detailFlap">
                <div id='div_no_available'></div>    
    	</div>
    </div>
         
    <div class="ux-common-grid-col9 father-popup-redirect container-white">
        
          <div  class="ux-hotels-detail-menu" >
              <form>
                <ul>
                    <li>Go to</li>
                    <li><a href='#facities'>Facilities</a>
                          </li> 
                    <li> <a href='#booking'>Booking conditions</a>
                    </li>
                    <li> <a href='#comments'>Comments</a>
                    </li>
                    <?php if (isset($checkinDate) && (isset($checkoutDate))){?>
                   <li class="currency" >
                        <label for="currency">
                            <span class="currencyTitle">Currency</span>
                            <select name="currency" id="currency" class="currency-change hotels-select">
                                <option value="BTC" selected="">Bitcoin</option>
                         	    <option value="XDG">Dogecoin</option>
                            	<option value="LTC">Litecoin</option>
                            	<option value="USD">US Dolar</option>
                            </select>
                        </label>
                    </li>
                    <?php } ?>
                </ul>
            </form>
          </div>    
        

        
        
             <!-- ############################################### -->
             <!--                    DETAIL                       -->
             <!-- ############################################### -->
                
               <div class="ux-hotels-detail-picture-container">
                    <div class="ux-hotels-detail-shadow"></div>
                        <div class="ux-hotels-detail-picture">
                            <div class="frame">
                                <img id="imagen_grande" src="http://media.staticontent.com/media/pictures/<?php echo $hotel->pictures[0]?>/879x370?truncate=true" style="height: 370px; width: 879px; position: absolute; top: 0px; left: 0px; z-index: 0; opacity: 0.995374;">                                                                        
                            </div>
                        </div>
                        <div class="ux-hotels-detail-name ">
                            <h1 id="hotel-name" title="<?php echo $hotel->name ?>">
                                <span class="hotel-name"><?php echo $hotel->name?></span>
                                <span class="ux-hotels-detail-star-rate"><?php for($i=0;$i<$hotel->starRating;$i++){?>★<?php }?> </span>
                            </h1>
                        </div>
                        <div class="ux-hotels-detail-overimage-v3 v4">
                           <!-- $hotel->reviewSummary->overallRating  -->
                            <?php if ($hotel->reviewSummary->overallRating != 0) { ?>
                            <div class="ux-hotels-detail-rate-secondary">
                                <div class="ux-hotels-detail-rate-score">
                                    <?php $overall_rating = $hotel->reviewSummary->overallRating; ?>
                                    <em><?php echo ((strlen($overall_rating) == 3) ? substr($overall_rating, 0, 2) : substr($overall_rating, 0, 1) . "." . substr($overall_rating, 1, 1) ); ?></em> point
                                </div>
                                <div class="ux-hotels-detail-rate-text">

                                    <?php if (($overall_rating >= 70) && ($overall_rating <= 80)) {
                                        $condicion = "Confort";
                                    } ?>
                            <?php if (($overall_rating > 80) && ($overall_rating < 90)) {
                                $condicion = "Very good";
                            } ?>
                            <?php if (($overall_rating >= 90) && ($overall_rating <= 100)) {
                                $condicion = "Excellent";
                            } ?>
                                    <em><?php echo (isset($condicion) ? $condicion : '') ?></em>
                                </div>
                                <!--<div class="ux-hotels-detail-rate-recommended">
                                    <span class="ux-common-icon-positive"></span> 80% lo recomendó
                                </div>
                                -->
                            </div>
                        <?php } ?>  
                            <div class="ux-hotels-detail-fare" id="div_show_available">
                               <!-- style="display: none;" -->
                                 <ul  class="price-holder">
                                    <li>
                                        <img class="loadingPrice" src="/bundles/btctriphotels/images/loading-bitcoin.gif">
                                    </li>
                                    <li>
                                        <span class="availabilityText">Checking availability...</span>
                                    </li>
                                </ul>
                               
                            </div>        
                        
                     </div>
             </div>
             <div class="ux-hotels-detail-thumbs">
                <ul class="ux-hotels-detail-thumbs-list">
                <?php   $pictures=$hotel->pictures;
                        $indice=0;
                        foreach($pictures as $pic){ ?>
                            <li class="photo-thumbnail">
                                <a onclick="javascript:changeImage('<?php echo $pic?>')">
                                    <img  data-img-index="<?php echo $indice;?>" src="http://media.staticontent.com/media/pictures/<?php echo $pic?>/40x40?truncate=true">
                                </a>
                                <div class="ux-hotels-detail-thumb-hover" onclick="javascript:changeImage('<?php echo $pic?>')"><span class="ux-hotels-detail-thumb-magnify"></span></div>
                            </li>
                       <?php $indice++; } ?>

                </ul>
            </div>
                <div class="ux-hotels-detail-description">
                    <div id="inner-description">
                        <p id="text-description"><?php echo $hotel->description?></p>
                    </div>
                    <div style="display: none;" class="toggleCommentLength">
                        <a id="seeMore">ver más</a>
                        <a id="seeLess">ver menos</a>
                    </div>
                </div>
                <div class="ux-hotels-detail-common-module ux-rooms-container" id='div_rooms_available'>
                   
                </div>

		<?php if (count($hotelReviews->reviews) > 0) { ?>
                    <!-- ############################################### -->
                    <!--                    REVIEW                       -->
                    <!-- ############################################### -->
                   <a id="comments">
                    <div class="ux-hotels-detail-common-module ux-reviews-container">
                        <span class="ux-hotels-detail-common-title">
                             Opinions and reviews for <?php echo $hotel->name?>
                        </span>
                        <div class="ux-common-comments-bubble" >
                            <div id="common-comments-list">
                            <?php $hotelReviews=$hotelReviews->reviews; 
                                  $cantidad_comentarios=1;
                                  foreach($hotelReviews as $review){
                                       ?>
                            
                                        <div class="ux-common-comment-bubble" id="comment_id" <?php echo ($cantidad_comentarios>10)? 'style=display:none' : ''?>>
                                            <div class="ux-common-comment-bubble-coluser">
                                                <div class="ux-common-comment-bubble-coluser-content">
                                                    <div class="ux-common-comment-bubble-avatar">

                                                    </div>
                                                    <div class="ux-common-comment-bubble-user">
                                                   	<?php if (isset($review->user)) {  ?>
                                                        <p><?php echo $review->user->name ?>
                                                            <?php if (!empty($review->user->country)){?>
                                                                <span class="flagIcon flag-<?php echo strtolower($review->user->country)?> image" style="height:11px;" title="<?php echo (empty($review->user->country)? $review->user->country : ""  )?>"></span>
                                                            <?php }?>
                                                        </p>
                                                    <?php } ?>
                                                        <p class="ux-common-comment-bubble-date"><?php $review_date = new DateTime($review->reviewDate);
                                                          echo date_format($review_date, 'j M Y');?></p>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="ux-common-comment-bubble-colopinion">
                                                <div class="ux-common-grid-row ux-common-comment-loading" style="z-index:2">
                                                    <span class="ux-common-comment-loading-spinner"><?php //  < img src="spinner-white-bg.gif"> ?> </span>
                                                </div>
                                                <div class="ux-common-comment-bubble-colopinion-content">
                                                    <span class="ux-common-comment-bubble-colopinion-arrow"></span>
                                                    <div class="ux-common-comment-bubble-opinion ux-common-comment-bubble-opinion-best">
                                                         <span class="text"><?php echo (isset($review->comments->description))? $review->comments->description : ""; ?></span>
                                                    </div>
                                                    <span class="providers" style="display: none;">Useful: 0, Useless: 0<p>{"code":"HBE","hotelID":"345663}</p></span>
                                                    </div>
                                            </div>
                                            <div class="ux-common-comment-bubble-colguest ">
                                                <div class="ux-common-comment-bubble-colguest-content">
                                                    <div class="ux-common-comment-bubble-verified">
                                                       Source: <span class="ux-common-comment-source-tripadvisor"><?php echo $review->provider?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ux-common-comment-bubble-colrate">
                                                <div class="ux-common-comment-bubble-colrate-content">
                                                    <div class="ux-common-comment-bubble-rate">
                                                        <em><?php echo ((strlen($review->averageScore)==3)?  substr($review->averageScore,0,2):  substr($review->averageScore,0,1).".".substr($review->averageScore,1,1)    ); ?></em> points
                                                    </div>
                                                </div>
                                            </div>
                                            </div>  
                                    <?php $cantidad_comentarios++; ?>
                                    
                            <?php }?>
                        </div>
                        <div id="loadingReviews" class="message" style="margin-bottom: 15px;">
                            <div class="searching">
                                <span class="text">Loading more comments </span>
                                    <img class="loader" alt="" src="/bundles/btctriphotels/images/loader-mdpi.gif">  
                            </div>
                        </div>
                        <div id="errorReviews" class="message" style="margin-bottom: 15px">
                            <div class="error">
                                <span class="text">Sorry, we can not show more comments at this time</span>
                            </div>
                        </div>
                        <div class="ux-common-comment-more" id='showButtonMoreComments'>
                            <?php if ($hotel->reviewSummary->commentsCount >10){ ?>    
                            <a class="ux-common-comment-more-button" onclick='javascript:showMoreComment(<?php echo $page ?>,"10",<?php echo $hotel->reviewSummary->commentsCount ?>);'>
                                <span class="ux-common-load-btn"></span> <span>See more comments ↓</span>
                                </a>
                            <?php }?>
                           <!--  <p class="ux-common-comment-more-description"><?php echo $hotel->reviewSummary->commentsCount ?> comments </p>   -->
                        </div>  
                           
                </div>
            </div>
                   </a>
                <?php } ?>        
                        
                <!-- ############################################### -->
                <!--                    SERVICES                      -->
                <!-- ############################################### -->

                <a id="facities">
                <div class="ux-hotels-detail-common-module ux-servicies">
                    <h3 class="ux-hotels-detail-common-title">Services of the <?php echo $hotel->name?></h3>
                        <ul class="ux-hotels-detail-common-list">
                        <li>
                            <div class="ux-hotels-detail-common-list-title"> Services</div>
                                <div class="ux-hotels-detail-common-list-description">
                                   <?php $amenities=$hotelAmenities;?>
                                    <?php
                                    $coma = ''; 
                                    foreach($amenities as $a){
                                       echo $coma . $a->description;
                                       $coma = ', '; 
                                     } ?>

                                </div>
                        </li>
                     </ul>
    		    </div>
                </a>
                <a id="booking">
        <div class="ux-hotels-detail-common-module ux-conditions">
            <h3 class="ux-hotels-detail-common-title">Booking conditions of the <?php echo $hotel->name?></h3>
                <ul class="ux-hotels-detail-common-list">
                    <li>
                        <div class="ux-hotels-detail-common-list-title"> Check-In</div>
                        <div class="ux-hotels-detail-common-list-description"><?php echo $hotel->time->checkIn;?>hs</div>
                    </li>
                    <li>
                        <div class="ux-hotels-detail-common-list-title">Check-Out</div>
                        <div class="ux-hotels-detail-common-list-description"><?php echo $hotel->time->checkOut;?>hs</div>
                    </li>
                    <li>
                        <div class="ux-hotels-detail-common-list-title"> Conditions</div>
                        <div class="ux-hotels-detail-common-list-description">Some restrictions apply, see detail in the payment order.</div>
                    </li>
                </ul>
        </div>
                </a>
     </div>
  </div>
 </div>

<?php $view['slots']->stop() ?>
<?php $view['slots']->start('javascripts') ?>
<script type="text/javascript" src="/bundles/btctriphotels/js/hotelUtils.js"></script>
<script type="text/javascript" src="/bundles/btctriphotels/js/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript" src="/bundles/btctriphotels/js/jquery-ui-1.10.4.custom.min.js"></script>
 <script>
     function changeImage(imagen){
        $('#imagen_grande').attr("src","http://media.staticontent.com/media/pictures/"+imagen+"/879x370?truncate=true");
     }

 
    function changeImageDetail(imagen,div_id){
         $('#imagen_'+div_id).attr("src","http://media.staticontent.com/media/pictures/"+imagen+"/270x250??truncate=true");
    }
 
function showMoreComment(page,parcial_comentarios,total_comentarios){
   page=page+1;
   $('#loadingReviews').attr('class',"");
   $.getJSON("<?php echo $enviromentPrefix ?>/hotels/showMoreComments/<?php echo $hotel_id?>/10/"+page+"/"+parcial_comentarios+"/"+total_comentarios, 
    function( data ) {
             lista_comentario=$('#common-comments-list').html();
             lista_comentarios_nuevos=data.data.showMoreComments;
             $('#common-comments-list').html(lista_comentario+lista_comentarios_nuevos);
             $('#showButtonMoreComments').html(data.data.showButtonMoreComments);
             $('#loadingReviews').attr('class',"message");
             
             
    });  
   
   
   
}
    
    
    
    $("#sb-hotels").change(function() {
        if ($("#sb-hotels").val()==1){
             $("#roomdos").attr("class","com-passenger cp-2 hidden");
             $("#labelroomdos").attr("class","lbl-room-2 hidden");
             $("#labelroomuno").attr("class","lbl-room-1 hidden");
             
        }else{
            $("#roomdos").attr("class","com-passenger cp-2");
            $("#labelroomdos").attr("class","lbl-room-2");
            $("#labelroomuno").attr("class","lbl-room-1");
        }
      
});
 $("#child_id_1").change(function() {
        cant=$("#child_id_1").val();
        $("#div_age_1").attr('class',"ctn-age hidden");
        $("#li_age_1_1").attr('class','ctn-selects-age room-1 ctn-1 hidden');
        $("#li_age_1_2").attr('class','ctn-selects-age room-1 ctn-2 hidden');
        $("#li_age_1_3").attr('class','ctn-selects-age room-1 ctn-3 hidden');
        $("#li_age_1_4").attr('class','ctn-selects-age room-1 ctn-4 hidden');
        $("#li_age_1_5").attr('class','ctn-selects-age room-1 ctn-5 hidden');
        for (var i=1;i<=cant;i++){
           $("#div_age_1").attr('class',"ctn-age");
           $("#li_age_1_"+i).attr('class','ctn-selects-age room-'+i+' ctn-'+i);
        }
 });
      
 $("#child_id_2").change(function() {
        cant=$("#child_id_2").val();
        $("#div_age_2").attr('class',"ctn-age hidden");
        $("#li_age_2_1").attr('class','ctn-selects-age room-2 ctn-1 hidden');
        $("#li_age_2_2").attr('class','ctn-selects-age room-2 ctn-2 hidden');
        $("#li_age_2_3").attr('class','ctn-selects-age room-2 ctn-3 hidden');
        $("#li_age_2_4").attr('class','ctn-selects-age room-2 ctn-4 hidden');
        $("#li_age_2_5").attr('class','ctn-selects-age room-2 ctn-5 hidden');
        for (var i=1;i<=cant;i++){
           $("#div_age_2").attr('class',"ctn-age");
           $("#li_age_2_"+i).attr('class','ctn-selects-age room-'+i+' ctn-'+i);
        }
 });

function  cerrar(){
    $("#mapModal").attr('class','modal hide');
}
 <?php if ((!empty($checkinDate)) && (!empty($checkoutDate))){ ?>
 $.getJSON("<?php echo $enviromentPrefix ?>/hotels/searchAvailableHotel/<?php echo $hotel_id?>/<?php echo (!empty($checkinDate))? $checkinDate.'/': '' ?><?php echo (!empty($checkoutDate))? $checkoutDate.'/': '' ?><?php echo $distribution?>", 
    function( data ) {
            $('#div_no_available').html(data.data.textAvailable);
            $('#div_show_available').html(data.data.showAvailable);
            $('#div_rooms_available').html(data.data.roomsAvailable);
            
            changeCurrencyVisibility(amplify.store('preferedCurrency'));
            
    });  
 <?php }else{ ?> 
$('#div_show_available').html("");
 <?php } ?>
  </script>

 
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
		$('#currency').val(amplify.store('preferedCurrency'));
	} 
    
</script> 
 
 
 
 
 
 <?php $view['slots']->stop() ?>