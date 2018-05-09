<?php

namespace BtcTrip\FlightsBundle\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

use \BtcTrip\APIBtcTripBundle\Classes\TravelportApi as TravelportApi;
use \BtcTrip\FlightsBundle\DependencyInjection\SearchSort as SearchSort;

class SearchController extends Controller
{

   	/**
	 * @Route("/results/oneway/{sFrom}/{sTo}/{sDepartureDate}/{sAdults}/{sChildren}/{sInfants}/{sDepartureTime}/{sClassFlight}/{sScaleFlight}/{sAirlineFlight}", 
	 			name="resultsAdvanceOneway",
	 			defaults={"sDepartureTime"="NA", "sClassFlight"="NA", "sScaleFlight"="NA", "sAirlineFlight"="NA"})   	
	 * @Template(engine="php", template="BtcTripFlightsBundle:Search:results.html.php")
	 */
	public function resultsOnewayAction($sFrom, $sTo, $sDepartureDate, $sAdults, $sChildren, $sInfants, $sDepartureTime, $sClassFlight, $sScaleFlight, $sAirlineFlight) {
		
		// TODO: agregar , $sDepartureTime,  $sClassFlight, $sScaleFlight, $sAirlineFlight en la vista
		return $this->results("oneway", $sFrom, $sTo, $sDepartureDate, "", $sAdults, $sChildren, $sInfants, $sDepartureTime, "", $sClassFlight, $sScaleFlight, $sAirlineFlight);
	}


   	/**
	 * @Route("/results/roundtrip/{sFrom}/{sTo}/{sDepartureDate}/{sReturningDate}/{sAdults}/{sChildren}/{sInfants}/{sDepartureTime}/{sReturningTime}/{sClassFlight}/{sScaleFlight}/{sAirlineFlight}", 
	 			name="resultsAdvanceRoundtrip",
	 			defaults={"sDepartureTime"="NA", "sReturningTime"="NA", "sClassFlight"="NA", "sScaleFlight"="NA", "sAirlineFlight"="NA"})   	
	 * @Template(engine="php", template="BtcTripFlightsBundle:Search:results.html.php")
	 */
	public function resultsRoundtripAction($sFrom, $sTo, $sDepartureDate, $sReturningDate, $sAdults, $sChildren, $sInfants, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight) {
		return $this->results("roundtrip", $sFrom, $sTo, $sDepartureDate, $sReturningDate, $sAdults, $sChildren, $sInfants, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight);
	}


	private function results($sTripType, $sFrom, $sTo, $sDepartureDate, $sReturningDate, $sAdults, $sChildren, $sInfants, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight) {
		$enviromentPrefix = $this->get('mega_helper')->getEnviromentPrefix();
		
		$sFromName = $this->get('city_manager')->getCityName($sFrom);
		$sToName = $this->get('city_manager')->getCityName($sTo);
		
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
		$iAdults = $sAdults;
		$iChildren = ( $sChildren === '0' ? '0' : count(preg_split('/\-/', $sChildren)) );
		$iInfants = $sInfants;
		
		return $this->search("roundtrip", $sFrom, $sTo, $sDepartureDate, $sReturningDate, $iAdults, $iChildren, $iInfants, $sOrderBy, $sOrderDir, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight);
	}

	/**
	 * @Route("/search/oneway/{sFrom}/{sTo}/{sDepartureDate}/{sAdults}/{sChildren}/{sInfants}/{sOrderBy}/{sOrderDir}/{sDepartureTime}/{sClassFlight}/{sScaleFlight}/{sAirlineFlight}", 
	 			name="searchOneway", 
	  			defaults={"_format"="json", "sOrderBy"="TOTALFARE", "sOrderDir"="ASCENDING", "sDepartureTime"="NA", "sClassFlight"="NA", "sScaleFlight"="NA", "sAirlineFlight"="NA"})
	 */
	public function searchOnewayAction($sFrom, $sTo, $sDepartureDate, $sAdults, $sChildren, $sInfants, $sOrderBy, $sOrderDir, $sDepartureTime, $sClassFlight, $sScaleFlight, $sAirlineFlight) {

		$iAdults = $sAdults;
		$iChildren = ( $sChildren === '0' ? '0' : count(preg_split('/\-/', $sChildren)) );
		$iInfants = $sInfants;
		
		return $this->search("oneway", $sFrom, $sTo, $sDepartureDate, "", $iAdults, $iChildren, $iInfants, $sOrderBy, $sOrderDir, $sDepartureTime, "", $sClassFlight, $sScaleFlight, $sAirlineFlight);
	}

