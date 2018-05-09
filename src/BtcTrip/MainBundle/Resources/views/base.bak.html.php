<!DOCTYPE html>
<!--[if IE 7]> <html class="ie7"> <![endif]-->
<!--[if IE 8]> <html class="ie8"> <![endif]-->
<!--[if IE 9]> <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html> <!--<![endif]-->

	<head>
	    <title><?php $view['slots']->output('title', 'BTCTrip - One for All, All for One!') ?></title>

	    <link rel="icon" type="image/x-icon" href="<?php echo $view['assets']->getUrl('favicon.ico') ?>" /> 
	
	    <meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1">
		<meta name="description" content="Travel and leisure with Bitcoins. The travel agency of the cryptocurrencies communities.">
		
		<meta property="og:title" content="BTCTrip - One for All, All for One!"/>
		<meta property="og:type" content="article"/>
		<meta property="og:url" content="http://btctrip.com"/>
		<meta property="og:site_name" content="Btctrip.com"/>
		<meta property="og:description" content="Travel and leisure with Bitcoins. The travel agency of the cryptocurrencies communities."/>
	
	    <?php $view['slots']->output('layout_stylesheets') ?>
	    
	</head>
	<body class="<?php $view['slots']->output('bodyClass') ?> btctrip es_ar">
		<div class="preloadimages">
			<?php $view['slots']->output('layout_preloadimages') ?>
		</div>	
			
		<div class="container">
		 	<?php $view['slots']->output('layout_body') ?>
	 	
		</div>

   		<?php $view['slots']->output('layout_javascripts') ?>
   		<footer class="footer-a">
	<div class="wrapper-padding">
		<div class="section">
			<div class="footer-lbl">Get In Touch</div>
			<div class="footer-email">E-mail: contacts@btctrip.com</div>

		</div>

		<div class="section">
			<div class="footer-lbl">newsletter sign up</div>
			<div class="footer-subscribe">
				<div class="footer-subscribe-a">
					<input type="text" placeholder="you email" value="" />
				</div>
			</div>
			<button class="footer-subscribe-btn">Sign up</button>
		</div>
	</div>
	<div class="clear"></div>
</footer>
    
<footer class="footer-b">
	<div class="wrapper-padding">
		<div class="footer-left">© Copyright 2017 BTC TRIP. All rights reserved.</div>
		<div class="footer-social">
			<a href="#" class="footer-twitter"></a>
			<a href="#" class="footer-facebook"></a>
			<a href="#" class="footer-vimeo"></a>
			<a href="#" class="footer-pinterest"></a>
			<a href="#" class="footer-instagram"></a>
		</div>
		<div class="clear"></div>
	</div>
</footer>


<script>
	var urlSearchPrefixG = "<?php echo $enviromentPrefix ?>/results";
	var urlShowPrefixHotelsG = "<?php echo $enviromentPrefix ?>/hotels/show";
	var urlSearchPrefixHotelsG = "<?php echo $enviromentPrefix ?>/hotels/result";
</script>

<?php 
$allSliders = array(// '/bundles/btctrip/images/slider/PORT-austria.jpg', 
		// '/bundles/btctrip/images/slider/PORT-boom.jpg',
		'/bundles/btctrip/images/slider/PORT-burning.jpg',
		'/bundles/btctrip/images/slider/PORT-china.jpg',
		'/bundles/btctrip/images/slider/PORT-londonFW.jpg',
		//'/bundles/btctrip/images/slider/PORT-mud.jpg',
		'/bundles/btctrip/images/slider/PORT-munich.jpg',
		'/bundles/btctrip/images/slider/PORT-peru.jpg',
		'/bundles/btctrip/images/slider/PORT-Rio.jpg',
		'/bundles/btctrip/images/slider/PORT-song.jpg',
		'/bundles/btctrip/images/slider/PORT-teshima.jpg',
		'/bundles/btctrip/images/slider/PORT-Vatican.jpg',
		'/bundles/btctrip/images/slider/PORT-wanderlust.jpg',
		'/bundles/btctrip/images/slider/PORT-mexico.jpg');

shuffle($allSliders);

