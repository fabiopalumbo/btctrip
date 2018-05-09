<?php

namespace BtcTrip\FlightsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;
use \BtcTrip\FlightsBundle\Transformer\AvailabilityResultTransformer as AvailabilityResultTransformer;
use BtcTrip\MainBundle\Service\BaseService;

/**
 * Helper para Flights
 *
 */
class FlightsHelper extends BaseService {

	public function processAvailabilityResponse($apiResponse, $searchParameters, $optionalParameters, $filterParams, $tpFlights) {
		$logger = $this->get('logger');
		$megaHelper = $this->get('mega_helper');
	
		$page = 1;
		if (isset($filterParams) && isset($filterParams['page'])) {
			$page = $filterParams['page'];
		}
			
		$transformer = new AvailabilityResultTransformer($this->container);
		$response = $transformer->transform($apiResponse, $page, $searchParameters);

		// guardar lo relevante para la compra y para el tracking
		//if (isset($response->result->data->metadata) && $response->result->data->metadata->status->code == 'SUCCEEDED' ) {
        if(true) {
				
			// calcular y agregar los precios totales de cada tipo de pasaje
			$this->calcularYAgregarPreciosTotales($response);
				
            /*
             * TRAVELPORT
             */
            foreach($tpFlights as $flight) {
                $response->result->data->items[] = $flight;
            }
            /*
             * END TRAVELPORT
             */
			// guarda los items de la bÃºsqueda y la metadata
			$this->persistInterestingResultParts($response, $apiResponse->meta->ticket, $optionalParameters, $filterParams);
		} else {
			$logger->error('El resultado de busqueda no fue exitoso.');
		}
		// traducir aeropuertos y los titulo de las clases de vuelo
	
		return $response;
	}

    /* OLD_CODE */
	
	public function updateFlightAvailability($orderId) {
		$logger = $this->get('logger');
		
		$retval = false;
		
		$order = $this->get('order_manager')->getById($orderId);
		
		// recuperar parametros de la busqueda del vuelo
		$searchParameters = $this->getSearchParameters($order['itinerary']['search']['url']);
		$filterParams = $order['itinerary']['search']['filters'];
		$optionalParameters = $order['itinerary']['search']['optionals'];
		
		$searchResult = $this->searchFlights($searchParameters, $filterParams, $optionalParameters);
		
		if (isset($searchResult->flights) && count($searchResult->flights) > 0) {
			$response = $this->processAvailabilityResponse($searchResult, $searchParameters, $optionalParameters, $filterParams);
			 
			// buscar el vuelo en los resultados
			$itinerarioOriginal = $order['itinerary'];
			$itinerarioNuevo = $this->searchFlightInResult($response->result->data, $itinerarioOriginal);
		
			// si se encontr— el vuelo actualizar la order con los nuevos datos (itinerario???, precio, id de itinerario, searchId, ticket id)
			if (isset($itinerarioNuevo)) {
				$order['itineraryOriginal'] = $itinerarioOriginal;
				$order['itinerary'] = $itinerarioNuevo;
				$order['itinerary']['metadata'] = $response->result->data->metadata;

				$this->get('order_manager')->save($order);
				
				// conseguir el nuevo ticket desde el servicio fields
				$requiredFields = $this->get('btctrip_api')->bookingFlightsFields($order['itinerary']['metadata']['ticket']['id'], $order['itinerary']['id']);
				if (!isset($requiredFields->errors)) {
					$order['requiredFields'] = json_decode(json_encode($requiredFields->data), true);
				} else {
					$logger->error("Error consultando los campos requeridos.");
					$logger->error(print_r($requiredFields, true));
				}
					
				$this->get('order_manager')->save($order);
				
				$retval = true;
			} else {
				$logger->error("Vuelo no encontrado.");
			}
		} else {
			$logger->error("Error en la busqueda.");
		}
		
		return $retval;
	}
	
