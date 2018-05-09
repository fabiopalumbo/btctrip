<?php

namespace BtcTrip\SearchBundle\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class SearchController extends Controller
{

   	/**
	 * @Route("/home", name="oldHome")
	 */
	public function oldHomeAction()	{
	    return $this->redirect($this->generateUrl('home'));
	}

   	/**
	 * @Route("/", name="home")
	 * @Template(engine="php")
	 */
	public function homeAction() {
		$enviromentPrefix = $this->get('mega_helper')->getEnviromentPrefix();
		
		return array('enviromentPrefix' => $enviromentPrefix);	
	}


   	/**
	 * @Route("/results/oneway/{sFrom}/{sTo}/{sDepartureDate}/{sAdults}/{sChildren}/{sInfants}/{sDepartureTime}/{sClassFlight}/{sScaleFlight}/{sAirlineFlight}", 
	 			name="resultsAdvanceOneway",
	 			defaults={"sDepartureTime"="NA", "sClassFlight"="NA", "sScaleFlight"="NA", "sAirlineFlight"="NA"})   	
	 * @Template(engine="php", template="BtcTripSearchBundle:Search:results.html.php")
	 */
	public function resultsOnewayAction($sFrom, $sTo, $sDepartureDate, $sAdults, $sChildren, $sInfants, $sDepartureTime, $sClassFlight, $sScaleFlight, $sAirlineFlight) {
		
		// TODO: agregar , $sDepartureTime,  $sClassFlight, $sScaleFlight, $sAirlineFlight en la vista
		return $this->results("oneway", $sFrom, $sTo, $sDepartureDate, "", $sAdults, $sChildren, $sInfants, $sDepartureTime, "", $sClassFlight, $sScaleFlight, $sAirlineFlight);
	}


   	/**
	 * @Route("/results/roundtrip/{sFrom}/{sTo}/{sDepartureDate}/{sReturningDate}/{sAdults}/{sChildren}/{sInfants}/{sDepartureTime}/{sReturningTime}/{sClassFlight}/{sScaleFlight}/{sAirlineFlight}", 
	 			name="resultsAdvanceRoundtrip",
	 			defaults={"sDepartureTime"="NA", "sReturningTime"="NA", "sClassFlight"="NA", "sScaleFlight"="NA", "sAirlineFlight"="NA"})   	
	 * @Template(engine="php", template="BtcTripSearchBundle:Search:results.html.php")
	 */
	public function resultsRoundtripAction($sFrom, $sTo, $sDepartureDate, $sReturningDate, $sAdults, $sChildren, $sInfants, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight) {
		
		// TODO: agregar , $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight en la vista
		return $this->results("roundtrip", $sFrom, $sTo, $sDepartureDate, $sReturningDate, $sAdults, $sChildren, $sInfants, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight);
	}


//	 * @Route("/results/{sTripType}/{sFrom}/{sTo}/{sDepartureDate}/{sReturningDate}/{sAdults}/{sChildren}/{sInfants}/{sOrderBy}/{sOrderDir}", 
//	 			name="resultsOrdering",
//	 			defaults={"sOrderBy"="TOTALFARE", "sOrderDir"="ASCENDING"}))

   	/**
	 * @ Route("/results/{sTripType}/{sFrom}/{sTo}/{sDepartureDate}/{sReturningDate}/{sAdults}/{sChildren}/{sInfants}", 
	 			name="results")
	 * @ Template(engine="php")
	 */
//	private function resultsAction($sTripType, $sFrom, $sTo, $sDepartureDate, $sReturningDate, $sAdults, $sChildren, $sInfants, $sOrderBy, $sOrderDir) {	
	private function results($sTripType, $sFrom, $sTo, $sDepartureDate, $sReturningDate, $sAdults, $sChildren, $sInfants, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight) {
		$enviromentPrefix = $this->get('mega_helper')->getEnviromentPrefix();
		
		$sFromName = $this->getCityName($sFrom);
		
		$sToName = $this->getCityName($sTo);
		
		$sOrderBy = 'TOTALFARE';
		$sOrderDir = 'ASCENDING';
		
		return array('enviromentPrefix' => $enviromentPrefix, 'sTripType' => $sTripType, 'sFrom' => $sFrom, 'sFromName' => $sFromName, 'sTo' => $sTo, 'sToName' => $sToName, 
				'sDepartureDate' => $sDepartureDate, 'sReturningDate' => $sReturningDate, 'sAdults' => $sAdults, 'sChildren' => $sChildren, 
				'sInfants' => $sInfants, 'sOrderBy' => $sOrderBy, 'sOrderDir' => $sOrderDir, 'sDepartureTime' => $sDepartureTime, 'sReturningTime' => $sReturningTime, 
				'sClassFlight' => $sClassFlight, 'sScaleFlight' => $sScaleFlight, 'sAirlineFlight' => $sAirlineFlight);
	}
	
