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

$jsLibsBaseUrl = str_replace('/app_dev.php', '', $app->getRequest()->getBaseUrl()).$view['assets']->getUrl('bundles/btctrip/javascript');
?>

<?php $view['slots']->set('bodyClass', 'results') ?>

<?php $view['slots']->start('stylesheets') ?>

		<!--searchbox-css-->
		<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/fl-small.css') ?>"/>
		<!--searchbox-css END-->
		<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/flights-web-results.css') ?>">
		<!--searching-animation-css-->
		<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/searching-animation.css') ?>"/>
		<!--searching-animation-css END-->

<?php $view['slots']->stop() ?>


<?php /*
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/airplane-background-1280.jpg') ?>" class="source-image">
*/ ?>


<?php $view['slots']->start('mainContent') ?>

<div class="results-top grid_24">
<h1 id="title" class="title page-title">
With bitcoins your trip is cheaper
</h1>

</div>
<div class="grid_6 alpha">
<div class="search">
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
<h2 class="producttitle">Search flights</h2>
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
Eliminar tramo</div> <p class="segmenttitle">Tramo 1</p>
<div class="mod-places">
<div class="com-city origin">
<label for="sb-origin-1-flights" id="lbl-origin-1-flights">Origen</label>
<input type="text" class="sb-origin" id="sb-origin-1-flights" placeholder="Ingrese una ciudad de origen" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un origen.</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un origen válido.</span></p>
</div>
<div class="com-city destination">
<label for="sb-destination-1-flights" id="lbl-destination-1-flights">Destino</label>
<input type="text" class="sb-destination" id="sb-destination-1-flights" placeholder="Ingrese una ciudad de destino" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un destino.</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un destino válido.</span></p>
</div>
<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">El destino debe ser diferente del origen.</span></p>
</div>
<div class="mod-dates">
<div class="com-datein">
<label for="sb-datein-1-flights" id="lbl-datein-1-flights">Partida</label>
<input type="text" class="sb-datein" id="sb-datein-1-flights" placeholder=dd/mm/aaaa maxlength=10 />
<span class="commonSprite buttonCalendarOn"></span>
</div>
<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese una fecha de partida válida.</span></p>
<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">La salida debe ser posterior a la entrada.</span></p>
<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese una fecha de partida.</span></p>
<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">La fecha de partida no está dentro del rango permitido.</span></p>
</div>
</div>
<div class="segment-2 ">
<div class="com-deletesegment">
Eliminar tramo</div> <p class="segmenttitle">Tramo 2</p>
<div class="mod-places">
<div class="com-city origin">
<label for="sb-origin-2-flights" id="lbl-origin-2-flights">Origen</label>
<input type="text" class="sb-origin" id="sb-origin-2-flights" placeholder="Ingrese una ciudad de origen" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un origen.</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un origen válido.</span></p>
</div>
<div class="com-city destination">
<label for="sb-destination-2-flights" id="lbl-destination-2-flights">Destino</label>
<input type="text" class="sb-destination" id="sb-destination-2-flights" placeholder="Ingrese una ciudad de destino" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un destino.</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un destino válido.</span></p>
</div>
<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">El destino debe ser diferente del origen.</span></p>
</div>
<div class="mod-dates">
<div class="com-datein">
<label for="sb-datein-2-flights" id="lbl-datein-2-flights">Partida</label>
<input type="text" class="sb-datein" id="sb-datein-2-flights" placeholder=dd/mm/aaaa maxlength=10 />
<span class="commonSprite buttonCalendarOn"></span>
</div>
<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese una fecha de partida válida.</span></p>
<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">La salida debe ser posterior a la entrada.</span></p>
<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese una fecha de partida.</span></p>
<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">La fecha de partida no está dentro del rango permitido.</span></p>
</div>
</div>
<div class="segment-3 hidden">
<div class="com-deletesegment">
Eliminar tramo</div> <p class="segmenttitle">Tramo 3</p>
<div class="mod-places">
<div class="com-city origin">
<label for="sb-origin-3-flights" id="lbl-origin-3-flights">Origen</label>
<input type="text" class="sb-origin" id="sb-origin-3-flights" placeholder="Ingrese una ciudad de origen" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un origen.</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un origen válido.</span></p>
</div>
<div class="com-city destination">
<label for="sb-destination-3-flights" id="lbl-destination-3-flights">Destino</label>
<input type="text" class="sb-destination" id="sb-destination-3-flights" placeholder="Ingrese una ciudad de destino" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un destino.</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un destino válido.</span></p>
</div>
<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">El destino debe ser diferente del origen.</span></p>
</div>
<div class="mod-dates">
<div class="com-datein">
<label for="sb-datein-3-flights" id="lbl-datein-3-flights">Partida</label>
<input type="text" class="sb-datein" id="sb-datein-3-flights" placeholder=dd/mm/aaaa maxlength=10 />
<span class="commonSprite buttonCalendarOn"></span>
</div>
<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese una fecha de partida válida.</span></p>
<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">La salida debe ser posterior a la entrada.</span></p>
<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese una fecha de partida.</span></p>
<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">La fecha de partida no está dentro del rango permitido.</span></p>
</div>
</div>
<div class="segment-4 hidden">
<div class="com-deletesegment">
Eliminar tramo</div> <p class="segmenttitle">Tramo 4</p>
<div class="mod-places">
<div class="com-city origin">
<label for="sb-origin-4-flights" id="lbl-origin-4-flights">Origen</label>
<input type="text" class="sb-origin" id="sb-origin-4-flights" placeholder="Ingrese una ciudad de origen" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un origen.</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un origen válido.</span></p>
</div>
<div class="com-city destination">
<label for="sb-destination-4-flights" id="lbl-destination-4-flights">Destino</label>
<input type="text" class="sb-destination" id="sb-destination-4-flights" placeholder="Ingrese una ciudad de destino" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un destino.</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un destino válido.</span></p>
</div>
<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">El destino debe ser diferente del origen.</span></p>
</div>
<div class="mod-dates">
<div class="com-datein">
<label for="sb-datein-4-flights" id="lbl-datein-4-flights">Partida</label>
<input type="text" class="sb-datein" id="sb-datein-4-flights" placeholder=dd/mm/aaaa maxlength=10 />
<span class="commonSprite buttonCalendarOn"></span>
</div>
<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese una fecha de partida válida.</span></p>
<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">La salida debe ser posterior a la entrada.</span></p>
<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese una fecha de partida.</span></p>
<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">La fecha de partida no está dentro del rango permitido.</span></p>
</div>
</div>
<div class="segment-5 hidden">
<div class="com-deletesegment">
Eliminar tramo</div> <p class="segmenttitle">Tramo 5</p>
<div class="mod-places">
<div class="com-city origin">
<label for="sb-origin-5-flights" id="lbl-origin-5-flights">Origen</label>
<input type="text" class="sb-origin" id="sb-origin-5-flights" placeholder="Ingrese una ciudad de origen" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un origen.</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un origen válido.</span></p>
</div>
<div class="com-city destination">
<label for="sb-destination-5-flights" id="lbl-destination-5-flights">Destino</label>
<input type="text" class="sb-destination" id="sb-destination-5-flights" placeholder="Ingrese una ciudad de destino" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un destino.</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un destino válido.</span></p>
</div>
<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">El destino debe ser diferente del origen.</span></p>
</div>
<div class="mod-dates">
<div class="com-datein">
<label for="sb-datein-5-flights" id="lbl-datein-5-flights">Partida</label>
<input type="text" class="sb-datein" id="sb-datein-5-flights" placeholder=dd/mm/aaaa maxlength=10 />
<span class="commonSprite buttonCalendarOn"></span>
</div>
<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese una fecha de partida válida.</span></p>
<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">La salida debe ser posterior a la entrada.</span></p>
<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese una fecha de partida.</span></p>
<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">La fecha de partida no está dentro del rango permitido.</span></p>
</div>
</div>
<div class="segment-6 hidden">
<div class="com-deletesegment">
Eliminar tramo</div> <p class="segmenttitle">Tramo 6</p>
<div class="mod-places">
<div class="com-city origin">
<label for="sb-origin-6-flights" id="lbl-origin-6-flights">Origen</label>
<input type="text" class="sb-origin" id="sb-origin-6-flights" placeholder="Ingrese una ciudad de origen" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un origen.</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un origen válido.</span></p>
</div>
<div class="com-city destination">
<label for="sb-destination-6-flights" id="lbl-destination-6-flights">Destino</label>
<input type="text" class="sb-destination" id="sb-destination-6-flights" placeholder="Ingrese una ciudad de destino" />
<p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un destino.</span></p>
<p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese un destino válido.</span></p>
</div>
<p class="error repeatedCity hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">El destino debe ser diferente del origen.</span></p>
</div>
<div class="mod-dates">
<div class="com-datein">
<label for="sb-datein-6-flights" id="lbl-datein-6-flights">Partida</label>
<input type="text" class="sb-datein" id="sb-datein-6-flights" placeholder=dd/mm/aaaa maxlength=10 />
<span class="commonSprite buttonCalendarOn"></span>
</div>
<p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese una fecha de partida válida.</span></p>
<p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">La salida debe ser posterior a la entrada.</span></p>
<p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese una fecha de partida.</span></p>
<p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">La fecha de partida no está dentro del rango permitido.</span></p>
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
<!--
<div class="com-age-flights hidden">
<label class="agenotificationtravel">Ages at the end of the travel.</label>
<label class="agenotificationdate hidden">Age at<span class="date">__/__/____</span></label>
<ul class="ctn-select-ages">
	<li class="ctn-select-age ctn-1">
		<select class="selectAge">
		<option value="-1" class="age-1" selected="selected" >Edad del niño 1</option>
		<option value="0" class="age-2">0 a 24 meses (en brazos)</option>
		<option value="I" class="age-3">0 a 24 meses (en asiento)</option>
		<option value="C" class="age-4">2 a 11 años</option>
		<option value="2" class="age-5">12 años o más</option>
		</select>
		<div class="rateMessage infant hidden"><span class="arrow"></span>Tarifa bebe</div>
		<div class="rateMessage children hidden"><span class="arrow"></span>Tarifa niño</div>
		<div class="rateMessage adult hidden"><span class="arrow"></span>Tarifa adulto</div>
		<p class="error hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese la edad.</span></p>
	</li>
	<li class="ctn-select-age ctn-2">
		<select class="selectAge">
		<option value="-1" class="age-1" selected="selected" >Edad del niño 2</option>
		<option value="0" class="age-2">0 a 24 meses (en brazos)</option>
		<option value="I" class="age-3">0 a 24 meses (en asiento)</option>
		<option value="C" class="age-4">2 a 11 años</option>
		<option value="2" class="age-5">12 años o más</option>
		</select>
		<div class="rateMessage infant hidden"><span class="arrow"></span>Tarifa bebe</div>
		<div class="rateMessage children hidden"><span class="arrow"></span>Tarifa niño</div>
		<div class="rateMessage adult hidden"><span class="arrow"></span>Tarifa adulto</div>
		<p class="error hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese la edad.</span></p>
	</li>
	<li class="ctn-select-age ctn-3">
		<select class="selectAge">
		<option value="-1" class="age-1" selected="selected" >Edad del niño 3</option>
		<option value="0" class="age-2">0 a 24 meses (en brazos)</option>
		<option value="I" class="age-3">0 a 24 meses (en asiento)</option>
		<option value="C" class="age-4">2 a 11 años</option>
		<option value="2" class="age-5">12 años o más</option>
		</select>
		<div class="rateMessage infant hidden"><span class="arrow"></span>Tarifa bebe</div>
		<div class="rateMessage children hidden"><span class="arrow"></span>Tarifa niño</div>
		<div class="rateMessage adult hidden"><span class="arrow"></span>Tarifa adulto</div>
		<p class="error hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese la edad.</span></p>
	</li>
	<li class="ctn-select-age ctn-4">
		<select class="selectAge">
		<option value="-1" class="age-1" selected="selected" >Edad del niño 4</option>
		<option value="0" class="age-2">0 a 24 meses (en brazos)</option>
		<option value="I" class="age-3">0 a 24 meses (en asiento)</option>
		<option value="C" class="age-4">2 a 11 años</option>
		<option value="2" class="age-5">12 años o más</option>
		</select>
		<div class="rateMessage infant hidden"><span class="arrow"></span>Tarifa bebe</div>
		<div class="rateMessage children hidden"><span class="arrow"></span>Tarifa niño</div>
		<div class="rateMessage adult hidden"><span class="arrow"></span>Tarifa adulto</div>
		<p class="error hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese la edad.</span></p>
	</li>
	<li class="ctn-select-age ctn-5">
	<select class="selectAge">
	<option value="-1" class="age-1" selected="selected" >Edad del niño 5</option>
	<option value="0" class="age-2">0 a 24 meses (en brazos)</option>
	<option value="I" class="age-3">0 a 24 meses (en asiento)</option>
	<option value="C" class="age-4">2 a 11 años</option>
	<option value="2" class="age-5">12 años o más</option>
	</select>
	<div class="rateMessage infant hidden"><span class="arrow"></span>Tarifa bebe</div>
	<div class="rateMessage children hidden"><span class="arrow"></span>Tarifa niño</div>
	<div class="rateMessage adult hidden"><span class="arrow"></span>Tarifa adulto</div>
	<p class="error hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese la edad.</span></p>
	</li>
	<li class="ctn-select-age ctn-6">
	<select class="selectAge">
	<option value="-1" class="age-1" selected="selected" >Edad del niño 6</option>
	<option value="0" class="age-2">0 a 24 meses (en brazos)</option>
	<option value="I" class="age-3">0 a 24 meses (en asiento)</option>
	<option value="C" class="age-4">2 a 11 años</option>
	<option value="2" class="age-5">12 años o más</option>
	</select>
	<div class="rateMessage infant hidden"><span class="arrow"></span>Tarifa bebe</div>
	<div class="rateMessage children hidden"><span class="arrow"></span>Tarifa niño</div>
	<div class="rateMessage adult hidden"><span class="arrow"></span>Tarifa adulto</div>
	<p class="error hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese la edad.</span></p>
	</li>
	<li class="ctn-select-age ctn-7">
	<select class="selectAge">
	<option value="-1" class="age-1" selected="selected" >Edad del niño 7</option>
	<option value="0" class="age-2">0 a 24 meses (en brazos)</option>
	<option value="I" class="age-3">0 a 24 meses (en asiento)</option>
	<option value="C" class="age-4">2 a 11 años</option>
	<option value="2" class="age-5">12 años o más</option>
	</select>
	<div class="rateMessage infant hidden"><span class="arrow"></span>Tarifa bebe</div>
	<div class="rateMessage children hidden"><span class="arrow"></span>Tarifa niño</div>
	<div class="rateMessage adult hidden"><span class="arrow"></span>Tarifa adulto</div>
	<p class="error hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">Por favor, ingrese la edad.</span></p>
	</li>
