<?php $view->extend('BtcTripMainBundle::layout.html.php') ?>

<?php

$dosDias = 172800;
$sFlightsAnticipationDays = date('Y-m-d', strtotime("now") + $dosDias);

$sHotelsAnticipationDays = date('Y-m-d', strtotime("now"));

?>
<?php $view['slots']->set('bodyClass', '') ?>

<?php $view['slots']->start('stylesheets') ?>

<!-- // scripts // -->
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/jquery-1.11.3.min.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/idangerous.swiper.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/slideInit.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/owl.carousel.min.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/bxSlider.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/jqeury.appear.js') ?>"></script>  
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/custom.select.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/jquery-ui.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/twitterfeed.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/script2.js') ?>"></script>
<!-- \\ scripts \\ --> 
 

<script type="text/javascript"	src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/ajax-coin-slider.js') ?>"> </script>
<script type="text/javascript"	src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/extjs.js') ?>"></script>
<link type="text/css" rel="stylesheet"	href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/home.css') ?>" />
<!--searchbox-css-->
<link type="text/css" rel="stylesheet"	href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/fl-big.css') ?>" />
<!--searchbox-css END-->
<link type="text/css" rel="stylesheet"	href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/ajax-coin-slider-styles.css') ?>" />
<link type="text/css" rel="stylesheet"	href="<?php echo $view['assets']->getUrl('bundles/btctriphotels/css/hotels-big.css') ?>" />

<!-- TODO - Estilo para el autocomplete  - Cambiarlo parecido al de despegar  -->
<link type="text/css" rel="stylesheet"	href="<?php echo $view['assets']->getUrl('/bundles/btctriphotels/css/jquery-ui.css') ?>" />



<?php $view['slots']->stop() ?>


<?php $view['slots']->start('mainContent') ?>