	private function searchFlights($parameters, $filters, $optionals) {
		/* @var $btctripApi \BtcTrip\APIBtcTripBundle\DependencyInjection\BtctripApi */
		$btctripApi = $this->get('btctrip_api');
		 
		if(isset($parameters['returnDate'])) {
			$searchResult = $btctripApi->availabilityFlightsRoundTrip($parameters['from'], $parameters['to'], $parameters['departureDate'], $parameters['returnDate'],
					$parameters['adults'], $parameters['children'], $parameters['infants'],
					$optionals['orderBy'], $optionals['orderDir'], $optionals['departureTime'], $optionals['returningTime'], $optionals['classFlight'],
					$optionals['scaleFlight'], $optionals['airlineFlight'], $filters);
		} else {
			$searchResult = $btctripApi->availabilityFlightsOneWay($parameters['from'], $parameters['to'], $parameters['departureDate'],
					$parameters['adults'], $parameters['children'], $parameters['infants'],
					$optionals['orderBy'], $optionals['orderDir'], $optionals['departureTime'], $optionals['returningTime'], $optionals['classFlight'],
					$optionals['scaleFlight'], $optionals['airlineFlight'], $filters);
		}
		 
		return $searchResult;
	}
	

	// busca el itinerario $itinerary en los itinerarios de $searchFlights
	// devuelve el itinerario si lo encuentra o null
	private function searchFlightInResult($searchFlights, $itinerary) {
		$itineraryResult = null;
		$currencyCode = "USD";
	
		// los 12 son para sacar la fecha de la busqueda y el pais de la agencia
		$wishlistOriginalSinPrecio = substr($itinerary['wishList'], 12, strpos($itinerary['wishList'], '_p:')-12);
	
		foreach ($searchFlights->items as $flight) {
			foreach ($flight->itinerariesBox->matchingInfoMap as $key => $matchingInfo) {
				
				//as $itineraryInfo
	
				$wishlistItinearioActualSinPrecio = substr($matchingInfo->wishList, 12, strpos($matchingInfo->wishList, '_p:')-12);
	
				// itinerario encontrado!!
				if ($wishlistItinearioActualSinPrecio == $wishlistOriginalSinPrecio) {
	
					$itineraryResult = array();
	
					$indexes = preg_split("/_/", $key);
					
					// outbound
					$itineraryResult['outboundRoute'] = $flight->itinerariesBox->outboundRoutes[$indexes[1]];
	
					// inbound
					if ($indexes[1] != '-1') {
						$itineraryResult['inboundRoute'] = $flight->itinerariesBox->inboundRoutes[$indexes[2]];
					}
	
					// itenerariesBoxPriceInfoList
					// $availabilityTransformer = new AvailabilityResultTransformer($this->container);
					// $itineraryResult['itinerariesBoxPriceInfoList'] = $availabilityTransformer->buildPriceInfoList($itineraryInfo->priceInfo, $currencyCode);
					
					$itineraryResult['itenerariesBoxPriceInfoList'] = $flight->itinerariesBox->itinerariesBoxPriceInfoList;
						
					// id
					$itineraryResult['id'] = $matchingInfo->id;
	
					// wishlist
					$itineraryResult['wishList'] = $matchingInfo->wishList;
	
					$itineraryResult['search'] = $itinerary['search'];
	
					break;
				}
			}
		}
	
		return $itineraryResult;
	}
	
	
	public function OLD_YAMIL_processAvailabilityResponse($apiResponse, $searchParameters, $optionalParameters, $filterParams) {
		$logger = $this->get('logger');
		$megaHelper = $this->get('mega_helper');
	
		$page = 1;
		if (isset($filterParams) && isset($filterParams['page'])) {
			$page = $filterParams['page'];
		}
			
		$transformer = new AvailabilityResultTransformer($this->container);
		$response = $transformer->transform($apiResponse, $page, $searchParameters);

		// guardar lo relevante para la compra y para el tracking
		if (isset($response->result->data->metadata) && $response->result->data->metadata->status->code == 'SUCCEEDED' ) {
				
			// calcular y agregar los precios totales de cada tipo de pasaje
			$this->calcularYAgregarPreciosTotales($response);
				
			// guarda los items de la bÃºsqueda y la metadata
			$this->persistInterestingResultParts($response, $apiResponse->meta->ticket, $optionalParameters, $filterParams);
				
		} else {
			$logger->error('El resultado de busqueda no fue exitoso.');
		}
		// traducir aeropuertos y los titulo de las clases de vuelo
	
		return $response;
	}
	
