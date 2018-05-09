<?php
namespace BtcTrip\APIBtcTripBundle\Classes;
use \BtcTrip\APIBtcTripBundle\Classes\DespegarCurl as DespegarCurl;
use \BtcTrip\APIBtcTripBundle\Classes\DespegarApiResponse as DespegarApiResponse;


class NewDespegarFlightApi extends BaseBookingApi {
    protected $site = 'US';
    protected $apiUrl = 'https://api.despegar.com/v3/';
    protected $xapikey = '343f1040cda04fcbbf01b6c5633fe34e';
    protected $agencycode = 'AG22546';
  
	/**
	 * @see https://api.despegar.com/v3/docs/method/flights-api-v3-Itinerary-availability
	 */
    public function availabilityFlightsRoundTrip($from, $to, $departureDate, $returnDate, $adults, $childrens, $infants,
			$orderBy, $orderDir, $departureTime, $returningTime, $classFlight, $scaleFlight, $airlineFlight, $filterParams) {
    	
    	$serviceInvocation = DespegarCurl::create($this->buildUrl('flights/itineraries') . 
            "?site={$this->site}" .
            "&from={$from}" .
            "&to={$to}" .
            "&departure_date={$departureDate}" .
            "&return_date={$returnDate}" .
            "&adults={$adults}" .
            "&children={$childrens}" .
            "&infants={$infants}"
        );
        /*
    			'?site='."/". $from ."/". $to ."/". $departureDate ."/". $returnDate ."/". $adults ."/". $childrens ."/". $infants)
    	->setParameter('pagesize', 10);
    	
    	$this->setOptionalParameters($serviceInvocation, $orderBy, $orderDir, $classFlight, $scaleFlight, $airlineFlight);
    	$this->setFiltersParameters($serviceInvocation, $filterParams);
    	
         */
    	$result = $serviceInvocation->get();
    	
    	try {
    		$this->handleError($result["http_code"], $result["error_code"], $result["error_msg"]);
    	} catch (BookingApiServerError $e) {
    		$this->logger->error("Server error code: " . $result["error_code"] . ", msg: " . $result["error_msg"]);
    		$this->logger->error(print_r($result["response"], true));
    	}
    	    	
    	$response=json_decode($result["response"]);
    	 
    	return $response;
    }

    /* OLD CODE. */
    public function getHotelsAvailabilityByLocation($latitude, $longitude, $checkin='', $checkout='', $distribution = "1", $pagesize=0, $page=1, $filterParams=array()) {
    	$serviceInvocation = DespegarCurl::create($this->buildUrl('availability/hotels') . "/" . $latitude . "/" . $longitude);
    	if (!empty($checkin)){
    		$serviceInvocation->setParameter('checkin', $checkin);
    	}
    	if (!empty($checkout)){
    		$serviceInvocation->setParameter('checkout', $checkout);
    	}
    	$serviceInvocation->setParameter('includehotel', true)
    	->setParameter('pagesize', 21)
    	->setParameter("paymenttype",4)   // Filtrado de hoteles que se paguen en un pago
    	->setParameter('page', $page)
    	->setParameter('distribution', $distribution);
    	$this->setFiltersParametersHotels($serviceInvocation, $filterParams);
    	$result = $serviceInvocation->get();
    
    	try {
    		 
    		$this->handleError($result["http_code"], $result["error_code"], $result["error_msg"]);
    	} catch (BookingApiBadRequestParameters $e)
    	{
    		$this->logger->error("Server error code: " . $result["error_code"] . ", msg: " . $result["error_msg"]);
    		$this->logger->error(print_r($result["response"], true));
    	}
    
    	$response=json_decode($result["response"]);
    	return $response;
    	 
    }
    
    public function getHotelsAvailability($city, $checkin='', $checkout='', $distribution = "1", $pagesize=0,$page=1,$filterParams=array()) {
        $serviceInvocation = DespegarCurl::create($this->buildUrl('availability/cities') . "/".$city."/hotels");
        if (!empty($checkin)){
            $serviceInvocation->setParameter('checkin', $checkin);
        }
        if (!empty($checkout)){
            $serviceInvocation->setParameter('checkout', $checkout);
        }
          $serviceInvocation->setParameter('includehotel', true)
            ->setParameter('pagesize', 21)
            ->setParameter("paymenttype",4)   // Filtrado de hoteles que se paguen en un pago    
            ->setParameter('page', $page)
            ->setParameter('distribution', $distribution);
        $this->setFiltersParametersHotels($serviceInvocation, $filterParams);
    	$result = $serviceInvocation->get();
        
        try {
           
	    	$this->handleError($result["http_code"], $result["error_code"], $result["error_msg"]);
    	} catch (BookingApiBadRequestParameters $e)
            {
    		$this->logger->error("Server error code: " . $result["error_code"] . ", msg: " . $result["error_msg"]);
    		$this->logger->error(print_r($result["response"], true));
    	}
	   
    	$response=json_decode($result["response"]);
     return $response;
   
    }

