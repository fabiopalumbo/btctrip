<?php $view->extend('BtcTripSearchBundle::layout.html.php') ?>

<?php

/*
Parameters may refer to values in the URL, entity properies posted as json, or both.

    from – 3 character airport or city id representing the starting point.
    to – 3 character airport or city id representing the destination.
    departureDate – The desired departure date. (format yyyy-MM-dd)
    returningDate – The desired returning date. (format yyyy-MM-dd)
    adults – Number of adults that will travel.
    children – Number of children that will travel.
    infants – Number of infants that will travel (only lap children up to 24 months).
*/



$sDepartureDateForSearchBox = date('Y,m,d', strtotime('previous month',strtotime($sDepartureDate)));
$sReturningDateForSearchBox = date('Y,m,d', strtotime('previous month',strtotime($sReturningDate)));

$dosDias = 172800;
$sAnticipationDays = date('Y-m-d', strtotime("now") + $dosDias);

$sChildrensCount = ( $sChildren!='0' ? count(split('-', $sChildren)) : 0 );

?>
<?php $view['slots']->set('bodyClass', 'results') ?>

<?php $view['slots']->start('stylesheets') ?>

		<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/results.css') ?>">

		<!--searchbox-css-->
		<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/fl-small.css') ?>"/>
		<!--searchbox-css END-->
		<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/flights-web-results.css') ?>">

<?php $view['slots']->stop() ?>


<?php $view['slots']->start('mainContent') ?>

<div class="span3 searchbg">
	<div class="searchform search">

<form class="searchbox" autocomplete="off">
<script type="text/html" id="autocomplete-tpl">
<div class="com-autocomplete">
<ul>
</ul>
<p class="msg-blank">Cities not found matching the search criteria: <span></span></p>
<p class="msg-error">We are improving the search engine. Try again later, please.</p>
<p class="msg-empty">Input at least the 3 first letters and wait for the results.</p>
<p class="msg-loading">Searching... <span></span></p>
<p class="msg-max-chars">The search exceed the allowed limit.</p>
</div>
</script>
<div class="pdt-flights fh">
<h2 class="producttitle">Search flights</h2>
<div class="ctn-roundtrip">
<div class="mod-places">
<div class="com-city origin">
<label for="sb-origin-flights" id="lbl-origin-flights">From</label>
<input type="text" class="sb-origin" id="sb-origin-flights" placeholder="Input origin city" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input the origin city.</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid origin city.</span></p>
</div>
<div class="com-city destination">
<label for="sb-destination-flights" id="lbl-destination-flights">To</label>
<input type="text" class="sb-destination" id="sb-destination-flights" placeholder="Input destination city" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input the destination city.</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid destination city.</span></p>
</div>
<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The destination must be different from the origin.</span></p>
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
<p class="error error-stayOut hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The return date is not within allowed range.</span></p>
<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The return date must be later than the departure date</span></p>
<p class="error error-maxDays hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The stay can't be more than 30 days</span></p>
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
<input type="text" class="sb-origin" id="sb-origin-1-flights" placeholder="Please, input origin" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input origin</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid origin</span></p>
</div>
<div class="com-city destination">
<label for="sb-destination-1-flights" id="lbl-destination-1-flights">Destination</label>
<input type="text" class="sb-destination" id="sb-destination-1-flights" placeholder="Please, input detination" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input destination</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid destination</span></p>
</div>
<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The destination and origin must be different.</span></p>
</div>
<div class="mod-dates">
<div class="com-datein">
<label for="sb-datein-1-flights" id="lbl-datein-1-flights">Departure</label>
<input type="text" class="sb-datein" id="sb-datein-1-flights" placeholder=dd/mm/aaaa maxlength=10 />
<span class="commonSprite buttonCalendarOn"></span>
</div>
<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date.</span></p>
<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date.</span></p>
<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
</div>
</div>
<div class="segment-2 ">
<div class="com-deletesegment">
Remove Leg</div> <p class="segmenttitle">Leg 1</p>
<div class="mod-places">
<div class="com-city origin">
<label for="sb-origin-2-flights" id="lbl-origin-2-flights">Origin</label>
<input type="text" class="sb-origin" id="sb-origin-2-flights" placeholder="Please, input origin" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input origin</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid origin</span></p>
</div>
<div class="com-city destination">
<label for="sb-destination-2-flights" id="lbl-destination-2-flights">Destination</label>
<input type="text" class="sb-destination" id="sb-destination-2-flights" placeholder="Please, input destination" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input destination</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid destination</span></p>
</div>
<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The destination and origin must be different.</span></p>
</div>
<div class="mod-dates">
<div class="com-datein">
<label for="sb-datein-2-flights" id="lbl-datein-2-flights">Departure</label>
<input type="text" class="sb-datein" id="sb-datein-2-flights" placeholder=dd/mm/aaaa maxlength=10 />
<span class="commonSprite buttonCalendarOn"></span>
</div>
<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date.</span></p>
<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date.</span></p>
<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
</div>
</div>
<div class="segment-3 hidden">
<div class="com-deletesegment">
Remove Leg</div> <p class="segmenttitle">Leg 1</p>
<div class="mod-places">
<div class="com-city origin">
<label for="sb-origin-3-flights" id="lbl-origin-3-flights">Origin</label>
<input type="text" class="sb-origin" id="sb-origin-3-flights" placeholder="Please, input origin" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input origin</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid origin</span></p>
</div>
<div class="com-city destination">
<label for="sb-destination-3-flights" id="lbl-destination-3-flights">Destination</label>
<input type="text" class="sb-destination" id="sb-destination-3-flights" placeholder="IPlease, input destination" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input destination</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid destination</span></p>
</div>
<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The destination and origin must be different.</span></p>
</div>
<div class="mod-dates">
<div class="com-datein">
<label for="sb-datein-3-flights" id="lbl-datein-3-flights">Departure</label>
<input type="text" class="sb-datein" id="sb-datein-3-flights" placeholder=dd/mm/aaaa maxlength=10 />
<span class="commonSprite buttonCalendarOn"></span>
</div>
<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date.</span></p>
<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date.</span></p>
<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
</div>
</div>
<div class="segment-4 hidden">
<div class="com-deletesegment">
Remove Leg</div> <p class="segmenttitle">Leg 1</p>
<div class="mod-places">
<div class="com-city origin">
<label for="sb-origin-4-flights" id="lbl-origin-4-flights">Origin</label>
<input type="text" class="sb-origin" id="sb-origin-4-flights" placeholder="Please, input origin" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input origin</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid origin</span></p>
</div>
<div class="com-city destination">
<label for="sb-destination-4-flights" id="lbl-destination-4-flights">Destination</label>
<input type="text" class="sb-destination" id="sb-destination-4-flights" placeholder="Please, input origin destination" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input destination</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid destination</span></p>
</div>
<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The destination and origin must be different.</span></p>
</div>
<div class="mod-dates">
<div class="com-datein">
<label for="sb-datein-4-flights" id="lbl-datein-4-flights">Departure</label>
<input type="text" class="sb-datein" id="sb-datein-4-flights" placeholder=dd/mm/aaaa maxlength=10 />
<span class="commonSprite buttonCalendarOn"></span>
</div>
<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date.</span></p>
<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date.</span></p>
<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
</div>
</div>
<div class="segment-5 hidden">
<div class="com-deletesegment">
Remove Leg</div> <p class="segmenttitle">Leg 1</p>
<div class="mod-places">
<div class="com-city origin">
<label for="sb-origin-5-flights" id="lbl-origin-5-flights">Origin</label>
<input type="text" class="sb-origin" id="sb-origin-5-flights" placeholder="Please, input origin" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input origin</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid origin</span></p>
</div>
<div class="com-city destination">
<label for="sb-destination-5-flights" id="lbl-destination-5-flights">Destination</label>
<input type="text" class="sb-destination" id="sb-destination-5-flights" placeholder="Please, input destination" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input destination</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid destination</span></p>
</div>
<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The destination and origin must be different.</span></p>
</div>
<div class="mod-dates">
<div class="com-datein">
<label for="sb-datein-5-flights" id="lbl-datein-5-flights">Departure</label>
<input type="text" class="sb-datein" id="sb-datein-5-flights" placeholder=dd/mm/aaaa maxlength=10 />
<span class="commonSprite buttonCalendarOn"></span>
</div>
<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date.</span></p>
<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date.</span></p>
<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
</div>
</div>
<div class="segment-6 hidden">
<div class="com-deletesegment">
Remove Leg</div> <p class="segmenttitle">Leg 1</p>
<div class="mod-places">
<div class="com-city origin">
<label for="sb-origin-5-flights" id="lbl-origin-5-flights">Origin</label>
<input type="text" class="sb-origin" id="sb-origin-5-flights" placeholder="Please, input origin" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input origin</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid origin</span></p>
</div>
<div class="com-city destination">
<label for="sb-destination-5-flights" id="lbl-destination-5-flights">Destination</label>
<input type="text" class="sb-destination" id="sb-destination-5-flights" placeholder="Please, input destination" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input destination</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid destination</span></p>
</div>
<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">The destination and origin must be different.</span></p>
</div>
<div class="mod-dates">
<div class="com-datein">
<label for="sb-datein-5-flights" id="lbl-datein-5-flights">Departure</label>
<input type="text" class="sb-datein" id="sb-datein-5-flights" placeholder=dd/mm/aaaa maxlength=10 />
<span class="commonSprite buttonCalendarOn"></span>
</div>
<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date.</span></p>
<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Please, input a valid departure date.</span></p>
<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Return date has to be after departure.</span></p>
</div>
</div>
<div class="mod-addsegment-flights">
<div class="com-addsegmentlink-flights">
<span class="more-sign">+</span> Add segment
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
<select id="sb-childrens-flights" AUTOCOMPLETE = "off">
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
<select id="sb-infants-flights" AUTOCOMPLETE = "off">
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