	private function searchResponseProcessor($response, $pageNumber, $orderBy, $orderDir) {
        // sort de los resultados.
        SearchSort::sort($response->result->data->items, array(
            'orderBy' => $orderBy,
            'orderDir' => $orderDir,
        ));


        // rellenado de los filtros resultantes de los vuelos encontrados.
        $americanAirlinesFlights = 0; // por default hacemos de cuenta que no existen vuelos de AA/TP, hasta que losencontremos.
        foreach($response->result->data->items as $key => $flight) {
            // si es un object, es de despegar, solo proceso tp.
            if(!is_object($flight)) {
                // NOTE: ojo con 'XXXXXXXXXXXXXXXXXX' que es el id que seteamos para cuando es un vuelo de travelport.
                if($flight['id'] == 'XXXXXXXXXXXXXXXXXX') {
                    // esto es para agregar el filtro de AA a lap agina de resultados.
                    $americanAirlinesFlights++;
                }
            }
        }

        if($americanAirlinesFlights) {
            $response->result->data->refinementSummary->airlines[] = array(
                'value' => array(
                    'code' => 'AA',
                    'description' => 'American Airlines',
                ),
                'count' => $americanAirlinesFlights,
                'selected' => false,
            );
        }

        // paginado de los resultados
        $response->result->data->paginationSummary->itemCount = count($response->result->data->items);
        $response->result->data->paginationSummary->pageCount = round($response->result->data->paginationSummary->itemCount / 10);

        if(empty($pageNumber)) {
            $offset = 0;
        } else {
            $offset = ($pageNumber-1) * 10;
        }
        $response->result->data->items = array_slice($response->result->data->items, $offset, 10);

        return $response;
    }