    public function getHotelAvailability($id, $checkin='', $checkout='', $distribution = "1") {
        $serviceInvocation = DespegarCurl::create($this->buildUrl('availability/hotels') . "/$id/booking");
           if (!empty($checkin)){
            $serviceInvocation->setParameter('checkin', $checkin);
        }
        if (!empty($checkout)){
            $serviceInvocation->setParameter('checkout', $checkout);
        }
            $serviceInvocation->setParameter('distribution', $distribution)
            ->setParameter('includehotel', true);
        $result = $serviceInvocation->get();

         try {
                $this->handleError($result["http_code"], $result["error_code"], $result["error_msg"]);
    	} catch (BookingApiBadRequestParameters $e)
            {
    		$this->logger->error("Server error code: " . $result["error_code"] . ", msg: " . $result["error_msg"]);
    		$this->logger->error(print_r($result["response"], true));
    	}
	   
    	$response=json_decode($result["response"]);    
        return $response;
    }
  public function getHotel($id) {
     try {
          $result = DespegarCurl::create($this->buildUrl('hotels') . "/$id")
            ->setParameter('includeamenities', true)
            ->setParameter('includesummary', true)      
        ->get();
          
	    	$this->handleError($result["http_code"], $result["error_code"], $result["error_msg"]);
    	} catch (BookingApiServerError $e) {
    		$this->logger->error("Server error code: " . $result["error_code"] . ", msg: " . $result["error_msg"]);
    		$this->logger->error(print_r($result["response"], true));
    	}    
      
        return json_decode($result["response"]);
    }
    public function bookHotel($parameters) {
        
    }
    
    public function autoCompleteHotels($term) {
        $result = DespegarCurl::create($this->buildUrl('autocomplete') . "/".rawurlencode($term)."?flow=hotels")
        ->get();
        $this->handleError($result["http_code"], $result["error_code"], $result["error_msg"]);
        $response=json_decode($result["response"]);
        return $response;
    }
    
    
    public function getHotelAmenities($hotel_id){
        $result = DespegarCurl::create($this->buildUrl('hotels') . "/".$hotel_id."/amenities")
        ->get();
        $this->handleError($result["http_code"], $result["error_code"], $result["error_msg"]);
        $response=json_decode($result["response"]);
        return $response;
    }
    
     public function getHotelPointSofInterest($hotel_id,$type){
        $result = DespegarCurl::create($this->buildUrl('hotels') . "/".$hotel_id."/pointsofinterest")
         ->setParameter('geotype', $type)
       //  ->setParameter('maxresults', 4)
                
        ->get();
        $this->handleError($result["http_code"], $result["error_code"], $result["error_msg"]);
        $response=json_decode($result["response"]);
        return $response;
    }
    
    
    public function getHotelReviews($hotel_id,$cantidad_comentarios,$page=1){
        $result = DespegarCurl::create($this->buildUrl('hotels') . "/".$hotel_id."/reviews")
          ->setParameter("notempty",1)
          ->setParameter('pagesize', $cantidad_comentarios)  
          ->setParameter('page', $page)      
          ->get();
        $this->handleError($result["http_code"], $result["error_code"], $result["error_msg"]);
        $response=json_decode($result["response"]);
        return $response;
    }
    public function getAmenities(){
          $result = DespegarCurl::create($this->buildUrl('hotels/amenities'))
        ->get();
        $this->handleError($result["http_code"], $result["error_code"], $result["error_msg"]);
        $response=json_decode($result["response"]);
   
        return $response;
    }
    	
    
	/**
	 * @see http://api.despegar.com/docs/method/flights-roundtrip-flights
	 */
    public function OLD_YAMIL_availabilityFlightsRoundTrip($from, $to, $departureDate, $returnDate, $adults, $childrens, $infants,
			$orderBy, $orderDir, $departureTime, $returningTime, $classFlight, $scaleFlight, $airlineFlight, $filterParams) {
    	
    	$serviceInvocation = DespegarCurl::create($this->buildUrl('availability/flights/roundTrip') . 
    			"/". $from ."/". $to ."/". $departureDate ."/". $returnDate ."/". $adults ."/". $childrens ."/". $infants)
    	->setParameter('pagesize', 10);
    	
    	$this->setOptionalParameters($serviceInvocation, $orderBy, $orderDir, $classFlight, $scaleFlight, $airlineFlight);
    	$this->setFiltersParameters($serviceInvocation, $filterParams);
    	
    	$result = $serviceInvocation->get();
    	
    	try {
    		$this->handleError($result["http_code"], $result["error_code"], $result["error_msg"]);
    	} catch (BookingApiServerError $e) {
    		$this->logger->error("Server error code: " . $result["error_code"] . ", msg: " . $result["error_msg"]);
    		$this->logger->error(print_r($result["response"], true));
    	}
    	    	
    	$response=json_decode($result["response"]);
    	 
    	return $response;
    }

    
    /**
     * @see http://api.despegar.com/docs/method/flights-one-way-flights
     */
    public function availabilityFlightsOneWay($from, $to, $departureDate, $adults, $childrens, $infants,
    		$orderBy, $orderDir, $departureTime, $returningTime, $classFlight, $scaleFlight, $airlineFlight, $filterParams) {
    	 
    	$serviceInvocation = DespegarCurl::create($this->buildUrl('availability/flights/oneWay') .
    			"/". $from ."/". $to ."/". $departureDate ."/". $adults ."/". $childrens ."/". $infants)
    			->setParameter('pagesize', 10);
    	 
 		$this->setOptionalParameters($serviceInvocation, $orderBy, $orderDir, $classFlight, $scaleFlight, $airlineFlight);
 		$this->setFiltersParameters($serviceInvocation, $filterParams);
    	 
    	$result = $serviceInvocation->get();
    	
    	try {
	    	$this->handleError($result["http_code"], $result["error_code"], $result["error_msg"]);
    	} catch (BookingApiServerError $e) {
    		$this->logger->error("Server error code: " . $result["error_code"] . ", msg: " . $result["error_msg"]);
    		$this->logger->error(print_r($result["response"], true));
    	}
	    
    	$response=json_decode($result["response"]);
    
    	return $response;
    }
    