<p class="error error-infantsqty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">No more babies than adults.</span></p>
</div>
<div class="mod-advancedsearch-flights">
<div class="com-business-flights">
<input type="checkbox" value="C" class="searchBusinessOnlyChkBox" id="searchBusinessOnlyChkBox" />
<label for="searchBusinessOnlyChkBox" class="lbl-searchBusinessOnly">Only Business</label>
</div>
<div class="com-oneway">
<input id="sb-oneway" class="sb-oneway" type="checkbox" name="oneway" value="oneway">
<label id="lbl-oneway" class="lbl-oneway" for="sb-oneway">One way</label>
</div> 
<div class="com-advancedlink">Advanced options</div> <div class="ctn-options hidden">
<div class="com-time-flights">
<div class="ctn-departureTime">
<label>Departure time</label>
<select id="slt-departuretime" class="slt-departuretime">
<option value="NA">No preference</option>
<option value="00">Midnight</option>
<option value="01">1 AM</option>
<option value="02">2 AM</option>
<option value="03">3 AM</option>
<option value="04">4 AM</option>
<option value="05">5 AM</option>
<option value="06">6 AM</option>
<option value="07">7 AM</option>
<option value="08">8 AM</option>
<option value="09">9 AM</option>
<option value="10">10 AM</option>
<option value="11">11 AM</option>
<option value="12">Noon</option>
<option value="13">1 PM</option>
<option value="14">2 PM</option>
<option value="15">3 PM</option>
<option value="16">4 PM</option>
<option value="17">5 PM</option>
<option value="18">6 PM</option>
<option value="19">7 PM</option>
<option value="20">8 PM</option>
<option value="21">9 PM</option>
<option value="22">10 PM</option>
<option value="23">11 PM</option>
</select>
</div>
<div class="ctn-returnTime">
<label>Return time</label>
<select id="slt-returntime" class="slt-returntime">
<option value="NA">No preference</option>
<option value="00">Midnight</option>
<option value="01">1 AM</option>
<option value="02">2 AM</option>
<option value="03">3 AM</option>
<option value="04">4 AM</option>
<option value="05">5 AM</option>
<option value="06">6 AM</option>
<option value="07">7 AM</option>
<option value="08">8 AM</option>
<option value="09">9 AM</option>
<option value="10">10 AM</option>
<option value="11">11 AM</option>
<option value="12">Noon</option>
<option value="13">1 PM</option>
<option value="14">2 PM</option>
<option value="15">3 PM</option>
<option value="16">4 PM</option>
<option value="17">5 PM</option>
<option value="18">6 PM</option>
<option value="19">7 PM</option>
<option value="20">8 PM</option>
<option value="21">9 PM</option>
<option value="22">10 PM</option>
<option value="23">11 PM</option>
</select>
</div>
</div> <div class="ctn-scaleandclass">
<div class="com-scale-flights">
<label>Stops</label>
<select id="slt-scale-flights">
<option value="NA">No preference</option>
<option value="0">Direct flights</option>
<option value="1">Up to 1 stop</option>
<option value="2">Up to 2 stop</option>
<option value="3">Up to 3 stop</option>
<option value="4">Up to 4 stop</option>
<option value="5">Up to 5 stop</option>
<option value="6">Up to 6 stop</option>
<option value="7">Up to 7 stop</option>
<option value="8">Up to 8 stop</option>
</select>
</div>
<div class="com-class-flights">
<label>Flights class</label>
<select class="classPref">
<option value="NA">No preference</option>
<option value="YC">Economy</option>
<option value="C">Business class</option>
<option value="F">First class</option>
</select>
</div> </div>
<div class="com-airline-flights">
<label for="sb-advancedairline" id="lb-advancedairline">Airlines</label>
<input type="text" class="sb-advancedairline" id="sb-advancedairline" placeholder="Input an airline" />
</div>
</div>
</div>
<div class="mod-searchbutton">
<div class="com-betterprice">
<span class="commonSprite littleBestPricelogo_es"></span>
</div>

	<a class="ctn-searchbutton">
	<input type="image" src="/bundles/btctrip/images/searchbtn.gif">
	</a>

</div>
<span class="commonSprite searchBoxCornerTR"></span>
<span class="commonSprite searchBoxCornerTL"></span>
<span class="commonSprite searchBoxCornerBR"></span>
<span class="commonSprite searchBoxCornerBL"></span>
</div>
</form>
</div>


<script type="text/html" id="autocomplete-tpl">
<div class="com-autocomplete">
<ul>
</ul>
<p class="msg-blank">No cities found: <span></span></p>
<p class="msg-error">We are improving the search engine. Please, try again in a few minutes</p>
<p class="msg-empty">You need at least 3 characters</p>
<p class="msg-loading">Searching... <span></span></p>
<p class="msg-max-chars">The search exceeded maximum number of characters</p>
</div>
</script>

 
<div id="filters" class="filters"></div>