	private function generateCaptcha() {
		$captchaService = $this->get('simple_captcha');

		return $captchaService->CreateImage();
	}

	function getCityName($cityId) {
		$cityCollection = $this->get('mega_helper')->getCollection('City');
	
		$city = $cityCollection->findOne(array('id' => $cityId));
		$cityName = (isset($city['place']) ? $city['place'] : '');
	
		if ($cityName == '') {
			$airportCollection = $this->get('mega_helper')->getCollection('Airport');
			
			$airport = $airportCollection->findOne(array('id' => $cityId));
			$city = $cityCollection->findOne(array('id' => $airport['parentCity']));
			
			$cityName = (isset($city['place']) ? $city['place'] : '');
		}
		
		return $cityName;
	}

	/**
	 *  http://www.us.despegar.com/shop/flights/data/search/roundtrip/MIA/BOG/2013-03-22/2013-03-29/1/0/0/TOTALFARE/ASCENDING/NA/NA/NA/NA/NA
	 *
	 *  Parameters may refer to values in the URL, entity properies posted as json, or both.
	 *
	 *    from : 3 character airport or city id representing the starting point.
	 *    to : 3 character airport or city id representing the destination.
	 *    departureDate : The desired departure date. (format yyyy-MM-dd)
	 *    returningDate : The desired returning date. (format yyyy-MM-dd)
	 *    adults : Number of adults that will travel.
	 *    children : Number of children that will travel.
	 *    infants : Number of infants that will travel (only lap children up to 24 months).
	 *
	 *    orderBy : order criteria
	 *    orderDir : order direction of selected criteria
	 *
	 *    classType
	 *    departureTime
	 *    returnTime
	 *    stops
	 *    airlines
	 */

	/**
	 * @Route("/search/roundtrip/{sFrom}/{sTo}/{sDepartureDate}/{sReturningDate}/{sAdults}/{sChildren}/{sInfants}/{sOrderBy}/{sOrderDir}/{sDepartureTime}/{sReturningTime}/{sClassFlight}/{sScaleFlight}/{sAirlineFlight}", 
	 			name="searchRoundtrip", 
	  			defaults={"_format"="json", "sOrderBy"="TOTALFARE", "sOrderDir"="ASCENDING", "sDepartureTime"="NA", "sReturningTime"="NA", "sClassFlight"="NA", "sScaleFlight"="NA", "sAirlineFlight"="NA"})
	 */
	public function searchRoundtripAction($sFrom, $sTo, $sDepartureDate, $sReturningDate, $sAdults, $sChildren, $sInfants, $sOrderBy, $sOrderDir, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight) {

		return $this->search("roundtrip", $sFrom, $sTo, $sDepartureDate, $sReturningDate, $sAdults, $sChildren, $sInfants, $sOrderBy, $sOrderDir, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight);
	}

	/**
	 * @Route("/search/oneway/{sFrom}/{sTo}/{sDepartureDate}/{sAdults}/{sChildren}/{sInfants}/{sOrderBy}/{sOrderDir}/{sDepartureTime}/{sClassFlight}/{sScaleFlight}/{sAirlineFlight}", 
	 			name="searchOneway", 
	  			defaults={"_format"="json", "sOrderBy"="TOTALFARE", "sOrderDir"="ASCENDING", "sDepartureTime"="NA", "sClassFlight"="NA", "sScaleFlight"="NA", "sAirlineFlight"="NA"})
	 */
	public function searchOnewayAction($sFrom, $sTo, $sDepartureDate, $sAdults, $sChildren, $sInfants, $sOrderBy, $sOrderDir, $sDepartureTime, $sClassFlight, $sScaleFlight, $sAirlineFlight) {

		return $this->search("oneway", $sFrom, $sTo, $sDepartureDate, "", $sAdults, $sChildren, $sInfants, $sOrderBy, $sOrderDir, $sDepartureTime, "", $sClassFlight, $sScaleFlight, $sAirlineFlight);
	}