?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#coin-slider').coinslider({ 
			width: 610, height: 347, hoverPause: true, navigation: true, delay: 5000, links: false,
			content: [
			<?php 
				$coma = '';
				foreach ($allSliders as $aSlider) {
					echo $coma . '{ img : \'' . $aSlider . '\' }';
					$coma = ',';
				}
			?>
			] 
		});
	});

	 $('.tab-links a').on('click', function(e)  {
	        var currentAttrValue = $(this).attr('href');
	 
	        // Show/Hide Tabs
	        $('.tabs ' + currentAttrValue).show().siblings().hide();
	 
	        // Change/remove current tab to active
	        $(this).parent('li').addClass('active').siblings().removeClass('active');
	 
	        e.preventDefault();
	    });

</script>

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
"jquery": "core-flights/loaders/jquery",
"handlebars": "core-flights/loaders/handlebars",
"amplify": "core-flights/loaders/amplify",
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
define('options', function() {
	return {
		orderCriteria: 'TOTALFARE',
		orderDirection: 'ASCENDING',
		personalSortId: 'UPA_1',
		initialCurrency: 'USD',
		clusters: {
			searchType: 'ROUNDTRIP',
			initialCurrencyCode: 'USD',
			redirectToCheckout: 'true',
			checkoutHandlerUrl: '<?php echo $enviromentPrefix ?>/checkout/form/{hash}/{version}/{itineraryId}/{clusterIndexTraking}/{provider}/INTERNATIONAL'
		},
		alerts: {
			show: false,
			config: {
				container: "#flights-alerts-popup",
				url: "/subscriptions-ui/subscriptions/price-alert-by-month/add",
				model: {
					origin: {
						code: "",
						description: ""
					},
					destination: {
						code: "",
						description: ""
					},
					currency: [{
						mask: "$",
						code: "ARS"
					}, {
						mask: "U$S",
						code: "USD"
					}]
				},
				outboundDate: "",
				inboundDate: ""
			}
		}
	};
});
define('messages', function() {
	return {
		clusters: {
			itineraries: {
				detailTitle: 'Flight details',
				delaysTitle: 'Flight punctuality stats'
			},
			actions: {
				emailTitle: 'Share a flight by E-Mail',
				paymentsTitle: 'Payment options',
				frequentflyer: {
					pointsPrograms: {
						"AR": 'Aerol√≠neas Plus',
						"LA": 'LANPass',
						"4M": 'LANPass',
						"XL": 'LANPass',
						"4C": 'LANPass',
						"LP": 'LANPass',
						"AA": 'AAdvantage',
						"JJ": 'Fidelidade',
						"G3": 'Smiles',
						"AD": 'TudoAzul',
						"O6": 'Programa Amigo',
						"TP": 'Victoria',
						"DL": 'SkyMiles',
						"UA": 'MileagePlus',
						"CM": 'MileagePlus',
						"AM": 'Club Premier',
						"AV": 'LifeMiles',
						"AC": 'Altitude',
						"TA": 'LifeMiles',
						"EK": 'Skywards'
					},
					units: {
						"MILE": "miles",
						"KILOMETER": "kilometers",
						"POINTS": "points",
						"CREDIT": "credits"
					}
				}
			},
			delays: {
				"LOW": "Minor delays",
				"MEDIUM": "Moderate delays",
				"HIGH": "Major delays"
			},
			ecological: {
				"ecologicalLow": "Preservation level: Low",
				"ecologicalMedium": "Preservation level: Medium",
				"ecologicalHigh": "Preservation level: High"
			}
		},
		filters: {
			priceError: 'Please, make sure minimum is less than maximum.',
			priceMaxError: 'Please, make sure tha maximum value is more than 0',
			resultsPriceError: 'Sorry, we could not find flights within a given price range. Please, try with different options',
			showAll: 'Show all &raquo;',
			showLess: 'Show less &laquo;',
			resultsError: 'Sorry, no flight found.',
			resultsErrorHelp: 'Undo',
			stops: {
				"NONE": "Direct",
				"ONE": "1 Stopover",
				"MORE_THAN_ONE": "2 or more stopovers"
			},
			time: {
				"MORNING": "Morning (06 a 12hs)",
				"AFTERNOON": "Afternoon (12 a 20hs)",
				"NIGHT": "Night (20 a 00hs)",
				"EARLY_MORNING": "Early morning (00 a 06hs)"
			}
		}
	};
});
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
						},
						'flights': {
							'PE, VE, CL': {
								places: Nibbler.Searchbox.js.Searchbox.Module.Places
							},
							'MX': function() {
								return {
									places: this.raffle({
										chance: 50,
										item: Nibbler.Searchbox.js.Searchbox.Module.Places
									}, {
										chance: 50,
										item: Nibbler.Searchbox.js.Searchbox.Module.PlacesOld
									})
								};
							}
						}
					}
				},
				boxes: [{
					init: true,
					box: Nibbler.Searchbox.js.Searchbox.Box.Flights,
					product: 'flights',
					id: 'flights',
					selector: 'div.pdt-flights',
					searcher: Nibbler.Searchbox.js.Searchbox.Searcher.Flights,
					options: {
						dates: {
							availableDays: 330,
							anticipationDays: '<?php echo $sFlightsAnticipationDays; ?>'
						},
						places: {
							autoCompleteType: Nibbler.Autocomplete.js.Autocomplete.Flights,
							autoCompleteCache: 'facet.a.c.e',
							autoCompleteUrl: '<?php echo $enviromentPrefix ?>/autocomplete/find',
							autoCompleteUrlOld: '/Flights.Services/Commons/AutoComplete.svc'
						},
						passengers: {
							maxPassengers: 8
						},
						multiple: {
							availableDays: 330,
							autoCompleteType: Nibbler.Autocomplete.js.Autocomplete.Flights,
							autoCompleteUrl: '<?php echo $enviromentPrefix ?>/autocomplete/find',
							autoCompleteUrlOld: '/Flights.Services/Commons/AutoComplete.svc',
							anticipationDays: '<?php echo $sFlightsAnticipationDays; ?>'
						},
						anticipatedSearch: false,
						store: true
					}
				}, {
					init: true,
					box: Nibbler.Searchbox.js.Searchbox.Box.Hotels,
					product: 'hotels',
					id: 'hotels',
					selector: 'div.pdt-hotels',
					searcher: Nibbler.Searchbox.js.Searchbox.Searcher.Hotels,
					options: {
						dates: {
							availableDays: 330,
							anticipationDays: '<?php echo $sHotelsAnticipationDays; ?>'
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
				flights: {
					dates: {
						dateIn: new Date(),
						dateOut: new Date()
					},
					places: {
						destinationText: '',
						destinationValue: '',
						originText: '',
						originValue: ''
					},
					passengers: {
						adults: 1,
						childs: 0,
						infants: 0
					},
					triptypes: {
						currentType: 'roundTrip'
					}
				}
			});
			_box.init();
		},
		updateOrigin: function(cityCode, cityDescription) {
			_box.notify('flights.places.origin.update', {
				place: cityDescription,
				code: cityCode
			});
		},
		updateDestination: function(cityCode, cityDescription) {
			_box.notify('flights.places.destination.update', {
				place: cityDescription,
				code: cityCode
			});
		}
	};
});
</script>


<script
	src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/home.js') ?>"></script>

<!--searchbox-js-->
	<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/searchboxHelper.js') ?>"></script>
	<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/searchbox.fl.js') ?>"></script>
	<script charset="utf-8" type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/top-airlines-cities-ar.js') ?>"></script>
	<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/autocomplete.js') ?>"></script>
<!--searchbox-js END-->

<script type="text/javascript" src="<?php echo $view['assets']->getUrl('/bundles/btctriphotels/js/jquery-ui.js') ?>"></script>
<!-- Sirve para validar formularios -->
<script type="text/javascript" src="<?php echo $view['assets']->getUrl('/bundles/btctripmain/js/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo $view['assets']->getUrl('/bundles/btctriphotels/js/hotelUtils.js') ?>"></script>



   		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-41639383-1', 'btctrip.com');
		  ga('send', 'pageview');
		
		</script>
		
	</body>
    
</html>