<script id="filters-template" type="text/x-handlebars-template">
<div class="flights-accordion">
<h3>Filter by:</h3>
<div class="accordion-section price">
<div class="accordion-header accordion-header-open name">
<h4>Price</h4>
<span class="accordion-arrow"></span>
</div>
<ul class="accordion-content items">
<li class="item values">
<ul>
<li>
<input class="price-min flights-input" type="text" name="price-min">
</li>
<li>
to </li>
<li>
<input class="price-max flights-input" type="text" name="price-max">
</li>
<li>
<a class="flights-mini-button apply">
<span>Apply</span>
</a>
</li>
</ul>
</li>
<li class="item clean">
<a href="#">Clear filter</a>
</li>
</ul>
</div>
<div class="accordion-section stops">
<div class="accordion-header accordion-header-open name">
<h4>Stops</h4>
<span class="accordion-arrow"></span>
</div>
<ul class="items accordion-content" data-stops-info='{ "name" : "allowedStopQuantities" }'>
<li class="item stops-all">
<label for="stops-all" class="selected disabled">
<input id="stops-all" class="all" type="checkbox" name="stops" value="NA" checked disabled>
<strong class="custom-label">All stops</strong>
<strong class="total">{{filterCount data.refinementSummary.stops}}</strong>
</label>
</li>
{{#_each data.refinementSummary.stops}}
<li class="item stops-{{data.value}}">
<label for="stops-{{data.value}}" class="{{#if data.count}} enabled {{else}} disabled {{/if}}">
<input id="stops-{{data.value}}" type="checkbox" name="stops" value="{{data.value}}" {{#if data.count}} enabled {{else}} disabled {{/if}}>
<span class="custom-label">{{filterName "stops" data.value}}</span>
<span class="total">{{data.count}}</span>
</label>
</li>
{{/_each}}
</ul>
</div>
<div class="accordion-section time-outbound">
<div class="accordion-header accordion-header-open name">
<h4>Departure time</h4>
<span class="accordion-arrow"></span>
</div>
<ul class="items accordion-content" data-time-outbound-info='{ "name" : "allowedOutboundTimeRanges" }'>
<li class="item time-outbound-all">
<label for="time-outbound-all" class="selected disabled">
<input id="time-outbound-all" class="all" type="checkbox" name="time-outbound" value="NA" checked disabled>
<strong class="custom-label">All times</strong>
<strong class="total">{{filterCount data.refinementSummary.timeOutbound}}</strong>
</label>
</li>
{{#_each data.refinementSummary.timeOutbound}}
<li class="item time-outbound-{{data.value}}">
<label for="time-outbound-{{data.value}}" class="{{#if data.count}} enabled {{else}} disabled {{/if}}">
<input id="time-outbound-{{data.value}}" type="checkbox" name="time-outbound" value="{{data.value}}" {{#if data.count}} enabled {{else}} disabled {{/if}}>
<span class="custom-label">{{filterName "time" data.value}}</span>
<span class="total">{{data.count}}</span>
</label>
</li>
{{/_each}}
</ul>
</div>
<div class="accordion-section time-inbound">
<div class="accordion-header accordion-header-open name">
<h4>Return time</h4>
<span class="accordion-arrow"></span>
</div>
<ul class="items accordion-content" data-time-inbound-info='{ "name" : "allowedInboundTimeRanges" }'>
<li class="item time-inbound-all">
<label for="time-inbound-all" class="selected disabled">
<input id="time-inbound-all" class="all" type="checkbox" name="time-inbound" value="NA" checked disabled>
<strong class="custom-label">All times</strong>
<strong class="total">{{filterCount data.refinementSummary.timeInbound}}</strong>
</label>
</li>
{{#_each data.refinementSummary.timeInbound}}
<li class="item time-inbound-{{data.value}}">
<label for="time-inbound-{{data.value}}" class="{{#if data.count}} enabled {{else}} disabled {{/if}}">
<input id="time-inbound-{{data.value}}" type="checkbox" name="time-inbound" value="{{data.value}}" {{#if data.count}} enabled {{else}} disabled {{/if}}>
<span class="custom-label">{{filterName "time" data.value}}</span>
<span class="total">{{data.count}}</span>
</label>
</li>
{{/_each}}
</ul>
</div>
<div class="accordion-section filter airport-outbound">
<div class="accordion-header accordion-header-open name">
<h4>Departure airports</h4>
<span class="accordion-arrow"></span>
</div>
<ul class="items accordion-content" data-airport-outbound-info='{ "name" : "allowedOutboundAirports" }'>
<li class="item airport-outbound-all">
<label for="airport-outbound-all" class="selected disabled">
<input id="airport-outbound-all" class="all" type="checkbox" name="airport-outbound" value="NA" checked disabled>
<strong class="custom-label">All airports</strong>
<strong class="total">{{filterCount data.refinementSummary.outboundAirports}}</strong>
</label>
</li>
{{#_each data.refinementSummary.outboundAirports}}
<li class="item airport-outbound-{{data.value.code}}" >
<label for="airport-outbound-{{data.value.code}}" class="enabled">
<input id="airport-outbound-{{data.value.code}}" type="checkbox" name="airport-outbound" value="{{data.value.code}}">
<span class="custom-label">{{data.value.description}}</span>
<span class="total">{{data.count}}</span>
</label>
</li>
{{/_each}}
</ul>
<div class="unique-airport">
<ul class="items" data-airport-info='{ "name" : "uniqueHomeAirport" }'>
<li class="item">
<label for="airport" class="enabled">
<input id="airport" type="checkbox" name="airport" value="TRUE">
<span class="custom-label">Depart and return by the same airport</span>
</label>
</li>
</ul>
</div>
</div>
<div class="accordion-section airport-inbound">
<div class="accordion-header accordion-header-open name">
<h4>Return airports</h4>
<span class="accordion-arrow"></span>
</div>
<ul class="items accordion-content" data-airport-inbound-info='{ "name" : "allowedInboundAirports" }'>
<li class="item airport-inbound-all">
<label for="airport-inbound-all" class="selected disabled">
<input id="airport-inbound-all" class="all" type="checkbox" name="airport-inbound" value="NA" checked disabled>
<strong class="custom-label">All airports</strong>
<strong class="total">{{filterCount data.refinementSummary.inboundAirports}}</strong>
</label>
</li>
{{#_each data.refinementSummary.inboundAirports}}
<li class="item airport-inbound-{{data.value.code}}" >
<label for="airport-inbound-{{data.value.code}}" class="enabled">
<input id="airport-inbound-{{data.value.code}}" type="checkbox" name="airport-inbound" value="{{data.value.code}}">
<span class="custom-label">{{data.value.description}}</span>
<span class="total">{{data.count}}</span>
</label>
</li>
{{/_each}}
</ul>
</div>
<div class="accordion-section airlines">
<div class="accordion-header accordion-header-open name">
<h4>Airlines</h4>
<span class="accordion-arrow"></span>
</div>
<ul class="items accordion-content" data-airlines-info='{ "name" : "allowedAirlines" }'>
<li class="item airlines-all">
<label for="airlines-all" class="selected disabled">
<input id="airlines-all" class="all" type="checkbox" name="airlines" value="NA" checked disabled>
<strong class="custom-label">All airlines</strong>
<strong class="total">{{filterCount data.refinementSummary.airlines}}</strong>
</label>
</li>
{{#_each data.refinementSummary.airlines}}
<li class="item airlines-{{data.value.code}}" {{#compare _data.index 15 operator=">"}} hidden {{/compare}} >
<label for="airlines-{{data.value.code}}" class="enabled">
<input id="airlines-{{data.value.code}}" type="checkbox" name="airlines" value="{{data.value.code}}">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/{{data.value.code}}.png" alt="{{data.value.description}}" title="{{data.value.description}}" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/default.png'" />
<span class="custom-label">{{data.value.description}}</span>
<span class="total">{{data.count}}</span>
</label>
</li>
{{#compare data.refinementSummary.airlines.length 15 operator=">"}}
<li class="item show-all">
<a href="#">Show all &raquo;</a>
</li>
{{/compare}}
{{/_each}}
</ul>
<div class="unique-airline">
<ul class="items" data-airline-info='{ "name" : "uniqueAirline" }'>
<li class="item">
<label for="airline" class="enabled">
<input id="airline" type="checkbox" name="airline" value="TRUE">
<span class="custom-label">Depart and return by the same airline</span>
</label>
</li>
</ul>
</div>
</div>
</div>
</script>
<script id="popup-filter-error-template" type="text/x-handlebars-template">
<div class="popup-filter-error">
<span>{{error}}</span>
</div>
</script> </div>

<?php 

$sCityFromArray = explode(',', $sFromName);
$sCityToArray = explode(',', $sToName);

$sReturningDateWithText = (strlen($sReturningDate) > 0 ? ' - ' . $sReturningDate : '');

?>

<div class="span9 omega container-white">

	<div id="results-loader" class="results-loader">

		<div class="span8 searchimagebg loader">
			<div class="row">
				<div class="span4 messagegetting">
					<span>We are getting you the best price for:</span>
				</div>
				<div class="span4 detailgetting">
					<span class="flightdetails"><?php echo $sCityFromArray[0] ?> to <?php echo $sCityToArray[0] ?>, <?php echo $sDepartureDate ?> <?php echo $sReturningDateWithText ?></span>
				</div>
			</div>
			<div class="span8 airlinesearch">
				<div class="searchprogress iterated-text">
					With... <br/><span class="airline iterated-text-description"></span>
				</div>
			</div>
		</div> 

	</div>


<div id="results-warning" class="results-warning messages" style="display: none;">
<span class="commonSprite warningSymbol"></span>
<div class="text">
<span class="message">
We didn't find flights
with seats.
</span>
<span class="help">All flights, without airline and time filters</span>
</div>
</div>


<!-- <div id="best-price-alert" style="display: none;"></div> -->

	<script id="best-price-alert-template" type="text/x-handlebars-template">
		{{#if aditionalsSearchesSummary}}
			{{#compare aditionalsSearchesSummary.differenceDays 0 operator=">"}}
				{{#if betterUpsellPrice}}
<div class="best-price-alert">
<div class="aditionalsSearchesSummary">
<div class="primary-message">
<div class="text-container">
<span class="alert-title">Good news!</span>
<span class="alert-description">
<span class="alert-text">
¡Saliendo
{{aditionalsSearchesSummary.differenceDays}}
{{#compare aditionalsSearchesSummary.differenceDays 1 operator="=="}}
día
{{else}}
días
{{/compare}}
{{#compare aditionalsSearchesSummary.differenceSummaryType "LESS" operator="=="}}
antes {{else}}
después {{/compare}}
puede ahorrar
</span>
{{#each aditionalsSearchesSummary.price}}
<span class="price-currency {{this.formatted.code}} alert-text">
<span class="currency">{{this.formatted.mask}}</span>
<span class="amount">{{this.formatted.amount}}</span>
</span>
{{/each}}
<span class="alert-text">
por adulto! </span>
</span>
</div>
<div class="button-container">
<a class="flights-best-price-button aditionalsSearchesSummaryButton" href="/shop/flights/results/roundtrip/<?php echo $sFrom?>/<?php echo $sTo?>/{{aditionalsSearchesSummary.departureDate.formatted}}/{{aditionalsSearchesSummary.arrivalDate.formatted}}/<?php echo $sAdults?>/<?php echo $sChildren?>/<?php echo $sInfants?>/NA/NA/NA/NA/NA" target="_blank">
<span>Ver mejor precio »</span>
</a>
</div>
</div>
<div class="secondary-message betterUpsellPriceButton" data-href="/shop/flights/results/roundtrip/<?php echo $sFrom?>/<?php echo $sTo?>/<?php echo $sDepartureDate?>/<?php echo $sReturningDate?>/<?php echo $sAdults?>/<?php echo $sChildren?>/<?php echo $sInfants?>/NA/NA/{{betterUpsellPrice.cabinType.code}}/NA/NA">
<span class="icon-business-class"></span>
<span class="alert-description">
<span class="alert-text">
A partir de </span>
{{#each betterUpsellPrice.price}}
<span class="price-currency {{this.formatted.code}} alert-text">
<span class="currency">{{this.formatted.mask}}</span>
<span class="amount">{{this.formatted.amount}}</span>
</span>
{{/each}}
<span class="alert-text">
adicionales por adulto, </span>
<span class="alert-text-line">
usted puede acceder a la {{betterUpsellPrice.cabinType.description}} </span>
</span>
</div>
</div>
</div>
{{else}}
<div class="best-price-alert">
<div class="aditionalsSearchesSummary">
<div class="primary-message">
<div class="text-container">
<span class="alert-title">¡Buenas noticias!</span>
<span class="alert-description">
<span class="alert-text">
¡Saliendo
{{aditionalsSearchesSummary.differenceDays}}
{{#compare aditionalsSearchesSummary.differenceDays 1 operator="=="}}
día
{{else}}
días
{{/compare}}
{{#compare aditionalsSearchesSummary.differenceSummaryType "LESS" operator="=="}}
antes {{else}}
después {{/compare}}
puede ahorrar
</span>
{{#each aditionalsSearchesSummary.price}}
<span class="price-currency {{this.formatted.code}} alert-text">
<span class="currency">{{this.formatted.mask}}</span>
<span class="amount">{{this.formatted.amount}}</span>
</span>
{{/each}}
<span class="alert-text">
por adulto! </span>
</span>
</div>
<div class="button-container">
<a class="flights-best-price-button aditionalsSearchesSummaryButton" href="/shop/flights/results/roundtrip/<?php echo $sFrom?>/<?php echo $sTo?>/{{aditionalsSearchesSummary.departureDate.formatted}}/{{aditionalsSearchesSummary.arrivalDate.formatted}}/<?php echo $sAdults?>/<?php echo $sChildren?>/<?php echo $sInfants?>/NA/NA/NA/NA/NA" target="_blank">
<span>Ver mejor precio »</span>
</a>
</div>
</div>
</div>
</div>
{{/if}}
{{else}}
{{#if betterUpsellPrice}}
<div class="best-price-alert">
<div class="betterUpsellPrice">
<div class="primary-message">
<div class="text-container">
<span class="icon-business-class"></span>
<span class="alert-description">
<span class="alert-text">
A partir de </span>
{{#each betterUpsellPrice.price}}
<span class="price-currency {{this.formatted.code}} alert-text">
<span class="currency">{{this.formatted.mask}}</span>
<span class="amount">{{this.formatted.amount}}</span>
</span>
{{/each}}
<span class="alert-text">
adicionales por adulto, </span>
<span class="alert-text-line">
usted puede acceder a la {{betterUpsellPrice.cabinType.description}} </span>
</span>
</div>
<div class="button-container">
<a class="flights-best-price-button betterUpsellPriceButton" href="/shop/flights/results/roundtrip/<?php echo $sFrom?>/<?php echo $sTo?>/<?php echo $sDepartureDate?>/<?php echo $sReturningDate?>/<?php echo $sAdults?>/<?php echo $sChildren?>/<?php echo $sInfants?>/NA/NA/{{betterUpsellPrice.cabinType.code}}/NA/NA" target="_blank">
<span>Ver precio »</span>
</a>
</div>
</div>
</div>
</div>
{{/if}}
{{/compare}}
{{else}}
{{#if betterUpsellPrice}}
<div class="best-price-alert">
<div class="betterUpsellPrice">
<div class="primary-message">
<div class="text-container">
<span class="icon-business-class"></span>
<span class="alert-description">
<span class="alert-text">
A partir de </span>
{{#each betterUpsellPrice.price}}
<span class="price-currency {{this.formatted.code}} alert-text">
<span class="currency">{{this.formatted.mask}}</span>
<span class="amount">{{this.formatted.amount}}</span>
</span>
{{/each}}
<span class="alert-text">
adicionales por adulto, </span>
<span class="alert-text-line">
usted puede acceder a la {{betterUpsellPrice.cabinType.description}} </span>
</span>
</div>
<div class="button-container">
<a class="flights-best-price-button betterUpsellPriceButton" href="/shop/flights/results/roundtrip/<?php echo $sFrom?>/<?php echo $sTo?>/<?php echo $sDepartureDate?>/<?php echo $sReturningDate?>/<?php echo $sAdults?>/<?php echo $sChildren?>/<?php echo $sInfants?>/NA/NA/{{betterUpsellPrice.cabinType.code}}/NA/NA" target="_blank">
<span>Ver precio »</span>
</a>
</div>
</div>
</div>
</div>
{{/if}}
{{/if}}
</script>


<div id="order" class="order" style="display: none;">
	<div class="insanelyBanner span6">
		<div class="insanelySpans span4">
			<span class="insanelycheap left">Insanely Cheap Business Class Tickets</span><br>
			<span class="foundit left">Found it cheaper somewhere?</span><span class="beatoffer">We can beat any offer!</span>
		</div>
		<a href="mailto:business@btctrip.com"><img id="insanelyCheapButton" class="getnowbtn" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/getnowbtn.png') ?>"></a>
	</div>   
	
<form class="order-form">
<ul>
<li class="orderby">
<label for="orderby">
<span class="orderTitle">Sort by</span>
<select name="orderby" id="orderby" class="flights-select">
<option value="FARE_DESCENDING" >Prices descending</option>
<option value="FARE_ASCENDING" >Prices ascending</option>
<option value="STOPSCOUNT_DESCENDING" >Stops descending</option>
<option value="STOPSCOUNT_ASCENDING" >Stops ascending</option>
<option value="TOTALFARE_ASCENDING" selected>Total price ascending</option>
<option value="TOTALFARE_DESCENDING" >Total price descending</option>
<option value="PERSONAL_ASCENDING" >Bestsellers</option>
</select>
</label>
</li>
</ul>
</form>
</div>

<div id="results-messages" class="messages" style="display: none;">
<span class="commonSprite warningSymbol"></span>
<div class="text">
<span class="message"></span>
<span class="help"></span>
</div>
</div>
<div id="results-error" class="results-error messages" style="display: none;">
<span class="commonSprite warningSymbol"></span>
<div class="text">
<span class="message">No seats available to match your request</span>
<span class="help">
Make a new search with closer cities or other dates. <br> Some routes are active in the peak season.:
</span>
</div>
</div>
<div id="filters-error" class="filters-error messages" style="display: none;">
<span class="commonSprite warningSymbol"></span>
<div class="text">
<span class="message">Sorry, we did not find any flight with the selected criteria.</span>
<span class="help"><a href="#" class="remove-last-action">Undo last action.</a></span>
</div>
</div>
<div id="clusters" class="clusters" style="display: none;"></div>

<script id="cluster-template" type="text/x-handlebars-template">
{{#_each this.items}}
<div class="cluster flights-cluster oldCluster" data-cluster-info='{ "index" : {{_data.index}}, "hash" : "{{data.id}}" }'>
<div class="itineraries">
{{#if data.itinerariesBox.outboundRoutes.length}}
<div class="sub-cluster outbound">
<ul class="item data">
<!--<li class="type-icon">
<span class="main-sprite icon-plane-outbound"></span>
</li>-->
<li class="type">
<span>Outbound</span>
</li>
<li class="city-departure">
{{data.itinerariesBox.outboundLocations.departure.city.description}},
</li>
<li class="airport">
<a data-location-info='{ "clusterIndex" : {{_data.index}}, "itineraryType" : "outbound", "locationType" : "departure" }'>
{{data.itinerariesBox.outboundLocations.departure.airport.code}}
</a>
</li>
<li class="arrow">
<span class="main-sprite icon-arrow"></span>
</li>
<li class="city-arrival">
{{data.itinerariesBox.outboundLocations.arrival.city.description}},
</li>
<li class="airport">
<a data-location-info='{ "clusterIndex" : {{_data.index}}, "itineraryType" : "outbound", "locationType" : "arrival" }'>
{{data.itinerariesBox.outboundLocations.arrival.airport.code}}
</a>
</li>
<li class="date">
<span>{{data.itinerariesBox.outboundRoutes.0.departureDateTime.formatted.date}}</span>
</li>
</ul>
<ul class="itineraries-group cluster-items-list">
{{#_each data.itinerariesBox.outboundRoutes}}
<li class="item itinerary cluster-item {{#compare _data.total 1 operator=">"}}itinerary-required{{/compare}}" data-itinerary-info='{ "clusterIndex" : {{../_data.index}}, "itineraryType" : "outbound", "itineraryIndex" : {{_data.index}} }'>
<label for="{{../_data.index}}-outbound-{{_data.index}}">
<ul>
<li class="radio">
<input type="radio" name="{{../_data.index}}-outbound" id="{{../_data.index}}-outbound-{{_data.index}}" />
</li>
<li class="leave">
<span>Depart:</span>
<strong class="hour">{{data.departureDateTime.formatted.time}}</strong>
</li>
<li class="delays">
{{#if data.delaySeverity}}
<span title="Estadísticas de puntualidad del último mes informado" class="main-sprite "></span>
{{/if}}
</li>
<li class="arrive">
<span>Arrive:</span>
<strong class="hour">{{data.arrivalDateTime.formatted.time}}</strong>
</li>
<li class="time">
<span>{{data.totalDuration.formatted}}</span>
</li>
<li class="stops">
<a href="#" class="text">
{{#if data.stopCount}}
{{data.stopCount}}
{{#compare data.stopCount 1 operator="=="}}
Stop
{{/compare}}
{{#compare data.stopCount 2 operator=">="}}
Stops
{{/compare}}
{{else}}
Direct
{{/if}}
</a>
</li>
<li class="bus">
{{#if data.cityAirportChange}}
<span class="main-sprite icon-bus" title="Cambio de aeropuerto"></span>
{{/if}}
</li>
<li class="airlines">
{{#_each data.airlines}}
<span class="image">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/{{data.code}}.png" alt="{{data.description}}" title="{{data.description}}" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/default.png'" />
</span>
{{#showPlusIcon total=_data.total index=_data.index}}
<span class="mainsprite icon-plus"></span>
{{/showPlusIcon}}
{{#compare _data.total 1 operator="=="}}
<span class="name">{{data.description}}</span>
{{/compare}}
{{/_each}}
</li>
<li class="ecological">
</li>
<li class="error">
<span class="main-sprite icon-error"></span>
</li>
</ul>
</label>
</li>
{{/_each}}
<li class="item error-message">Please, choose an outbound time.</li>
</ul>
</div>
{{/if}}
{{#if data.itinerariesBox.inboundRoutes.length}}
<div class="sub-cluster inbound">
<ul class="item data">
<!-- <li class="type-icon">
<span class="main-sprite icon-plane-inbound"></span>
</li> -->
<li class="type">
<span>Inbound</span>
</li>
<li class="city-departure">
{{data.itinerariesBox.inboundLocations.departure.city.description}},
</li>
<li class="airport">
<a data-location-info='{ "clusterIndex" : {{_data.index}}, "itineraryType" : "inbound", "locationType" : "departure" }'>
{{data.itinerariesBox.inboundLocations.departure.airport.code}}
</a>
</li>
<li class="arrow">
<span class="main-sprite icon-arrow"></span>
</li>
<li class="city-arrival">
{{data.itinerariesBox.inboundLocations.arrival.city.description}},
</li>
<li class="airport">
<a data-location-info='{ "clusterIndex" : {{_data.index}}, "itineraryType" : "inbound", "locationType" : "arrival" }'>
{{data.itinerariesBox.inboundLocations.arrival.airport.code}}
</a>
</li>
<li class="date">
<span>{{data.itinerariesBox.inboundRoutes.0.departureDateTime.formatted.date}}</span>
</li>
</ul>
<ul class="itineraries-group cluster-items-list">
{{#_each data.itinerariesBox.inboundRoutes}}
<li class="item itinerary cluster-item {{#compare _data.total 1 operator=">"}}itinerary-required{{/compare}}" data-itinerary-info='{ "clusterIndex" : {{../_data.index}}, "itineraryType" : "inbound", "itineraryIndex" : {{_data.index}} }'>
<label for="{{../_data.index}}-inbound-{{_data.index}}">
<ul>
<li class="radio">
<input type="radio" name="{{../_data.index}}-inbound" id="{{../_data.index}}-inbound-{{_data.index}}" />
</li>
<li class="leave">
<span>Depart:</span>
<strong class="hour">{{data.departureDateTime.formatted.time}}</strong>
</li>
<li class="delays">
{{#if data.delaySeverity}}
<span title="Estadísticas de puntualidad del último mes informado" class="main-sprite "></span>
{{/if}}
</li>
<li class="arrive">
<span>Arrive:</span>
<strong class="hour">{{data.arrivalDateTime.formatted.time}}</strong>
</li>
<li class="time">
<span>{{data.totalDuration.formatted}}</span>
</li>
<li class="stops">
<a href="#" class="text">
{{#if data.stopCount}}
{{data.stopCount}}
{{#compare data.stopCount 1 operator="=="}}
Stop
{{/compare}}
{{#compare data.stopCount 2 operator=">="}}
Stops
{{/compare}}
{{else}}
Direct
{{/if}}
</a>
</li>
<li class="bus">
{{#if data.cityAirportChange}}
<span class="main-sprite icon-bus" title="Cambio de aeropuerto"></span>
{{/if}}
</li>
<li class="airlines">
{{#_each data.airlines}}
<span class="image">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/{{data.code}}.png" alt="{{data.description}}" title="{{data.description}}" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/default.png'" />
</span>
{{#showPlusIcon total=_data.total index=_data.index}}
<span class="mainsprite icon-plus"></span>
{{/showPlusIcon}}
{{#compare _data.total 1 operator="=="}}
<span class="name">{{data.description}}</span>
{{/compare}}
{{/_each}}
</li>
<li class="ecological">
</li>
<li class="error">
<span class="main-sprite icon-error"></span>
</li>
</ul>
</label>
</li>
{{/_each}}
<li class="item error-message">Please, choose a return time.</li>
</ul>
</div>
{{/if}}

</div>

<div class="fare-container">
<ul class="fare-detail">

<?php  	

if (isset($sAdults) && $sAdults == 1 && 
	(!isset($sChildrensCount) || (isset($sChildrensCount) && $sChildrensCount == 0)) && 
	(!isset($sInfants) || (isset($sInfants) && $sInfants == 0)) ) {   ?>
<span class="fare-description fare-description-only-adult price-comment"><a>Total price</a></span>
<span class="fare fare-only-adult">
{{#each data.itinerariesBox.itinerariesBoxPriceInfoList}}
<span class="price-currency {{total.fare.formatted.code}}">
<span class="currency">{{total.fare.formatted.mask}}</span>
<span class="amount">{{total.fare.formatted.amount}}</span>
</span>
{{/each}}
</span>

<?php  } else {   ?>
<span class="fare-description price-comment"><a>Price per adult</a></span>
<span class="fare">
{{#each data.itinerariesBox.itinerariesBoxPriceInfoList}}
<span class="price-currency {{adult.baseFare.formatted.code}}">
<span class="currency">{{adult.baseFare.formatted.mask}}</span>
<span class="amount">{{adult.totalOnlyOne.formatted.amount}}</span>
</span>
{{/each}}
</span>

<?php if ( (isset($sChildrensCount) && $sChildrensCount > 0) || (isset($sInfants) && $sInfants > 0)) {   ?>
<li>
<span class="item-detail"><?php echo $sAdults . " Adult" . (($sAdults > 1) ? "s" : "") ?></span>
<span class="item-price">
{{#each data.itinerariesBox.itinerariesBoxPriceInfoList}}
<span class="price-currency {{adult.totalFare.formatted.code}}">
<span class="currency">{{adult.totalFare.formatted.mask}}</span>
<span class="amount">{{adult.total.formatted.amount}}</span>
</span>
{{/each}}
</span>
</li>
<?php }  ?>
<?php if ( isset($sChildrensCount) && $sChildrensCount > 0) {   ?>
<li>
<span class="item-detail"><?php echo $sChildrensCount . " Children" . (($sChildrensCount > 1) ? "s" : "") ?></span>
<span class="item-price">
{{#each data.itinerariesBox.itinerariesBoxPriceInfoList}}
<span class="price-currency {{child.totalFare.formatted.code}}">
<span class="currency">{{child.totalFare.formatted.mask}}</span>
<span class="amount">{{child.total.formatted.amount}}</span>
</span>
{{/each}}
</span>
</li>
<?php }  ?>
<?php if ( isset($sInfants) && $sInfants > 0) {   ?>
<li>
<span class="item-detail"><?php echo $sInfants . " Infant" . (($sInfants > 1) ? "s" : "") ?></span>
<span class="item-price">
{{#each data.itinerariesBox.itinerariesBoxPriceInfoList}}
<span class="price-currency {{infant.totalFare.formatted.code}}">
<span class="currency">{{infant.totalFare.formatted.mask}}</span>
<span class="amount">{{infant.total.formatted.amount}}</span>
</span>
{{/each}}
</span>
</li>
<?php }  ?>

<li class="fare-price">
<span class="item-detail">Total</span>
<span class="item-price">
{{#each data.itinerariesBox.itinerariesBoxPriceInfoList}}
<span class="price-currency {{total.fare.formatted.code}}">
<span class="currency">{{total.fare.formatted.mask}}</span>
<span class="amount">{{total.fare.formatted.amount}}</span>
</span>
{{/each}}
</span>
</li>

<?php } ?>

</ul>

<a href="#" class="buy btn-buy flights-button">
<span>Buy</span>
</a>

</div>
</div>
{{/_each}}
</script>
<script id="popup-price-comment-template" type="text/x-handlebars-template">
<p>All prices include fees and taxes.</p>
</script>
<script id="popup-airport-template" type="text/x-handlebars-template">
<p>{{city.description}}</p>
<p>{{airport.description}}</p>
</script>
<script id="popup-delays-template" type="text/x-handlebars-template">
<div class="delays">
<div class="flights-list-grid">
<ul class="delays-keys-column">
<li class="head">
<span class="description-flight">{{this.departureCityCode}} - {{this.arrivalCityCode}}</span>
</li>
{{#_each this.delays}}
<li class="{{even_odd _data.index}}">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/{{data.leg.airline.code}}.png" alt="{{data.leg.airline.description}}" title="{{data.leg.airline.description}}" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/default.png'" />
{{data.leg.airline.code}} {{data.leg.flightNumber}}
</li>
{{/_each}}
</ul>
<ul>
<li class="head">Tramo</li>
{{#_each this.delays}}
<li class="{{even_odd _data.index}}">
{{#compare data.leg.departure.code "null" operator="!="}}
{{data.leg.departure.code}}
{{/compare}}
-
{{#compare data.leg.arrival.code "null" operator="!="}}
{{data.leg.arrival.code}}
{{/compare}}
</li>
{{/_each}}
</ul>
<ul>
<li class="head">Atrasos + 30 min</li>
{{#_each this.delays}}
<li class="{{even_odd _data.index}}">
{{#compare data.moreThan30MinutesPercent "null" operator="!="}}
{{data.moreThan30MinutesPercent}} %
{{else}}
-
{{/compare}}
</li>
{{/_each}}
</ul>
<ul>
<li class="head">Atrasos + 60 min</li>
{{#_each this.delays}}
<li class="{{even_odd _data.index}}">
{{#compare data.moreThan60MinutesPercent "null" operator="!="}}
{{data.moreThan60MinutesPercent}} %
{{else}}
-
{{/compare}}
</li>
{{/_each}}
</ul>
<ul>
<li class="head">Cancelaciones</li>
{{#_each this.delays}}
<li class="{{even_odd _data.index}}">
{{#compare data.cancelledPercent "null" operator="!="}}
{{data.cancelledPercent}} %
{{else}}
-
{{/compare}}
</li>
{{/_each}}
</ul>
</div>
<div class="ANAC-info-container">
<div class="delays-src-container">
<a class="show-ANAC-info" href="javascript:;">Fuente: ANAC</a>
</div>
<p class="information-ANAC">
The information provided on the % of delays and cancellations historic domestic and international flights according to <a href="http://www2.anac.gov.br/percentuaisdeatraso/" target="_blank">http://www2.anac.gov.br/percentuaisdeatraso/</a>.
</p>
</div>
</div>
</script>
<script id="popup-detail-template" type="text/x-handlebars-template">
<div class="detail">
{{#_each this.segments}}
{{#segmentHasAirportChange list index}}
<div class="small-message">The cost of the transit between the airports it is not included in the fare.</div>
{{/segmentHasAirportChange}}
<div class="segment">
<ul class="detail-info">
<li class="data">
<span class="name">
{{get array= "First segment,Second segment,Third segment,Fourth segmente,Fifth segment,Sixth segment" index=_data.index}}
</span>
<span>-</span>
<span class="number">Flight {{data.flightNumber}}</span>
<span>-</span>
<span class="class">{{data.cabinTypeDescription}}</span>
<span class="airline">
<span class="logo">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/{{data.carrier.code}}.png" alt="{{data.carrier.description}}" title="{{data.carrier.description}}" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/default.png'" />
</span>
<strong class="name">{{data.carrier.description}}</strong>
</span>
</li>
<li class="itinerary">
<span class="location">Depart from {{data.departure.location.city.description}}, {{data.departure.location.airport.description}} ({{data.departure.location.airport.code}})</span>
<span class="date">{{data.departure.date.formatted}} - {{data.departure.hour.formatted}}</span>
</li>
<li class="itinerary">
<span class="location">Arrive at {{data.arrival.location.city.description}}, {{data.arrival.location.airport.description }} ({{data.arrival.location.airport.code}})</span>
<span class="date">{{data.arrival.date.formatted}} - {{data.arrival.hour.formatted}}</span>
</li>
{{#compare data.carrier.code data.operatingCarrier.code operator="!=" }}
<li>
<ul class="operated-by">
<li class="title">Flight operated by:</li>
<li class="logo">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/{{data.operatingCarrier.code}}.png" alt="{{data.operatingCarrier.description}}" title="{{data.operatingCarrier.description}}" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/default.png'" />
</li>
<li class="name"><strong>{{data.operatingCarrier.description}}</strong></li>
</ul>
</li>
{{/compare}}
{{#if data.stopovers}}
<li class="stops">
<ul>
<li class="title">Stops:</li>
{{#each data.stopovers}}
<li class ="stop">- {{location.city.description}}</li>
{{/each}}
</ul>
</li>
{{/if}}
</ul>
</div>
{{#showConnection segments=../segments}}
<span class="time">
Connection time: {{_data.waitDuration.formatted}}
</span>
{{/showConnection}}
{{/_each}}
<div class="detail-footer">
<div >
<span class="total time">
Flight total time: {{totalDuration.formatted}}
</span>
<span class="detail-local-hour">Times in local time of each city</span>
</div>
{{#if this.carbonFootprintInfo}}
{{/if}}
<div class="rules">
<span class="airline">
<span class="logo">
{{#_each airlines}}
<span>
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/{{data.code}}.png" alt="{{data.description}}" title="{{data.description}}" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/default.png'" />
</span>
{{#showPlusIcon total=_data.total index=_data.index}}
<span class="mainsprite icon-plus"></span>
{{/showPlusIcon}}
{{#compare _data.total 1 operator="=="}}
<span class="name">
<strong>{{data.description}}</strong>
</span>
{{/compare}}
{{/_each}}
</span>
</span>
</div>
</div>
</div>
</script>


<div class="pagination" id="pagination"></div>
<script id="pagination-template" type="text/x-handlebars-template">
<ul>
{{#compare pages.length 7 operator=">"}}
<li class="pagination-button prev" data-page-number="{{calcule currentPage 1 symbol="-"}}">
<a data-page-number="{{calcule currentPage 1 symbol="-"}}">« Anterior</a>
</li>
{{#compare currentPage 4 operator="<"}}
<li class="page" data-page-number="1" >
<a data-page-number="1">1</a>
</li>
<li class="page" data-page-number="2" >
<a data-page-number="2">2</a>
</li>
<li class="page" data-page-number="3" >
<a data-page-number="3">3</a>
</li>
<li class="dots">
<a>...</a>
</li>
<li class="page" data-page-number="{{pages.length}}" >
<a data-page-number="{{pages.length}}">{{pages.length}}</a>
</li>
{{else}}
{{#compare currentPage lastPages operator=">"}}
<li class="page" data-page-number="1" >
<a data-page-number="1">1</a>
</li>
<li class="dots">
<a>...</a>
</li>
<li class="page" data-page-number="{{calcule pages.length 2 symbol="-"}}" >
<a data-page-number="{{calcule pages.length 2 symbol="-"}}">{{calcule pages.length 2 symbol="-"}}</a>
</li>
<li class="page" data-page-number="{{calcule pages.length 1 symbol="-"}}" >
<a data-page-number="{{calcule pages.length 1 symbol="-"}}">{{calcule pages.length 1 symbol="-"}}</a>
</li>
<li class="page" data-page-number="{{pages.length}}" >
<a data-page-number="{{pages.length}}">{{pages.length}}</a>
</li>
{{else}}
<li class="page" data-page-number="1" >
<a data-page-number="1">1</a>
</li>
<li class="dots">
<a>...</a>
</li>
<li class="page" data-page-number="{{currentPage}}" >
<a data-page-number="{{currentPage}}">{{currentPage}}</a>
</li>
<li class="dots">
<a>...</a>
</li>
<li class="page" data-page-number="{{pages.length}}" >
<a data-page-number="{{pages.length}}">{{pages.length}}</a>
</li>
{{/compare}}
{{/compare}}
<li class="pagination-button next" data-page-number="{{calcule currentPage 1 symbol="+"}}">
<a data-page-number="{{calcule currentPage 1 symbol="+"}}">Siguiente »</a>
</li>
{{else}}
{{#_each pages prevPage=prevPage}}
<li class="page" data-page-number="{{calcule _data.index 1 symbol="+"}}" >
<a data-page-number="{{calcule _data.index 1 symbol="+"}}">{{calcule _data.index 1 symbol="+"}}</a>
</li>
{{/_each}}
{{/compare}}
</ul>
</script>
<script id="popup-reviews-template" type="text/x-handlebars-template">
<div class="reviews">
<div class="popup-header">
<div class="airline">
<span class="logo">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/{{airline.code}}.png" alt="{{airline.description}}" title="{{airline.description}}" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/airlines') ?>/default.png'" />
</span>
<h4 class="name">{{airline.description}}</h4>
</div>
</div>
<div class="details">
<ul class="items">
<li class="item first">
<ul>
<li class="description">{{inAirportDetails.average.description}}</li>
<li class="bars">
<span class="commonSprite empty-bars">
<span class="commonSprite full-bars" style='width: {{calcule inAirportDetails.average.score 10 symbol="*"}}%;'></span>
</span>
</li>
<li class="points">{{inAirportDetails.average.score}}</li>
</ul>
</li>
{{#each inAirportDetails.categories}}
<li class="item">
<ul>
<li class="description">{{description}}</li>
<li class="bars">
<span class="commonSprite empty-bars">
<span class="commonSprite full-bars" style='width: {{calcule score 10 symbol="*"}}%;'></span>
</span>
</li>
<li class="points">{{score}}</li>
</ul>
</li>
{{/each}}
</ul>
<ul class="items">
<li class="item first">
<ul>
<li class="description">{{inPlaneDetails.average.description}}</li>
<li class="bars">
<span class="commonSprite empty-bars">
<span class="commonSprite full-bars" style='width: {{calcule inPlaneDetails.average.score 10 symbol="*"}}%;'></span>
</span>
</li>
<li class="points">{{inPlaneDetails.average.score}}</li>
</ul>
</li>
{{#each inPlaneDetails.categories}}
<li class="item">
<ul>
<li class="description">{{description}}</li>
<li class="bars">
<span class="commonSprite empty-bars">
<span class="commonSprite full-bars" style='width: {{calcule score 10 symbol="*"}}%;'></span>
</span>
</li>
<li class="points">{{score}}</li>
</ul>
</li>
{{/each}}
</ul>
</div>
</div>
</script> 
</div>



<?php $view['slots']->stop() ?>


<?php $view['slots']->start('javascripts') ?>

<script>
	var urlSearchPrefixG = "<?php echo $enviromentPrefix ?>/results";
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
	
	<div class="results-update" style="display: none;">
	<img class="logo" src="">
	<p>Updating information</p>
	<img class="update-loader" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/loader.gif') ?>">
</div> 


<script>
require.config({
"baseUrl": "<?php echo $app->getRequest()->getSchemeAndHttpHost() ?>",
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
"libs.amplify": "<?php echo $app->getRequest()->getSchemeAndHttpHost().substr_replace($view['assets']->getUrl('bundles/btctrip/javascript/amplify-1.1.0.min.js'), '', -3) ?>",
"libs.handlebars": "<?php echo $app->getRequest()->getSchemeAndHttpHost().substr_replace($view['assets']->getUrl('bundles/btctrip/javascript/handlebars-1.0.0.beta.6.min.js'), '', -3) ?>",
"libs.jquery": "<?php echo $app->getRequest()->getSchemeAndHttpHost().substr_replace($view['assets']->getUrl('bundles/btctrip/javascript/jquery-1.7.1.min.js'), '', -3) ?>"
}
});
</script>
<script>
define('services', function() {
return {
search : '<?php echo $enviromentPrefix ?>/search/<?php echo $sTripType?>/<?php echo $sFrom?>/<?php echo $sTo?>/<?php echo $sDepartureDate?>/<?php echo ( $sReturningDate != "" ? $sReturningDate.'/' : "") ?><?php echo $sAdults?>/<?php echo $sChildren?>/<?php echo $sInfants?>/<?php echo $sOrderBy?>/<?php echo $sOrderDir?>/<?php echo $sDepartureTime?>/<?php echo ( $sReturningTime != "" ? $sReturningTime.'/' : "")?><?php echo $sClassFlight?>/<?php echo $sScaleFlight?>/<?php echo $sAirlineFlight?>',
refine : '<?php echo $enviromentPrefix ?>/refine/<?php echo strtoupper($sTripType)?>/<?php echo $sFrom?>/<?php echo $sTo?>/INTERNATIONAL/{hash}/{version}/{filterStrategy}/{orderCriteria}/{orderDirection}/{pageIndex}/{minPrice}/{maxPrice}/{originalCurrencyPrice}/{selectedCurrencyPrice}/{allowedOutboundTimeRanges}/{allowedInboundTimeRanges}/{allowedAirlines}/NA/{allowedStopQuantities}/{allowedOutboundAirports}/{allowedInboundAirports}/{uniqueAirline}/{uniqueHomeAirport}/NA/NA/NA/NA',
item : '<?php echo $enviromentPrefix ?>/item/<?php echo strtoupper($sTripType)?>/INTERNATIONAL/{hash}/{version}/{itemHash}'
};
});
define('options', function() {
return {
orderCriteria : '<?php echo strtoupper($sOrderBy)?>',
orderDirection : '<?php echo strtoupper($sOrderDir)?>',
personalSortId : 'UPA_1',
initialCurrency : 'USD',
clusters : { searchType : '<?php echo strtoupper($sTripType)?>',
initialCurrencyCode : 'USD',
redirectToCheckout : 'true',
checkoutHandlerUrl : '<?php echo $enviromentPrefix ?>/checkout/form/{hash}/{version}/{itineraryId}/{clusterIndexTraking}/{provider}/INTERNATIONAL'
}
};
});
define('messages', function() {
return {
clusters : { itineraries: {
detailTitle : 'Flight detail',
delaysTitle : 'Punctuality statistics reported of the last month'
},
actions: {
emailTitle : 'Share flight by e-mail',
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
"LOW" : "This flight present low delays.",
"MEDIUM" : "This flight present medium delays.",
"HIGH" : "This flight present high delays."
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
"MORNING" : "Morning (06 to 12hs)",
"AFTERNOON" : "Afternoon (12 to 20hs)",
"NIGHT" : "Night (20 to 00hs)",
"EARLY_MORNING" : "Early morning (00 to 06hs)"
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
currentDate : new Date( <?php echo time(); ?>),
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
anticipatedSearch : true
}
}
]
});
_box = box;
_box.setBoxOptions({ flights : {
dates : {
dateIn : new Date(<?php echo $sDepartureDateForSearchBox; ?>) 
,dateOut : new Date(<?php echo $sReturningDateForSearchBox; ?>)
},
places : {
destinationText : "<?php echo $sToName?>",
destinationValue : "<?php echo $sTo?>",
originText : "<?php echo $sFromName?>",
originValue : "<?php echo $sFrom?>"
},
<?php if ($sDepartureTime != 'NA' || $sReturningTime != 'NA' || $sScaleFlight != 'NA' || $sClassFlight != 'NA') { ?>
advanced: {
departureTime : '<?php echo $sDepartureTime?>',
returnTime : '<?php echo $sReturningTime?>',
scaleFlight : '<?php echo $sScaleFlight?>',
classFlight : '<?php echo $sClassFlight?>'
},
<?php } ?>
passengers : {
adults : <?php echo $sAdults?>,
childs : <?php echo $sChildrensCount?>,
infants : <?php echo $sInfants?>
},
triptypes : {
currentType : '<?php echo($sTripType=='oneway'? 'oneWay' : 'roundTrip') ?>'
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
<script>
require.config({
"paths": {

"libs.jquery.templates": "<?php echo $app->getRequest()->getSchemeAndHttpHost().substr_replace($view['assets']->getUrl('bundles/btctrip/javascript/jquery.tmpl-beta1.0.0.min'), '', -3) ?>",
"nibbler.autocomplete": "<?php echo $app->getRequest()->getSchemeAndHttpHost().substr_replace($view['assets']->getUrl('bundles/btctrip/javascript/autocomplete'), '', -3) ?>",
"handlebars": "<?php echo $app->getRequest()->getSchemeAndHttpHost().substr_replace($view['assets']->getUrl('bundles/btctrip/javascript/handlebars-1.0.0.beta.6.min.js'), '', -3) ?>",
"amplify": "<?php echo $app->getRequest()->getSchemeAndHttpHost().substr_replace($view['assets']->getUrl('bundles/btctrip/javascript/amplify-1.1.0.min'), '', -3) ?>",
"libs.json": "<?php echo $app->getRequest()->getSchemeAndHttpHost().substr_replace($view['assets']->getUrl('bundles/btctrip/javascript/json2.min'), '', -3) ?>"
},
"shim": {
"libs.jquery.templates": {
"deps": ["jquery"]
},
"nibbler.autocomplete": {
"deps": ["jquery", "libs.jquery.templates"]
},
"handlebars": {
"exports": "Handlebars"
},
"amplify": {
"deps": ["jquery"],
"exports": "amplify"
}
}
});
if (typeof(Handlebars) === "undefined") {
define("nibbler.handlebars", ["handlebars"], function() {
return Handlebars;
});
} else {
define("nibbler.handlebars", [], function() {
return Handlebars;
});
}
if (typeof(amplify) === "undefined") {
define("nibbler.amplify", ["amplify"], function() {
return amplify;
});
} else {
define("nibbler.amplify", [], function() {
return amplify;
});
}
if (typeof(jQuery.tmpl) === "undefined") {
define("nibbler.jquery.templates", ["libs.jquery.templates"], function() {
return jQuery.tmpl;
});
} else {
define("nibbler.jquery.templates", [], function() {
return jQuery.tmpl;
});
}
if (typeof(JSON) === "undefined") {
define("nibbler.json", ["libs.json"], function() {
return JSON;
});
} else {
define("nibbler.json", [], function() {
return JSON;
});
}
if (typeof(Nibbler) === "undefined" || Nibbler.hasOwnProperty("Autocomplete") === false) {
define("nibbler.alerts.autocomplete", ["nibbler.autocomplete"], function() {
function loadCss(url) {
var link = document.createElement("link");
link.type = "text/css";
link.rel = "stylesheet";
link.href = url;
document.getElementsByTagName("head")[0].appendChild(link);
}
loadCss("<?php echo $view['assets']->getUrl('bundles/btctrip/styles/autocomplete.css') ?>");
return Nibbler.Autocomplete.js.Autocomplete;
});
} else {
define("nibbler.alerts.autocomplete", [], function() {
return Nibbler.Autocomplete.js.Autocomplete;
});
}
define("nibbler.alerts.options", function() {
return {
autocomplete: {
url : '/frontendservices-web/Autocomplete/',
type: 'flights'
},
multiselect: {
selectedText : "meses",
noneSelectedText : "Input a travel month"
},
country: "AR"
};
});
</script>
<script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/results.js') ?>"></script>
<!--header-js-->
<script type="text/javascript" charset="utf-8" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/popup.js') ?>"></script>
<script type="text/javascript">
$(document).ready(function(){
$('.link-cars, .link-hotels, .link-flights, .link-packages, .link-cruises').click(function(){
window.location.href=$(this).find('a').attr("href");
});
var popupBestPrice = Nibbler.Popup.js.Creator({
id:'popupBestPrice',
title:'btctrip.com: we love flight with bitcoins',
noPuntita:false
});
$(popupBestPrice).hide();
$('#header').append(popupBestPrice);
$('.popUpContent','#popupBestPrice').append('<p class="popupBestServiceText">We work every day to help you save time and money on your shopping trip. We want you to rest assured that every time you purchase Despegar.com is accessing the best rates available. So now we guarantee that Despegar.com you find the best rates on flights, hotels and rental cars, in the event you a better rate encontrase give you the difference up to a maximum of USD 100, the change official day of issuance of the voucher, as a credit on a future purchase in our site</p>');
$('.popUpContent','#popupBestPrice').append('<a href="/commercial-web/betterprice/termsandconditions" target="_blank">The best price - guaranteed!</a>');
$('.bestPricelogo').click(function(){
$('#popupBestPrice').css({
'top': '135px',
'left': '767px'
});
(($.browser.msie && ($.browser.version < '8')) ? $('#popupBestPrice').show() : $('#popupBestPrice').fadeIn());
});
$('#countrySlogan').click(function(){
$('#popupCountries').hide();
$('#popupCountries').css('top', '75px');
$('#popupCountries').css('left', $('#countrySlogan').position().left - 80);
if($.browser.msie && ($.browser.version < '8')){
$('#popupTelephones').hide();
$('#popupCountries').show();
}else{
$('#popupTelephones').fadeOut();
$('#popupCountries').fadeIn();
}
});
$('.BR#officeTelephones').click(function(){
if($.browser.msie && ($.browser.version < '8')){
$('#popupCountries').hide();
$('#popupTelephones').show();
}else{
$('#popupCountries').fadeOut();
$('#popupTelephones').fadeIn();
}
});
$('.AR#officeTelephones').click(function(){
if($.browser.msie && ($.browser.version < '8')){
$('#popupCountries').hide();
$('.mod-tooltip').show();
hideOnClick();
}else{
$('#popupCountries').fadeOut();
$('.mod-tooltip').fadeIn();
hideOnClick();
}
});
$('#popupCountries .closePopUp, #popupCountries .cancel').click (function(){
(($.browser.msie && ($.browser.version < '8')) ? $('#popupCountries').hide() : $('#popupCountries').fadeOut());
return false;
});
$('#popupTelephones .closePopUp, #popupTelephones .cancel').click (function(){
(($.browser.msie && ($.browser.version < '8')) ? $('#popupTelephones').hide() : $('#popupTelephones').fadeOut());
return false;
});
$('.mod-tooltip .close-tooltip, .mod-tooltip .cancel').click (function(){
(($.browser.msie && ($.browser.version < '8')) ? $('.mod-tooltip').hide() : $('.mod-tooltip').fadeOut());
return false;
});
var hideOnClick = function()
{
$( document ).one( 'mousedown', function( event )
{
var target = $( event.target );
// Se oculta si el click fue hecho fuera del area del tooltip
if ( !target.is( 'div.mod-tooltip' ) && target.parents( 'div.mod-tooltip' ).length == 0 )
{
if($.browser.msie && ($.browser.version < '8')){
$('div.mod-tooltip').hide();
}else{
$('div.mod-tooltip').fadeOut();
}
}
else
{
hideOnClick();
}
});
};
$('#popupCountries .submit').click(function() {
var cityCode = $("select.countries option:selected" ).data("code");
if (cityCode) {
Common.Utils.Cookie.CreateCookie("GeoHome",cityCode,400);
}
location.href = "http://" + $(".countries").val();
});
});
</script>
<!--header-js END-->

<!--searchbox-js-->
<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/searchboxHelper.js') ?>"></script>
<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/searchbox.fl.js') ?>"></script>
<script charset="utf-8" type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/top-airlines-cities-ar.js') ?>"></script>
<script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/autocomplete.js') ?>"></script>
<!--searchbox-js END-->

<!--footer-js-->
<script type="text/javascript" charset="utf-8" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/footer.js') ?>"></script>

<script type="text/javascript">

$(document).ready(function(){
var fakeLinks = new linkListCreator();
var linkList= {
ulId:"#about-list",
section:"home",
language:"en",
linkType:"span",
links :
[
{
linkText: "Confidentiality policy",
linkRef: "/confidentiality",
linkTarget: "_blank",
linkClass: "item",
linkId: ""
},
{
linkText: "Best price",
linkRef: "/betterprice-termsandconditions",
linkTarget: "_blank",
linkClass: "item",
linkId: ""
}
]
}
fakeLinks.draw(linkList);
var fakeLink = new Nibbler.Footer.js.FakeLinkCreator();
var website={
linkText: "BtcTrip.com",
linkRef: "http://BtcTrip.com",
linkClass: "",
linkId: ""
}
<!--UPA-TRACKER-->
});
</script>
<!--footer-js END-->


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
			{msg:'Alitalia'}
			,
			{msg:'Air France'}
			,
			{msg:'Iberia'}
			,
			{msg:'Air Europa'}
			,
			{msg:'KLM'}
			,
			{msg:'Lufthansa'}
			,
			{msg:'British Airways'}
			,
			{msg:'Swiss'}
			,
			{msg:'American Airlines'}
			,
			{msg:'Tunisair'}
			,
			{msg:'Jat Airways'}
		] ,
		delay: Math.floor(454,545)
	}
}
var ChargeOffers= new Nibbler.SearchingAnimation.js.searchingAnimation(optionSearching);
ChargeOffers.init();
<!--searching-animation-init END-->
</script>

<?php $view['slots']->stop() ?>