</ul>
</div>
-->
<p class="error error-infantsqty hidden"><span class="commonSprite errorCrossIcon"></span><span class="errortext">No puede ingresar mas bebés que adultos.</span></p>
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
<option value="F">First clase</option>
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
<div class="com-searchbutton">
<a class="buttonSprite ctn-searchbutton">
<span>Search</span>
</a>
</div></div>
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
<p class="msg-blank">No se encontraron ciudades que coincidan con: <span></span></p>
<p class="msg-error">Estamos mejorando el sistema de búsqueda. Inténtelo nuevamente en unos minutos</p>
<p class="msg-empty">Ingrese al menos las primeras 3 letras, y aguarde a ver los resultados</p>
<p class="msg-loading">Buscando <span></span></p>
<p class="msg-max-chars">La busqueda excedio el tamaño maximo de caracteres</p>
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
<strong class="label">All stops</strong>
<strong class="total">{{filterCount data.refinementSummary.stops}}</strong>
</label>
</li>
{{#_each data.refinementSummary.stops}}
<li class="item stops-{{data.value}}">
<label for="stops-{{data.value}}" class="{{#if data.count}} enabled {{else}} disabled {{/if}}">
<input id="stops-{{data.value}}" type="checkbox" name="stops" value="{{data.value}}" {{#if data.count}} enabled {{else}} disabled {{/if}}>
<span class="label">{{filterName "stops" data.value}}</span>
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
<strong class="label">All times</strong>
<strong class="total">{{filterCount data.refinementSummary.timeOutbound}}</strong>
</label>
</li>
{{#_each data.refinementSummary.timeOutbound}}
<li class="item time-outbound-{{data.value}}">
<label for="time-outbound-{{data.value}}" class="{{#if data.count}} enabled {{else}} disabled {{/if}}">
<input id="time-outbound-{{data.value}}" type="checkbox" name="time-outbound" value="{{data.value}}" {{#if data.count}} enabled {{else}} disabled {{/if}}>
<span class="label">{{filterName "time" data.value}}</span>
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
<strong class="label">All times</strong>
<strong class="total">{{filterCount data.refinementSummary.timeInbound}}</strong>
</label>
</li>
{{#_each data.refinementSummary.timeInbound}}
<li class="item time-inbound-{{data.value}}">
<label for="time-inbound-{{data.value}}" class="{{#if data.count}} enabled {{else}} disabled {{/if}}">
<input id="time-inbound-{{data.value}}" type="checkbox" name="time-inbound" value="{{data.value}}" {{#if data.count}} enabled {{else}} disabled {{/if}}>
<span class="label">{{filterName "time" data.value}}</span>
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
<strong class="label">All airports</strong>
<strong class="total">{{filterCount data.refinementSummary.outboundAirports}}</strong>
</label>
</li>
{{#_each data.refinementSummary.outboundAirports}}
<li class="item airport-outbound-{{data.value.code}}" >
<label for="airport-outbound-{{data.value.code}}" class="enabled">
<input id="airport-outbound-{{data.value.code}}" type="checkbox" name="airport-outbound" value="{{data.value.code}}">
<span class="label">{{data.value.description}}</span>
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
<span>Derparture and return by the same airport</span>
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
<strong class="label">All airports</strong>
<strong class="total">{{filterCount data.refinementSummary.inboundAirports}}</strong>
</label>
</li>
{{#_each data.refinementSummary.inboundAirports}}
<li class="item airport-inbound-{{data.value.code}}" >
<label for="airport-inbound-{{data.value.code}}" class="enabled">
<input id="airport-inbound-{{data.value.code}}" type="checkbox" name="airport-inbound" value="{{data.value.code}}">
<span class="label">{{data.value.description}}</span>
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
<strong class="label">All airlines</strong>
<strong class="total">{{filterCount data.refinementSummary.airlines}}</strong>
</label>
</li>
{{#_each data.refinementSummary.airlines}}
<li class="item airlines-{{data.value.code}}" {{#compare _data.index 15 operator=">"}} hidden {{/compare}} >
<label for="airlines-{{data.value.code}}" class="enabled">
<input id="airlines-{{data.value.code}}" type="checkbox" name="airlines" value="{{data.value.code}}">
<img src="http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/{{data.value.code}}.png" alt="{{data.value.description}}" title="{{data.value.description}}" onerror="this.src='http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/default.png'" />
<span class="label">{{data.value.description}}</span>
<span class="total">{{data.count}}</span>
</label>
</li>
{{#compare data.refinementSummary.airlines.length 15 operator=">"}}
<li class="item show-all">
<a href="#">Ver todas &raquo;</a>
</li>
{{/compare}}
{{/_each}}
</ul>
<div class="unique-airline">
<ul class="items" data-airline-info='{ "name" : "uniqueAirline" }'>
<li class="item">
<label for="airline" class="enabled">
<input id="airline" type="checkbox" name="airline" value="TRUE">
<span>Ida y vuelta por la misma aerolínea</span>
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
<div class="grid_18 omega">
<div id="results-loader" class="results-loader">
<!--searching-animation-html-->
<!--[if gt IE 7]><!--><div class="loader" style="height:312px"><!--<![endif]-->
<!--[if IE 7]><div class="loader" style="height:272px;"> <![endif]-->
<div class="fade-container">
<h1 class="iterated-text"><span class="iterated-text-description"></span><span class="susp-points"></span><span class="space-points">&nbsp;&nbsp;&nbsp;</span></h1>
<div class="best-price-container">
<img class=" cuca-best-price littleBestPricelogo_es" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/bitcoin-anim.png') ?>" alt="">
<h2>Best price founded!</h2>
</div>
</div>
<img class="imgBot" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/azafata.png') ?>" alt="">
<div class="second-text">
<div class="second-text-image"><img src=""></div>
<p class="second-text-description"></p>
</div>
</div>


<!--searching-animation-html END-->
</div><div id="results-warning" class="results-warning messages" style="display: none;">
<span class="commonSprite warningSymbol"></span>
<div class="text">
<span class="message">
We didn't find flights
with seats.
</span>
<span class="help">A continuación le mostramos vuelos de todas las aerolíneas, sin restricción de horario, clase o escalas.</span>
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
<a class="flights-best-price-button aditionalsSearchesSummaryButton" href="/shop/flights/results/roundtrip/<?=$sFrom?>/<?=$sTo?>/{{aditionalsSearchesSummary.departureDate.formatted}}/{{aditionalsSearchesSummary.arrivalDate.formatted}}/<?=$sAdults?>/<?=$sChildren?>/<?=$sInfants?>/NA/NA/NA/NA/NA" target="_blank">
<span>Ver mejor precio »</span>
</a>
</div>
</div>
<div class="secondary-message betterUpsellPriceButton" data-href="/shop/flights/results/roundtrip/<?=$sFrom?>/<?=$sTo?>/<?=$sDepartureDate?>/<?=$sReturningDate?>/<?=$sAdults?>/<?=$sChildren?>/<?=$sInfants?>/NA/NA/{{betterUpsellPrice.cabinType.code}}/NA/NA">
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
<a class="flights-best-price-button aditionalsSearchesSummaryButton" href="/shop/flights/results/roundtrip/<?=$sFrom?>/<?=$sTo?>/{{aditionalsSearchesSummary.departureDate.formatted}}/{{aditionalsSearchesSummary.arrivalDate.formatted}}/<?=$sAdults?>/<?=$sChildren?>/<?=$sInfants?>/NA/NA/NA/NA/NA" target="_blank">
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
<a class="flights-best-price-button betterUpsellPriceButton" href="/shop/flights/results/roundtrip/<?=$sFrom?>/<?=$sTo?>/<?=$sDepartureDate?>/<?=$sReturningDate?>/<?=$sAdults?>/<?=$sChildren?>/<?=$sInfants?>/NA/NA/{{betterUpsellPrice.cabinType.code}}/NA/NA" target="_blank">
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
<a class="flights-best-price-button betterUpsellPriceButton" href="/shop/flights/results/roundtrip/<?=$sFrom?>/<?=$sTo?>/<?=$sDepartureDate?>/<?=$sReturningDate?>/<?=$sAdults?>/<?=$sChildren?>/<?=$sInfants?>/NA/NA/{{betterUpsellPrice.cabinType.code}}/NA/NA" target="_blank">
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
<form class="order-form">
<ul>
<li class="orderby">
<label for="orderby">
<span>Sort by</span>
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
<!--
<li class="currency">
<label for="currency">
<span>Currency</span>
<select name="currency" id="currency" class="currency-change flights-select">
<option value="ARS" >Bitcoins</option>
<option value="USD" selected>United State Dolars</option>
</select>
</label>
</li>
-->
</ul>
</form>
</div><div id="results-messages" class="messages" style="display: none;">
<span class="commonSprite warningSymbol"></span>
<div class="text">
<span class="message"></span>
<span class="help"></span>
</div>
</div>
<div id="results-error" class="results-error messages" style="display: none;">
<span class="commonSprite warningSymbol"></span>
<div class="text">
<span class="message">We didn't found flights with free sits for your search.</span>
<span class="help">
Make a new search with closer cities or other dates. <br> Some routes are active in the peak season.
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
<li class="type-icon">
<span class="main-sprite icon-plane-outbound"></span>
</li>
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
<span title="Estadísticas de puntualidad del último mes informado" class="main-sprite icon-clock-{{data.delaySeverity}}"></span>
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
<img src="http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/{{data.code}}.png" alt="{{data.description}}" title="{{data.description}}" onerror="this.src='http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/default.png'" />
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
<li class="item error-message">Por favor, seleccione un horario de ida.</li>
</ul>
</div>
{{/if}}
{{#if data.itinerariesBox.inboundRoutes.length}}
<div class="sub-cluster inbound">
<ul class="item data">
<li class="type-icon">
<span class="main-sprite icon-plane-inbound"></span>
</li>
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
<span title="Estadísticas de puntualidad del último mes informado" class="main-sprite icon-clock-{{data.delaySeverity}}"></span>
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
<img src="http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/{{data.code}}.png" alt="{{data.description}}" title="{{data.description}}" onerror="this.src='http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/default.png'" />
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
<span class="fare-description">Price per adult</span>
<span class="fare">
{{#each data.itinerariesBox.itinerariesBoxPriceInfoList}}
<span class="price-currency {{adult.baseFare.formatted.code}}">
<span class="currency">{{adult.baseFare.formatted.mask}}</span>
<span class="amount">{{adult.baseFare.formatted.amount}}</span>
</span>
{{/each}}
</span>
<!--
<li>
<span class="item-detail">1 Adulto</span>
<span class="item-price">
{{#each data.itinerariesBox.itinerariesBoxPriceInfoList}}
<span class="price-currency {{adult.totalFare.formatted.code}}">
<span class="currency">{{adult.totalFare.formatted.mask}}</span>
<span class="amount">{{adult.totalFare.formatted.amount}}</span>
</span>
{{/each}}
</span>
</li>
<li class="taxes-price">
<span class="item-detail">Imp. y tasas</span>
<span class="item-price">
{{#each data.itinerariesBox.itinerariesBoxPriceInfoList}}
<span class="price-currency {{total.taxes.formatted.code}}">
<span class="currency">{{total.taxes.formatted.mask}}</span>
<span class="amount">{{total.taxes.formatted.amount}}</span>
</span>
{{/each}}
</span>
</li>
<li class="charges-price">
<span class="item-detail">Cargos</span>
<span class="item-price">
{{#each data.itinerariesBox.itinerariesBoxPriceInfoList}}
<span class="price-currency {{total.charges.formatted.code}}">
<span class="currency">{{total.charges.formatted.mask}}</span>
<span class="amount">{{total.charges.formatted.amount}}</span>
</span>
{{/each}}
</span>
</li>
-->
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
<li class="charges-price">
<span class="item-detail">Taxes included</span>

</li>
</ul>
<a href="#" class="buy btn-buy flights-button">
<span>Buy</span>
</a>

</div>
</div>
{{/_each}}
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
<img src="http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/{{data.leg.airline.code}}.png" alt="{{data.leg.airline.description}}" title="{{data.leg.airline.description}}" onerror="this.src='http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/default.png'" />
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
La información proporcionada sobre el % de retrasos y cancelaciones histórico de vuelos nacionales e internacionales surge del sitio <a href="http://www2.anac.gov.br/percentuaisdeatraso/" target="_blank">http://www2.anac.gov.br/percentuaisdeatraso/</a> , por lo que Despegar.com.ar SA. se exime de responsabilidad respecto del cumplimiento o no de tales porcentajes.
</p>
</div>
</div>
</script>
<script id="popup-detail-template" type="text/x-handlebars-template">
<div class="detail">
{{#_each this.segments}}
{{#segmentHasAirportChange list index}}
<div class="small-message">El costo de traslado entre aeropuertos no está incluido en la tarifa</div>
{{/segmentHasAirportChange}}
<div class="segment">
<ul class="detail-info">
<li class="data">
<span class="name">
{{get array= "First segment,Second segment,Third segment,Fourth segmente,Fifth segment,Sixth segment"
index=_data.index}}
</span>
<span>-</span>
<span class="number">Flight {{data.flightNumber}}</span>
<span>-</span>
<span class="class">{{data.cabinTypeDescription}}</span>
<span class="airline">
<span class="logo">
<img src="http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/{{data.carrier.code}}.png" alt="{{data.carrier.description}}" title="{{data.carrier.description}}" onerror="this.src='http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/default.png'" />
</span>
<strong class="name">{{data.carrier.description}}</strong>
</span>
</li>
<li class="itinerary">
<span class="location">Depart from {{data.departure.location.city.description}}, {{data.departure.location.airport.description}} ({{data.departure.location.airport.code}})</span>
<span class="date">{{data.departure.date.formatted}}</span>
</li>
<li class="itinerary">
<span class="location">Arrive at {{data.arrival.location.city.description}}, {{data.arrival.location.airport.description }} ({{data.arrival.location.airport.code}})</span>
<span class="date">{{data.arrival.date.formatted}}</span>
</li>
{{#compare data.carrier.code data.operatingCarrier.code operator="!=" }}
<li>
<ul class="operated-by">
<li class="title">Flight operated by:</li>
<li class="logo">
<img src="http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/{{data.operatingCarrier.code}}.png" alt="{{data.operatingCarrier.description}}" title="{{data.operatingCarrier.description}}" onerror="this.src='http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/default.png'" />
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
<li class ="stop">- {{location.city.description}}, {{duration}}</li>
{{/each}}
</ul>
</li>
{{/if}}
</ul>
</div>
<span class="time">
{{#showConnection segments=../segments}}
{{#if _data.showWaitDuration}}
Conection in {{_data.locationDescription}} with wait of {{_data.waitDuration}}
{{else}}
Conexión en {{_data.cityDescription}}
{{/if}}
{{#if _data.showAirportChange}}
with airport change
{{/if}}
{{else}}
Flight total time: {{../../totalDuration}}
{{/showConnection}}
</span>
{{/_each}}
<div class="detail-footer">
<div class="bottom-box">
<span class="detail-local-hour">Times in local time of each city</span>

</div>
{{#if this.carbonFootprintInfo}}
{{/if}}
<div class="rules">
<span class="airline">
<span class="logo">
{{#_each airlines}}
<span>
<img src="http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/{{data.code}}.png" alt="{{data.description}}" title="{{data.description}}" onerror="this.src='http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/default.png'" />
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
<script id="popup-payments-template" type="text/x-handlebars-template">
<div class="payments flights-list-grid">
{{#if numberOfInstalments}}
<ul class="payments-fees">
<li class="head">Cuotas</li>
{{#_each numberOfInstalments}}
<li class="{{even_odd _data.index}}">{{data}}</li>
{{/_each}}
</ul>
{{/if}}
{{#compare payments.length 7 operator=">"}}
<div class="payments-info">
<span class="payments-arrow payments-prev" style="display: none;">&lt;</span>
<span class="payments-arrow payments-next">&gt;</span>
<div class="payments-container">
{{/compare}}
{{#each payments}}
<ul>
<li class="head">
<img src="http://ar.staticontent.com/img-versioned/1.23.6/common/cards/{{creditCard.code}}.png" alt="{{creditCard.description}}">
</li>
{{#if availableInstalments}}
{{#_each availableInstalments}}
<li class="{{even_odd _data.index}}">
{{#if data}}
{{#each data.prices}}
<p class="price-currency {{formatted.code}}">{{formatted.mask}} {{formatted.amount}}</p>
{{/each}}
{{else}}
<p>-</p>
{{/if}}
</li>
{{/_each}}
{{/if}}
</ul>
{{/each}}
{{#compare payments.length 7 operator=">"}}
</div>
</div>
{{/compare}}
</div>
</script><script id="frequent-flyer-template" type="text/x-handlebars-template">
<span>
Comprando estos vuelos usted suma
{{#compare program "KNOWN" operator="=="}}
hasta {{points}} {{/compare}}
{{unit}} del programa {{pointsProgram}} de {{airline}} </span>
</script>
<script id="popup-email-template" type="text/x-handlebars-template">
<form id="email" action="/shop/flights/recomendation" method="post" accept-charset="utf-8">
<input class="input" name="ticketHash" type="hidden" value="{{ticketHash}}">
<input class="input" name="version" type="hidden" hidden" value="{{version}}">
<input class="input" name="itineraryHash" type="hidden" value="{{itineraryHash}}">
<input class="input currencyCode" name="currencyCode" type="hidden" value="{{currencyCode}}">
<label for="sender-name">
<span class="form-detail">De (nombre)</span>
<div class="input-container required">
<input class="input sender-name flights-input" type="text" id="sender-name" name="name" value="">
<span class="main-sprite icon-error"></span>
<span class="empty-error-message">Por favor, ingrese su nombre.</span>
</div>
</label>
<label for="sender">
<span class="form-detail">De (e-mail)</span>
<div class="input-container required">
<input class="input sender flights-input" data-validations='{"email" : true}' type="text" id="sender" name="fromEmail" value="" >
<span class="main-sprite icon-error"></span>
<span class="empty-error-message">Por favor, ingrese su dirección de e-mail.</span>
<span class="invalid-error-message">Por favor, ingrese una dirección de e-mail correcta.</span>
</div>
</label>
<label for="receiver">
<span class="form-detail">Para (e-mail)</span>
<div class="input-container required">
<input class="input receiver flights-input" data-validations='{"email" : true, "multiple" : true}' id="receiver" type="text" name="toEmail" value="">
<span class="main-sprite icon-error"></span>
<span class="input-detail">Incluye más e-mails separándolos con coma</span>
<span class="empty-error-message">Por favor, ingrese el e-mail del destinatario.</span>
<span class="invalid-error-message">Por favor, ingrese una dirección de e-mail correcta.</span>
</div>
</label>
<label for="subject">
<span class="form-detail">Asunto</span>
<div class="input-container">
<input class="input subject placeholder flights-input" id="subject" type="text" name="subject" placeholder="Recomendación de vuelo a París">
<span class="main-sprite icon-error"></span>
<span class="empty-error-message">Por favor, ingrese un asunto.</span>
</div>
</label>
<label for="message">
<span class="form-detail">Comentario</span>
<div class="input-container">
<textarea class="input message flights-input" data-original-value="Encontré este vuelo de Roma a París en Despegar.com y quería recomendártelo." id="message" name="comment" cols="42" rows="4">Encontré este vuelo de Roma a París en Despegar.com y quería recomendártelo.</textarea>
<span class="main-sprite icon-error"></span>
<span class="empty-error-message">Por favor, ingrese un comentario.</span>
</div>
</label>
<label for="send-copy">
<span class="form-detail"></span>
<div class="input-container">
<input type="checkbox" class="send-copy input" id="send-copy" name="sendCopy" value="" />
<span class="send-copy-label">Enviar una copia a mi e-mail</span>
</div>
</label>
<a class="btn-send flights-send-button">
<span>Enviar</span>
</a>
</form>
</script>
<script id="popup-email-success-template" type="text/x-handlebars-template">
<p class="email-feedback">Muchas gracias, {{fromName}}. Su recomendación fue enviada a {{fromEmail}}.</p>
</script>
<script id="popup-email-error-template" type="text/x-handlebars-template">
<p class="email-feedback">Hubo un error al intentar enviar el email. Por favor, intentelo más tarde.</p>
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
<img src="http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/{{airline.code}}.png" alt="{{airline.description}}" title="{{airline.description}}" onerror="this.src='http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/default.png'" />
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
</script> </div>

<?php $view['slots']->stop() ?>


<?php $view['slots']->start('javascripts') ?>

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
	
<!--	<div class="results-update" style="display: none;">
	<img class="logo" src="">
	<p>Updating information</p>
	<img class="update-loader" src="http://ar.staticontent.com/shop/flights/img-versioned/1.33.6/despegar/static/loaders/loader.gif">
</div> -->



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
"libs.amplify": "<?php echo $jsLibsBaseUrl ?>/amplify-1.1.0.min",
"libs.handlebars": "<?php echo $jsLibsBaseUrl ?>/handlebars-1.0.0.beta.6.min",
"libs.jquery": "<?php echo $jsLibsBaseUrl ?>/jquery-1.7.1.min"
}
});
</script>
<script>
define('services', function() {
return {
search : '<?php echo $enviromentPrefix ?>/search/<?=$sTripType?>/<?=$sFrom?>/<?=$sTo?>/<?=$sDepartureDate?>/<?=( $sReturningDate != "" ? $sReturningDate.'/' : "") ?><?=$sAdults?>/<?=$sChildren?>/<?=$sInfants?>/<?=$sOrderBy?>/<?=$sOrderDir?>/<?=$sDepartureTime?>/<?=( $sReturningTime != "" ? $sReturningTime.'/' : "")?><?=$sClassFlight?>/<?=$sScaleFlight?>/<?=$sAirlineFlight?>',
refine : '<?php echo $enviromentPrefix ?>/refine/<?=strtoupper($sTripType)?>/INTERNATIONAL/{hash}/{version}/{filterStrategy}/{orderCriteria}/{orderDirection}/{pageIndex}/{minPrice}/{maxPrice}/{originalCurrencyPrice}/{selectedCurrencyPrice}/{allowedOutboundTimeRanges}/{allowedInboundTimeRanges}/{allowedAirlines}/{allowedStopQuantities}/{allowedOutboundAirports}/{allowedInboundAirports}/{uniqueAirline}/{uniqueHomeAirport}',
item : '<?php echo $enviromentPrefix ?>/item/<?=strtoupper($sTripType)?>/INTERNATIONAL/{hash}/{version}/{itemHash}'
};
});
define('options', function() {
return {
orderCriteria : '<?=strtoupper($sOrderBy)?>',
orderDirection : '<?=strtoupper($sOrderDir)?>',
personalSortId : 'UPA_1',
initialCurrency : 'USD',
clusters : { searchType : '<?=strtoupper($sTripType)?>',
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
			code: "<?=$sFrom?>",
			description: "<?=$sFrom?>"
		},
		destination: {
			code: "<?=$sTo?>",
			description: "<?=$sTo?>"
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
, outboundDate: "<?=$sDepartureDate?>"
, inboundDate: "<?=$sReturningDate?>"
}
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
"ecologicalLow" : "Nivel de preservación: Poco ecológico",
"ecologicalMedium" : "Nivel de preservación: Medianamente ecológico",
"ecologicalHigh" : "Nivel de preservación: Muy ecológico"
}
},
filters : { priceError : 'Por favor, verifique que el valor mínimo sea menor que el valor máximo.',
priceMaxError : 'Por favor, verifique que el valor máximo sea mayor a 0.',
resultsPriceError : 'Lo sentimos, no se encontraron vuelos dentro del rango de precio seleccionado. Por favor, intente nuevamente con otras opciones.',
showAll : 'Ver todas &raquo;',
showLess : 'Ver menos &laquo;',
resultsError : 'Disculpe, no encontramos vuelos con el último criterio que ha seleccionado.',
resultsErrorHelp : 'Deshacer la última acción.',
stops : {
"NONE" : "Direct",
"ONE" : "1 Stop",
"MORE_THAN_ONE" : "2 o more stops"
},
time : {
"MORNING" : "Morning (06 a 12hs)",
"AFTERNOON" : "Afternoon (12 a 20hs)",
"NIGHT" : "Night (20 a 00hs)",
"EARLY_MORNING" : "Ealy morning (00 a 06hs)"
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
currentDate : new Date( <?=time(); ?>),
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
anticipationDays : '<?=$sAnticipationDays; ?>'
},
places: {
autoCompleteType : Nibbler.Autocomplete.js.Autocomplete.Flights,
autoCompleteCache : 'facet.a.c.e',
autoCompleteUrl : '<?=$enviromentPrefix ?>/autocomplete/find',
autoCompleteUrlOld : '/Flights.Services/Commons/AutoComplete.svc'
},
passengers: {
maxPassengers : 8
},
multiple: {
availableDays : 330,
autoCompleteType : Nibbler.Autocomplete.js.Autocomplete.Flights,
autoCompleteUrl : '<?=$enviromentPrefix ?>/autocomplete/find',
autoCompleteUrlOld : '/Flights.Services/Commons/AutoComplete.svc',
anticipationDays : '<?=$sAnticipationDays; ?>'
},
anticipatedSearch : true
}
}
]
});
_box = box;
_box.setBoxOptions({ flights : {
dates : {
dateIn : new Date(<?=$sDepartureDateForSearchBox; ?>) 
,dateOut : new Date(<?=$sReturningDateForSearchBox; ?>)
},
places : {
destinationText : '<?=$sToName?>',
destinationValue : '<?=$sTo?>',
originText : '<?=$sFromName?>',
originValue : '<?=$sFrom?>'
},
<?php if ($sDepartureTime != 'NA' || $sReturningTime != 'NA' || $sScaleFlight != 'NA' || $sClassFlight != 'NA') { ?>
advanced: {
departureTime : '<?=$sDepartureTime?>',
returnTime : '<?=$sReturningTime?>',
scaleFlight : '<?=$sScaleFlight?>',
classFlight : '<?=$sClassFlight?>'
},
<?php } ?>
passengers : {
adults : <?=$sAdults?>,
childs : <?=$sChildrensCount?>,
infants : <?=$sInfants?>
},
triptypes : {
currentType : '<?= ($sTripType=='oneway'? 'oneWay' : 'roundTrip') ?>'
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
"nibbler.alerts": "http://ar.staticontent.com/nibbler-versioned/1.1.197/pkg/alerts",
"libs.jquery.templates": "http://ar.staticontent.com/jslibs/jquery.tmpl-beta1.0.0.min",
"nibbler.autocomplete": "http://ar.staticontent.com/nibbler-versioned/1.1.197/pkg/autocomplete",
"handlebars": "<?php echo $jsLibsBaseUrl ?>/handlebars-1.0.0.beta.6.min",
"amplify": "http://ar.staticontent.com/jslibs/amplify-1.1.0.min",
"libs.json": "http://ar.staticontent.com/jslibs/json2.min"
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
loadCss("http://ar.staticontent.com/nibbler-versioned/1.1.197/Nibbler/Autocomplete/css/despegar/pkg/autocomplete.css");
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
noneSelectedText : "Ingrese un mes de viaje"
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
$('.popUpContent','#popupBestPrice').append('<p class="popupBestServiceText">Trabajamos todos los d&iacute;as para ayudarle a economizar tiempo y dinero en sus compras de viaje. Queremos que tenga la tranquilidad que cada vez que compra en Despegar.com est&aacute; accediendo a las mejores tarifas disponibles. Por ello ahora le garantizamos que en Despegar.com usted encontrar&aacute; las mejores tarifas en vuelos, hoteles y alquiler de autos, en el caso de que usted encontrase una mejor tarifa le daremos la diferencia hasta un m&aacute;ximo de USD 100, al cambio oficial del d&iacute;a de la emisi&oacute;n del voucher, como cr&eacute;dito en una futura compra en nuestro sitio.</p>');
$('.popUpContent','#popupBestPrice').append('<a href="/commercial-web/betterprice/termsandconditions" target="_blank">Garantía de mejor precio</a>');
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
<script type="text/javascript" src="http://ar.staticontent.com/nibbler-versioned/1.1.197/pkg/autocomplete.js"></script><!--searchbox-js END-->
<!--footer-js-->
<script type="text/javascript" charset="utf-8" src="http://ar.staticontent.com/nibbler-versioned/1.1.197/pkg/footer.js"></script>
<!-- mail-offers-js -->
<script type="text/javascript" charset="utf-8" src="http://ar.staticontent.com/nibbler-versioned/1.1.197/pkg/MailOffers.js"></script>
<!-- mail-offers-js END-->
<script type="text/javascript">
<!-- mail-offers-init -->
new Nibbler.MailOffers.js.MailOffers({
container : 'div#footer',
language : 'es',
cityCode : 'BUE'
});
<!-- mail-offers-init END -->
$(document).ready(function(){
var fakeLinks = new linkListCreator();
var linkList= {
ulId:"#about-list",
section:"home",
language:"es",
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
secondText:{msg:'&iexcl;S&uacute;mese a la nueva forma de comprar su viaje!</br>&iexcl;12 millones de viajeros ya nos eligieron!'},
delay:900
},
customOptions : {
iteratedText: [
{msg:'Searching flights to <?php echo $sToName ?> by Alitalia'}
,
{msg:'Searching flights to <?php echo $sToName ?> by Air France'}
,
{msg:'Searching flights to <?php echo $sToName ?> by Iberia'}
,
{msg:'Searching flights to <?php echo $sToName ?> by Air Europa'}
,
{msg:'Searching flights to <?php echo $sToName ?> by KLM'}
,
{msg:'Searching flights to <?php echo $sToName ?> by Lufthansa'}
,
{msg:'Searching flights to <?php echo $sToName ?> by British Airways'}
,
{msg:'Searching flights to <?php echo $sToName ?> by Swiss'}
,
{msg:'Searching flights to <?php echo $sToName ?> by American Airlines'}
,
{msg:'Searching flights to <?php echo $sToName ?> by Tunisair'}
,
{msg:'Searching flights to <?php echo $sToName ?> by Jat Airways'}
],
secondText: {
msg:'With Bitcoin your flight is cheaper!',
img:'<?php echo $view['assets']->getUrl('bundles/btctrip/images/bitcoin-mini.png') ?>'
}
, delay: Math.floor(454,545)
}
}
var ChargeOffers= new Nibbler.SearchingAnimation.js.searchingAnimation(optionSearching);
ChargeOffers.init();
<!--searching-animation-init END-->
</script>

<?php $view['slots']->stop() ?>


