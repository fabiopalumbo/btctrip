<?php

namespace BtcTrip\FlightsBundle\Transformer;

use BtcTrip\MainBundle\DocumentManager\AirportManager;
/**
 * Aplica las transformaciones propias de la presentacion como ser el formateo de los precios y aeropuertos y fechas.
 * 
 * @author yamil
 *
 */
class AvailabilityResultTransformer {
	private $container;
	
	public function __construct($container) {
		$this->container = $container;
	}
	
	public function transform($result, $currentPage, $searchParameters) {
		$transformation = $this->buildBase();
		
		$transformation['result']['data']['items'] = $this->buildItems($result);
		$transformation['result']['data']['status'] = $this->getStatus();
		$transformation['result']['data']['metadata'] = $this->buildMetadata($result, $searchParameters);
		$transformation['result']['data']['paginationSummary'] = $this->buildPaginationSummary($result, $currentPage);
		$transformation['result']['data']['refinementSummary'] = $this->buildRefinementSummary($result); 
		
		return json_decode(json_encode($transformation));
	}

	private function buildBase() {
		$retval = array("result" => array("status" => $this->getStatus()), "messages" => null);
		
		return $retval;
	}
	
	private function buildRefinementSummary($result) {
		$refinementSummary = array();
		
		$facets = $result->meta->facets;
		
		foreach ($facets as $facet) {
			$refinementSummary[$facet->key] = array();
			
			switch ($facet->type) {
				case 'discrete':  
					$values = $facet->values;
					foreach ($values as $value) {
						$refinementSummary[$facet->key][] = array(
								'value' => array('code' => $value->id, 'description' => $this->translateAirports($value->description)),
								'count' => $value->count,
								'selected' => false);
					}
					break;
					
				case 'range':
					$refinementSummary[$facet->key]['min'] = $facet->min;
					$refinementSummary[$facet->key]['max'] = $facet->max;
					break;
			}
			
			$refinementSummary['uniqueAirlineSelected'] = false;
			$refinementSummary['uniqueHomeAirportSelected'] = false;
		}
		
		return $refinementSummary;
	}
	
	private function buildPaginationSummary($result, $currentPage) {
		$pagsum = array();
		
		$pagsum['itemCount'] = $result->meta->total;
		$pagsum['pageCount'] = $result->meta->pageCount;
		$pagsum['currentPage'] = $currentPage;
		
		return $pagsum;
	}
	
	private function buildMetadata($result, $searchParameters) {
		$metadata = array();
		
		$metadata['status'] = $this->getStatus();
		// ignorados: fareSelectorType, providers, hasFrequenFlyerInfo, currencyRates
		$metadata['currencyCode'] = $result->meta->currencyCode;
		$metadata['ticket'] = array('hash' => $this->buildHashTicket($result, $searchParameters), 'version' => '1');
		
		return $metadata;
	}
	
	private function buildHashTicket($result, $searchParameters) {
		// US_0_0_0_R_A-1_SCL-BUE-20140417_BUE-SCL-20140423
		// US_0_0_0_R_A-1_C-1_SCL-BUE-20140417_BUE-SCL-20140423
		// US_0_0_0_R_A-1_C-1_I-1_SCL-BUE-20140417_BUE-SCL-20140423
		
		// prefijo generico
		$hashTicket = 'US_0_0_0_R';
		
		// passengers counts
		$hashTicket .= '_A-' . $searchParameters['adults'];
		$hashTicket .= '_C-' . $searchParameters['children'];
		$hashTicket .= '_I-' . $searchParameters['infants'];
		
		// outbound
		$unformattedDate = str_replace('-', '', $searchParameters['departureDate']) ;
		$hashTicket .= '_' . $searchParameters['from'] . '-' . $searchParameters['to'] . '-' . $unformattedDate;
		
		// inbound
		if (!empty($searchParameters['returningDate'])) {
			$unformattedDate = str_replace('-', '', $searchParameters['returningDate']) ;
			$hashTicket .= '_' . $searchParameters['to'] . '-' . $searchParameters['from'] . '-' . $unformattedDate;
		}
		
		return $hashTicket;
	}
	
	private function buildItems($result) {
		$items = array();
		// id, itinerariesBox, [weights], [provider]
		
		foreach ($result->flights as $flight) {
			$item['id'] = $flight->id;
			$item['itinerariesBox'] = $this->buildItinerariesBox($flight, $result->meta->currencyCode); 

			$items[] = $item;
		}
		
		return $items;
	}
	