	private function search($sTripType, $sFrom, $sTo, $sDepartureDate, $sReturningDate, $iAdults, $iChildren, $iInfants, $sOrderBy, $sOrderDir, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight, $filterParams = null) {
		$logger = $this->get('logger');
		$btctripApi = $this->get('btctripapi');
				
		$sOrderDir = str_replace(array('ASCENDING', 'DESCENDING'), array('asc', 'desc'), $sOrderDir);
		// ECONOMY, BUSINESS, FIRSTCLASS, PREMIUM_ECONOMY, PREMIUM_BUSINESS, PREMIUM_FIRSTCLASS
		$sClassFlight = str_replace(array('YC', 'C', 'F'), array('ECONOMY', 'BUSINESS', 'FIRSTCLASS'), $sClassFlight);
		
		$optionalsParameters = array('sDepartureTime', 'sReturningTime', 'sClassFlight', 'sScaleFlight', 'sAirlineFlight');
		foreach ($optionalsParameters as $optionalsParameter) {
			${$optionalsParameter} = str_replace('NA', null, ${$optionalsParameter});
		}
		
		if (isset($filterParams)) {
			foreach ($filterParams as $name => $value) {
				if ($filterParams[$name] == 'NA') {
					$filterParams[$name] = null;
				}
			}
		}

		$searchParameters = array(
				'from' => $sFrom, 'to' => $sTo,
				'departureDate' => $sDepartureDate, 'returningDate' => $sReturningDate,
				'adults' => $iAdults, 'children' => $iChildren, 'infants' => $iInfants
		);

        // cached search 
        $memcached = new \Memcached();
        $memcached->addServer('localhost', 11211);

        $cache = new \Doctrine\Common\Cache\MemcachedCache();
        $cache->setMemcached($memcached);

        $cachedSearchKey = "{$sFrom}_{$sTo}_{$sDepartureDate}_{$sReturningDate}_{$iAdults}_{$iChildren}_{$iInfants}_{$sDepartureTime}_{$sReturningTime}_{$sClassFlight}_{$sScaleFlight}_{$sAirlineFlight}_{$filterParams['timeoutbound']}_{$filterParams['timeinbound']}_{$filterParams['airlines']}_{$filterParams['stops']}_{$filterParams['price']}_{$filterParams['outboundAirports']}_{$filterParams['inboundAirports']}";
        $cachedSearch = $cache->fetch($cachedSearchKey);
        if($cachedSearch) {
            $response = $this->searchResponseProcessor($cachedSearch, $filterParams['page'], $sOrderBy, $sOrderDir);
            return new Response(json_encode($cachedSearch));
        }
        // end cached search 
		
		$apiResponse = array();
		
        // search AA?
        $searchAA = false;
        $searchOnlyAA = false;
        if(!empty($sAirlineFlight) && !empty($filterParams['airlines'])) {
            if(($sAirlineFlight == 'AA') || ($filterParams['airlines'] == 'AA')) {
                $searchOnlyAA = true;
            } else if(strstr($sAirlineFlight, 'AA') || strstr($filterParams['airlines'], 'AA')) {
                // FIXME: cabeceada para sacar ',AA' o 'AA,'
                $filterParams['airlines'] = str_replace('AA,', '', $filterParams['airlines']);
                $filterParams['airlines'] = str_replace(',AA', '', $filterParams['airlines']);
                $sAirlineFlight = str_replace('AA,', '', $sAirlineFlight);
                $sAirlineFlight = str_replace(',AA', '', $sAirlineFlight);

                $searchAA = true;
            }
        } else {
            $searchAA = true;
        }

        if(!$searchOnlyAA) {
            if ($sTripType == 'roundtrip') {
                $apiResponse = $btctripApi->availabilityFlightsRoundTrip($sFrom, $sTo, $sDepartureDate, $sReturningDate, $iAdults, $iChildren, $iInfants,
                        $sOrderBy, $sOrderDir, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight, $filterParams);

            } else if ($sTripType == 'oneway') {
                $apiResponse = $btctripApi->availabilityFlightsOneWay($sFrom, $sTo, $sDepartureDate, $iAdults, $iChildren, $iInfants,
                        $sOrderBy, $sOrderDir, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight, $filterParams);
                
            } else {
                $logger->error('Tipo de vuelo inv�lido: ' . $sTripType);
            }
        }

        
        /*
         * TRAVELPORT
         */
        if($searchAA || $searchOnlyAA) {
            $travelportApi = new TravelportApi($logger);
            $travelportApi->setCityManager($this->get('city_manager'));
            $travelportApi->setAirportManager($this->get('airport_manager'));
            $travelportApi->setExchangeRates($this->get('exchangerate')->getLastExchangeRatesCurrencyIndexed());
            $tpFlights = $travelportApi->availabilityFlights($sTripType, $sFrom, $sTo, $sDepartureDate, $sReturningDate, $iAdults, $iChildren, $iInfants, $sOrderBy, $sOrderDir, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight, $filterParams);
        }
        /*
         * END TRAVELPORT
         */

		// estos son los parametros opcionales armados para ser persistidos
		$optionalParameters = array(
				'orderBy' => $sOrderBy, 'orderDir' => $sOrderDir, 'departureTime' => $sDepartureTime, 'returningTime' => $sReturningTime,
				'classFlight' => $sClassFlight, 'scaleFlight' => $sScaleFlight, 'airlineFlight' => $sAirlineFlight
		);
		
		if ((isset($apiResponse->flights) && count($apiResponse->flights) > 0) || !empty($tpFlights)) {
            /*
             * TRAVELPORT
             */
			$response = $this->get('flights_helper')->processAvailabilityResponse($apiResponse, $searchParameters, $optionalParameters, $filterParams, $tpFlights);
            /*
             * END TRAVELPORT
             */
		} else {
			$response = $this->buildBasicResponse('NO_RESULTS');
		}

        $cache->save($cachedSearchKey, $response, 600);
        $response = $this->searchResponseProcessor($response, $filterParams['page'], $sOrderBy, $sOrderDir);

		return new Response(json_encode($response));
	}
	
	
	private function buildBasicResponse($statusCode) {
		$status = array('code' => $statusCode, 'message' => null);
		
		$response = array("messages" => null, 'result' => array('status' => $status,
						'data' => array('status' => $status, 'metadata' => array('status' => $status))));
		
		return $response;
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
					
		$logger = $this->get('logger');
		$btctripApi = $this->get('btctrip_api');

		$priceRange; // = $minPrice . '-' . $maxPrice;
		if ($minPrice == 'NA' && $maxPrice == 'NA') {
			$priceRange = null;
		} else if ($minPrice == 'NA') {
			$priceRange = '0-' . $maxPrice;
		} else {
			$priceRange = $minPrice . '-1000000';
		}
		
		// parametros permitidos actualmente, como son requeridos por la btctripapi
		$filtersParameters = array('page' => $pageIndex, 'timeoutbound' => $allowedOutboundTimeRanges,
					'timeinbound' => $allowedInboundTimeRanges, 'airlines' => $allowedAirlines, 'stops' => $allowedStopQuantities,
					'price' => $priceRange, 'outboundAirports' => $allowedOutboundAirports, 'inboundAirports' => $allowedInboundAirports);
		
		// TODO: pasar estos parametros deducidos como se pasan en el search convencional
		// TODO: resolver que hacer con los filtros por stops vs los de la busqueda avanzada, por ahora si va el de los filtros no va el de la avanzada.
		
		//  US_0_0_0_R_A-1_MIA-BUE-20131114_BUE-MIA-20131115 para no seguir deduciendolos
		$hashParams = preg_split('/_/', substr($hash, 11));
		foreach ($hashParams as $hashParam) {
			$params = preg_split('/-/', $hashParam);
			
			switch ($params[0]) {
				case 'A':
					$iAdults = $params[1];
					break;
				case 'C':
					$iChildren = $params[1];
					break;
				case 'I':
					$iInfants = $params[1];
					break;
			}
			
			if (count($params) == 3) {
				if (!isset($sDepartureDate)) { 
					$sDepartureDate = substr($params[2], 0, 4) . '-' . substr($params[2], 4, 2) . '-' . substr($params[2], 6);
				} else if (!isset($sReturningDate)) {
					$sReturningDate = substr($params[2], 0, 4) . '-' . substr($params[2], 4, 2) . '-' . substr($params[2], 6);
				}
			}
		}
		
		if (!isset($sReturningDate)) {
			$sReturningDate = null;
		}
		
		// TODO: agregar el cabinType en los parametros del refine
		
		return $this->search(strtolower($flightType), $sFrom, $sTo, $sDepartureDate, $sReturningDate, $iAdults, $iChildren, $iInfants, $orderCriteria, 
				$orderDirection, $allowedOutboundTimeRanges, $allowedInboundTimeRanges, null, null, $allowedAirlines, $filtersParameters);

	}
	