<!-- main-cont -->
<div class="main-cont">
<div class="">
	<div class="mp-slider">
		<!-- // slider // -->
		<div class="mp-slider-row">
			<div class="swiper-container">
			    <div class="swiper-preloader-bg"></div>
			    <div id="preloader">
			    	<div id="spinner"></div>
			    </div>
			    
				<a href="#" class="arrow-left"></a>
				<a href="#" class="arrow-right"></a>
				<div class="swiper-pagination"></div>
  				<div class="swiper-wrapper">  				
                    <div class="swiper-slide"> 
						<div class="slide-section" style="background:url('bundles/btctrip/images/LUGARES01.png') center top no-repeat;">
							<div class="mp-slider-lbl">Great journey begins with a small step</div>
							<div class="mp-slider-lbl-a">Make Your Life Better and Bright!  You must trip with Us!</div>
							<div class="mp-slider-btn"><a href="#" class="btn-a">Learn more</a></div>
						</div>
					</div>
                    <div class="swiper-slide"> 
						<div class="slide-section  slide-b" style="background:url('bundles/btctrip/images/LUGARES02.png') center top no-repeat;">
							<div class="mp-slider-lbl">Great journey begins with a small step</div>
							<div class="mp-slider-lbl-a">Make Your Life Better and Bright!  You must trip with Us!</div>
							<div class="mp-slider-btn"><a href="#" class="btn-a">Learn more</a></div>
						</div>      
      				</div>
      				<div class="swiper-slide"> 
						<div class="slide-section slide-b" style="background:url('bundles/btctrip/images/LUGARES03.png') center top no-repeat;">
							<div class="mp-slider-lbl">Relax with us. we love our clients</div>
							<div class="mp-slider-lbl-a">Make Your Life Better and Bright!  You must trip with Us!</div>
							<div class="mp-slider-btn"><a href="#" class="btn-a">Learn more</a></div>
						</div>      
      				</div>
      				<div class="swiper-slide"> 
						<div class="slide-section slide-b" style="background:url('bundles/btctrip/images/LUGARES04.png') center top no-repeat;">
							<div class="mp-slider-lbl">Planning trip with your friends</div>
							<div class="mp-slider-lbl-a">Make Your Life Better and Bright!  You must trip with Us!</div>
							<div class="mp-slider-btn"><a href="#" class="btn-a">Learn more</a></div>
						</div>      
      				  
      				</div>
 				
  				</div>
			</div>
		</div>
		<!-- \\ slider \\ -->
	</div>	
	
	<div class="wrapper-a-holder">
	<div class="wrapper-a">
	
		<!-- // search // -->
			<!-- // tab content tickets // -->

				<div class="span4 searchbg">

	<ul class="tab-links">
		<li class="active"><a href="#tab1">Flights</a></li>
		<li><a href="#tab2">Hotels</a></li>
	</ul>

	<div class="tabs">
		<div id="tab1" class="searchform tab active">

			<form class="searchbox" autocomplete="off">
				<script type="text/html" id="autocomplete-tpl">
		<div class="com-autocomplete">
		<ul>
		</ul>
		<p class="msg-blank">Cities not found matching the search criteria: <span></span></p>
		<p class="msg-error">We are improving the search system. Try again later.</p>
		<p class="msg-empty">Input at least the 3 first letters and wait for the results.</p>
		<p class="msg-loading">Searchin <span></span></p>
		<p class="msg-max-chars">The search exceed the allowed limit.</p>
		</div>
		</script>
				<div class="pdt-flights fh">
					<!-- <h2 class="producttitle">Search flights</h2> -->
					<div class="ctn-roundtrip">
						<div class="mod-places">
							<div class="com-city origin">
								<label for="sb-origin-flights" id="lbl-origin-flights">From</label>
								<input type="text" class="sb-origin" id="sb-origin-flights"
									placeholder="Input origin city" />
								<p class="error error-empty hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input a origin city.</span>
								</p>
								<p class="error error-badcity hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input an valid origin city.</span>
								</p>
							</div>
							<div class="com-city destination">
								<label for="sb-destination-flights" id="lbl-destination-flights">To</label>
								<input type="text" class="sb-destination"
									id="sb-destination-flights"
									placeholder="Input destination city" />
								<p class="error error-empty hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input a destination city.</span>
								</p>
								<p class="error error-badcity hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input a valid destination city.</span>
								</p>
							</div>
							<p class="error repeatedCity hidden">
								<span class="commonSprite errorCrossIcon"></span><span
									class="errortext">The destination must be different of the origin.</span>
							</p>
						</div>
						<div class="mod-dates">
							<div class="com-datein">
								<label for="sb-datein-flights" id="lbl-datein-flights">Depart</label>
								<input type="text" class="sb-datein" id="sb-datein-flights"
									placeholder="dd/mm/yyyy" maxlength=10 /> <span
									class="commonSprite buttonCalendarOn"></span>
							</div>
							<div class="com-dateout">
								<label for="sb-dateout-flights" id="lbl-dateout-flights">Return</label>
								<input type="text" class="sb-dateout" id="sb-dateout-flights"
									placeholder="dd/mm/yyyy" maxlength=10 /> <span
									class="commonSprite buttonCalendarOn"></span>
							</div>
							<p class="error error-emptyIn hidden">
								<span class="commonSprite errorCrossIcon"></span><span
									class="errortext">Please, input a departure date.</span>
							</p>
							<p class="error error-emptyOut hidden">
								<span class="commonSprite errorCrossIcon"></span><span
									class="errortext">Please, input a return date.</span>
							</p>
							<p class="error error-dateIn hidden">
								<span class="commonSprite errorCrossIcon"></span><span
									class="errortext">Please, input a valid departure date.</span>
							</p>
							<p class="error error-dateOut hidden">
								<span class="commonSprite errorCrossIcon"></span><span
									class="errortext">Please, input a valid return date. </span>
							</p>
							<p class="error error-stayIn hidden">
								<span class="commonSprite errorCrossIcon"></span><span
									class="errortext">The departure date is out of the permited
									range.</span>
							</p>
							<p class="error error-stayOut hidden">
								<span class="commonSprite errorCrossIcon"></span><span
									class="errortext">The return date is out of the permited
									range.</span>
							</p>
							<p class="error error-range hidden">
								<span class="commonSprite errorCrossIcon"></span><span
									class="errortext">The return date must be later than the
									departure date</span>
							</p>
							<p class="error error-maxDays hidden">
								<span class="commonSprite errorCrossIcon"></span><span
									class="errortext">The stay should be less than 30 days.</span>
							</p>
							<p class="error error-sameDate hidden">
								<span class="commonSprite errorCrossIcon"></span><span
									class="errortext">The return date must be later than the
									departure date.</span>
							</p>
							<p class="error error-checkDate hidden">
								<span class="commonSprite errorCrossIcon"></span><span
									class="errortext">Your check-in and check-out at the hotel must
									be between the departure and return dates of your flight.</span>
							</p>
						</div>
					</div>
					<div class="ctn-multipledestination hidden">
						<div class="segment-1 ">
							<div class="com-deletesegment">Remove Leg</div>
							<p class="segmenttitle">Leg 1</p>
							<div class="mod-places">
								<div class="com-city origin">
									<label for="sb-origin-1-flights" id="lbl-origin-1-flights">Origin</label>
									<input type="text" class="sb-origin" id="sb-origin-1-flights"
										placeholder="Ingrese una ciudad de origen" />
									<p class="error error-empty hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input origin</span>
									</p>
									<p class="error error-badcity hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input a valid origin</span>
									</p>
								</div>
								<div class="com-city destination">
									<label for="sb-destination-1-flights"
										id="lbl-destination-1-flights">Destination</label> <input
										type="text" class="sb-destination"
										id="sb-destination-1-flights"
										placeholder="Ingrese una ciudad de destino" />
									<p class="error error-empty hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input destination.</span>
									</p>
									<p class="error error-badcity hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input a valid destination</span>
									</p>
								</div>
								<p class="error repeatedCity hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Origin and destination can't be same</span>
								</p>
							</div>
							<div class="mod-dates">
								<div class="com-datein">
									<label for="sb-datein-1-flights" id="lbl-datein-1-flights">Departure</label>
									<input type="text" class="sb-datein" id="sb-datein-1-flights"
										placeholder=dd/mm/aaaa maxlength=10 /> <span
										class="commonSprite buttonCalendarOn"></span>
								</div>
								<p class="error error-dateIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input a valid departure date</span>
								</p>
								<p class="error error-range hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Return date has to be after departure.</span>
								</p>
								<p class="error error-emptyIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input departure date.</span>
								</p>
								<p class="error error-stayIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">The date is outside of allowed range</span>
								</p>
							</div>
						</div>
						<div class="segment-2 ">
							<div class="com-deletesegment">Remove Leg</div>
							<p class="segmenttitle">Leg 2</p>
							<div class="mod-places">
								<div class="com-city origin">
									<label for="sb-origin-2-flights" id="lbl-origin-2-flights">Origin</label>
									<input type="text" class="sb-origin" id="sb-origin-2-flights"
										placeholder="Ingrese una ciudad de origen" />
									<p class="error error-empty hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input origin</span>
									</p>
									<p class="error error-badcity hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input a valid origin</span>
									</p>
								</div>
								<div class="com-city destination">
									<label for="sb-destination-2-flights"
										id="lbl-destination-2-flights">Destination</label> <input
										type="text" class="sb-destination"
										id="sb-destination-2-flights"
										placeholder="Ingrese una ciudad de destino" />
									<p class="error error-empty hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input destination.</span>
									</p>
									<p class="error error-badcity hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input a valid destination</span>
									</p>
								</div>
								<p class="error repeatedCity hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Origin and destination can't be same</span>
								</p>
							</div>
							<div class="mod-dates">
								<div class="com-datein">
									<label for="sb-datein-2-flights" id="lbl-datein-2-flights">Departure</label>
									<input type="text" class="sb-datein" id="sb-datein-2-flights"
										placeholder=dd/mm/aaaa maxlength=10 /> <span
										class="commonSprite buttonCalendarOn"></span>
								</div>
								<p class="error error-dateIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input a valid departure date</span>
								</p>
								<p class="error error-range hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Return date has to be after departure.</span>
								</p>
								<p class="error error-emptyIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input departure date.</span>
								</p>
								<p class="error error-stayIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">The date is outside of allowed range</span>
								</p>
							</div>
						</div>
						<div class="segment-3 hidden">
							<div class="com-deletesegment">Remove Leg</div>
							<p class="segmenttitle">Leg 3</p>
							<div class="mod-places">
								<div class="com-city origin">
									<label for="sb-origin-3-flights" id="lbl-origin-3-flights">Origin</label>
									<input type="text" class="sb-origin" id="sb-origin-3-flights"
										placeholder="Ingrese una ciudad de origen" />
									<p class="error error-empty hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input origin</span>
									</p>
									<p class="error error-badcity hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input a valid origin</span>
									</p>
								</div>
								<div class="com-city destination">
									<label for="sb-destination-3-flights"
										id="lbl-destination-3-flights">Destination</label> <input
										type="text" class="sb-destination"
										id="sb-destination-3-flights"
										placeholder="Ingrese una ciudad de destino" />
									<p class="error error-empty hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input destination.</span>
									</p>
									<p class="error error-badcity hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input a valid destination</span>
									</p>
								</div>
								<p class="error repeatedCity hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Origin and destination can't be same</span>
								</p>
							</div>
							<div class="mod-dates">
								<div class="com-datein">
									<label for="sb-datein-3-flights" id="lbl-datein-3-flights">Departure</label>
									<input type="text" class="sb-datein" id="sb-datein-3-flights"
										placeholder=dd/mm/aaaa maxlength=10 /> <span
										class="commonSprite buttonCalendarOn"></span>
								</div>
								<p class="error error-dateIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input a valid departure date</span>
								</p>
								<p class="error error-range hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Return date has to be after departure.</span>
								</p>
								<p class="error error-emptyIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input departure date.</span>
								</p>
								<p class="error error-stayIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">The date is outside of allowed range</span>
								</p>
							</div>
						</div>
						<div class="segment-4 hidden">
							<div class="com-deletesegment">Remove Leg</div>
							<p class="segmenttitle">Leg 4</p>
							<div class="mod-places">
								<div class="com-city origin">
									<label for="sb-origin-4-flights" id="lbl-origin-4-flights">Origin</label>
									<input type="text" class="sb-origin" id="sb-origin-4-flights"
										placeholder="Ingrese una ciudad de origen" />
									<p class="error error-empty hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input origin</span>
									</p>
									<p class="error error-badcity hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input a valid origin</span>
									</p>
								</div>
								<div class="com-city destination">
									<label for="sb-destination-4-flights"
										id="lbl-destination-4-flights">Destination</label> <input
										type="text" class="sb-destination"
										id="sb-destination-4-flights"
										placeholder="Ingrese una ciudad de destino" />
									<p class="error error-empty hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input destination.</span>
									</p>
									<p class="error error-badcity hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input a valid destination</span>
									</p>
								</div>
								<p class="error repeatedCity hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Origin and destination can't be same</span>
								</p>
							</div>
							<div class="mod-dates">
								<div class="com-datein">
									<label for="sb-datein-4-flights" id="lbl-datein-4-flights">Departure</label>
									<input type="text" class="sb-datein" id="sb-datein-4-flights"
										placeholder=dd/mm/aaaa maxlength=10 /> <span
										class="commonSprite buttonCalendarOn"></span>
								</div>
								<p class="error error-dateIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input a valid departure date</span>
								</p>
								<p class="error error-range hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Return date has to be after departure.</span>
								</p>
								<p class="error error-emptyIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input departure date.</span>
								</p>
								<p class="error error-stayIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">The date is outside of allowed range</span>
								</p>
							</div>
						</div>
						<div class="segment-5 hidden">
							<div class="com-deletesegment">Remove Leg</div>
							<p class="segmenttitle">Leg 5</p>
							<div class="mod-places">
								<div class="com-city origin">
									<label for="sb-origin-5-flights" id="lbl-origin-5-flights">Origin</label>
									<input type="text" class="sb-origin" id="sb-origin-5-flights"
										placeholder="Ingrese una ciudad de origen" />
									<p class="error error-empty hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input origin</span>
									</p>
									<p class="error error-badcity hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input a valid origin</span>
									</p>
								</div>
								<div class="com-city destination">
									<label for="sb-destination-5-flights"
										id="lbl-destination-5-flights">Destination</label> <input
										type="text" class="sb-destination"
										id="sb-destination-5-flights"
										placeholder="Ingrese una ciudad de destino" />
									<p class="error error-empty hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input destination.</span>
									</p>
									<p class="error error-badcity hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input a valid destination</span>
									</p>
								</div>
								<p class="error repeatedCity hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Origin and destination can't be same</span>
								</p>
							</div>
							<div class="mod-dates">
								<div class="com-datein">
									<label for="sb-datein-5-flights" id="lbl-datein-5-flights">Departure</label>
									<input type="text" class="sb-datein" id="sb-datein-5-flights"
										placeholder=dd/mm/aaaa maxlength=10 /> <span
										class="commonSprite buttonCalendarOn"></span>
								</div>
								<p class="error error-dateIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input a valid departure date</span>
								</p>
								<p class="error error-range hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Return date has to be after departure.</span>
								</p>
								<p class="error error-emptyIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input departure date.</span>
								</p>
								<p class="error error-stayIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">The date is outside of allowed range</span>
								</p>
							</div>
						</div>
						<div class="segment-6 hidden">
							<div class="com-deletesegment">Remove Leg</div>
							<p class="segmenttitle">Leg 6</p>
							<div class="mod-places">
								<div class="com-city origin">
									<label for="sb-origin-6-flights" id="lbl-origin-6-flights">Origin</label>
									<input type="text" class="sb-origin" id="sb-origin-6-flights"
										placeholder="Ingrese una ciudad de origen" />
									<p class="error error-empty hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input origin</span>
									</p>
									<p class="error error-badcity hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input a valid origin</span>
									</p>
								</div>
								<div class="com-city destination">
									<label for="sb-destination-6-flights"
										id="lbl-destination-6-flights">Destination</label> <input
										type="text" class="sb-destination"
										id="sb-destination-6-flights"
										placeholder="Ingrese una ciudad de destino" />
									<p class="error error-empty hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input destination.</span>
									</p>
									<p class="error error-badcity hidden">
										<span class="commonSprite errorCrossIcon"></span><span
											class="errortext">Please, input a valid destination</span>
									</p>
								</div>
								<p class="error repeatedCity hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Origin and destination can't be same</span>
								</p>
							</div>
							<div class="mod-dates">
								<div class="com-datein">
									<label for="sb-datein-6-flights" id="lbl-datein-6-flights">Departure</label>
									<input type="text" class="sb-datein" id="sb-datein-6-flights"
										placeholder=dd/mm/aaaa maxlength=10 /> <span
										class="commonSprite buttonCalendarOn"></span>
								</div>
								<p class="error error-dateIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input a valid departure date</span>
								</p>
								<p class="error error-range hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Return date has to be after departure.</span>
								</p>
								<p class="error error-emptyIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">Please, input departure date.</span>
								</p>
								<p class="error error-stayIn hidden">
									<span class="commonSprite errorCrossIcon"></span><span
										class="errortext">The date is outside of allowed range</span>
								</p>
							</div>
						</div>
						<div class="mod-addsegment-flights">
							<div class="com-addsegmentlink-flights">
								<span class="more-sign">+</span> Add Leg
							</div>
						</div>
					</div>
					<div class="mod-passengers-flights">
						<div class="ctn-passengers">
							<div class="com-adults-flights">
								<label> 12+ years</label> <select id="sb-adults-flights"
									class="sb-adults-flights">
									<option value="1" selected="selected">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
								</select>
							</div>
							<div class="com-childrens-flights">
								<label>under 12</label> <select id="sb-childrens-flights">
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
								</select>
							</div>
							<div class="com-infants-flights">
								<label>under 2</label> <select id="sb-infants-flights">
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
								</select>
							</div>

						</div>

						<p class="error error-infantsqty hidden">
							<span class="commonSprite errorCrossIcon"></span><span
								class="errortext">No more babies than adults</span>
						</p>
					</div>

					<div class="mod-searchbutton">

						<div class="com-oneway">
							<input id="sb-oneway" class="sb-oneway" type="checkbox"
								name="oneway" value="oneway"> <label id="lbl-oneway"
								class="lbl-oneway" for="sb-oneway">One way</label>
						</div>

						<div class="com-searchbutton">
							<a class=" ctn-searchbutton"> <input type="image"
								src="/bundles/btctrip/images/searchbtn.gif">
							</a>
						</div>

					</div>

				</div>
			</form>
		</div>

		<div id="tab2" class="searchform tab">
		<?php echo $view->render('BtcTripHotelsBundle:CoreHotels:formHotel.html.php', array('showTitle' => false)) ?>
	</div>

	</div>