	private function search($sTripType, $sFrom, $sTo, $sDepartureDate, $sReturningDate, $sAdults, $sChildren, $sInfants, $sOrderBy, $sOrderDir, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight) {
		
		// procesar los parametros
		
		$serviceUrl = "/shop/flights/data/search";

		// $paramsUrl = "/roundtrip/MIA/BOG/2013-03-22/2013-03-29/1/0/0/TOTALFARE/ASCENDING/NA/NA/NA/NA/NA";
		// /oneway/BUE/SJC/2013-04-25/1/0/0/TOTALFARE/ASCENDING/NA/NA/NA/NA

		// $sOrderBy/$sOrderDir/

		$paramsUrl = "/${sTripType}/${sFrom}/${sTo}/$sDepartureDate/";
		$paramsUrl .= ($sReturningDate!=''?$sReturningDate.'/':'');
		$paramsUrl .= "$sAdults/$sChildren/$sInfants/$sOrderBy/$sOrderDir/$sDepartureTime/";
		$paramsUrl .= ($sReturningTime!=''?$sReturningTime.'/':'');
		$paramsUrl .= "$sClassFlight/$sScaleFlight/$sAirlineFlight";

		$fullServiceUrl = $serviceUrl.$paramsUrl;
		
		$jsonResponse = $this->gateawayInvoque($fullServiceUrl);
		// $jsonResponse = $this->getJsonDummy();
		
		return new Response($jsonResponse);		
	}
	
	private function getJsonDummy() {
		$logger = $this->get('logger');

		//$kernel = $this->get('kernel');
		//$innerPath = $kernel->locateResource('@BtcTripSearchBundle/Resources/data/aBig.json');
		//$innerPath = '@BtcTripSearchBundle/Resources/data/airports.dat';
		
		//$path = $kernel->locateResource($innerPath);
		
		$path = $this->container->getParameter('kernel.root_dir') . '/Resources/data/aBig.json';
		
		$logger->debug($path);
				
		$data = file_get_contents($path, "r");
		
		return $data; 
	}
	
	
	// en esta version se le pasa el iso origen y destino por cambio de despegar
	//  http://www.despegar.com.ar/shop/flights/data /refine/ONEWAY/INTERNATIONAL   /-1732460662/1/PRECLUSTER/FARE       /ASCENDING/1/NA/NA/ARS/ARS/NA/NA/NA/NA/NA/NA/NA/NA
	//  http://karimflights.karnak.net/app_dev.php   /refine/ROUNDTRIP/INTERNATIONAL/448033864  /2/PRECLUSTER/STOPSCOUNT/DESCENDING/1/NA/NA/USD/USD/NA/NA/NA/NA/NA/NA/NA/NA
	//
	// 											 /INTERNATIONAL/{hash}/{version}/{filterStrategy}/{orderCriteria}/{orderDirection}/
	//				{pageIndex}/{minPrice}/{maxPrice}/{originalCurrencyPrice}/{selectedCurrencyPrice}/{allowedOutboundTimeRanges}/
	//				{allowedInboundTimeRanges}/{allowedAirlines}/{allowedAlliances}/{allowedStopQuantities}/
	//				{allowedOutboundAirports}/{allowedInboundAirports}/{uniqueAirline}/{uniqueHomeAirport}/
	//				{allowedOutboundScheduleRange}/{allowedInboundScheduleRange}/{allowedOutboundDurationRange}/{allowedInboundDurationRange}',
	
	// http://www.us.despegar.com/shop/flights/data/refine/ROUNDTRIP/mia/bue/INTERNATIONAL/US_0_0_0_R_A-1_MIA-BUE-20131114_BUE-MIA-20131115/2/PRECLUSTER/TOTALFARE/ASCENDING/1/NA/NA/USD/USD/NA/NA/NA/NA/ONE/NA/NA/NA/NA/NA/NA/NA/NA?allowedStays=NA&allowedDateRanges=NA
	
