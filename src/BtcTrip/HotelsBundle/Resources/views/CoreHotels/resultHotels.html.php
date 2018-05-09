<?php $view->extend('BtcTripMainBundle::layout.html.php') ?>


<?php
$sAnticipationDays = date('Y-m-d', strtotime("now"));

$sDepartureDateForSearchBox = date('Y,m,d', strtotime('previous month',strtotime($checkinDate)));
$sReturningDateForSearchBox = date('Y,m,d', strtotime('previous month',strtotime($checkoutDate)));

?>

<?php $view['slots']->set('bodyClass', 'results') ?>


<?php $view['slots']->start('stylesheets') ?>

		<?php foreach ($view['assetic']->stylesheets( 
				array( 'bundles/btctrip/styles/results.css', 
					'@BtcTripHotelsBundle/Resources/public/css/hotels-small.css',
					'@BtcTripHotelsBundle/Resources/public/css/search.css',
					'@BtcTripHotelsBundle/Resources/public/css/resultHotels.css'), array('cssrewrite') 
			) as $url): ?>
    	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $view->escape($url) ?>">
		<?php endforeach; ?>
   
<?php $view['slots']->stop() ?>


<?php $view['slots']->start('mainContent') ?>
          
       
<div class="span3 searchbg" >
    <div class="searchform search">
        	<script type="text/html" id="autocomplete-tpl">
		<div class="com-autocomplete">
		<ul>
		</ul>
		<p class="msg-blank">Cities not found matching the search criteria: <span></span></p>
		<p class="msg-error">We are improving the search system. Try again later.</p>
		<p class="msg-empty">Input at least the 3 first letters and wait for the results.</p>
		<p class="msg-loading">Searching <span></span></p>
		<p class="msg-max-chars">The search exceed the allowed limit.</p>
		</div>
		</script>
        <?php echo $view->render('BtcTripHotelsBundle:CoreHotels:formHotel.html.php', array('showTitle' => true,"checkinDate"=>$checkinDate , "checkoutDate"=>$checkoutDate,'sFromName'=>$sFromName,'distribution'=>$distribution)) ?>   
    </div>
    <div class="filters" id="filters-placeholder" style="display: block;">
    </div>
</div>
        
<div class="span9 omega container-white">  
    <div  id="results-loader"  class="results-loader">
        <div class="span8 searchimagebg loader">
            <div class="row">
                <div class="span4 messagegetting">
                    <span>Getting the best prices for hotels</span>
                </div>
                <div class="span4 detailgetting">
                    <span class="hotelsdetails"> in <?php echo $sFromName ?>, from <?php echo $checkinDate ?> to <?php echo $checkoutDate ?></span>
                </div>
            </div>
            <div class="span8 airlinesearch">
                <div class="searchprogress iterated-text">
           Searching... <br>  <span class="airline iterated-text-description"></span>
                </div>
                </div>
        </div> 
    </div> 
</div>

<?php $view['slots']->stop() ?>


<?php $view['slots']->start('javascripts')?>

<script>
	var urlSearchPrefixG = "<?php echo $enviromentPrefix ?>/results";
	var urlShowPrefixHotelsG = "<?php echo $enviromentPrefix ?>/hotels/show";
	var urlSearchPrefixHotelsG = "<?php echo $enviromentPrefix ?>/hotels/result";
</script>

