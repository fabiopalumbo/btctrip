<?php

namespace BtcTrip\HotelsBundle\Transformer;

/**
 * Aplica las transformaciones propias de la presentacion como ser el formateo de los precios  y fechas.
 * 
 * @author asobrado
 *
 */
class AvailabilityResultTransformer {
	private $container;
	private $currencyPrecision = array('BTC' => 4, 'XDG' => 0, 'LTC' => 2);
	
	public function __construct($container) {
		$this->container = $container;
	}
	
	public function transform($result, $currentPage, $searchParameters) {
		$transformation = $this->buildBase();
		
		$transformation['result']['data']['items'] = $this->buildItems($result);
		$transformation['result']['data']['status'] = $this->getStatus();
		$transformation['result']['data']['metadata'] = $this->buildMetadata($result, $searchParameters);
		$transformation['result']['data']['paginationSummary'] = $this->buildPaginationSummary($result, $currentPage);
		$transformation['result']['data']['facets'] = $this->buildMetaFacets($result);
		//$transformation['result']['data']['refinementSummary'] = $this->buildRefinementSummary($result); 
		
		return json_decode(json_encode($transformation));
	}

        private function buildMetaFacets($result){
            $facets = array();
            foreach ($result->meta->facets as $facet) {
			$facets[] = $facet;
		}
		
		return $facets;
            
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
		//$pagsum['pageCount'] = $result->meta->pageCount;
		$pagsum['currentPage'] = $currentPage;
		
		return $pagsum;
	}
	
	private function buildMetadata($result, $searchParameters) {
		$metadata = array();
		
		$metadata['status'] = $this->getStatus();
		// ignorados: fareSelectorType, providers, hasFrequenFlyerInfo, currencyRates
		$metadata['currencyCode'] = $result->meta->currencyCode;
		return $metadata;
	}
	
	
	
	private function buildItems($result) {
		$items = array();
		foreach ($result->availability as $hotel) {
			$item['id'] = $hotel->id;
			$item['availability'] = $this->buildAvailability($hotel, $result->meta->currencyCode); 
            $items[] = $item;
		}
		
		return $items;
	}
	