	/**
	 * @Route("/refine/{flightType}/{sFrom}/{sTo}/INTERNATIONAL/{hash}/{version}/{filterStrategy}/{orderCriteria}/{orderDirection}/{pageIndex}/{minPrice}/{maxPrice}/{originalCurrencyPrice}/{selectedCurrencyPrice}/{allowedOutboundTimeRanges}/{allowedInboundTimeRanges}/{allowedAirlines}/{allowedAlliances}/{allowedStopQuantities}/{allowedOutboundAirports}/{allowedInboundAirports}/{uniqueAirline}/{uniqueHomeAirport}/{allowedOutboundScheduleRange}/{allowedInboundScheduleRange}/{allowedOutboundDurationRange}/{allowedInboundDurationRange}", 
	 			name="refine", 
	  			defaults={"_format"="json"})
	 */
	public function refineAction($flightType, $sFrom, $sTo, $hash, $version, $filterStrategy, $orderCriteria, $orderDirection, 
				$pageIndex, $minPrice, $maxPrice, $originalCurrencyPrice, $selectedCurrencyPrice, 
				$allowedOutboundTimeRanges, $allowedInboundTimeRanges, $allowedAirlines, $allowedAlliances, $allowedStopQuantities, 
				$allowedOutboundAirports, $allowedInboundAirports, $uniqueAirline, $uniqueHomeAirport,
				$allowedOutboundScheduleRange, $allowedInboundScheduleRange, $allowedOutboundDurationRange, $allowedInboundDurationRange) {
		
		$serviceUrl = "/shop/flights/data/refine";
		$paramsUrl = "/$flightType/$sFrom/$sTo/INTERNATIONAL";
		// a partir del 14/02/2014 agregaron un parametro mas, en un principio de uso desconocido.
		$paramsUrl .= "/NA/$hash/$version/$filterStrategy/$orderCriteria/$orderDirection";
		$paramsUrl .= "/$pageIndex/$minPrice/$maxPrice/$originalCurrencyPrice/$selectedCurrencyPrice/$allowedOutboundTimeRanges";
		$paramsUrl .= "/$allowedInboundTimeRanges/$allowedAirlines/$allowedAlliances/$allowedStopQuantities/$allowedOutboundAirports/$allowedInboundAirports";
		$paramsUrl .= "/$uniqueAirline/$uniqueHomeAirport";
		$paramsUrl .= "/$allowedOutboundScheduleRange/$allowedInboundScheduleRange/$allowedOutboundDurationRange/$allowedInboundDurationRange";
		
		$fullServiceUrl = $serviceUrl . $paramsUrl;

		$jsonResponse = $this->gateawayInvoque($fullServiceUrl);
		
		return new Response($jsonResponse);	
	}
	

	public function gateawayInvoque($fullServiceUrl) {
		$megaHelper = $this->get('mega_helper');
		$logger = $this->get('logger');

		$baseUrl = "http://www.us.despegar.com";
		
		$targetUrl = $baseUrl . $fullServiceUrl; 
	
		$referer = $this->getRequest()->headers->get('referer');
		
		// guardarla en la sesion del usuario
		$this->get('session_manager')->setLastUserSearch($referer);
		
		$referer = substr($referer, strpos($referer, 'results')-1, strlen($referer));
		$referer = $baseUrl . '/shop/flights' . $referer;
	
		$logger->debug('targetUrl: ' .$targetUrl . ' - referer: ' . $referer);
	
		// hacer la llamada
		$resultJson = $megaHelper->executeSmartRemoteRequest($targetUrl, $referer);
		
		$resultTranslatedJson = $this->translateTextual($resultJson);

		//$logger->debug('ressults json: ' . $resultTranslatedJson);

		// procesar el resultado
		$resultArray = json_decode($resultTranslatedJson);

		// guardar lo relevante para la compra y para el tracking
		if (isset($resultArray->result->data->metadata) && $resultArray->result->data->metadata->status->code == 'SUCCEEDED' ) {
		
			// calcular y agregar los precios totales de cada tipo de pasaje
			$this->calcularYAgregarPreciosTotales($resultArray);
			
			// guarda los items de la búsqueda y la metadata
			$megaHelper->persistInterestingResultParts($resultArray);
			
		} else if ( isset($resultArray->result->metadata->status->code) && 
					$resultArray->result->metadata->status->code == 'VALIDATION_ERROR')  {
			// error esperado, no hacer nada mas que devolverlo al cliente
		
		} else if ( isset($resultArray->result->data->metadata->status->code) && 
					$resultArray->result->data->metadata->status->code == 'NO_RESULTS')  {
			// error esperado, no hacer nada mas que devolverlo al cliente
		
		} else {
			$logger->error('El resultado de busqueda no fue exitoso.');
			$logger->error('TargetUrl: ' . $targetUrl);
			$logger->error(print_r($resultJson, true));
			
			$resultArray = $megaHelper->generateResponseError(); 
			
			if ( isset($resultArray->result->status) &&
				$resultArray->result->status->message != 'Invalid Parameters')  {
			
				$remailer = $this->get('remailer');
				
				$content = 'TargetUrl: ' . $targetUrl . '<br><br>';
				$content .= print_r($resultJson, true);
				
				$remailer->sendEmailToAdmins("Error - En la busqueda de despegar", $content);
			}
		}
		
		// return new Response("<pre>" . print_r($resultArray, true) . "</pre>");
		
		$jsonResponse = json_encode($resultArray);
	
		return $jsonResponse;
	
	}