	private function buildItinerariesBox($flight, $currencyCode) {
		$itinerariesBox['id'] = 0;
		
		// outboundLocations y inboundLocations
		$departureOutboundLocationCode = $flight->outboundRoutes[0]->segments[0]->departure->location;
		$departureOutboundLocationDescription = $this->translateAirports($flight->outboundRoutes[0]->segments[0]->departure->locationDescription);
		$arrivalOutboundLocationCode = $flight->outboundRoutes[0]->segments[count($flight->outboundRoutes[0]->segments)-1]->arrival->location;
		$arrivalOutboundLocationDescription = $this->translateAirports($flight->outboundRoutes[0]->segments[count($flight->outboundRoutes[0]->segments)-1]->arrival->locationDescription);
		 
		$itinerariesBox['outboundLocations'] = array(
				"departure" => $this->buildLocation($departureOutboundLocationCode, $departureOutboundLocationDescription), 
				"arrival" => $this->buildLocation($arrivalOutboundLocationCode, $arrivalOutboundLocationDescription));
		
		if (isset($flight->inboundRoutes[0])) {
			$departureInboundLocationCode = $flight->inboundRoutes[0]->segments[0]->departure->location;
			$departureInboundLocationDescription = $this->translateAirports($flight->inboundRoutes[0]->segments[0]->departure->locationDescription);
			$arrivalInboundLocationCode = $flight->inboundRoutes[0]->segments[count($flight->inboundRoutes[0]->segments)-1]->arrival->location;
			$arrivalInboundLocationDescription = $this->translateAirports($flight->inboundRoutes[0]->segments[count($flight->inboundRoutes[0]->segments)-1]->arrival->locationDescription);
				
			$itinerariesBox['inboundLocations'] = array(
					"departure" => $this->buildLocation($departureInboundLocationCode, $departureInboundLocationDescription),
					"arrival" => $this->buildLocation($arrivalInboundLocationCode, $arrivalInboundLocationDescription));
		} else {
			$itinerariesBox['inboundLocations'] = array();
		}

		// outboundRoutes
		$itinerariesBox['outboundRoutes'] = $this->buildRoutes($flight->outboundRoutes);
		$itinerariesBox['inboundRoutes'] = $this->buildRoutes($flight->inboundRoutes);
		
		// seatsRemaining, category, inboundHiddenRouteCount, outboundHiddenRouteCount, commercialPolicyDescription
		
		$itinerariesBox['matchingInfoMap']  = $this->buildMatchingInfoMap($flight->itineraryInfos);
		
		$itinerariesBox['itinerariesBoxPriceInfoList'] = $this->buildPriceInfoList($flight->priceInfo, $currencyCode);
		
		return $itinerariesBox;
	}
	
	// publica porque se reutiliza en la busqueda manual
	public function buildPriceInfoList($priceInfo, $currencyCode) {
		$priceInfoList = array();
		$priceInfoItem = array();

		// ignorados: baseFare, *.rawObject
		
		$priceInfoItem['currencyCode'] = $currencyCode;
		
		$passengersCount = $priceInfo->adults->quantity + 
			($priceInfo->children !== NULL ? $priceInfo->children->quantity : 0) +
			($priceInfo->infants !== NULL ? $priceInfo->infants->quantity : 0);
		if ($priceInfo->total->charges == 0) {
			$priceInfo->total->charges = 1;
		}
		
		$priceInfoItem['total'] = array(
			'fare' => $this->buildFormattedPrice($priceInfo->total->fare, $currencyCode),
			'taxes' => $this->buildFormattedPrice($priceInfo->total->taxes, $currencyCode),
			'charges' => $this->buildFormattedPrice($priceInfo->total->charges, $currencyCode));
		
		$priceInfoItem['adult'] = array(
			'quantity' => $priceInfo->adults->quantity,
			'baseFare' => $this->buildFormattedPrice($priceInfo->adults->baseFare, $currencyCode),
			'taxes' => $this->buildFormattedPrice($priceInfo->total->taxes, $currencyCode),
			'charges' => $this->buildFormattedPrice(intval($priceInfo->total->charges / $passengersCount), $currencyCode),
			'totalFare' => $this->buildFormattedPrice($priceInfo->adults->baseFare * $priceInfo->adults->quantity, $currencyCode));
		
		$priceInfoItem['child'] = null;
		if ($priceInfo->children !== NULL) {
			$priceInfoItem['child'] = array(
				'quantity' => $priceInfo->children->quantity,
				'baseFare' => $this->buildFormattedPrice($priceInfo->children->baseFare, $currencyCode),
				'totalFare' => $this->buildFormattedPrice($priceInfo->children->baseFare * $priceInfo->children->quantity, $currencyCode));
		} 
		
		$priceInfoItem['infant'] = null;
		if ($priceInfo->infants !== NULL) {
			$priceInfoItem['infant'] = array(
					'quantity' => $priceInfo->infants->quantity,
					'baseFare' => $this->buildFormattedPrice($priceInfo->infants->baseFare, $currencyCode),
					'totalFare' => $this->buildFormattedPrice($priceInfo->infants->baseFare * $priceInfo->infants->quantity, $currencyCode));
		}
		
		$priceInfoList[] = $priceInfoItem;
		
		return $priceInfoList;
	}
	