	private function calcularYAgregarPreciosTotales($result) {
		// Se agrega el precio por pasajero: promedio del precio total
	
		$logger = $this->get('logger');
	
		$items = $result->result->data->items;
	
		// REQ: el btc_trip.percent_fee se aplica sobre el fee de despegar
		$btcTripFee = ( $this->container->getParameter('btc_trip.percent_fee') / 100 );
	
		for($i=0; $i<count($items); $i++) {
			$itinerariesBox = $items[$i]->itinerariesBox->itinerariesBoxPriceInfoList[0];
	
			$passengersCount = $this->countPasengers($itinerariesBox);
				
			$totalAdults = 0;
			$totalChildren = 0;
			$totalInfants = 0;
				
			if(!isset($itinerariesBox->adult)) {
				// TODO: throw exception
				$logger->error('Debe haber al menos un adulto entre los pasajeros!!');
			}
	
			$btctripCharges = $itinerariesBox->adult->charges->raw * $btcTripFee;
				
			// para los casos que despegar no nos da ninguna comision, cobramos como el minimo de despegar, a 30 usd son 10 usd.
			if ($btctripCharges < 10) {
				$comisionMinimaDespegar = 30;
				$btctripCharges = ceil($comisionMinimaDespegar * $btcTripFee);
			}
	
			$totalOnlyFare = $itinerariesBox->adult->totalFare->raw;
			$totalOnlyFare += ( isset($itinerariesBox->child) ? $itinerariesBox->child->totalFare->raw : 0 );
			$totalOnlyFare += ( isset($itinerariesBox->infant) ? $itinerariesBox->infant->totalFare->raw : 0 );
				
			// se calcula el porcentaje de cada tarifa sobre la tarifa total sin los charges $ taxes
			$farePercentageAdults =  $itinerariesBox->adult->totalFare->raw / $totalOnlyFare;
			$farePercentageChildren = ( isset($itinerariesBox->child) ? $itinerariesBox->child->totalFare->raw / $totalOnlyFare : 0 );
			$farePercentageInfants = ( isset($itinerariesBox->infant) ? $itinerariesBox->infant->totalFare->raw / $totalOnlyFare : 0 );
				
			$totalAdults = $itinerariesBox->adult->totalFare->raw;
			$totalAdults += $farePercentageAdults * $itinerariesBox->total->taxes->raw;
			$totalAdults += ($btctripCharges + $itinerariesBox->adult->charges->raw) * $itinerariesBox->adult->quantity;
				
			$itinerariesBox->adult->total = (object) array('formatted' => (object) array('amount' => $this->moneyFromNumber($totalAdults)));
				
			if (isset($itinerariesBox->child)) {
				$totalChildren = $itinerariesBox->child->totalFare->raw;
				$totalChildren += $farePercentageChildren * $itinerariesBox->total->taxes->raw;
				$totalChildren += ($btctripCharges + $itinerariesBox->adult->charges->raw) * $itinerariesBox->child->quantity;
	
				$itinerariesBox->child->total = (object) array('formatted' => (object) array('amount' => $this->moneyFromNumber($totalChildren)));
			}
				
			if (isset($itinerariesBox->infant)) {
				$totalInfants = $itinerariesBox->infant->totalFare->raw;
				$totalInfants += $farePercentageInfants * $itinerariesBox->total->taxes->raw;
				$totalInfants += ($btctripCharges + $itinerariesBox->adult->charges->raw) * $itinerariesBox->infant->quantity;
	
				$itinerariesBox->infant->total = (object) array('formatted' => (object) array('amount' => $this->moneyFromNumber($totalInfants)));
			}
				
			// se recalcula el total
			$total = $totalAdults + $totalChildren + $totalInfants;
				
			$perPassenger = $total / $passengersCount;
			// se chequea el total
	
			$itinerariesBox->total->fare->formatted->amount = $this->moneyFromNumber($total);
			$itinerariesBox->total->perPassenger = (object) array('formatted' => (object) array('amount' => $this->moneyFromNumber($perPassenger), 'code' => 'USD', 'mask' => 'USD'));
			
			// agregar los precios en BTC y el resto de las monedas
			$this->agregarPreciosEnOtrasMonedas($items[$i]->itinerariesBox->itinerariesBoxPriceInfoList);
			
		}
	
	}
	