	private function calcularYAgregarPreciosTotales($result) {
		$logger = $this->get('logger');
		
		$items = $result->result->data->items;
		
		// REQ: el btc_trip.percent_fee se aplica sobre el fee de despegar
		$btcTripFee = 1 + ( $this->container->getParameter('btc_trip.percent_fee') / 100 );
		
		for($i=0; $i<count($items); $i++) {
			$itinerariesBox = $items[$i]->itinerariesBox->itinerariesBoxPriceInfoList[0];
			
			// Al 04/01/2014 no cargan de forma prolija los charges en el json de la web,
			// no ponen los charges separados en cada tipo de pasajero, solo lo ponen en el adult y en el total
			// Asi que como para mantener la coherencia se lo sumo a ese de adult ademas del total.
			
			// calcular el precio total para los adultos
			if(isset($itinerariesBox->adult)) {
				$adultCharges = $this->numberFromMoney($itinerariesBox->adult->charges->formatted->amount) * $btcTripFee;
				
				// para los casos que despegar no nos da ninguna comision, cobramos como el minimo de despegar, a 30 usd son 10 usd.
				if ($adultCharges == 0) {
					$comisionMinimaDespegar = 30;
					$adultCharges = $comisionMinimaDespegar * $btcTripFee - $comisionMinimaDespegar;
				}
				
				$itinerariesBox->adult->charges->formatted->amount = $this->moneyFromNumber($adultCharges);
				
				$totalPriceAdult = $this->numberFromMoney($itinerariesBox->adult->baseFare->formatted->amount) +
					$this->numberFromMoney($itinerariesBox->adult->charges->formatted->amount) +
					$this->numberFromMoney($itinerariesBox->adult->taxes->formatted->amount);
				
				$itinerariesBox->adult->totalOnlyOne = (object) array('formatted' => (object) array('amount' => $this->moneyFromNumber($totalPriceAdult)));
				
				$totalPriceAdults = $totalPriceAdult * $itinerariesBox->adult->quantity;

				$itinerariesBox->adult->total = (object) array('formatted' => (object) array('amount' => $this->moneyFromNumber($totalPriceAdults)));
				
			} else {
				$logger->error('Debe haber al menos un adulto entre los pasajeros!!');
			}
			
			// Seteo de los precios y ch&t a los childrens e infants
			if (isset($itinerariesBox->child)) {
				
				$totalTaxesChild = 0;
				if (isset($itinerariesBox->infant)) {
					$totalTaxesChild = $itinerariesBox->child->quantity * 
							$this->numberFromMoney($itinerariesBox->adult->taxes->formatted->amount);
				} else {
					$totalTaxesChild = $this->numberFromMoney($itinerariesBox->total->taxes->formatted->amount) -
					 		 $itinerariesBox->adult->quantity * $this->numberFromMoney($itinerariesBox->adult->taxes->formatted->amount);
				}
				
				$totalPriceChildrens = 0;
				$totalPriceChildrens = ( $this->numberFromMoney($itinerariesBox->child->baseFare->formatted->amount) +
			 				$this->numberFromMoney($itinerariesBox->adult->charges->formatted->amount) ) * 
			 				$itinerariesBox->child->quantity + $totalTaxesChild;
			 				
				$itinerariesBox->child->total = (object) array('formatted' => (object) array('amount' => $this->moneyFromNumber($totalPriceChildrens)));
			}
				
			if (isset($itinerariesBox->infant)) {
				
				$totalTaxesInfant = 0;
				if (isset($itinerariesBox->child)) {
					$totalTaxesInfant = $this->numberFromMoney($itinerariesBox->total->taxes->formatted->amount) - 
							 ( ($itinerariesBox->child->quantity + $itinerariesBox->adult->quantity) *
							 $this->numberFromMoney($itinerariesBox->adult->taxes->formatted->amount) );
				} else {
					$totalTaxesInfant = $this->numberFromMoney($itinerariesBox->total->taxes->formatted->amount) -
					 		 $itinerariesBox->adult->quantity * $this->numberFromMoney($itinerariesBox->adult->taxes->formatted->amount);
				}
				
				// asignacion solo para crear el sdtclass object
				$itinerariesBox->infant->charges = $itinerariesBox->adult->charges;
			
				$totalPriceInfants = ( $this->numberFromMoney($itinerariesBox->infant->baseFare->formatted->amount) + 
						$this->numberFromMoney($itinerariesBox->infant->charges->formatted->amount) ) * $itinerariesBox->infant->quantity 
						+ $totalTaxesInfant;
			
				$itinerariesBox->infant->total = (object) array('formatted' => (object) array('amount' => $this->moneyFromNumber($totalPriceInfants)));
			}
			
			
			// Totales para los charges
			$totalPassengers = 0;
			$totalPassengers += (isset($itinerariesBox->adult) ? $this->numberFromMoney($itinerariesBox->adult->quantity) : 0);
			$totalPassengers += (isset($itinerariesBox->child) ? $this->numberFromMoney($itinerariesBox->child->quantity) : 0);
			$totalPassengers += (isset($itinerariesBox->infant) ? $this->numberFromMoney($itinerariesBox->infant->quantity) : 0);
			
			// por si llega a estar en 0 el fee de despegar le pongo el m�nimo de btctrip por pasajero
			$totalCharges = $this->numberFromMoney($itinerariesBox->total->charges->formatted->amount);
			$totalChargesWithFee =  ( ( $totalCharges != 0 ) ? $this->moneyFromNumber($totalCharges) : 30 * $totalPassengers ) * $btcTripFee;
			$itinerariesBox->total->charges->formatted->amount = $totalChargesWithFee;
			
			// recalculo el total total a partir de los totales de cada tipo de pasajero
			$totalRecalculado = 0;
			$totalRecalculado += (isset($itinerariesBox->adult) ? $this->numberFromMoney($itinerariesBox->adult->total->formatted->amount) : 0);
			$totalRecalculado += (isset($itinerariesBox->child) ? $this->numberFromMoney($itinerariesBox->child->total->formatted->amount) : 0);
			$totalRecalculado += (isset($itinerariesBox->infant) ? $this->numberFromMoney($itinerariesBox->infant->total->formatted->amount) : 0);
				
			$itinerariesBox->total->fare->formatted->amount = $this->moneyFromNumber($totalRecalculado);
			
		}
		
	}
	