	private function buildFormattedPrice($price, $currency) {
		$formattedPrice = array();
		
		$formattedPrice['raw'] = $price;
		$formattedPrice['formatted'] = array('code' => $currency, 'amount' => $price, 'mask' => $currency);
		
		return $formattedPrice;
	}
	
	private function buildMatchingInfoMap($itineraryInfos) {
		$matchingInfoMap = array();
		
		foreach ($itineraryInfos as $itineraryInfo) {
			$key = '_' . $itineraryInfo->outboundRouteIndex . '_' . $itineraryInfo->inboundRouteIndex;
			
			// ignorados: commercialPolicyDescription, frequentFlyerInfo
			$matchingInfoMap[$key] = array(
				'sequenceNumber' => 0,
				//'id' => $itineraryInfo->id,
				'id' => $itineraryInfo->itineraryId,
				'validatingCarrier' => $itineraryInfo->validatingCarrier,
				'commercialPolicyDescription' => $itineraryInfo->commercialPolicyDescription, 
				'wishList' => $itineraryInfo->wishlistId);
		}
		
		return $matchingInfoMap;
	}
	
	private function buildRoutes($routes) {
		$transformedRoutes = array();
		
		foreach ($routes as $route) {
			$transformedRoute = array();

			// props ignoradas: "delayInfos": null, "delaySeverity": null, baggageFeesAirlineCode
			
			$transformedRoute['type'] = 'AIR';
			$transformedRoute['hidden'] = false;
			$transformedRoute['cityAirportChange'] = $route->hasAirportChange;
			$transformedRoute['stopCount'] = count($route->segments) - 1;
			
			$durationParts = preg_split("/:/" ,$route->duration);
			$transformedRoute['totalDuration'] = array('formatted' => $durationParts[0] . 'h ' . $durationParts[1] . 'm') ; 
			
			$transformedRoute['segments'] = $this->buildSegments($route->segments); 
			
			//   'economyRoute'
			$transformedRoute['airlines'] = $this->buildAirlines($route->segments); 
			
			$datetime = $this->getTimeZoneDateTime($route->segments[0]->departure->date, $route->segments[0]->departure->timezone);
			$transformedRoute['departureDateTime'] =  array(
	 				'raw' => $datetime->getTimestamp() * 1000, 
	 				'formatted' => array('date' => $datetime->format('l d F Y'), 'time' => $datetime->format('H:i')),
	 				'rawObject' => $datetime->getTimestamp() * 1000);
	
			$datetime = $this->getTimeZoneDateTime($route->segments[count($route->segments) - 1]->arrival->date, $route->segments[count($route->segments) - 1]->arrival->timezone);
			$transformedRoute['arrivalDateTime'] =  array(
					'raw' => $datetime->getTimestamp() * 1000,
					'formatted' => array('date' => $datetime->format('l d F Y'), 'time' => $datetime->format('H:i')),
					'rawObject' => $datetime->getTimestamp() * 1000);
			
			$transformedRoutes[] = $transformedRoute;
		}
		
		return $transformedRoutes;
		
	}
	
	private function buildAirlines($segments) {
		$airlines = array();
		$airlinesMap = array();
		
		foreach ($segments as $segment) {
			$airlinesMap[$segment->marketingCarrierCode] = $segment->marketingCarrierDescription;
		}
		
		foreach ($airlinesMap as $code => $description) {
			$airline = array('code' => $code, 'description' => $description);
			$airlines[] = $airline;
		}
		
		return $airlines;
	}
	