    private function setOptionalParameters($serviceInvocation, $orderBy, $orderDir, $classFlight, $scaleFlight, $airlineFlight) {
    	if (!empty($orderBy)) {
    		$serviceInvocation->setParameter('sort', $orderBy);
    	}
    	if (!empty($orderDir)) {
    		$serviceInvocation->setParameter('order', $orderDir);
    	}
    	
    	// $departureTime, $returningTime: ignorados por estar deprecados en la api actual
    	
    	if (!empty($classFlight)) {
    		$serviceInvocation->setParameter('cabintype', $classFlight);
    	}
    	if (!empty($scaleFlight)) {
    		$serviceInvocation->setParameter('stopsadvancedparameter', $scaleFlight);
    	}
    	if (!empty($airlineFlight)) {
    		$serviceInvocation->setParameter('airlinesadvancedparameter', $airlineFlight);
    	}
    }
    
    private function setFiltersParametersHotels($serviceInvocation, $filterParams) {
    	if (isset($filterParams)) {
            $params=array();
            foreach($filterParams as $name => $value){
                foreach ($value as $n => $v) {
                     if(!empty($params[$n])){
                         $valor=$params[$n];
                         $params[$n]=$valor.'-'.$v;
                     }else{
                         $params[$n]=$v;
                     }
                }
            }
           $this->setFiltersParameters($serviceInvocation,$params);
    	}
        
    }
     private function setFiltersParameters($serviceInvocation, $filterParams) {
    	if (isset($filterParams)) {
            //print_r($filterParams);
            foreach ($filterParams as $name => $value) {
    	        $serviceInvocation->setParameter($name, $value);
        }
    	}
    }
    
    
    public function availabilityFlightsReprice($ticket, $itineraryId) {
    	$result = DespegarCurl::create($this->buildUrl('availability/flights/reprice') . "/".$ticket."/".$itineraryId)
    	->get();
    	$this->handleError($result["http_code"], $result["error_code"], $result["error_msg"]);
    	$response=json_decode($result["response"]);
    	
    	return $response;
    }
    
    /**
	 * @see http://api.despegar.com/docs/method/Booking-flight-booking-fields
	 */
    public function bookingFlightsFields($ticket, $itineraryId) {
    	$result = DespegarCurl::create($this->buildUrl('booking/flights/fields') . "/".$ticket."/".$itineraryId)
    	->setParameter('agencycode', $this->agencycode)
    	->get();
    	$this->handleError($result["http_code"], $result["error_code"], $result["error_msg"]);
    	$response=json_decode($result["response"]);
    	 
    	return $response;
    }
    
    /**
     * @see http://api.despegar.com/docs/method/Booking-flight-booking 
     */
    public function bookingFlightsBook($jsonParameters) {
    	$serviceInvocation = DespegarCurl::create($this->buildUrl('booking/flights/book'));
    	
    	$serviceInvocation->setRawData($jsonParameters);
    	
    	$result = $serviceInvocation->post(true);
    	
    	$this->handleError($result["http_code"], $result["error_code"], $result["error_msg"]);
    	$response=json_decode($result["response"]);
    	 
    	return $response;
    }
 
    
} 