</div>
			
	</div>
	</div>
     <!-- // testimonials // -->
    <div class="clear"></div>	
    <div class="testimonials">
    
      <div class="testimonials-lbl fly-in">what our clients say</div>
      <div class="testimonials-lbl-a fly-in"></div>  
      
      <div class="testimonials-holder fly-in">
      	<div id="testimonials-slider">
      	<!-- // -->
      	<div class="testimonials-i">
        	<div class="testimonials-a"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/charlie-shrem.png') ?>" /></div>
        	<div class="testimonials-b">"BtcTrip is Amazing!" Charlie Shrem</div>
        	<div class="testimonials-c">
          	<nav>
            	<ul>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
            	</ul>
          	</nav>
        	</div>
        	<div class="testimonials-d">CEO of Bitinstant</div>
      	</div>
      	<!-- // -->
      	<div class="testimonials-i">
        	<div class="testimonials-a"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/erik-voorhees.png') ?>" /></div>
        	<div class="testimonials-b">"Thanks for the great service!" Erik Voorhees</div>
        	<div class="testimonials-c">
          	<nav>
            	<ul>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
            	</ul>
          	</nav>
        	</div>
        	<div class="testimonials-d">SatoshiDice Founder - CEO of Coinapult</div>
      	</div>      	
      	<!-- // -->
      	<div class="testimonials-i">
        	<div class="testimonials-a"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/jon-matonis.png') ?>" /></div>
        	<div class="testimonials-b">"I'm liking this service more and more" Jon Matonis </div>
        	<div class="testimonials-c">
          	<nav>
            	<ul>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
            	</ul>
          	</nav>
        	</div>
        	<div class="testimonials-d">Executive Director at Bitcoin Foundation</div>
      	</div>
      	<!-- // -->
      	<!-- // -->
      	<div class="testimonials-i">
        	<div class="testimonials-a"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/nicolas-carry.png') ?>" /></div>
        	<div class="testimonials-b">"Amazing customer service always rules the day" Nicolas Cary</div>
        	<div class="testimonials-c">
          	<nav>
            	<ul>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
            	</ul>
          	</nav>
        	</div>
        	<div class="testimonials-d">CEO of Blockchain.info</div>
      	</div>      	
      	<!-- // -->
      	<!-- // -->
      	<div class="testimonials-i">
        	<div class="testimonials-a"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/roger-ver2.png') ?>" /></div>
        	<div class="testimonials-b">"I love the service that they are providing to the Bitcoin community." Roger Ver</div>
        	<div class="testimonials-c">
          	<nav>
            	<ul>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
            	</ul>
          	</nav>
        	</div>
        	<div class="testimonials-d">Bitcoin Investor</div>
      	</div>      	
      	<!-- // -->
      	<!-- // -->
      	<div class="testimonials-i">
        	<div class="testimonials-a"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/tuur-demeester.png') ?>" /></div>
        	<div class="testimonials-b">"BTCTrip is quick, effortless, and allows me to use the best money in the world" Tuur Demeester</div>
        	<div class="testimonials-c">
          	<nav>
            	<ul>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
            	</ul>
          	</nav>
        	</div>
        	<div class="testimonials-d">BTCTRIP customer</div>
      	</div>      	
      	<!-- // -->
      	<!-- // -->
      	<div class="testimonials-i">
        	<div class="testimonials-a"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/amir-taaki.png') ?>" /></div>
        	<div class="testimonials-b">"I think BtcTrip is amazing." Amir Taaki</div>
        	<div class="testimonials-c">
          	<nav>
            	<ul>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
            	</ul>
          	</nav>
        	</div>
        	<div class="testimonials-d">Bitcoin developer</div>
      	</div>      	
      	<!-- // -->      	
      	</div>
      </div>
      
    </div>   		
	<div class="mp-offesr">
		<div class="wrapper-padding-a">
			<div class="offer-slider">
				<header class="fly-in page-lbl">
					<div class="offer-slider-lbl">Offers</div>
					<p>Special Discount in Business Class paying with BITCOINS.</p>
				</header>
				
				<div class="fly-in offer-slider-c">
					<div id="offers" class="owl-slider">
					<!-- // -->
						<div class="offer-slider-i">
							<a class="offer-slider-img" href="#">
								<img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/slide-01a.png') ?>" />
								<span class="offer-slider-overlay">
									<span class="offer-slider-btn">view details</span>
								</span>
							</a>
							<div class="offer-slider-txt">
								<div class="offer-slider-link"><a href="#">Teshima Art Museum</a></div>
								<div class="offer-slider-l">
									<div class="offer-slider-location">Location: Japan </div>
									<nav class="stars">
										<ul>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-a.png') ?>"/></a></li>
										</ul>
										<div class="clear"></div>
									</nav>
								</div>
								<div class="offer-slider-r">
									<b>756$</b>
									<span>avg/night</span>
								</div>
								<div class="offer-slider-devider"></div>								
								<div class="clear"></div>
							</div>
						</div>
					<!-- \\ -->
					<!-- // -->
						<div class="offer-slider-i">
							<a class="offer-slider-img" href="#">
								<img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/slide-01b.png') ?>" />
								<span class="offer-slider-overlay">
									<span class="offer-slider-btn">view details</span>
								</span>
							</a>
							<div class="offer-slider-txt">
								<div class="offer-slider-link"><a href="#">Rio de Janeiro</a></div>
								<div class="offer-slider-l">
									<div class="offer-slider-location">location: Brazil</div>
									<nav class="stars">
										<ul>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-a.png') ?>"/></a></li>
										</ul>
										<div class="clear"></div>
									</nav>
								</div>
								<div class="offer-slider-r">
									<b>900$</b>
									<span>avg/night</span>
								</div>
								<div class="offer-slider-devider"></div>								
								<div class="clear"></div>
							</div>
						</div>
					<!-- \\ -->
					<!-- // -->
						<div class="offer-slider-i">
							<a class="offer-slider-img" href="#">
								<img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/slide-01c.png') ?>" />
								<span class="offer-slider-overlay">
									<span class="offer-slider-btn">view details</span>
								</span>
							</a>
							<div class="offer-slider-txt">
								<div class="offer-slider-link"><a href="#">Fashion Week</a></div>
								<div class="offer-slider-l">
									<div class="offer-slider-location">location: USA</div>
									<nav class="stars">
										<ul>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-a.png') ?>"/></a></li>
										</ul>
										<div class="clear"></div>
									</nav>
								</div>
								<div class="offer-slider-r">
									<b>900$</b>
									<span>avg/night</span>
								</div>
								<div class="offer-slider-devider"></div>								
								<div class="clear"></div>
							</div>
						</div>
                        <!-- // -->
						<div class="offer-slider-i">
							<a class="offer-slider-img" href="#">
								<img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/slide-01d.png') ?>" />
								<span class="offer-slider-overlay">
									<span class="offer-slider-btn">view details</span>
								</span>
							</a>
							<div class="offer-slider-txt">
								<div class="offer-slider-link"><a href="#">Wanderlust Yoga Festival</a></div>
								<div class="offer-slider-l">
									<div class="offer-slider-location">location: USA</div>
									<nav class="stars">
										<ul>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-a.png') ?>"/></a></li>
										</ul>
										<div class="clear"></div>
									</nav>
								</div>
								<div class="offer-slider-r">
									<b>900$</b>
									<span>avg/night</span>
								</div>
								<div class="offer-slider-devider"></div>								
								<div class="clear"></div>
							</div>
						</div>
                         <!-- // -->
						<div class="offer-slider-i">
							<a class="offer-slider-img" href="#">
								<img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/slide-01e.png') ?>" />
								<span class="offer-slider-overlay">
									<span class="offer-slider-btn">view details</span>
								</span>
							</a>
							<div class="offer-slider-txt">
								<div class="offer-slider-link"><a href="#">Burning Man</a></div>
								<div class="offer-slider-l">
									<div class="offer-slider-location">location: USA</div>
									<nav class="stars">
										<ul>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-a.png') ?>"/></a></li>
										</ul>
										<div class="clear"></div>
									</nav>
								</div>
								<div class="offer-slider-r">
									<b>900$</b>
									<span>avg/night</span>
								</div>
								<div class="offer-slider-devider"></div>								
								<div class="clear"></div>
							</div>
						</div>						
                        <!-- // -->
						<div class="offer-slider-i">
							<a class="offer-slider-img" href="#">
								<img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/slide-01f.png') ?>" />
								<span class="offer-slider-overlay">
									<span class="offer-slider-btn">view details</span>
								</span>
							</a>
							<div class="offer-slider-txt">
								<div class="offer-slider-link"><a href="#">The Great Wall</a></div>
								<div class="offer-slider-l">
									<div class="offer-slider-location">location: China</div>
									<nav class="stars">
										<ul>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-a.png') ?>"/></a></li>
										</ul>
										<div class="clear"></div>
									</nav>
								</div>
								<div class="offer-slider-r">
									<b>900$</b>
									<span>avg/night</span>
								</div>
								<div class="offer-slider-devider"></div>								
								<div class="clear"></div>
							</div>
						</div>						
					<!-- // -->
					
					<!-- \\ -->
					</div>
				</div>
			</div>

			
					</div>
				</div>
			</div>
		</div>
	</div>

		<div class="mp-b">
			<div class="wrapper-padding">
				<div class="fly-in mp-b-left">
					<div class="mp-b-lbl">choose hotel by region</div>
					<!-- // regions // -->
						<div class="regions">
							<div class="regions-holder">
								<map id="imgmap201410281607" name="imgmap201410281607">
								<!--img alt="" usemap="#imgmap201410281607" width="347" height="177" src="img/world.png" id="imgmap201410281607">
									<area id="africa" shape="poly" alt="africa" title="" coords="183,153,173,129,176,115,170,107,163,97,145,98,138,85,141,75,149,63,161,58,169,57,173,56,172,61,182,65,185,62,199,65,204,77,211,89,212,92,222,92,221,96,210,110,207,117,221,125,217,141,203,138,192,152" href="" />
									<area id="asia" shape="poly" alt="asia" title="" coords="256,96,259,93,260,83,269,76,277,86,281,96,278,102,289,116,304,111,309,99,295,87,306,70,312,58,311,47,316,39,308,33,306,27,319,29,329,40,331,28,340,20,336,15,311,14,289,11,282,10,280,12,258,10,250,4,236,8,227,12,218,11,223,16,225,23,220,37,222,43,217,45,221,49,221,56,201,58,199,63,202,70,208,79,214,89,225,86,233,77,236,72,247,79" href="" />
									<area id="europe" shape="poly" alt="europe" title="" coords="191,56,177,55,170,46,157,56,149,54,157,38,171,31,168,20,183,11,197,14,220,16,220,32,218,42,213,47,219,55" href="" />
									<area id="austalia" shape="poly" alt="australia" title="" coords="302,155,315,150,322,153,327,162,335,161,342,154,342,108,328,103,321,110,326,119,313,128,297,138,296,151" href="" />
									<area id="north-america" shape="poly" alt="north_america" title="" coords="58,94,55,84,52,79,52,75,42,68,56,67,61,75,66,72,65,61,82,49,90,46,100,42,102,36,102,29,99,21,111,15,115,28,131,18,140,17,156,2,154,0,96,1,90,3,88,9,74,11,66,8,53,8,50,12,35,13,28,10,5,15,0,18,1,32,13,28,22,31,21,42,14,53,18,68,25,76,31,84,40,89" href="" />
									<area id="south-america" shape="poly" alt="south_america" title="" coords="62,102,68,89,81,92,99,101,99,106,105,109,118,113,117,122,113,126,110,140,103,143,97,156,88,165,75,169,71,137,70,131,56,121,54,113,56,106" href="" /-->
								</map>						
								<div class="asia"></div>
								<div class="africa"></div>
								<div class="austalia"></div>
								<div class="europe"></div>
								<div class="north-america"></div>
								<div class="south-america"></div>
							</div>
						</div>
					<!-- // regions // -->
					<nav class="regions-nav">
						<ul>
							<li><a class="europe" href="#">Europe</a></li>
							<li><a class="asia" href="#">Asia</a></li>
							<li><a class="north-america" href="#">North america</a></li>
							<li><a class="south-america" href="#">south america</a></li>
							<li><a class="africa" href="#">africa</a></li>
							<li><a class="austalia" href="#">australia</a></li>		
						</ul>
					</nav>
				</div>
				<div class="fly-in mp-b-right">
					<div class="mp-b-lbl">reasons to book with us</div>
					<div class="reasons-item-a">
						<div class="reasons-lbl">Why?</div>
						<div class="reasons-txt">No intermediaries, we deal directly with hotels & transporters </div>
					</div>
					<div class="reasons-item-b">
						<div class="reasons-lbl">Best </div>
						<div class="reasons-txt">Outstanding customer service and customer satisfaction </div>
					</div>
					<div class="clear"></div>
					<div class="reasons-item-c">
						<div class="reasons-lbl">Difference</div>
						<div class="reasons-txt">Experience </div>
					</div>
					<div class="reasons-item-d">
						<div class="reasons-lbl"> Where?</div>
						<div class="reasons-txt">Choice of best accommodation available </div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	
	</div>

</div>


<?php $view['slots']->stop() ?>

<?php $view['slots']->start('secondContent') ?>



<?php $view['slots']->stop()?>

<?php $view['slots']->start('javascripts')?>

<?php $view['slots']->stop() ?>


