<?php $view->extend('BtcTripSearchBundle::layout.html.php') ?>

<?php

$dosDias = 172800;
$sAnticipationDays = date('Y-m-d', strtotime("now") + $dosDias);

?>
<?php $view['slots']->set('bodyClass', '') ?>

<?php $view['slots']->start('stylesheets') ?>

	<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/ajax-coin-slider.js') ?>"> </script>
	<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/extjs.js') ?>"></script>


		<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/home.css') ?>"/>

		<!--searchbox-css-->
		<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/fl-big.css') ?>"/>
		<!--searchbox-css END-->

		<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/ajax-coin-slider-styles.css') ?>"/>

		
<?php $view['slots']->stop() ?>


<?php $view['slots']->start('mainContent') ?>

<div class="span4 searchbg">
	<div class="searchform">
		
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
		<input type="text" class="sb-origin" id="sb-origin-flights" placeholder="Input origin city" />
		<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a origin city.</span></p>
		<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input an valid origin city.</span></p>
		</div>
		<div class="com-city destination">
		<label for="sb-destination-flights" id="lbl-destination-flights">To</label>
		<input type="text" class="sb-destination" id="sb-destination-flights" placeholder="Input destination city" />
		<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a destination city.</span></p>
		<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid destination city.</span></p>
		</div>
		<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The destination must be different of the origin.</span></p>
		</div>
		<div class="mod-dates">
		<div class="com-datein">
		<label for="sb-datein-flights" id="lbl-datein-flights">Depart</label>
		<input type="text" class="sb-datein" id="sb-datein-flights" placeholder=dd/mm/aaaa maxlength=10 />
		<span class="commonSprite buttonCalendarOn"></span>
		</div>
		<div class="com-dateout">
		<label for="sb-dateout-flights" id="lbl-dateout-flights">Return</label>
		<input type="text" class="sb-dateout" id="sb-dateout-flights" placeholder=dd/mm/aaaa maxlength=10 />
		<span class="commonSprite buttonCalendarOn"></span>
		</div>
		<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a departure date.</span></p>
		<p class="error error-emptyOut hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a return date.</span></p>
		<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date.</span></p>
		<p class="error error-dateOut hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid return date. </span></p>
		<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The departure date is out of the permited range.</span></p>
		<p class="error error-stayOut hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">La fecha de regreso no está dentro del rango permitido.</span></p>
		<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The return date must be later than the departure date</span></p>
		<p class="error error-maxDays hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">La estadía no puede ser superior a 30 días.</span></p>
		<p class="error error-sameDate hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The return date must be later than the departure date.</span></p>
		<p class="error error-checkDate hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Your check-in and check-out at the hotel must be between the departure and return dates of your flight.</span></p>
		</div>
		</div>
		<div class="ctn-multipledestination hidden">
		<div class="segment-1 ">
		<div class="com-deletesegment">
		Remove Leg</div> <p class="segmenttitle">Leg 1</p>
		<div class="mod-places">
		<div class="com-city origin">
		<label for="sb-origin-1-flights" id="lbl-origin-1-flights">Origin</label>
		<input type="text" class="sb-origin" id="sb-origin-1-flights" placeholder="Ingrese una ciudad de origen" />
		<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input origin</span></p>
		<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid origin</span></p>
		</div>
		<div class="com-city destination">
		<label for="sb-destination-1-flights" id="lbl-destination-1-flights">Destination</label>
		<input type="text" class="sb-destination" id="sb-destination-1-flights" placeholder="Ingrese una ciudad de destino" />
		<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input destination.</span></p>
		<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid destination</span></p>
		</div>
		<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Origin and destination can't be same</span></p>
		</div>
		<div class="mod-dates">
		<div class="com-datein">
		<label for="sb-datein-1-flights" id="lbl-datein-1-flights">Departure</label>
		<input type="text" class="sb-datein" id="sb-datein-1-flights" placeholder=dd/mm/aaaa maxlength=10 />
		<span class="commonSprite buttonCalendarOn"></span>
		</div>
		<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date</span></p>
		<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
		<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input departure date.</span></p>
		<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The date is outside of allowed range</span></p>
		</div>
		</div>
		<div class="segment-2 ">
		<div class="com-deletesegment">
		Remove Leg</div> <p class="segmenttitle">Leg 2</p>
		<div class="mod-places">
		<div class="com-city origin">
		<label for="sb-origin-2-flights" id="lbl-origin-2-flights">Origin</label>
		<input type="text" class="sb-origin" id="sb-origin-2-flights" placeholder="Ingrese una ciudad de origen" />
		<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input origin</span></p>
		<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid origin</span></p>
		</div>
		<div class="com-city destination">
		<label for="sb-destination-2-flights" id="lbl-destination-2-flights">Destination</label>
		<input type="text" class="sb-destination" id="sb-destination-2-flights" placeholder="Ingrese una ciudad de destino" />
		<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input destination.</span></p>
		<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid destination</span></p>
		</div>
		<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Origin and destination can't be same</span></p>
		</div>
		<div class="mod-dates">
		<div class="com-datein">
		<label for="sb-datein-2-flights" id="lbl-datein-2-flights">Departure</label>
		<input type="text" class="sb-datein" id="sb-datein-2-flights" placeholder=dd/mm/aaaa maxlength=10 />
		<span class="commonSprite buttonCalendarOn"></span>
		</div>
		<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date</span></p>
		<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
		<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input departure date.</span></p>
		<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The date is outside of allowed range</span></p>
		</div>
		</div>
		<div class="segment-3 hidden">
		<div class="com-deletesegment">
		Remove Leg</div> <p class="segmenttitle">Leg 3</p>
		<div class="mod-places">
		<div class="com-city origin">
		<label for="sb-origin-3-flights" id="lbl-origin-3-flights">Origin</label>
		<input type="text" class="sb-origin" id="sb-origin-3-flights" placeholder="Ingrese una ciudad de origen" />
		<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input origin</span></p>
		<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid origin</span></p>
		</div>
		<div class="com-city destination">
		<label for="sb-destination-3-flights" id="lbl-destination-3-flights">Destination</label>
		<input type="text" class="sb-destination" id="sb-destination-3-flights" placeholder="Ingrese una ciudad de destino" />
		<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input destination.</span></p>
		<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid destination</span></p>
		</div>
		<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Origin and destination can't be same</span></p>
		</div>
		<div class="mod-dates">
		<div class="com-datein">
		<label for="sb-datein-3-flights" id="lbl-datein-3-flights">Departure</label>
		<input type="text" class="sb-datein" id="sb-datein-3-flights" placeholder=dd/mm/aaaa maxlength=10 />
		<span class="commonSprite buttonCalendarOn"></span>
		</div>
		<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date</span></p>
		<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
		<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input departure date.</span></p>
		<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The date is outside of allowed range</span></p>
		</div>
		</div>
		<div class="segment-4 hidden">
		<div class="com-deletesegment">
		Remove Leg</div> <p class="segmenttitle">Leg 4</p>
		<div class="mod-places">
		<div class="com-city origin">
		<label for="sb-origin-4-flights" id="lbl-origin-4-flights">Origin</label>
		<input type="text" class="sb-origin" id="sb-origin-4-flights" placeholder="Ingrese una ciudad de origen" />
		<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input origin</span></p>
		<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid origin</span></p>
		</div>
		<div class="com-city destination">
		<label for="sb-destination-4-flights" id="lbl-destination-4-flights">Destination</label>
		<input type="text" class="sb-destination" id="sb-destination-4-flights" placeholder="Ingrese una ciudad de destino" />
		<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input destination.</span></p>
		<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid destination</span></p>
		</div>
		<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Origin and destination can't be same</span></p>
		</div>
		<div class="mod-dates">
		<div class="com-datein">
		<label for="sb-datein-4-flights" id="lbl-datein-4-flights">Departure</label>
		<input type="text" class="sb-datein" id="sb-datein-4-flights" placeholder=dd/mm/aaaa maxlength=10 />
		<span class="commonSprite buttonCalendarOn"></span>
		</div>
		<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date</span></p>
		<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
		<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input departure date.</span></p>
		<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The date is outside of allowed range</span></p>
		</div>
		</div>
		<div class="segment-5 hidden">
		<div class="com-deletesegment">
		Remove Leg</div> <p class="segmenttitle">Leg 5</p>
		<div class="mod-places">
		<div class="com-city origin">
		<label for="sb-origin-5-flights" id="lbl-origin-5-flights">Origin</label>
		<input type="text" class="sb-origin" id="sb-origin-5-flights" placeholder="Ingrese una ciudad de origen" />
		<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input origin</span></p>
		<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid origin</span></p>
		</div>
		<div class="com-city destination">
		<label for="sb-destination-5-flights" id="lbl-destination-5-flights">Destination</label>
		<input type="text" class="sb-destination" id="sb-destination-5-flights" placeholder="Ingrese una ciudad de destino" />
		<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input destination.</span></p>
		<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid destination</span></p>
		</div>
		<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Origin and destination can't be same</span></p>
		</div>
		<div class="mod-dates">
		<div class="com-datein">
		<label for="sb-datein-5-flights" id="lbl-datein-5-flights">Departure</label>
		<input type="text" class="sb-datein" id="sb-datein-5-flights" placeholder=dd/mm/aaaa maxlength=10 />
		<span class="commonSprite buttonCalendarOn"></span>
		</div>
		<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date</span></p>
		<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
		<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input departure date.</span></p>
		<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The date is outside of allowed range</span></p>
		</div>
		</div>
		<div class="segment-6 hidden">
		<div class="com-deletesegment">
		Remove Leg</div> <p class="segmenttitle">Leg 6</p>
		<div class="mod-places">
		<div class="com-city origin">
		<label for="sb-origin-6-flights" id="lbl-origin-6-flights">Origin</label>
		<input type="text" class="sb-origin" id="sb-origin-6-flights" placeholder="Ingrese una ciudad de origen" />
		<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input origin</span></p>
		<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid origin</span></p>
		</div>
		<div class="com-city destination">
		<label for="sb-destination-6-flights" id="lbl-destination-6-flights">Destination</label>
		<input type="text" class="sb-destination" id="sb-destination-6-flights" placeholder="Ingrese una ciudad de destino" />
		<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input destination.</span></p>
		<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid destination</span></p>
		</div>
		<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Origin and destination can't be same</span></p>
		</div>
		<div class="mod-dates">
		<div class="com-datein">
		<label for="sb-datein-6-flights" id="lbl-datein-6-flights">Departure</label>
		<input type="text" class="sb-datein" id="sb-datein-6-flights" placeholder=dd/mm/aaaa maxlength=10 />
		<span class="commonSprite buttonCalendarOn"></span>
		</div>
		<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date</span></p>
		<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
		<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input departure date.</span></p>
		<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The date is outside of allowed range</span></p>
		</div>
		</div>
		<div class="mod-addsegment-flights">
		<div class="com-addsegmentlink-flights">
		<span class="more-sign">+</span> Add Leg
		</div></div> </div>
		<div class="mod-passengers-flights">
		<div class="ctn-passengers">
		<div class="com-adults-flights">
		<label>	12+ years</label>
		<select id="sb-adults-flights" class="sb-adults-flights">
		<option value="1" selected="selected" >1</option>
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
		<label>under 12</label>
		<select id="sb-childrens-flights" >
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
		<label>under 2</label>
		<select id="sb-infants-flights" >
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
		
		<p class="error error-infantsqty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">No more babies than adults</span></p>
		</div>
		
		<div class="mod-searchbutton">
		
		<div class="com-oneway">
			<input id="sb-oneway" class="sb-oneway" type="checkbox" name="oneway" value="oneway">
			<label id="lbl-oneway" class="lbl-oneway" for="sb-oneway">One way</label>
		</div> 
		
		<div class="com-searchbutton">
			<a class=" ctn-searchbutton">
			<input type="image" src="/bundles/btctrip/images/searchbtn.gif">
			</a>
		</div>
		
		</div>
		
		</div>
		</form>
	</div>
 </div>

	<div class="span8">		
		<div id="coin-slider" class="l10px">
		</div>
	</div>