<script id="popup-template" type="text/x-handlebars-template">
	<div id="{{id}}" class="flights-popup {{id}}">
	<div class="popup-border"></div>
	<div class="popup-container">
	{{#if title}}
	<div class="popup-header"><h4>{{title}}</h4></div>
	{{/if}}
	<div class="popup-content"></div>
	</div>
	{{#unless hideCloseIcon}}
	<span class="popup-close-button popup-close">&times;</span>
	{{/unless}}
	{{#unless noPuntita}}
	<span class="popup-arrow popup-arrow-{{indicatorPosition}}"></span>
	{{/unless}}
	</div>
</script>
	
<div class="results-update" style="display:none;">
	<img class="logo" src="">
	<p>Updating information</p>
	<img class="update-loader" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/loader.gif') ?>">
</div> 


<script>
require.config({
"baseUrl": "<?php echo $view['assets']->getUrl('bundles/btctrip/javascript') ?>",
"shim": {
"handlebars": {
"exports": "Handlebars"
},
"amplify": {
"deps": ["jquery"],
"exports": "amplify"
}
},
"paths": {
"libs.amplify": "<?php echo $view['assets']->getUrl('bundles/btctrip/javascript') ?>/amplify-1.1.0.min",
"libs.handlebars": "<?php echo $view['assets']->getUrl('bundles/btctrip/javascript') ?>/handlebars-1.0.0.beta.6.min",
"libs.jquery": "<?php echo $view['assets']->getUrl('bundles/btctrip/javascript') ?>/jslibs/jquery-1.7.1.min"
}
});
</script>

<script>
define('services', function() {
	return {
		search: '<?php echo $enviromentPrefix ?>/search/roundtrip',
		refine: '<?php echo $enviromentPrefix ?>/refine/ROUNDTRIP/INTERNATIONAL/{hash}/{version}/{filterStrategy}/{orderCriteria}/{orderDirection}/{pageIndex}/{minPrice}/{maxPrice}/{originalCurrencyPrice}/{selectedCurrencyPrice}/{allowedOutboundTimeRanges}/{allowedInboundTimeRanges}/{allowedAirlines}/{allowedStopQuantities}/{allowedOutboundAirports}/{allowedInboundAirports}/{uniqueAirline}/{uniqueHomeAirport}',
		item: '<?php echo $enviromentPrefix ?>/item/ROUNDTRIP/INTERNATIONAL/{hash}/{version}/{itemHash}'
	};
});
</script>


<!--searchbox-js-->
<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/searchboxHelper.js') ?>"></script>
<script type="text/javascript" src="<?php echo $view['assets']->getUrl('/bundles/btctriphotels/js/search.js') ?>"></script>
<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/autocomplete.js') ?>"></script>
<!--searchbox-js END-->



<script>
	    function aplicarFiltro(){
		   parametros='';
		   $("input[type=checkbox]:checked").each(function(){
		        if ($(this).val()!='NA'){
		             parametros=parametros+$(this).attr('name')+'|'+$(this).val()+'||';
		        }
		   });
			valor_ult_param='';
			if (parametros!=''){
				valor_ult_param='/'+parametros;
			}
			$.getJSON( "<?php echo $enviromentPrefix ?>/hotels/resultFacets/<?php echo $hotel_id?>/<?php echo (!empty($checkinDate))? $checkinDate.'/': '' ?><?php echo (!empty($checkoutDate))? $checkoutDate.'/': '' ?><?php echo $distribution?>/1"+valor_ult_param, 
	    	    function( data ) {
			    	$('#filters-placeholder').html(data.data.filters);
			    	$('#results-loader').html(data.data.hotels);
	  		});
	  
		}
	    
    
       function aplicarPaginado(pagina){
		   amplify.publish('doSearch');
		   
		   parametros='';
		   $("input[type=checkbox]:checked").each(function(){
		        if ($(this).val()!='NA'){
		             parametros=parametros+$(this).attr('name')+'|'+$(this).val()+'||';
		        }
		   });
		    valor_ult_param='';
		    if (parametros!=''){
		       valor_ult_param='/'+parametros;
		   }
	   
	   
	      $.getJSON( "<?php echo $enviromentPrefix ?>/hotels/resultFacets/<?php echo $hotel_id?>/<?php echo (!empty($checkinDate))? $checkinDate.'/': '' ?><?php echo (!empty($checkoutDate))? $checkoutDate.'/': '' ?><?php echo $distribution?>/"+pagina+valor_ult_param, 
	    	    function( data ) {
			    	$('#filters-placeholder').html(data.data.filters);
			    	$('#results-loader').html(data.data.hotels);
	    		});
  
		} 
</script>


<script>
define('searchbox', ["amplify"], function() {
	var _box = null;
	return {
		init: function() {
			var box = new Nibbler.Searchbox.js.Searchbox({
				context: $('.searchbox'),
				config: {
					currentDate: new Date( <?php echo time() * 1000; ?> ),
					brand: 0,
					country: 'US',
					locale: 'es'
				},
				activations: {
					'*': {
						'*': {
							'*': {
								places: Nibbler.Searchbox.js.Searchbox.Module.Places
							}
						}
					},
					'0': {
						'*': {
							'*': {
								places: Nibbler.Searchbox.js.Searchbox.Module.Places
							}
						},
						'hotels': {
							'*': {
								places: Nibbler.Searchbox.js.Searchbox.Module.Places
							}
						}
					}
				},
				boxes: [{
					init: true,
					box: Nibbler.Searchbox.js.Searchbox.Box.Hotels,
					product: 'hotels',
					id: 'hotels',
					selector: 'div.pdt-hotels',
					searcher: Nibbler.Searchbox.js.Searchbox.Searcher.Hotels,
					options: {
						dates: {
							availableDays: 330,
							anticipationDays: '<?php echo $sAnticipationDays; ?>',
							disabled: <?php echo (isset($sFromName) && empty($checkinDate) && empty($checkoutDate)) ? 'true' : 'false' ;  ?>
						},
						places: {
							autoCompleteType: Nibbler.Autocomplete.js.Autocomplete.Hotels,
							autoCompleteCache: 'facet.a.c.e',
							autoCompleteUrl: '<?php echo $enviromentPrefix ?>/hotels/autocomplete/find',
							autoCompleteUrlOld: '/Hotels.Services/Commons/AutoComplete.svc'
						},
						passengers: {
							maxPassengers: 8
						},
						anticipatedSearch: false,
						store: true
					}
				}]
			});
			_box = box;
            _box.setBoxOptions({ 
                	hotels : {
                		dates : {
                			dateIn : new Date(<?php echo $sDepartureDateForSearchBox; ?>) 
                			,dateOut : new Date(<?php echo $sReturningDateForSearchBox; ?>)
                			},
            	        places : {
                		    destinationText : "<?php echo $sFromName?>",
                    		destinationValue : "<?php echo $hotel_id?>",
                                
                 }}
            });
			_box.init();
		}
	};
});
</script>

<script>
	typeof jQuery == "undefined" ? define("jquery", ["libs.jquery"], function () {
	    return jQuery
	}) : define("jquery", [], function () {
	    return jQuery
	}), typeof amplify == "undefined" ? define("amplify", ["libs.amplify"], function () {
	    return amplify
	}) : define("amplify", [], function () {
	    return amplify
	}), require(["searchbox"], function (r) {
    	$(function () {
        	r.init()
    	}), define("core-hotels/popup", [ "jquery", "amplify", "handlebars"], function (e, t, n, r) {
    function s(e) {  // "core-flights/utils", "core-flights/tmpl-helpers"
        var t = new i(e);
        return t.showPopup(), t
    }
    function o(e) {
        var t = new i(e);
        return t.togglePopup(), t
    }
    var i = function (n) {
        function d() {
            var e = t(s.elementTrigger),
                n = {
                    left: function () {
                        o.css({
                            top: e.offset().top + e.outerHeight() / 2 - o.outerHeight() / 2,
                            left: e.offset().left - o.outerWidth() - 15
                        }), o.find(".popup-arrow-right").css("top", (o.outerHeight() - 20) / 2 - 10)
                    },
                    right: function () {
                        o.css({
                            top: e.offset().top + e.outerHeight() / 2 - o.outerHeight() / 2,
                            left: e.offset().left + e.outerWidth() + 15
                        }), o.find(".popup-arrow-left").css("top", (o.outerHeight() - 20) / 2 - 10)
                    },
                    top: function () {
                        o.css({
                            top: e.offset().top - o.outerHeight() - 15,
                            left: e.offset().left + e.outerWidth() / 2 - o.width() / 2
                        }), o.find(".popup-arrow-bottom").css("left", (o.outerWidth() - 20) / 2 - 10)
                    },
                    bottom: function () {
                        o.css({
                            top: e.offset().top + e.outerHeight() + 15,
                            left: e.offset().left + e.outerWidth() / 2 - o.width() / 2
                        }), o.find(".popup-arrow-top").css("left", (o.outerWidth() - 20) / 2 - 10)
                    },
                    center: function () {
                        o.css({
                            top: e.offset().top + e.outerHeight() + 10,
                            left: (t("body").width() - o.outerWidth()) / 2
                        }), o.find(".popup-arrow-top").css("left", (o.outerWidth() - 20) / 2 - 20)
                    },
                    fixed: function () {
                        var e = t(window).scrollTop() + (t(window).height() - o.outerHeight()) / 2;
                        e < 0 && (e = 0), o.css({
                            top: e,
                            left: (t("body").width() - o.outerWidth()) / 2
                        }), o.find(".popup-arrow-top").css("left", (o.outerWidth() - 20) / 2 - 10)
                    }
                };
            n[s.position]()
        }
        function m() {
            return o
        }
       
        var i = r.compile(t("#popup-template").html()),
            s = {
                $template: null,
                $data: null,
                $functions: null,
                dynamic: !0,
                $content: null,
                showModal: !1,
                hideCloseIcon: !1,
                dontClosePopup: !0,
                dinamicPosition: !1,
                popupContainer: t("body"),
                movePopup: !0
            };
        s = t.extend(s, n);
        var o = t("#" + s.id),
            u = function () {
                o.length === 0 ? (o = t(i(s)), o.hide(), o.appendTo(s.popupContainer), c(), a()) : o.is(":visible") ? o.stop(!0, !0).fadeOut(50, function () {
                    a()
                }) : a()
            }, a = function () {
                n.showModal && e.showModal(), h(), p(s.dontClosePopup)
            }, f = function () {
                o.data("trigger_left", null), o.data("trigger_top", null), p(!1)
            }, l = function () {
                var e = t(s.elementTrigger).offset().left,
                    n = t(s.elementTrigger).offset().top;
                o.length === 0 || o.data("trigger_left") != e || o.data("trigger_top") != n ? (u(), o.data("trigger_left", e), o.data("trigger_top", n)) : f()
            }, c = function () {
                t(".popup-close-button", o).click(function () {
                    f()
                }), t(document).keyup(function (e) {
                    e.keyCode == 27 && t(".popup-close-button", o).click()
                })
            }, h = function () {
                s.dynamic && t(".popup-content", o).empty();
                if (t(".popup-content", o).children().length === 0) if (s.$template) {
                        var e = r.compile(s.$template.html());
                        t(".popup-content", o).html(e(s.$data))
                    } else t(".popup-content", o).html(s.$content.show())
            }, p = function (t) {
                t ? (s.movePopup && v(s.elementTrigger, s.popupPosition, s.dinamicPosition), o.stop(!0, !0).fadeIn()) : (o.stop(!0, !0).fadeOut(), s.showModal && e.hideModal())
            }, v = function (e, n, r) {
                e !== undefined && (s.elementTrigger = e), n !== undefined && (s.position = n), r !== undefined && (s.dinamicPosition = r);
                var i = t(s.elementTrigger);
                d();
                if (s.dinamicPosition) {
                    var u = i.offset().left + i.outerWidth() / 2,
                        a = u + o.outerWidth() / 2;
                    if (t(window).width() < a) {
                        var f = a - t(window).width();
                        o.css({
                            left: i.offset().left + i.outerWidth() / 2 - o.outerWidth() / 2 - f - 13
                        });
                        var l = a - u + f - 13;
                        t(".popup-arrow", o).css("left", l)
                    }
                }
                t(".flights-popup").css("z-index", 5), o.css("z-index", 6)
            };
        this.showPopup = u, this.hidePopup = f, this.togglePopup = l, this.movePopup = v, this.getPopupElement = m
    };
    return {
        openPopup: s,
        togglePopup: o
    }
       }), define("results/layout", ["jquery", "amplify", "core-flights/utils"], function (e, t, n) {
    function r() {
        t.subscribe("doSearch", function (e) {
            e.result.data.metadata.status.code == "SUCCEEDED_RELAXED" ? l() : c(), i()
        }), t.subscribe("doRefine", function (e, t, n, r) {
            e.result.data.metadata.status.code == "SUCCEEDED_RELAXED" ? l() : c(), a(), p()
        }), t.subscribe("doItem", function (e, t, n) {
            p()
        }), t.subscribe("resultsError", function () {
            i(), s()
        }), t.subscribe("refineError", function (e) {
            e && u(), p()
        }), t.subscribe("refine", function (t, n, r) {
            r.id == "pagination" && e(window).scrollTop(0), h(), d()
        }), t.subscribe("item", function (e, t) {
            h(), d()
        })
    }
    function i() {
        e("#results-loader").hide()
    }
    function s() {
        e("#results-error").show()
    }
    function o() {
        e("#results-error").hide()
    }
    function u() {
        e("#filters-error").show()
    }
    function a() {
        e("#filters-error").hide()
    }
    function f(t, n) {
        var r = e("#results-messages");
        r.find(".message").html(t), r.find(".help").html(n), r.show()
    }
    function l() {
        e("#results-warning").show()
    }
    function c() {
        e(".results-messages").hide()
    }
    function h() {
        var t = e(".results-update"),
            r = e(window),
            i = r.scrollTop() + (r.height() - t.outerHeight()) / 2;
        i < 0 && (i = 0), t.css({
            top: i,
            left: (e("body").width() - t.outerWidth()) / 2
        }).show(), n.showModal()
    }
    function p() {
        n.hideModal(), e(".results-update").hide()
    }
    function d() {
        e(".popUpNew").hide()
    }
    return {
        init: r
    }
})
        })
</script>

<!--searching-animation-js-->
<script type="text/javascript" charset="utf-8" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/searching-animation.js') ?>"></script>
<!--searching-animation-js END-->
<script>
<!--searching-animation-init-->
var options = null;
var optionSearching={
	jsonInit : {
		iteratedText:[{msg:'Searching best price'}],
		delay:900
	},
	customOptions : {
		iteratedText: [
		   	{msg:'Bitcoiners hotels'}
		   	,
			{msg:'Independient hotels'}
			,
			{msg:'Hostels'}
			,
			{msg:'Boutique hotels'}
			,
			{msg:'Luxury hotels'}
		] ,
		delay: Math.floor(454,545)
	}
}
var ChargeOffers= new Nibbler.SearchingAnimation.js.searchingAnimation(optionSearching);
ChargeOffers.init();
<!--searching-animation-init END-->
</script>

<script>
    
 $.getJSON( "<?php echo $enviromentPrefix ?>/hotels/resultFacets/<?php echo $hotel_id?>/<?php echo (!empty($checkinDate))? $checkinDate.'/': '' ?><?php echo (!empty($checkoutDate))? $checkoutDate.'/': '' ?><?php echo $distribution?>/<?php echo $page;?>", 
    	    function( data ) {
		    	$('#filters-placeholder').html(data.data.filters);
		    	$('#results-loader').html(data.data.hotels);
    		});  
</script>

<script type="text/javascript" charset="utf-8" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/popup.js') ?>"></script>

<script type="text/javascript" src="<?php echo $view['assets']->getUrl('/bundles/btctriphotels/js/hotelUtils.js') ?>"></script>
<script>
	if ($('#no-dates-cb').prop('checked')) {
		$('div.com-datein span.buttonCalendarOn').removeClass('buttonCalendarOn');
		$('div.com-dateout span.buttonCalendarOn').removeClass('buttonCalendarOn');
	} 
	
    <?php if (isset($distribution)) {
         $array_distribution = explode("!", $distribution);
         $cantidad_habitacion = count($array_distribution);
    ?>
        armarHabitaciones('<?php echo $cantidad_habitacion ?>');
        armarHuespedes();
   <?php } ?>     
</script>
   
<script>
    
  
</script> 


<?php $view['slots']->stop() ?>