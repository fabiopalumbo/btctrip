<?php
namespace BtcTrip\APIBtcTripBundle\Classes;
use \BtcTrip\APIBtcTripBundle\Classes\TravelportCurl as TravelportCurl;

//use \BtcTrip\FlightBundle\DocumentManager\CityManager as CityManager;
//use \BtcTrip\APIBtcTripBundle\Classes\DespegarApiResponse as DespegarApiResponse;


class TravelportApi extends BaseBookingApi {
  
    protected $apiUrl = 'http://consolid.webtravelcaster.com/api/1.1/';
    protected $apiUsername = 'btctrip';
    protected $apiPassword = 'u7N6gpP3';

    private $activeToken = false;
    //protected $activeToken = '2fd5870242e5fa62';

    // passenger classes identifiers for travelport api.
    protected $passengerClasses = array(
        'ADT' => 'adults',
        'CH' => 'childrens',
        'IN' => 'infants',
    );

    // comision sumada a cada pasajero en USD.
    protected $comissionPerPassenger = 10;

    // service charge de travelport
    protected $segmentServiceCharge = 10;

    /**
     * horrible hacks for city and airport manager.
     */
    protected $cityManager = false;
    public function setCityManager($manager) {
        $this->cityManager = $manager;
    }
    protected $airportManager = false;
    public function setAirportManager($manager) {
        $this->airportManager = $manager;
    }

    protected $exchangeRates = false;
    public function setExchangeRates($rates) {
        $this->exchangeRates = $rates;
    }

    /**
     * gets the active connection token to access api calls
     */
    private function getConnectionToken() {
        $memcached = new \Memcached();
        $memcached->addServer('localhost', 11211);

        $cache = new \Doctrine\Common\Cache\MemcachedCache();
        $cache->setMemcached($memcached);
        $this->activeToken = $cache->fetch("travelportApiToken");

        if($this->activeToken) {
            return $this->activeToken;
        } else {
            $this->activeToken = $this->requestConnectionToken();
            $cache->save("travelportApiToken", $this->activeToken, 3600);
            return $this->activeToken;
        }
    }

    /**
     * requests a token from travelport to access the api calls.
     */
    private function requestConnectionToken() {
        $parameters = array(
            'username' => $this->apiUsername,
            'password' => $this->apiPassword,
        );

        $response = $this->call('FlightService.json/GetAccessToken', $parameters);
        if($response) {
            return $response;
        }
    }