<?php $view['slots']->stop() ?>

<?php $view['slots']->start('secondContent') ?>
	
		<div class="row sectionsTitles">
			<div class="span8 underscore"><span class="testimonial"><img src="/bundles/btctrip/images/testimonialshead.png"></span></div>
			<div class="span4 underscore"><span class="testimonial"><img src="/bundles/btctrip/images/specialhead.png" class="l20px"></span></div>
		</div>
		<div class="row press">
			<div id="left span8">
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim1'); document.getElementById('name1').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim1'); document.getElementById('name1').style.color='#4f4f4f'">
					<div class="name" id="name1">Charlie Shrem</div><div class="testbox testimonial-bg" id="testim1">
					<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/charlie-shrem.jpg"/><div class="testcopy"><br><i>"BtcTrip is Amazing!"</i><br>CEO of Bitinstant</div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim2'); document.getElementById('name2').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim2'); document.getElementById('name2').style.color='#4f4f4f'">
					<div class="name" id="name2">Jon Matonis</div><div class="testbox testimonial-bg" id="testim2">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/jon-matonis.jpg"/>
						<div  class="testcopy"><i>"I'm liking this service <br/> more and more"</i><br/>Executive Director at Bitcoin Foundation</div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim3'); document.getElementById('name3').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim3'); document.getElementById('name3').style.color='#4f4f4f'">
					<div class="name" id="name3">Erik Voorhees</div><div class="testbox testimonial-bg" id="testim3">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/erik-voorhees.jpg"/>
						<div  class="testcopy"><i>"Thanks for the great service!"</i><br/>SatoshiDice Founder<br/>CEO of Coinapult</div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim4'); document.getElementById('name4').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim4'); document.getElementById('name4').style.color='#4f4f4f'">
					<div class="name" id="name4">Nicolas Cary</div><div class="testbox testimonial-bg" id="testim4">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/nicolas-carry.jpg"/>
						<div  class="testcopy"><i>"Amazing customer service always rules the day."</i> CEO of Blockchain.info</div>
					</div>
				</div>
			</div>
			<div class="" style="width: 640px;">
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim6'); document.getElementById('name6').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim6'); document.getElementById('name6').style.color='#4f4f4f'">
					<div class="name" id="name6">Roger Ver</div><div class="testbox testimonial-bg" id="testim6">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/roger-ver.png"/>
						<div  class="testcopy"><i>"I love the service that they are providing to the Bitcoin community."</i><br>Bitcoin Investor </div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim7'); document.getElementById('name7').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim7'); document.getElementById('name7').style.color='#4f4f4f'">
					<div class="name" id="name7">Tuur Demeester</div><div class="testbox testimonial-bg" id="testim7">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/tuur-demeester.jpg"/>
						<div  class="testcopy"><i>"BTCTrip is quick, effortless, and allows me to use the best money in the world"</i></div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim8'); document.getElementById('name8').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim8'); document.getElementById('name8').style.color='#4f4f4f'">
					<div class="name" id="name8">Amir Taaki</div><div class="testbox testimonial-bg" id="testim8">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/amir-taaki.jpg"/>
						<div  class="testcopy"><i>"I think BtcTrip is amazing."</i><br/><br/>Bitcoin developer</div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim9'); document.getElementById('name9').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim9'); document.getElementById('name9').style.color='#4f4f4f'">
					<div class="name" id="name9">Vitalik Buterin</div><div class="testbox testimonial-bg" id="testim9">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/vitalik-buterin.jpg"/>
						<div  class="testcopy"><i>"We've really enjoyed Btctrip so far."</i><br/>Head Write at Bitcoin Magazine<br/></div>						
					</div>
				</div>
			</div>

			<div class="" style="width: 640px;">
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim6-2'); document.getElementById('name6-2').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim6-2'); document.getElementById('name6-2').style.color='#4f4f4f'">
					<div class="name" id="name6-2">Lasse B. Olesen</div><div class="testbox testimonial-bg" id="testim6-2">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/lasse-olesen.jpg"/>
						<div  class="testcopy"><i>"I bought a flight ticket cheaper than I found it anywhere else!"</i><br/>BitcoinNordic Founder</div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim7-2'); document.getElementById('name7-2').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim7-2'); document.getElementById('name7-2').style.color='#4f4f4f'">
					<div class="name" id="name7-2">@MundoBitcoin</div><div class="testbox testimonial-bg" id="testim7-2">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/avatar.png"/>
						<div  class="testcopy"><i>"Now I can run away incognito when the shit hits the fan!"</i><br/>MundoBitcoin.org</div>
					</div>
				</div>	
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim8-2'); document.getElementById('name8-2').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim8-2'); document.getElementById('name8-2').style.color='#4f4f4f'">
					<div class="name" id="name8-2">Thalia & Chris</div><div class="testbox testimonial-bg" id="testim8-2">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/avatar.png"/>
						<div  class="testcopy"><i>"You guys are seriously awesome!!"</i><br/>Great panamanian bitcoin travelers</div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim9-2'); document.getElementById('name9-2').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim9-2'); document.getElementById('name9-2').style.color='#4f4f4f'">
					<div class="name" id="name9-2">Satoshi</div><div class="testbox testimonial-bg" id="testim9-2">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/satoshi-avatar.jpg"/>
						<div  class="testcopy"><i>"After coding Bitcoin, I fly with BtcTrip."</i><br/>Satoshi Nakamoto, Cryptocurrency prophet</div>
					</div>
				</div>		
			</div>
			
			<a href="mailto:business@btctrip.com" >
				<div id="right" class="featuredby higher" title="Insanely Cheap Business Class Tickets. Found it cheaper somewhere? We can beat any offer!">
					<div> </div>
				</div>
			</a>
		</div>
		<div class="underscore testimonial-section" ><span class="testimonial"><img src="/bundles/btctrip/images/presshead.png" ></span></div>
		<div class="repress" >
			<div class="span2 pressbgd nyt" style="margin-left: 0px;">
				<a href="http://intransit.blogs.nytimes.com/2014/02/07/rewards-program-tries-bitcoin/?_php=true&_type=blogs&rref=travel&module=Ribbon&version=context&region=Header&action=click&contentCollection=Travel&pgtype=Blogs&_r=0" target="_blank"><img src="/bundles/btctrip/images/btcnytimes.jpg"></a>
			</div>
			<div class="span2 pressbgd" >
				<a href="http://bitcoinexaminer.org/btctrip-has-a-new-business-account-and-plans-to-launch-three-new-services/" target="_blank"><img src="/bundles/btctrip/images/btcexaminer.jpg"></a>
			</div>
			<div class="span2 pressbgd">
				<a href="http://www.bitcoinbulletin.com/2013/08/23/the-top-5-bitcoin-shops/" target="_blank"><img src="/bundles/btctrip/images/btcbulletin.jpg"></a>
			</div>
			<div class="span2 pressbgd">
				<a href="http://bitcoinmagazine.com/6446/btctrip-travel-the-world-with-global-currency/" target="_blank"><img src="/bundles/btctrip/images/btcmagazine.jpg"></a>
			</div>
			<div class="span2 pressbgd">
				<a href="http://www.coinsiderthis.com/2013/08/23/coinsider-this-show-4-problems-possibilities-and-poker/" target="_blank"><img src="/bundles/btctrip/images/btccoinsider.jpg"></a>
			</div>
		</div>


	<div class="preloadimages">
		<img src="/bundles/btctrip/images/starbg.png">
		<img src="/bundles/btctrip/images/starbginvert.png">
	</div>