	private function agregarPreciosEnOtrasMonedas(&$itinerariesBoxPriceInfoList) {
		$precioUsd = $itinerariesBoxPriceInfoList[0];
		
		$xchgRates = $this->get('exchange_rate')->getLastExchangeRatesCurrencyIndexed();
		
		foreach ($xchgRates as $code => $rate) {
			// clone
			$newPrice = clone $precioUsd;
			// & deep copy
			foreach($precioUsd as $key => $val) {
				if (is_object($val) || (is_array($val))) {
					$newPrice->{$key} = unserialize(serialize($val));
				}
			}
			
			$this->populateNewCurrencyPrice($newPrice, $code, $rate);
			$itinerariesBoxPriceInfoList[] = $newPrice;
		}
		
	}
	
	private function populateNewCurrencyPrice(&$price, $currency, $rate) {
		$price->currencyCode = $currency;
		
		$price->adult->totalFare->formatted->code = $currency;
		$price->adult->totalFare->formatted->mask = $currency;
		$price->adult->total->formatted->amount = $this->crytoFromNumber($this->numberFromMoney($price->adult->total->formatted->amount) / $rate, $currency);
		
		if (isset($price->child)) {
			$price->child->totalFare->formatted->code = $currency;
			$price->child->totalFare->formatted->mask = $currency;
			$price->child->total->formatted->amount = $this->crytoFromNumber($this->numberFromMoney($price->child->total->formatted->amount) / $rate, $currency);
		}
		
		if (isset($price->infant)) {
			$price->infant->totalFare->formatted->code = $currency;
			$price->infant->totalFare->formatted->mask = $currency;
			$price->infant->total->formatted->amount = $this->crytoFromNumber($this->numberFromMoney($price->infant->total->formatted->amount) / $rate, $currency);
		}
		
		$price->total->fare->formatted->code = $currency;
		$price->total->fare->formatted->mask = $currency;
		$price->total->fare->formatted->amount = $this->crytoFromNumber($this->numberFromMoney($price->total->fare->formatted->amount) / $rate, $currency);
		
		$price->total->perPassenger->formatted->code = $currency;
		$price->total->perPassenger->formatted->mask = $currency;
		$price->total->perPassenger->formatted->amount = $this->crytoFromNumber($this->numberFromMoney($price->total->perPassenger->formatted->amount) / $rate, $currency);
	}
	