    protected function call($apiOperation, $parameters = false, $httpMethod = 'GET', $httpHeaders = false) {
        $callUrl = $this->apiUrl . $apiOperation;

        if($parameters) {
            $urlParams = http_build_query($parameters);
        }

        if($httpMethod == 'GET') {
            if($parameters) {
                $urlParams = http_build_query($parameters);
                $callUrl .= '?' . $urlParams;
            }
        }

        $curlHandler = curl_init($callUrl);
        curl_setopt($curlHandler, CURLOPT_CUSTOMREQUEST, $httpMethod);                                                                     

        if($httpMethod == 'POST') {
            if($parameters) {
                $urlParams = http_build_query($parameters);
                curl_setopt($curlHandler, CURLOPT_URL, $callUrl);
                curl_setopt($curlHandler, CURLOPT_POST, count($parameters));
                curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $urlParams);
            }
        }

        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, TRUE);
        if($httpHeaders) {
            curl_setopt($curlHandler, CURLOPT_HTTPHEADER, $httpHeaders);
        }

        $response = curl_exec($curlHandler); 
        if(!$response) {
            return false;
            //return "ERROR: " . curl_error($curlHandler);
        }

        curl_close($curlHandler);

        $response = json_decode($response);

        return $response;
    }

    public function availabilityFlights($type, $from, $to, $departureDate, $returnDate, $adults, $childrens, $infants,
        $orderBy, $orderDir, $departureTime, $returningTime, $classFlight, $scaleFlight, $airlineFlight, $filterParams) {

        $token = $this->getConnectionToken();

        // passengers
        $passengersArray = array();
        foreach($this->passengerClasses as $travelportId => $class) {
            if(!empty($$class)) {
                array_push($passengersArray, array(
                    'Type' => $travelportId,
                    'SubType' => 'NA',
                    'Count' => $$class,
                    'Age' => 0,
                ));
            }
        }

        $legs = array();

        array_push($legs, array(
            'DepartureAirportCity' => $from,
            'ArrivalAirportCity' => $to,
            'FlightDate' => $departureDate,
        ));

        if($type == 'roundtrip') {
            array_push($legs, array(
                'DepartureAirportCity' => $to,
                'ArrivalAirportCity' => $from,
                'FlightDate' => $returnDate,
            ));
        }

        $searchParams = array(
            'Token' => $token,
            'Legs' => $legs,
            'Passengers' => $passengersArray,
/*
            'Airlines' => array(
		'AA'
            ),
*/
        );

        if(!empty($classFlight)) {
            $searchParams['CabinClasses'] = array(
                'F','A','P','X','Z','J','D','I','R','C','U',
            );
        }

        $params = array(
            'query' => json_encode($searchParams)
        );
        $response = $this->call('FlightService.json/GetFlightAvailability', $params);

        // stops filter.
        $maxStops = false;
        if(!empty($filterParams['stops'])) {
            if(strstr($filterParams['stops'], 'NONE') || strstr($scaleFlight, 'NONE')) {
                $maxStops = 1;
            }
            if(strstr($filterParams['stops'], ',ONE') || strstr($scaleFlight, 'NONE')) {
                $maxStops = 2;
            }
            if(strstr($filterParams['stops'], 'MORE_THAN_ONE') || strstr($scaleFlight, 'NONE')) {
                $maxStops = false;
            }
        }

        // departure time
        $minTimeOutbound = false;
        $maxTimeOutbound = false;
        if(!empty($filterParams['timeoutbound'])) {
            if(strstr($filterParams['timeoutbound'], 'EARLY_MORNING')) {
                $minTimeOutbound = 0;
                $maxTimeOutbound = 6;
            }

            if(strstr($filterParams['timeoutbound'], 'MORNING')) {
                if($minTimeOutbound === false) {
                    $minTimeOutbound = 6;
                }
                $maxTimeOutbound = 6;
            }
            if(strstr($filterParams['timeoutbound'], 'AFTERNOON')) {
                if($minTimeOutbound === false) {
                    $minTimeOutbound = 12;
                }
                $maxTimeOutbound = 20;
            }
            if(strstr($filterParams['timeoutbound'], 'NIGHT')) {
                if($minTimeOutbound === false) {
                    $minTimeOutbound = 20;
                }
                $maxTimeOutbound = 24;
            }
        }

        // return time
        $minTimeInbound = false;
        $maxTimeInbound = false;
        if(!empty($filterParams['timeinbound'])) {
            if(strstr($filterParams['timeinbound'], 'EARLY_MORNING')) {
                $minTimeInbound = 0;
                $maxTimeInbound = 6;
            }

            if(strstr($filterParams['timeinbound'], 'MORNING')) {
                if($minTimeInbound === false) {
                    $minTimeInbound = 6;
                }
                $maxTimeInbound = 6;
            }
            if(strstr($filterParams['timeinbound'], 'AFTERNOON')) {
                if($minTimeInbound === false) {
                    $minTimeInbound = 12;
                }
                $maxTimeInbound = 20;
            }
            if(strstr($filterParams['timeinbound'], 'NIGHT')) {
                if($minTimeInbound === false) {
                    $minTimeInbound = 20;
                }
                $maxTimeInbound = 24;
            }
        }

        // apply filters
        foreach($response->Fares as $key => $fare) {
            // stops filter
            if($maxStops) {
                $oStops = count($fare->Legs[0]->Options[0]->Segments);
                $iStops = count($fare->Legs[1]->Options[0]->Segments);
                if($oStops > $maxStops || $iStops > $maxStops) {
                    unset($response->Fares[$key]);
                }
            }
        }

        $flights = $this->adaptToDespegarAvailabilityItems($response);

        return $flights;
    }

    protected function formatCrypto($amount, $cryptoCode) {
        // copy&paste de yamil.
        if ($cryptoCode == 'BTC') {
            return number_format($amount, 2, '.', '');
        } else if ($cryptoCode == 'XDG') {
            return number_format($amount, 0, '.', ',');
        } else if ($cryptoCode == 'LTC') {
            return number_format($amount, 2, '.', ',');
        } else {
            return number_format($amount, 0, '.', ',');
        }
    }

    protected function getClassDescription($class) {
        switch($class) {
            case 'F':
            case 'A':
            case 'P':
            case 'X':
            case 'Z':
                $class = 'First Class';
                break;
            case 'J':
            case 'D':
            case 'I':
            case 'R':
            case 'C':
            case 'U':
                $class = 'Business Class';
                break;
            default:
                $class = 'Economy Class';
                break;
        }
        return $class;
    }

    private function adaptToDespegarAvailabilityItems($tpResponse) {
        $items = array();
        foreach($tpResponse->Fares as $fare) {
            $item = array();

            // TODO: fix this.
            $item['id'] = 'XXXXXXXXXXXXXXXXXX';

	    // segment count needed for pricing
	    $segmentCount = 0;
            foreach($fare->Legs as $leg) {
		$segmentCount += count($leg->Options[0]->Segments);
	    }

            foreach($fare->Legs as $leg) {
                if($leg->LegNumber == 1) {
                    $in_or_out = 'outbound';
                } else {
                    $in_or_out = 'inbound';
                }

                foreach($leg->Options as $legOption) {
                    /* option->segment : route->segment*/
                    $optionSegments = array();
                    $optionAirlines = array();

                    foreach($legOption->Segments as $key => $segment) {
                        $airline = array(
                            'code' => $segment->Airline,
                            // TODO: fix htis.
                            'description' => $this->getAirlineName($segment->Airline),
                            //'description' => 'American Airlines',
                        );
                        if(!in_array($airline, $optionAirlines)) {
                            $optionAirlines[] = $airline;
                        }

                        $depDateTime = strtotime("{$segment->Departure->Date} {$segment->Departure->Time}");
                        $arrivalDateTime = strtotime("{$segment->Arrival->Date} {$segment->Arrival->Time}");

                        $optionSegments[] = array(
                            'sequenceNumber' => $segment->SegmentNumber,
                            'flightNumber' => $segment->FlightNumber,
                            'bookingClass' => $segment->BookingClass,
                            'operatingCarrier' => array(
                                    'code' => $segment->Airline,
                                    // TODO: fix this.
                                    //'description' => $segment->Airline,
				    'description' => $this->getAirlineName($segment->Airline),
                                    //'description' => 'American Airlines',
                            ),
                            'carrier' => array(
                                    'code' => $segment->Airline,
                                    // TODO: fix this.
                                    //'description' => $segment->Airline,
				    'description' => $this->getAirlineName($segment->Airline),
                                    //'description' => 'American Airlines',
                            ),
                            'departure' => array(
                                'dateTime' => $depDateTime,
                                'location' => array(
                                    'code' => $segment->Departure->AirportCode,
                                    'airport' => array(
                                        'code' => $segment->Departure->AirportCode,
                                        'description' => $this->getAirportNameByCode($segment->Departure->AirportCode),
                                    ),
                                    'city' => array(
                                        'code' => $this->getAirportCityByCode($segment->Departure->AirportCode),
                                        'description' => $this->getCityNameByCode($this->getAirportCityByCode($segment->Departure->AirportCode)),
                                    ),
                                ),
                                'date' => array(
                                    'raw' => $depDateTime * 1000,
                                    'formatted' => date("D d F", $depDateTime),
                                    'rawObject' => $depDateTime * 1000,
                                ),
                                'hour' => array(
                                    'raw' => $depDateTime * 1000,
                                    'formatted' => date("H:i", $depDateTime),
                                    'rawObject' => $depDateTime * 1000,
                                ),
                            ),
                            'arrival' => array(
                                'dateTime' => $arrivalDateTime,
                                'location' => array(
                                    'code' => $segment->Arrival->AirportCode,
                                    'airport' => array(
                                        'code' => $segment->Arrival->AirportCode,
                                        'description' => $this->getAirportNameByCode($segment->Arrival->AirportCode),
                                    ),
                                    'city' => array(
                                        'code' => $this->getAirportCityByCode($segment->Arrival->AirportCode),
                                        'description' => $this->getCityNameByCode($this->getAirportCityByCode($segment->Arrival->AirportCode)),
                                    ),
                                ),
                                'date' => array(
                                    'raw' => $arrivalDateTime * 1000,
                                    'formatted' => date("D d F", $arrivalDateTime),
                                    'rawObject' => $arrivalDateTime * 1000,
                                ),
                                'hour' => array(
                                    'raw' => $arrivalDateTime * 1000,
                                    'formatted' => date("H:i", $arrivalDateTime),
                                    'rawObject' => $arrivalDateTime * 1000,
                                ),
                            ),
                            // TODO: fix everything below this.
                            'cabinTypeDescription' => $this->getClassDescription($segment->BookingClass),
                            'tueketingCabinType' => '',
                        );

                        // TODO: fix this. theres a problem with timezones and wait duration. if you go from one timezone
                        // to another you get a wrong wait duration.
                        if($segment->SegmentNumber > 1) {
                            $prevFlightArrivalDate = strtotime("{$legOption->Segments[$key]->Arrival->Date} {$legOption->Segments[$key]->Arrival->Time}");
                            $waitDuration = $depDateTime - $prevFlightArrivalDate;

                            $waitDuration = date('H', $waitDuration) . 'h ' . date('i', $waitDuration) . 'm';

                            $optionSegments[count($optionSegments)-1]['waitDuration'] = array(
                                'formatted' => $waitDuration,
                            );
                        }
                    }

                    $hours = floor($legOption->OptionDuration / 60);
                    $minutes = $legOption->OptionDuration - ($hours * 60);
                    $totalDuration = "{$hours}h {$minutes}m";

                    /* option : route */
                    $item['itinerariesBox'][$in_or_out . 'Routes'][] = array(
                        'type' => 'AIR',
                        'hidden' => false,
                        // TODO: fix this
                        'cityAirportChange' => false,
                        // END FIX THIS
                        'stopCount' => count($optionSegments) - 1,
                        'segments' => $optionSegments,
                        'totalDuration' => array(
                            'formatted' => $totalDuration,
                        ),
                        'airlines' => $optionAirlines,
                        'departureDateTime' => array(
                            'raw' => $optionSegments[0]['departure']['dateTime'] * 1000,
                            'formatted' => array(
                                'date' => date("l d F Y", $optionSegments[0]['departure']['dateTime']),
                                'time' => $optionSegments[0]['departure']['hour']['formatted'],
                            ),
                            'rawObject' => $optionSegments[0]['departure']['dateTime'] * 1000,
                        ),
                        'arrivalDateTime' => array(
                            'raw' => $optionSegments[0]['arrival']['dateTime'] * 1000,
                            'formatted' => array(
                                'date' => date("l d F Y", $optionSegments[0]['arrival']['dateTime']),
                                'time' => $optionSegments[0]['arrival']['hour']['formatted'],
                            ),
                            'rawObject' => $optionSegments[0]['arrival']['dateTime'] * 1000,
                        ),
                        // internal field, needed to confirm availability with travelport.
                        'optionId' => $legOption->FlightOptionID,
                    );
                }

                /* option -> location */
                $depAirportCode = $legOption->Segments[0]->Departure->AirportCode;
                $depAirportDescription = $this->getAirportNameByCode($legOption->Segments[0]->Departure->AirportCode);
                $depCityCode = $this->getAirportCityByCode($legOption->Segments[0]->Departure->AirportCode);
                $depCityDescription = $this->getCityNameByCode($this->getAirportCityByCode($legOption->Segments[0]->Departure->AirportCode));

                $arrivalAirportCode = $legOption->Segments[count($legOption->Segments)-1]->Arrival->AirportCode;
                $arrivalAirportDescription = $this->getAirportNameByCode($legOption->Segments[count($legOption->Segments)-1]->Arrival->AirportCode);
                $arrivalCityCode = $this->getAirportCityByCode($legOption->Segments[count($legOption->Segments)-1]->Arrival->AirportCode);
                $arrivalCityDescription = $this->getCityNameByCode($this->getAirportCityByCode($legOption->Segments[count($legOption->Segments)-1]->Arrival->AirportCode));

                $item['itinerariesBox'][$in_or_out . 'Locations'] = array(
                    'departure' => array(
                        'code' => $depAirportCode,
                        'airport' => array(
                            'code' => $depAirportCode,
                            'description' => $depAirportDescription,
                        ),
                        'city' => array(
                            'code' => $depCityCode,
                            'description' => $depCityDescription,
                        ),
                    ),
                    'arrival' => array(
                        'code' => $arrivalAirportCode,
                        'airport' => array(
                            'code' => $arrivalAirportCode,
                            'description' => $arrivalAirportDescription,
                        ),
                        'city' => array(
                            'code' => $arrivalCityCode,
                            'description' => $arrivalCityDescription,
                        ),
                    ),
                );
            }

            /**
             * itinerariesBoxPriceList (precios)
             */
            $coins = array('USD', 'BTC', 'XDG', 'LTC');
            foreach($coins as $key => $coin) {
                $item['itinerariesBox']['itinerariesBoxPriceInfoList'][$key] = array(
                    'currencyCode' => $coin,
                );

                // all prices originally in dollars.
                if($coin == 'USD') {
                    $exchangeRate = 1;
                } else {
                    $exchangeRate = 1 / $this->exchangeRates[$coin];
		
                }

                $passengerCount = 0;
                foreach($fare->PaxFares as $paxFare) {
                    $passengerCount += $paxFare->Count;

                    switch($paxFare->PaxType) {
                        case 'ADT':
                            $idx = 'adult';
                            break;
                        case 'IN':
                            $idx = 'infant';
                            break;
                        case 'CH':
                            $idx = 'child';
                            break;
                    }

                    $item['itinerariesBox']['itinerariesBoxPriceInfoList'][$key][$idx] = array(
                        'quantity' => $paxFare->Count,
                        'baseFare' => array(
                            'raw' => $paxFare->PaxFareAmount * $exchangeRate,
                            'formatted' => array(
                                'code' => $coin,
                                'amount' => $paxFare->PaxFareAmount * $exchangeRate,
                                'mask' => $coin,
                            )
                        ),
                        'totalFare' => array(
                            'raw' => $paxFare->PaxFareAmount * $exchangeRate * $paxFare->Count,
                            'formatted' => array(
                                'code' => $coin,
                                'amount' => $paxFare->PaxFareAmount * $exchangeRate * $paxFare->Count,
                                'mask' => $coin,
                            )
                        ),
                        // TODO: fix htis.
                        'total' => array(
                            'formatted' => array(
                                'amount' => $this->formatCrypto(((($paxFare->PaxFareAmount + $paxFare->PaxTaxAmount + $this->comissionPerPassenger) * $paxFare->Count) + ($this->segmentServiceCharge * $paxFare->Count * $segmentCount)) * $exchangeRate, $coin),
                            )
                        ),
                    );
                }

                /** adult only // yamil te odio. **/
                $item['itinerariesBox']['itinerariesBoxPriceInfoList'][$key]['adult']['taxes'] = array(
                    'raw' => $fare->TaxAmount * $exchangeRate,
                    'formatted' => array(
                        'code' => $coin,
                        'amount' => $fare->TaxAmount * $exchangeRate,
                        'mask' => $coin,
                    )
                );
                $item['itinerariesBox']['itinerariesBoxPriceInfoList'][$key]['adult']['charges'] = array(
                    'raw' => $fare->ServiceAmount / $passengerCount * $exchangeRate,
                    'formatted' => array(
                        'code' => $coin,
                        // TODO: fix this.
                        'amount' => $fare->ServiceAmount / $passengerCount * $exchangeRate,
                        'mask' => $coin,
                    )
                );

                $item['itinerariesBox']['itinerariesBoxPriceInfoList'][$key]['total'] = array(
                    'fare' => array(
                        'raw' => ($fare->FareAmount + $fare->TaxAmount) * $exchangeRate,
                        'formatted' => array(
                            'code' => $coin,
                            // NOTE: NO TOCAR. ESTA HECHO ASI EN EL CODIGO DE YAMIL DE JS
                            'amount' => $this->formatCrypto((($fare->FareAmount + $fare->TaxAmount + ceil($this->comissionPerPassenger * $passengerCount) + ($this->segmentServiceCharge * $passengerCount * $segmentCount))) * $exchangeRate, $coin),
                            'mask' => $coin,
                        )
                    ),
                    'taxes' => array(
                        'raw' => $fare->TaxAmount * $exchangeRate,
                        'formatted' => array(
                            'code' => $coin,
                            'amount' => $fare->TaxAmount * $exchangeRate,
                            'mask' => $coin,
                        )
                    ),
                    'charges' => array(
                        'raw' => $fare->ServiceAmount * $exchangeRate,
                        'formatted' => array(
                            'code' => $coin,
                            'amount' => $fare->ServiceAmount * $exchangeRate,
                            'mask' => $coin,
                        )
                    ),
                    // NOTE: NO TOCAR. ESTA HECHO ASI EN EL CODIGO DE YAMIL DE JS
                    'perPassenger' => array(
                        'raw' => $this->formatCrypto(($fare->FareAmount + $fare->TaxAmount + ($this->comissionPerPassenger * $passengerCount) + ($this->segmentServiceCharge * $passengerCount * $segmentCount)) * $exchangeRate / $passengerCount, $coin),
                        'formatted' => array(
                            'code' => $coin,
                            'amount' => $this->formatCrypto(($fare->FareAmount + $fare->TaxAmount + ($this->comissionPerPassenger * $passengerCount) + ($this->segmentServiceCharge * $passengerCount * $segmentCount)) * $exchangeRate / $passengerCount, $coin),
                            'mask' => $coin,
                        )
                    ),
                );
            }

            /* 
             * matchingInfoMap
             */
            foreach($item['itinerariesBox']['outboundRoutes'] as $oIdx => $outboundRoute) {
                if(empty($item['itinerariesBox']['inboundRoutes'])) {
                    $key = '_' . $oIdx . '_' . '-1';

                    $item['itinerariesBox']['matchingInfoMap'][$key] = array(
                    'sequenceNumber' => 0,
                    //'id' => $itineraryInfo->id,
                    // NOTE: esto es el ID de travelport que usa btctrip para los preorder y blabla.
                    'id' => $tpResponse->RecommendationID .'_'. $fare->FareID .'_'. $outboundRoute['optionId'] .'_'. '-1',
                    'validatingCarrier' => $fare->ValidatingCarrier,
                    // TODO: fix this. no commercialPolicyDescription found on travelport.
                    'commercialPolicyDescription' => '',
                    // TODO: fix this. no wishList found on travelport.
                    'wishList' => '',
                    );
                } else {
                    foreach($item['itinerariesBox']['inboundRoutes'] as $iIdx => $inboundRoute) {
                        $key = '_' . $oIdx . '_' . $iIdx;

                        $item['itinerariesBox']['matchingInfoMap'][$key] = array(
                        'sequenceNumber' => 0,
                        //'id' => $itineraryInfo->id,
                        // NOTE: esto es el ID de travelport que usa btctrip para los preorder y blabla.
                        'id' => $tpResponse->RecommendationID .'_'. $fare->FareID .'_'. $outboundRoute['optionId'] .'_'. $inboundRoute['optionId'],
                        'validatingCarrier' => $fare->ValidatingCarrier,
                        // TODO: fix this. no commercialPolicyDescription found on travelport.
                        'commercialPolicyDescription' => '',
                        // TODO: fix this. no wishList found on travelport.
                        'wishList' => '',
                        );
                    }
                }
            }

            $items[] = $item;
        }

        return $items;
    }

    public function getAirportNameByCode($code) {
        $airport = $this->airportManager->getByCode($code);
        return $airport['description'];
    }

    public function getAirportCityByCode($code) {
        $airport = $this->airportManager->getByCode($code);
        return $airport['parentCity'];
    }

    public function getCityNameByCode($code) {
        $city = $this->cityManager->getByCode($code);
        return $city['name'];
    }

    public function bookingFlightsFields($recommendationId, $fareId, $options) {
        $token = $this->getConnectionToken();

        $searchParams = array(
            'Token' => $token,
            'RecommendationID' => $recommendationId,
            'FareID' => $fareId,
            'OptionID' => $options,
        );

        $params = array(
            'confirmation' => json_encode($searchParams)
        );

        $fields = $this->call('FlightService.json/ConfirmFlightAvailability', $params);

        return $fields;
    }

    public function confirmFlightAvailability($recommendationId, $fareId, $options) {
        $params = array(
            'Token' => $this->getConnectionToken(),
            'RecommendationID' => $recommendationId,
            'FareID' => $fareId,
            'OptionID' => $options
        );

        $params = array(
            'confirmation' => json_encode($params)
        );

        $response = $this->call('FlightService.json/ConfirmFlightAvailability', $params);

        return $response;
    }

    public function bookFlight($params) {
        $params['Token'] = $this->getConnectionToken();

        $params = array(
            'booking' => json_encode($params)
        );
        $response = $this->call('FlightService.json/BookFlight', $params, 'POST');

        return $response;
    }

    // required
    public function getHotelsAvailability($city, $checkin='', $checkout='', $distribution = "1", $pagesize=0,$filtros=array()){}
    public function getHotelAvailability($id, $checkin='', $checkout='', $distribution = "1"){}
    public function bookHotel($parameters){}
    public function getHotelAmenities($hotel_id){}
    public function getHotelPointSofInterest($hotel_id,$type){}
    public function getHotelReviews($hotel_id,$cantidad_comentarios,$page){}
    public function getAmenities(){}

    protected $airlineList = array(
	"M3" => "ABSA Cargo Airline",
	"JP" => "Adria Airways",
	"A3" => "Aegean Airlines",
	"EI" => "Aer Lingus",
	"NG" => "Aero Contractors",
	"P5" => "Aero República",
	"SU" => "Aeroflot",
	"AR" => "Aerolineas Argentinas",
	"2K" => "Aerolineas Galapagos S.A. Aerogal",
	"AM" => "Aeromexico",
	"8U" => "Afriqiyah Airways",
	"ZI" => "Aigle Azur",
	"AH" => "Air Algérie",
	"G9" => "Air Arabia",
	"KC" => "Air Astana",
	"UU" => "Air Austral",
	"BT" => "Air Baltic",
	"AB" => "Air Berlin",
	"BP" => "Air Botswana",
	"SM" => "Air Cairo",
	"TY" => "Air Caledonie",
	"AC" => "Air Canada",
	"CA" => "Air China Limited",
	"XK" => "Air Corsica",
	"UX" => "Air Europa",
	"AF" => "Air France",
	"AI" => "Air India",
	"JS" => "Air Koryo",
	"NX" => "Air Macau",
	"MD" => "Air Madagascar",
	"KM" => "Air Malta",
	"MK" => "Air Mauritius",
	"9U" => "Air Moldova",
	"SW" => "Air Namibia",
	"NZ" => "Air New Zealand",
	"PX" => "Air Niugini",
	"YW" => "Air Nostrum",
	"JU" => "Air SERBIA a.d. Beograd",
	"HM" => "Air Seychelles",
	"VT" => "Air Tahiti",
	"TN" => "Air Tahiti Nui",
	"TS" => "Air Transat",
	"NF" => "Air Vanuatu",
	"RU" => "AirBridgeCargo Airlines",
	"SB" => "Aircalin",
	"4Z" => "Airlink",
	"AS" => "Alaska Airlines",
	"AZ" => "Alitalia",
	"NH" => "All Nippon Airways",
	"UJ" => "AlMasria Universal Airlines",
	"K4" => "ALS",
	"AA" => "American Airlines",
	"W3" => "Arik Air",
	"IZ" => "Arkia Israeli Airlines",
	"OZ" => "Asiana",
	"5Y" => "Atlas Air",
	"KK" => "Atlasjet Airlines",
	"AU" => "Austral",
	"OS" => "Austrian",
	"AV" => "AVIANCA",
	"O6" => "Avianca Brasil",
	"J2" => "Azerbaijan Airlines",
	"AD" => "Azul Brazilian Airlines",
	"JA" => "B&H Airlines",
	"UP" => "Bahamasair",
	"PG" => "Bangkok Air",
	"B2" => "Belavia - Belarusian Airlines",
	"8H" => "BH AIR",
	"BG" => "Biman",
	"NT" => "Binter Canarias",
	"BV" => "Blue Panorama",
	"KF" => "Blue1",
	"BM" => "bmi Regional",
	"OB" => "Boliviana de Aviación - BoA",
	"BA" => "British Airways",
	"SN" => "Brussels Airlines",
	"FB" => "Bulgaria air",
	"5C" => "C.A.L. Cargo Airlines",
	"W8" => "Cargojet Airways",
	"CV" => "Cargolux S.A.",
	"BW" => "Caribbean Airlines",
	"V3" => "Carpatair",
	"CX" => "Cathay Pacific",
	"CI" => "China Airlines",
	"CK" => "China Cargo Airlines",
	"MU" => "China Eastern",
	"CF" => "China Postal Airlines",
	"CZ" => "China Southern Airlines",
	"WX" => "CityJet",
	"MN" => "Comair",
	"DE" => "Condor",
	"CM" => "COPA Airlines",
	"XC" => "Corendon Airlines",
	"SS" => "Corsair International",
	"OU" => "Croatia Airlines",
	"CU" => "Cubana",
	"OK" => "Czech Airlines j.s.c",
	"DL" => "Delta Air Lines",
	"D0" => "DHL Air",
	"ES" => "DHL Aviation EEMEA B.S.C.(c)",
	"Z6" => "Dniproavia",
	"D9" => "Donavia",
	"KA" => "Dragonair",
	"MS" => "Egyptair",
	"LY" => "EL AL",
	"EK" => "Emirates",
	"OV" => "Estonian Air",
	"ET" => "Ethiopian Airlines",
	"EY" => "Etihad Airways",
	"YU" => "Euroatlantic Airways",
	"QY" => "European Air Transport",
	"EW" => "Eurowings",
	"BR" => "EVA Air",
	"FX" => "Federal Express",
	"FJ" => "Fiji Airways",
	"AY" => "Finnair",
	"BE" => "flybe",
	"FH" => "Freebird Airlines",
	"GA" => "Garuda",
	"A9" => "Georgian Airways",
	"ST" => "Germania",
	"GF" => "Gulf Air",
	"HR" => "Hahn Air",
	"HU" => "Hainan Airlines",
	"HA" => "Hawaiian Airlines",
	"5K" => "Hi Fly",
	"HX" => "Hong Kong Airlines",
	"UO" => "Hong Kong Express Airways",
	"IB" => "IBERIA",
	"FI" => "Icelandair",
	"7i" => "InselAir",
	"D6" => "Interair",
	"4O" => "Interjet",
	"3L" => "InterSky",
	"IR" => "Iran Air",
	"EP" => "Iran Aseman Airlines",
	"6H" => "Israir",
	"JL" => "Japan Airlines",
	"J9" => "Jazeera Airways",
	"9W" => "Jet Airways",
	"S2" => "Jet Lite (India) Limited",
	"B6" => "JetBlue",
	"R5" => "Jordan Aviation",
	"5N" => "JSC Nordavia-RA",
	"HO" => "Juneyao Airlines",
	"KQ" => "Kenya Airways",
	"Y9" => "Kish Air",
	"KL" => "KLM",
	"KE" => "Korean Air",
	"KU" => "Kuwait Airways",
	"LR" => "LACSA",
	"TM" => "LAM",
	"LA" => "Lan Airlines",
	"4M" => "Lan Argentina",
	"UC" => "Lan Cargo",
	"4C" => "Lan Colombia Airlines",
	"LP" => "Lan Perú",
	"XL" => "LanEcuador",
	"LI" => "LIAT Airlines",
	"N4" => "LLC \"NORD WIND\"",
	"LO" => "LOT Polish Airlines",
	"LH" => "Lufthansa",
	"LH" => "Lufthansa Cargo",
	"CL" => "Lufthansa CityLine",
	"LG" => "Luxair",
	"W5" => "Mahan Air",
	"MH" => "Malaysia Airlines",
	"TF" => "Malmö Aviation",
	"AE" => "Mandarin Airlines",
	"MP" => "Martinair Cargo",
	"M7" => "MAS AIR",
	"ME" => "MEA",
	"IG" => "Meridiana fly",
	"OM" => "MIAT",
	"YM" => "Montenegro Airlines",
	"NE" => "Nesma Airlines",
	"HG" => "NIKI",
	"NP" => "Nile Air",
	"KZ" => "Nippon Cargo Airlines (NCA)",
	"BJ" => "Nouvelair",
	"OA" => "Olympic Air",
	"WY" => "Oman Air",
	"8Q" => "Onur Air",
	"R2" => "Orenair",
	"PC" => "Pegasus Airlines",
	"NI" => "PGA-Portugália Airlines",
	"PR" => "Philippine Airlines",
	"PK" => "PIA",
	"PW" => "Precision Air",
	"PV" => "PrivatAir",
	"QF" => "Qantas",
	"QR" => "Qatar Airways",
	"FV" => "Rossiya Airlines",
	"AT" => "Royal Air Maroc",
	"BI" => "Royal Brunei",
	"RJ" => "Royal Jordanian",
	"WB" => "RwandAir",
	"S7" => "S7 Airlines",
	"SA" => "SAA",
	"FA" => "Safair",
	"4Q" => "Safi Airways",
	"S3" => "Santa Barbara",
	"SK" => "SAS",
	"SP" => "SATA Air Açores",
	"S4" => "SATA Internacional",
	"SV" => "Saudi Arabian Airlines",
	"SC" => "Shandong Airlines",
	"FM" => "Shanghai Airlines",
	"ZH" => "Shenzhen Airlines",
	"SQ" => "SIA",
	"SQ" => "SIA Cargo",
	"3U" => "Sichuan Airlines",
	"7L" => "Silk Way West Airlines",
	"MI" => "Silkair",
	"H2" => "SKY Airline",
	"XZ" => "South African Express Airways",
	"UL" => "SriLankan",
	"SD" => "Sudan Airways",
	"XQ" => "SunExpress",
	"PY" => "Surinam Airways",
	"LX" => "SWISS",
	"RB" => "Syrianair",
	"DT" => "TAAG - Angola Airlines",
	"TA" => "TACA",
	"T0" => "TACA Peru",
	"VR" => "TACV Cabo Verde Airlines",
	"PZ" => "TAM - Transportes Aéreos del Mercosur Sociedad Anónima",
	"JJ" => "TAM Linhas Aéreas",
	"EQ" => "TAME - Linea Aérea del Ecuador",
	"TP" => "TAP Portugal",
	"RO" => "TAROM",
	"SF" => "Tassili Airlines",
	"TG" => "Thai Airways International",
	"TK" => "THY - Turkish Airlines",
	"GS" => "Tianjin Airlines",
	"3V" => "TNT Airways S.A.",
	"UN" => "Transaero",
	"GE" => "TransAsia Airways",
	"X3" => "TUIfly",
	"TU" => "Tunisair",
	"PS" => "Ukraine International Airlines",
	"UA" => "United Airlines",
	"5X" => "UPS Airlines",
	"U6" => "Ural Airlines",
	"US" => "US Airways",
	"UT" => "UTair",
	"HY" => "Uzbekistan Airways",
	"VN" => "Vietnam Airlines",
	"VS" => "Virgin Atlantic",
	"VA" => "Virgin Australia",
	"VG" => "VLM Airlines",
	"Y4" => "Volaris",
	"VI" => "Volga-Dnepr Airlines",
	"G3" => "VRG Linhas Aéreas S.A. - Grupo GOL",
	"VY" => "Vueling",
	"WI" => "White coloured by you",
	"WF" => "Wideroe",
	"MF" => "Xiamen Airlines",
	"IY" => "Yemenia",
	);

	public function getAirlineName($code) {
		return @$this->airlineList[$code];
	}
} 

