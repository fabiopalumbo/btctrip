<?php
namespace BtcTrip\APIBtcTripBundle\Classes;
use \Exception;

abstract class BaseBookingApi {
  
    const RADIUS = 50;
    
    protected $apiUrl = '';
    protected $xapikey = '';

    protected $logger;
    
    /*
     * TODO    Sobrado A.
     * Poner esto para cada api en particular. 
     */
    private $apiMethods = array(
        /** API V3
        'flights/itineraries',
        */
        /* OLD_YAMIL
         */
        'availability/hotels',
        'autocomplete',
        'availability/cities',
        'availability/flights/roundTrip',
    	'availability/flights/oneWay',
    	'availability/flights/reprice',
    	'booking/flights/fields',
    	'booking/flights/book',
       // 'autocomplete/cities',
        'hotels',
        'hotels/amenities'
    );

    private static $staticContentUrl = 'http://media.staticontent.com/media/pictures/';

    public function __construct($logger) {
    	$this->logger = $logger;
    }

    /**
     * @return string
     */
    public function getApiUrl() {
        return $this->apiUrl;
    }
    
      /**
     * @return string
     */
    public function getXApiKey() {
        return $this->xapikey;
    }
    
    /**
     * @return array
     */
    public function getApiMethods() {
        return $this->apiMethods;
    }
    
    /**
     * @param string $apiMethod
     * @return boolean
     */
    public function inApiMethods($apiMethod) {
        return in_array($apiMethod, $this->getApiMethods());
    }
    
    public function buildUrl($apiMethod) {
        if (!$this->inApiMethods($apiMethod)) 
            throw new BookingApiInvalidMethodException('Invalid API method');
        
        return $this->getApiUrl() . $apiMethod;
    }

    public static function getStaticContentUrl() {
        return self::$staticContentUrl;
    }
    
    protected function handleError($httpCode, $errorCode, $errorMessage) {
        
        switch ($httpCode) {
         /*   case 400:
                throw new BookingApiBadRequestParameters('Bad request parameters', 400);
                break;  */
            case 401:
                throw new BookingApiUnauthorized('Unauthorized request', 401);                
                break;
            case 404:
                throw new BookingApiServerError('Service not found', 404);
                break;
            case 500:
                throw new BookingApiServerError('Server internal error', 500);
                break; 
        }
        if($errorCode > 0) {
            throw new BookingApiCurlError($errorMessage, $errorCode);
        }
    }
    
    abstract public function getHotelsAvailability($city, $checkin='', $checkout='', $distribution = "1", $pagesize=0,$filtros=array());

    abstract public function getHotelAvailability($id, $checkin='', $checkout='', $distribution = "1");
    abstract public function bookHotel($parameters);
    abstract public function getHotelAmenities($hotel_id);
    abstract public function getHotelPointSofInterest($hotel_id,$type);
    
    abstract public function getHotelReviews($hotel_id,$cantidad_comentarios,$page);
    abstract public function getAmenities();

    public function getLogger() {
		return $this->logger;
	}
	public function setLogger($logger) {
		$this->logger = $logger;
		return $this;
	}

} // DespegarApi

class BookingApiException                  extends Exception {}
class BookingApiInvalidMethodException     extends BookingApiException {}

class BookingApiBadRequestParameters       extends BookingApiException {} // 400
class BookingApiUnauthorized               extends BookingApiException {} // 401
class BookingApiServerError                extends BookingApiException {} // 404 y 500
class BookingApiCurlError                  extends BookingApiException {}