	private function calcularYAgregarPreciosTotalesFee1($result) {
		$logger = $this->get('logger');
	
		$items = $result->result->data->items;
		
		// $logger->debug('----> ' . print_r($items[0]->itinerariesBox->itinerariesBoxPriceInfoList[0],true) );
		
		// REQ: el btc_trip.percent_fee se aplica sobre el baseFare
		$btcTripFee = 1 + ( $this->container->getParameter('btc_trip.percent_fee') / 100 );
		
		
		for($i=0; $i<count($items); $i++) {
			$itinerariesBox = $items[$i]->itinerariesBox->itinerariesBoxPriceInfoList[0];
			
			$totalPriceAdults = 0;
			$totalPriceChildrens = 0;
			
			// Ajuste del BtcTrip Fee al total para que el calculo del nuevo total, que deduce el precio del infant a partir de este total, incluya el fee.
			$totalConFee = $this->numberFromMoney($itinerariesBox->total->fare->formatted->amount) * $btcTripFee;
			$itinerariesBox->total->fare->formatted->amount = $this->moneyFromNumber($totalConFee);
			
			// calcular el precio total para los adultos
			if(isset($itinerariesBox->adult)) {
				$totalPriceAdult = $this->numberFromMoney($itinerariesBox->adult->baseFare->formatted->amount) + 
							 $this->numberFromMoney($itinerariesBox->adult->charges->formatted->amount) +
							 $this->numberFromMoney($itinerariesBox->adult->taxes->formatted->amount);  
				
				$totalPriceAdult = $totalPriceAdult * $btcTripFee;

				$itinerariesBox->adult->totalOnlyOne = (object) array('formatted' => (object) array('amount' => $this->moneyFromNumber($totalPriceAdult)));    	
				
				$totalPriceAdults = $totalPriceAdult * $itinerariesBox->adult->quantity;
				
		//		$logger->debug('prices adult: '. $totalPriceAdult . ' , ' . $itinerariesBox->adult->quantity );
				
				$itinerariesBox->adult->total = (object) array('formatted' => (object) array('amount' => $this->moneyFromNumber($totalPriceAdults)));    	
				
			} else {
				$logger->error('Debe haber al menos un adulto entre los pasajeros!!');
			}
			
			// supongo que si viajan bebes, los ninios tienen la misma taxes que los adultos
			// si  no se calcula a partir del taxes total
			
			// seteo de los ch&t a los childrens e infants
			if (isset($itinerariesBox->child)) {
				$totalPriceChildrens = 0;
				
				if (!isset($itinerariesBox->infant)) {
					$totalPriceChildrens = $this->numberFromMoney($itinerariesBox->total->fare->formatted->amount) - $totalPriceAdults;
					
					// $logger->debug('prices child: '. $totalPriceChildrens . '= ' . $this->numberFromMoney($itinerariesBox->total->fare->formatted->amount) . ' - ' . $totalPriceAdults );
				} else {
					// supongo que tiene el mismo charge y tax que el adulto
					$pricePerChild = $this->numberFromMoney($itinerariesBox->child->baseFare->formatted->amount) +
							$this->numberFromMoney($itinerariesBox->adult->charges->formatted->amount) +
							 $this->numberFromMoney($itinerariesBox->adult->taxes->formatted->amount);
							 
					$totalPriceChildrens = $pricePerChild * $itinerariesBox->child->quantity;
				}
				
				$totalPriceChildrens = $totalPriceChildrens * $btcTripFee; 
				
				$itinerariesBox->child->total = (object) array('formatted' => (object) array('amount' => $this->moneyFromNumber($totalPriceChildrens)));
			}
			
			if (isset($itinerariesBox->infant)) {
				// asignacion solo para crear el sdtclass object
				$itinerariesBox->infant->taxes = $itinerariesBox->adult->taxes;
				
				$totalPriceInfants = 0;
				
				if (!isset($itinerariesBox->child)) {
					$totalPriceInfants = $this->numberFromMoney($itinerariesBox->total->fare->formatted->amount) - $totalPriceAdults;
					
				} else {
					$totalPriceInfants = $this->numberFromMoney($itinerariesBox->total->fare->formatted->amount) - ($totalPriceAdults + $totalPriceChildrens);
				}
				
				$totalPriceInfants = $totalPriceInfants * $btcTripFee;
				
				$itinerariesBox->infant->total = (object) array('formatted' => (object) array('amount' => $this->moneyFromNumber($totalPriceInfants)));
			}

			// recalculo el total total a partir de los totales de cada tipo de pasajero
			$totalRecalculado = 0;
			$totalRecalculado += (isset($itinerariesBox->adult) ? $this->numberFromMoney($itinerariesBox->adult->total->formatted->amount) : 0);
			$totalRecalculado += (isset($itinerariesBox->child) ? $this->numberFromMoney($itinerariesBox->child->total->formatted->amount) : 0);
			$totalRecalculado += (isset($itinerariesBox->infant) ? $this->numberFromMoney($itinerariesBox->infant->total->formatted->amount) : 0);
			
			$itinerariesBox->total->fare->formatted->amount = $this->moneyFromNumber($totalRecalculado);
		}
	}