	private function buildSegments($segments) {
		$transformedSegments = array();
		$transformedSegment = array();
		
		for ($i = 0; $i < count($segments); $i++) {
			$segment = $segments[$i];
			
			// ignorados" "nightFlight": true
			
			$transformedSegment['sequenceNumber'] = $i + 1;
			$transformedSegment['flightNumber'] = $segment->flightNumber;
			$transformedSegment['cabinTypeDescription'] = $this->translateCabinType($segment->marketingCabinTypeDescription);
			$transformedSegment['tueketingCabinType'] = $segment->marketingCabinTypeCode;
			$transformedSegment['bookingClass'] = $segment->bookingClass;
			
			$transformedSegment['operatingCarrier'] = array('code' => $segment->operatingCarrierCode, 'description' => $segment->operatingCarrierDescription);
			$transformedSegment['carrier'] = array('code' => $segment->marketingCarrierCode, 'description' => $segment->marketingCarrierDescription) ;
			
			$transformedSegment['departure'] = $this->buildDeprival($segment->departure);
			$transformedSegment['arrival'] = $this->buildDeprival($segment->arrival);
			
			if ($i > 0) {
				$lastArrivalDate = $this->getTimeZoneDateTime($segments[$i-1]->arrival->date, $segments[$i-1]->arrival->timezone);
				$currentDepartureDate = $this->getTimeZoneDateTime($segments[$i]->departure->date, $segments[$i]->departure->timezone);
				$waitDuration = $currentDepartureDate->diff($lastArrivalDate);
				
				$transformedSegment['waitDuration'] = array('formatted' => $waitDuration->format('%hh %im'));
			}
			
			// stopovers
			// aircraftModel
			
			$transformedSegments[] = $transformedSegment;
		}
		
		return $transformedSegments;
	}
	
	private function buildDeprival($deprival) {
		$transformedDeprival = array();
		
		$transformedDeprival['location'] = $this->buildLocation($deprival->location, $this->translateAirports($deprival->locationDescription));
		
		// 	"date": "2014-04-17T23:05:00", "timezone": -3,
		$datetime = $this->getTimeZoneDateTime($deprival->date, $deprival->timezone);
		  
 		$transformedDeprival['date'] = array(
 				'raw' => $datetime->getTimestamp() * 1000, 
 				'formatted' => $datetime->format('D d M'),
 				'rawObject' => $datetime->getTimestamp() * 1000);
 		$transformedDeprival['hour'] = array(
 				'raw' => $datetime->getTimestamp() * 1000,
 				'formatted' => $datetime->format('H:i'),
 				'rawObject' => $datetime->getTimestamp() * 1000);
		
		return $transformedDeprival;
	}
	
	private function buildLocation($airportCode, $airportDescription) {
		$location = array("code" => $airportCode);
		$location['airport'] = array("code" => $airportCode, "description" => $airportDescription);
		
		$airport = $this->container->get('airport_manager')->getByCode($airportCode);
		
		$city = $this->container->get('city_manager')->getByCode($airport['parentCity']);
		
		$location['city'] = array("code" => $city['id'], "description" => $city['name']);;
		
		return $location;
	}
	
	private function getStatus() {
		return array("code" => "SUCCEEDED", "message" => null);
	}
	
	private function getTimeZoneDateTime($stringDate, $timezone) { 
		if (strpos($timezone, '.') > 0) {
			$tzParts = preg_split('/\./', $timezone);
			$mins = ceil( 60 * ('0.'.$tzParts[1]));
			
			$tempTime = \DateTime::createFromFormat('H i', abs($tzParts[0]) . ' ' . $mins);
		} else {
			$tempTime = \DateTime::createFromFormat('H', abs($timezone));		
		}
		$stringTimezone = ($timezone<0 ? '-' : '+') . $tempTime->format('H:i');
		
	    $datetime = \DateTime::createFromFormat(\DateTime::ISO8601, $stringDate.$stringTimezone);
	 
	    return $datetime; 
	}  
	
	private function translateAirports($text) {
		if (strpos($text, 'Aeropuerto Internacional') !== false) {
			$text = preg_replace('/Aeropuerto Internacional (.*)/', '\1 International Airport', $text);
		} else {
			$text = preg_replace('/Aeropuerto (.*)/', '\1 Airport', $text);
		}
	
		return $text;
	}
	
	private function translateCabinType($text) {
		$spanishCabinTypes = array('/Clase Económica/', '/Económica/', '/Clase Executive\/Business/');
		$englishCabinTypes = array('Economy class', 'Economy class', 'Executive/Business class');
	
		$text = preg_replace($spanishCabinTypes, $englishCabinTypes, $text);
		
		return $text;
	}
	
}