	private function getSearchParameters($searchUrl) {
		$parametersStartPosition;
		$parametersEndPosition;
		$isRoundTrip = true;
		 
		if ($parametersStartPosition = strpos($searchUrl, 'roundtrip')) {
			$parametersStartPosition += 10;
			$parametersEndPosition = 35;
		} else {
			$parametersStartPosition = strpos($searchUrl, 'oneway') + 7;
			$parametersEndPosition = 24;
			$isRoundTrip = false;
		}
		 
		$urlParameters = substr($searchUrl, $parametersStartPosition, $parametersEndPosition);
		$parameters = preg_split('/\//', $urlParameters);
		 
		$retval = array('from' => $parameters[0],
				'to' => $parameters[1],
				'departureDate' => $parameters[2] );
		 
		if ($isRoundTrip) {
			$retval['returnDate'] = $parameters[3];
			$retval['adults'] = $parameters[4];
			$retval['children'] = ( $parameters[5] === '0' ? '0' : count(preg_split('/\-/', $parameters[5])) );
			$retval['infants'] = $parameters[6];
		} else {
			$retval['adults'] = $parameters[3];
			$retval['children'] = ( $parameters[4] === '0' ? '0' : count(preg_split('/\-/', $parameters[4])) );
			$retval['infants'] = $parameters[5];
		}
		 
		return $retval;
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
	
	private function crytoFromNumber($amount, $cryptoCode) {
		if ($cryptoCode == 'BTC') {
			return number_format($amount, 4, '.', ',');
		} else if ($cryptoCode == 'XDG') {
			return number_format($amount, 0, '.', ',');
		} else if ($cryptoCode == 'LTC') {
			return number_format($amount, 2, '.', ',');
		}
	}
	
	// cambia el formato del precio, el punto por la coma para los separadores de miles
	private function reFormatPrices($result) {
		$priceMatcher = array('/"amount":"(\d+)\.(\d+)"/');
		$priceReplacement = array('"amount":"\1,\2"');
	
		$result = preg_replace($priceMatcher, $priceReplacement, $result);
	
		return $result;
	}	

	public function generateResponseError() {
		$responseError["result"]["data"]["metadata"]["status"]["code"] = "ERROR";
		$responseError["result"]["data"]["metadata"]["status"]["message"] = "See messages for details";

		$responseError["messages"][0]["code"] = "SEARCH_ENGINE_UNAVAILABLE";
		$responseError["messages"][0]["value"] = "Search engine temporally unavailable";
		$responseError["messages"][0]["description"] = "The search engine is temporally unavailable. Please, try again in a few minutes.";
		
		return $responseError;	
	}


	private function persistInterestingResultParts($resultArray, $ticket, $optionalParameters, $filterParams) {
		$session = $this->container->get('session_manager')->getSession();
		$sessionid = $session->getId();
		 
		// Cada busqueda es una busqueda nueva y se persisten todas.
		// La bœsqueda usa la œltima.
		
		$aResult['sessionId'] = $sessionid;
		$aResult['items'] = $resultArray->result->data->items;
		$aResult['metadata'] = $resultArray->result->data->metadata;
		// este es el ticket del resultado de la busqueda via api
		$aResult['metadata']->ticket->id = $ticket;
		
		$searchUrl = $this->container->get('request')->headers->get('referer');
		$aResult['search'] = array('url' => $searchUrl, 'optionals' => $optionalParameters, 'filters' => $filterParams);

		$this->container->get('flights_search_manager')->save($aResult);
	}
	
	// devuelve el resumen del itinerario siendo el destino de cada segmento
	public function getItineraryBrief($itinerary) {
		$logger = $this->container->get('logger');
		
		$brief = '';
		
		$outboundRoute = $itinerary['outboundRoute'];
		
		for ( $s=0; $s < count($outboundRoute['segments']); $s++ ) {
			$brief .= $outboundRoute['segments'][$s]['arrival']['location']['airport']['code'] . ( $s+1 < count($outboundRoute['segments']) ? ' - ' : '' );
		}
		
		if ( isset($itinerary['inboundRoute']) ) {
			$inboundRoute = $itinerary['inboundRoute'];
			$brief .= ' - ';
			
			for ( $s=0; $s < count($inboundRoute['segments']); $s++ ) {
				$brief .= $inboundRoute['segments'][$s]['arrival']['location']['airport']['code'] . ( $s+1 < count($inboundRoute['segments']) ? ' - ' : '' );
			}
		}
		
		return $brief;
	}
	


	
}