	private function countPasengers($itinerariesBox) {
		$count = ( isset($itinerariesBox->adult) ? $itinerariesBox->adult->quantity : 0 );
		$count += ( isset($itinerariesBox->child) ? $itinerariesBox->child->quantity : 0 );
		$count += ( isset($itinerariesBox->infant) ? $itinerariesBox->infant->quantity : 0 );
		
		return $count;
	}

	private function numberFromMoney($amount) {
		return str_replace(',', '', $amount);
	}
	
	private function moneyFromNumber($amount) {
		return number_format($amount, 0, '.', ',');
	}

	private function translateTextual($result) {
		$result = $this->translateDays($result);
		$result = $this->translateMonths($result);
		$result = $this->translateCabinType($result);
		$result = $this->translateAirports($result);
		$result = $this->translateCities($result);
		$result = $this->reFormatPrices($result);

		return $result;
	}

	private function translateMonths($result) {
		$englishMonths = array('january','february','march','april','may','june','july', 'august', 'september', 'october', 'november', 'december',
						'jan"','feb"','mar"','apr"','may"','jun"','jul"', 'aug"', 'sep"', 'oct"', 'nov"', 'dec"'); 
		$spanishMonths = array('enero','febrero','marzo','abril','mayo','junio','julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre',
						'ene"','feb"','mar"','abr"','may"','jun"','jul"', 'ago"', 'sep"', 'oct"', 'nov"', 'dic"'); 

		$result = str_replace($spanishMonths, $englishMonths, $result); 

		return $result;
	}