<?php $view['slots']->stop() ?>

<?php $view['slots']->start('javascripts') ?>

<script>
	var urlSearchPrefixG = "<?php echo $enviromentPrefix ?>/results";
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#coin-slider').coinslider({ 
			width: 610, height: 347, hoverPause: true, navigation: true, delay: 5000, links: false,
			content: [
				{ img : '/bundles/btctrip/images/slider/12.jpg' },
				{ img : '/bundles/btctrip/images/slider/20.jpg' },
				{ img : '/bundles/btctrip/images/slider/0.jpg' },
				{ img : '/bundles/btctrip/images/slider/1.jpg' },
				{ img : '/bundles/btctrip/images/slider/4.jpg' },
				{ img : '/bundles/btctrip/images/slider/11.jpg' },						
				{ img : '/bundles/btctrip/images/slider/13.jpg' },
				{ img : '/bundles/btctrip/images/slider/14.jpg' },
				{ img : '/bundles/btctrip/images/slider/15.jpg' },
				{ img : '/bundles/btctrip/images/slider/16.jpg' },
				{ img : '/bundles/btctrip/images/slider/17.jpg' },
				{ img : '/bundles/btctrip/images/slider/18.jpg' },
				{ img : '/bundles/btctrip/images/slider/19.jpg' }
			] 
		});
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
search : '<?php echo $enviromentPrefix ?>/search/roundtrip',
refine : '<?php echo $enviromentPrefix ?>/refine/ROUNDTRIP/INTERNATIONAL/{hash}/{version}/{filterStrategy}/{orderCriteria}/{orderDirection}/{pageIndex}/{minPrice}/{maxPrice}/{originalCurrencyPrice}/{selectedCurrencyPrice}/{allowedOutboundTimeRanges}/{allowedInboundTimeRanges}/{allowedAirlines}/{allowedStopQuantities}/{allowedOutboundAirports}/{allowedInboundAirports}/{uniqueAirline}/{uniqueHomeAirport}',
item : '<?php echo $enviromentPrefix ?>/item/ROUNDTRIP/INTERNATIONAL/{hash}/{version}/{itemHash}'
};
});
define('options', function() {
return {
orderCriteria : 'TOTALFARE',
orderDirection : 'ASCENDING',
personalSortId : 'UPA_1',
initialCurrency : 'USD',
clusters : { searchType : 'ROUNDTRIP',
initialCurrencyCode : 'USD',
redirectToCheckout : 'true',
checkoutHandlerUrl : '<?php echo $enviromentPrefix ?>/checkout/form/{hash}/{version}/{itineraryId}/{clusterIndexTraking}/{provider}/INTERNATIONAL'
},
alerts : { show : false,
config : {
	container : "#flights-alerts-popup",
	url : "/subscriptions-ui/subscriptions/price-alert-by-month/add",
	model: {
		origin: {
			code: "",
			description: ""
		},
		destination: {
			code: "",
			description: ""
		},
	currency: [
{
mask: "$",
code: "ARS"
},
{
mask: "U$S",
code: "USD"
}
]
}
, outboundDate: ""
, inboundDate: ""
}
}
};
});
define('messages', function() {
return {
clusters : { itineraries: {
detailTitle : 'Flight details',
delaysTitle : 'Flight punctuality stats'
},
actions: {
emailTitle : 'Share a flight by E-Mail',
paymentsTitle : 'Payment options',
frequentflyer : {
pointsPrograms : {
"AR" : 'Aerolíneas Plus',
"LA" : 'LANPass',
"4M" : 'LANPass',
"XL" : 'LANPass',
"4C" : 'LANPass',
"LP" : 'LANPass',
"AA" : 'AAdvantage',
"JJ" : 'Fidelidade',
"G3" : 'Smiles',
"AD" : 'TudoAzul',
"O6" : 'Programa Amigo',
"TP" : 'Victoria',
"DL" : 'SkyMiles',
"UA" : 'MileagePlus',
"CM" : 'MileagePlus',
"AM" : 'Club Premier',
"AV" : 'LifeMiles',
"AC" : 'Altitude',
"TA" : 'LifeMiles',
"EK" : 'Skywards'
},
units : {
"MILE" : "miles",
"KILOMETER" : "kilometers",
"POINTS" : "points",
"CREDIT" : "credits"
}
}
},
delays: {
"LOW" : "Minor delays",
"MEDIUM" : "Moderate delays",
"HIGH" : "Major delays"
},
ecological: {
"ecologicalLow" : "Preservation level: Low",
"ecologicalMedium" : "Preservation level: Medium",
"ecologicalHigh" : "Preservation level: High"
}
},
filters : { priceError : 'Please, make sure minimum is less than maximum.',
priceMaxError : 'Please, make sure tha maximum value is more than 0',
resultsPriceError : 'Sorry, we could not find flights within a given price range. Please, try with different options',
showAll : 'Show all &raquo;',
showLess : 'Show less &laquo;',
resultsError : 'Sorry, no flight found.',
resultsErrorHelp : 'Undo',
stops : {
"NONE" : "Direct",
"ONE" : "1 Stopover",
"MORE_THAN_ONE" : "2 or more stopovers"
},
time : {
"MORNING" : "Morning (06 a 12hs)",
"AFTERNOON" : "Afternoon (12 a 20hs)",
"NIGHT" : "Night (20 a 00hs)",
"EARLY_MORNING" : "Early morning (00 a 06hs)"
}
}
};
});
</script>
<script>
define('searchbox', ["amplify"], function() {
var _box = null;
return {
init : function(){
var box = new Nibbler.Searchbox.js.Searchbox({
context: $( '.searchbox' ),
config: {
currentDate : new Date( <?php echo time() * 1000; ?>),
brand : 0,
country : 'US',
locale : 'es'
},
activations: {
'*' : {
'*' : {
'*' : {
places: Nibbler.Searchbox.js.Searchbox.Module.Places
}
}
},
'0' : {
'*' : {
'*' : {
places: Nibbler.Searchbox.js.Searchbox.Module.Places
}
},
'hotels': {
'*' : {
places: Nibbler.Searchbox.js.Searchbox.Module.Places
}
},
'flights': {
'PE, VE, CL' : {
places: Nibbler.Searchbox.js.Searchbox.Module.Places
},
'MX' : function()
{
return {
places: this.raffle(
{ chance: 50, item: Nibbler.Searchbox.js.Searchbox.Module.Places },
{ chance: 50, item: Nibbler.Searchbox.js.Searchbox.Module.PlacesOld }
)
};
}
},
'cars, flightshotels' : {
'*' : {
places: Nibbler.Searchbox.js.Searchbox.Module.Places
}
},
'packages' :{
'*' : {
places: Nibbler.Searchbox.js.Searchbox.Module.Places
},
'*' : {
searcher: Nibbler.Searchbox.js.Searchbox.Searcher.PackagesV2
}
},
'cruises' : {
'*' : {
searcher: Nibbler.Searchbox.js.Searchbox.Searcher.CruisesV2
}
}
}
}
,
boxes: [
{
init : true,
box : Nibbler.Searchbox.js.Searchbox.Box.Flights,
product : 'flights',
id : 'flights',
selector : 'div.pdt-flights',
searcher : Nibbler.Searchbox.js.Searchbox.Searcher.Flights,
options : {
dates: {
availableDays : 330,
anticipationDays : '<?php echo $sAnticipationDays; ?>'
},
places: {
autoCompleteType : Nibbler.Autocomplete.js.Autocomplete.Flights,
autoCompleteCache : 'facet.a.c.e',
autoCompleteUrl : '<?php echo $enviromentPrefix ?>/autocomplete/find',
autoCompleteUrlOld : '/Flights.Services/Commons/AutoComplete.svc'
},
passengers: {
maxPassengers : 8
},
multiple: {
availableDays : 330,
autoCompleteType : Nibbler.Autocomplete.js.Autocomplete.Flights,
autoCompleteUrl : '<?php echo $enviromentPrefix ?>/autocomplete/find',
autoCompleteUrlOld : '/Flights.Services/Commons/AutoComplete.svc',
anticipationDays : '<?php echo $sAnticipationDays; ?>'
},
anticipatedSearch : true,
store: true
}
}
]
});
_box = box;
_box.setBoxOptions({ flights : {
dates : {
dateIn : new Date() 
,dateOut : new Date()
},
places : {
destinationText : '',
destinationValue : '',
originText : '',
originValue : ''
},
passengers : {
adults : 1,
childs : 0,
infants : 0
},
triptypes : {
currentType : 'roundTrip'
}
}
});
_box.init();
}
, updateOrigin : function(cityCode, cityDescription) {
_box.notify('flights.places.origin.update', { place: cityDescription, code: cityCode });
}
, updateDestination : function(cityCode, cityDescription) {
_box.notify('flights.places.destination.update', { place: cityDescription, code: cityCode });
}
, updateMultipleOrigin : function(index, cityCode, cityDescription) {
_box.notify('flights.multiple.' + index + '.origin.update', { place: cityDescription, code: cityCode });
}
, updateMultipleDestination : function(index, cityCode, cityDescription) {
_box.notify('flights.multiple.' + index + '.destination.update', { place: cityDescription, code: cityCode });
}
};
});
</script>


<script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/home.js') ?>"></script>


<!--searchbox-js-->
	<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/searchboxHelper.js') ?>"></script>
	<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/searchbox.fl.js') ?>"></script>
	<script charset="utf-8" type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/top-airlines-cities-ar.js') ?>"></script>
	<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/autocomplete.js') ?>"></script>
<!--searchbox-js END-->



<?php $view['slots']->stop() ?>