	/*
	// funcion usada para limpiar el resultado de la web de despegar para la migracion a la api
	private function minimizarRespuesta($result) {
		$logger = $this->get('logger');

		unset($result->result->data->aditionalsSearchesSummary);
		unset($result->result->data->betterUpsellPrice);
		unset($result->result->data->hiddenClusterCount);
		unset($result->result->data->priceSuggestionMatrix);
		unset($result->result->data->pricesSummary);
		unset($result->result->data->reviewsSummary);
		unset($result->result->htmlContent);
		
		$items = $result->result->data->items;
		foreach ($items as $item) {
			unset($item->economyItem);
			unset($item->emissionPrice);
			unset($item->favorite);
			unset($item->hidden);
			unset($item->itinerariesBox->emissionPrice);
			unset($item->itinerariesBox->paymentsInfo);
			unset($item->itinerariesBox->frequentFlyerInfo);
			
			$routesDefs = array('outboundRoutes');
			if ( isset($item->itinerariesBox->inboundRoutes) ) {
				$routesDefs[] = 'inboundRoutes';
			}
			
			foreach ($routesDefs as $z => $routeDef) {
				$routes = $item->itinerariesBox->$routeDef;
				
// 				$logger->debug(print_r($routes, true));
				
				unset($routes{0}->routeAncillaries);
				unset($routes{0}->carbonFootprintInfo);
				unset($routes{0}->segmentsByCabinTypeName);
				
				$segments = $routes{0}->segments;
				foreach ($segments as $segment) {
					unset($segment->ancillaryInfo);
					unset($segment->review);
				}
				
				$routes{0}->segments = $segments;
				$item->itinerariesBox->$routeDef = $routes;
			}
			
		}
		
		$result->result->data->items = $items;
		
		return $result;
	}  */
	


}