	private function buildAvailability($hotel, $currencyCode) {
		
                
		$availability['id'] = 0;
		$availability['hotel'] = $hotel;
		
		$avgDiscountPriceWithoutTax = $hotel->avgDiscountPriceWithoutTax;
		$avgPriceWithoutTax = $hotel->avgPriceWithoutTax;
		$unformattedAvgDiscountPriceDiscount = str_replace(',', '', $avgDiscountPriceWithoutTax);
		$unformattedAvgDiscountPrice = str_replace(',', '', $avgPriceWithoutTax);

		$exchangeRateService = $this->container->get('exchange_rate');
		$xchgRates = $exchangeRateService->getLastExchangeRatesCurrencyIndexed();
		
		$cryptoPrices = array();
		
		foreach ($xchgRates as $currency => $rate) {
			$cryptoPrice['avgDiscountPriceWithoutTax'] = round($unformattedAvgDiscountPriceDiscount / $rate, $this->currencyPrecision[$currency]);
			$cryptoPrice['avgPriceWithoutTax'] = round($unformattedAvgDiscountPrice / $rate, $this->currencyPrecision[$currency]);
			$cryptoPrice['currency'] = $currency;
			
			$cryptoPrices[] = $cryptoPrice; 
		}
		
		$availability['cryptoPrices'] = $cryptoPrices;
		
		return $availability;
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
				'id' => $itineraryInfo->id,
				'validatingCarrier' => $itineraryInfo->validatingCarrier,
				'commercialPolicyDescription' => $itineraryInfo->commercialPolicyDescription, 
				'wishList' => $itineraryInfo->wishlistId);
		}
		
		return $matchingInfoMap;
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
	
	public function transformPriceHotel($room_first) {
		$transformation['result']['data']['hotel']['id'] = $room_first->id;
		$transformation['result']['data']['hotel']['descripcion'] = $room_first->roomsDetail[0]->description;
		$transformation['result']['data']['hotel']['averagePricesPerNight']['avgPrice']['usd'] = $room_first->prices->averagePricesPerNight->avgPrice->priceWithoutTax;
		$transformation['result']['data']['hotel']['averagePricesPerNight']['avgDiscountPrice']['usd'] = $room_first->prices->averagePricesPerNight->avgDiscountPrice->priceWithoutTax;
		$transformation['result']['data']['hotel']['soldOut'] = $room_first->roomsDetail[0]->soldOut;

		$exchangeRateService = $this->container->get('exchange_rate');
		$xchgRates = $exchangeRateService->getLastExchangeRatesCurrencyIndexed();
		
		$unformattedAvgPrice = str_replace(',', '', $room_first->prices->averagePricesPerNight->avgPrice->priceWithoutTax);
		$unformattedAvgDiscountPrice = str_replace(',', '', $room_first->prices->averagePricesPerNight->avgDiscountPrice->priceWithoutTax);
		              
		foreach ($xchgRates as $currency => $rate) {
			$transformation['result']['data']['hotel']['averagePricesPerNight']['avgPrice'][strtolower($currency)] = round($unformattedAvgPrice / $rate, $this->currencyPrecision[$currency]);
			$transformation['result']['data']['hotel']['averagePricesPerNight']['avgDiscountPrice'][strtolower($currency)] = round($unformattedAvgDiscountPrice / $rate, $this->currencyPrecision[$currency]);
		}       
		
		return json_decode(json_encode($transformation));
	}

	
	public function transformRoomPriceHotel($rooms) {
		$indice=0;
		$items = array();
		foreach ($rooms as $r){
			$room=array();           
			$room['id'] = $r->id;
			$room['description'] =$r->description;
			$room['typeCode'] = $r->roomsDetail[0]->typeCode;
			$room['pictures'] = (isset($r->roomsDetail[0]->pictures)? $r->roomsDetail[0]->pictures : '');
			$room['discountText'] = $r->discountText;
			$room['regimeDescription']= $r->regimeDescription;
			$room['availableRooms']=(isset($r->roomsDetail[0]->availableRooms)? $r->roomsDetail[0]->availableRooms :"");
			$room['refundable']=$r->penalty->refundable;
			
			$room['prices']['averagePricesPerNight']['avgPrice']['usd'] = $r->prices->averagePricesPerNight->avgPrice->priceWithoutTax;
			$room['prices']['averagePricesPerNight']['avgDiscountPrice']['usd'] = $r->prices->averagePricesPerNight->avgDiscountPrice->priceWithoutTax;

			$exchangeRateService = $this->container->get('exchange_rate');
			$xchgRates = $exchangeRateService->getLastExchangeRatesCurrencyIndexed();
			
			$unformattedAvgPrice = str_replace(',', '', $r->prices->averagePricesPerNight->avgPrice->priceWithoutTax);
			$unformattedAvgDiscountPrice = str_replace(',', '', $r->prices->averagePricesPerNight->avgDiscountPrice->priceWithoutTax);
			
			foreach ($xchgRates as $currency => $rate) {
				$room['prices']['averagePricesPerNight']['avgPrice'][strtolower($currency)] = round($unformattedAvgPrice / $rate, $this->currencyPrecision[$currency]);
				$room['prices']['averagePricesPerNight']['avgDiscountPrice'][strtolower($currency)] = round($unformattedAvgDiscountPrice / $rate, $this->currencyPrecision[$currency]);
			}

			$room['soldOut'] = $r->roomsDetail[0]->soldOut;
			$room['amenities'] = isset($r->roomsDetail[0]->amenities) ? $r->roomsDetail[0]->amenities : "";

			$transformation['result']['data']['room'][] = $room;
		}
		
		return json_decode(json_encode($transformation));
	}
	
}