	private function translateDays($result) {
		$englishDays = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday',
								'"mon', '"tue', '"wed', '"thu', '"fri', '"sat', '"sun'); 
		$spanishDays = array('lunes','martes','miércoles','jueves','viernes','sábado','domingo',
								'"lun', '"mar', '"mié', '"jue', '"vie', '"sáb', '"dom'); 

		$result = str_replace($spanishDays, $englishDays, $result); 

		return $result;
	}

	private function translateCabinType($result) {
		$englishCabinTypes = array('Economy class', 'Economy class', 'Executive/Business class');
		$spanishCabinTypes = array('Clase Económica', 'Económica', 'Clase Executive/Business');
	
		$result = str_replace($spanishCabinTypes, $englishCabinTypes, $result);	 
	
		return $result;
	}

	private function translateAirports($result) {
		$spanishRegexs = array('/"Aeropuerto Internacional (.*?)"/', '/"Aeropuerto (.*?)"/');
		$englishReplacement = array('"\1 International Airport"', '"\1 Airport"'); 
		
		$result = preg_replace($spanishRegexs, $englishReplacement, $result);
	
		return $result;
	}
	
	// este translate es basicamente por el de los meses modifica Chicago por Chicaug :|
	private function translateCities($result) {
		$englishCities = array('Chicago');
		$spanishCities = array('Chicaug');
		
		$result = str_replace($spanishCities, $englishCities, $result);
		
		return $result;
	}

	// cambia el formato del precio, el punto por la coma para los separadores de miles
	private function reFormatPrices($result) {
		$priceMatcher = array('/"amount":"(\d+)\.(\d+)"/');
		$priceReplacement = array('"amount":"\1,\2"'); 
		
		$result = preg_replace($priceMatcher, $priceReplacement, $result);
	
		return $result;
	}


	// 
	// Tareas
	// 	
	// 	Dejar funcionando la búsqueda principal, con todos los campos.
	//
	// 	Dejar funcionando la paginación.
	//
	// 	Traducción de resultados de busqueda.
	//
	// 	Traducción de autocompletes.
	//
	//	Procesar los resultados de busqueda.
	//
	// 	? Se podrá levantar la ubicación del usuario para agregarla como primera búsqueda por defecto?
	//
	//



	// 
	// Cuesti�n de precio
	//
	// Alternativa 1:
	// 	Dejar los precios en la p�gina de resultados solamente en dolares. 
	// 	Enviar la orden de bitpay en dolares.
	// 	https://bitpay.com/bitcoin-exchange-rates
	//
	// 	Pros: 
	// 		Poco tiempo de desarrollo
	// 	Contra:
	// 		Poca presencia de btcs en el sitio.
	//
	// Alternativa 2:
	// 	Pollear el precio desde bitpay a cada minuto y convertir los precios seg�n esta cotizaci�n. 
	// 	Generar la orden de bitpay en bitcoins.
	//	
	//	Pros: 
	//		M�s presencia del btc en el sitio desde el punto de vista del usuario.
	//		Controlamos la cotizaci�n in house
	//	Contra:
	//		Tiempo de desarrollo
	//
	
	
	// 
	// Refinado de la búsqueda
	// 
	// implemenatar servicio refine
	// http://karimflights.karnak.net/app_dev.php/refine/ROUNDTRIP/INTERNATIONAL/-1039591028/1/PRECLUSTER/TOTALFARE/ASCENDING/1/NA/NA/USD/USD/NA/NA/NA/NONE/NA/NA/NA/NA
	// 	

}


