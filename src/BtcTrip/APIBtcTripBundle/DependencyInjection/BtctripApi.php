<?php
namespace BtcTrip\APIBtcTripBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\ContainerInterface;
use \BtcTrip\APIBtcTripBundle\Classes\TravelportApi as TravelportApi;
use \BtcTrip\APIBtcTripBundle\Classes\DespegarApi as DespegarApi;
use \BtcTrip\APIBtcTripBundle\Classes\NewDespegarFlightApi as NewDespegarFlightApi;
use BtcTrip\MainBundle\Service\BaseService;

class BtctripApi extends BaseService {
  
	public function getHotelsAvailabilityByLocation($latitude, $longitude, $checkinDate='', $checkoutDate='', $distribution, $pagesize=0, $page=1, $params) {
		$apiDespegar = new DespegarApi($this->getLogger());
		$availability= $apiDespegar->getHotelsAvailabilityByLocation($latitude, $longitude, $checkinDate, $checkoutDate, $distribution, $pagesize, $page, $params);
		return $availability;
	}
	
   public function getHotelsAvailability($city, $checkinDate='', $checkoutDate='', $distribution, $pagesize=0, $page=1, $params) {
       $apiDespegar = new DespegarApi($this->getLogger());
       $availability= $apiDespegar->getHotelsAvailability($city, $checkinDate, $checkoutDate, $distribution, $pagesize, $page, $params);	
       return $availability;
   }

    public function getHotelAvailability($sbhotels, $checkinDate='', $checkoutDate='', $distribution){
            $apiDespegar = new DespegarApi($this->getLogger());
            $availability= $apiDespegar->getHotelAvailability($sbhotels, $checkinDate, $checkoutDate, $distribution);	
            return $availability;
    }
     public function getHotel($sbhotels){
            $apiDespegar = new DespegarApi($this->getLogger());
            $hotel= $apiDespegar->getHotel($sbhotels);	
            return $hotel->hotels[0];
    }
    
    public function getAmenities(){
        $apiDespegar = new DespegarApi($this->getLogger());
            $hotel= $apiDespegar->getAmenities();	
            return $hotel;
    }
    public function getHotelPointSofInterest($hotel_id,$type){
        $apiDespegar = new DespegarApi($this->getLogger());
        $point= $apiDespegar->getHotelPointSofInterest($hotel_id,$type);	
        return $point;
    }
    
    /*
     * Parametrizar la API 
     * TODO 
     * pasar estos mensaje a la clase DespegarApi
     * 
     */
     public function autoCompleteHotels($term) {
           $apiDespegar = new DespegarApi($this->getLogger());
           $autocompleteHotels= $apiDespegar->autoCompleteHotels($term);	
            return $autocompleteHotels;
            
    }  
    /*
     * Parametrizar la API 
     * TODO 
     * pasar estos mensaje a la clase DespegarApi
     * 
     */
      public function autoCompleteFlights($term) {
           $apiDespegar = new DespegarApi($this->getLogger());
           $autocompleteFlights= $apiDespegar->autoCompleteFlights($term);	
            return $autocompleteFlights;
    }     
	
    public function getHotelAmenities($hotel_id){
        $apiDespegar = new DespegarApi($this->getLogger());
        $hotelAmenities= $apiDespegar->getHotelAmenities($hotel_id);	
        return $hotelAmenities;
    }
    
    public function getHotelReviews($hotel_id,$cantidad_comentarios,$page){
        $apiDespegar = new DespegarApi($this->getLogger());
        $hotelReviews= $apiDespegar->getHotelReviews($hotel_id,$cantidad_comentarios,$page);	
        return $hotelReviews;
    }

    public function availabilityFlightsRoundTrip($from, $to, $departureDate, $returnDate, $adults, $childrens, $infants,
    $sOrderBy, $sOrderDir, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight, $filterParams = null) {

        /* YAMIL CODE
        */
    	$apiDespegar = new DespegarApi($this->getLogger());
    	$flights = $apiDespegar->availabilityFlightsRoundTrip($from, $to, $departureDate, $returnDate, $adults, $childrens, $infants,
    			$sOrderBy, $sOrderDir, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight, $filterParams);

    	return $flights;
    }
    
    public function availabilityFlightsOneWay($from, $to, $departureDate, $adults, $childrens, $infants,
    		$sOrderBy, $sOrderDir, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight, $filterParams = null) {
    	$apiDespegar = new DespegarApi($this->getLogger());
    	$flights = $apiDespegar->availabilityFlightsOneWay($from, $to, $departureDate, $adults, $childrens, $infants,
    			$sOrderBy, $sOrderDir, $sDepartureTime, $sReturningTime, $sClassFlight, $sScaleFlight, $sAirlineFlight, $filterParams);
    
    	return $flights;
    }
    
    public function availabilityFlightsReprice($ticket, $itineraryId) {
    	$apiDespegar = new DespegarApi($this->getLogger());
    	$repriced = $apiDespegar->availabilityFlightsReprice($ticket, $itineraryId);
    
    	return $repriced;
    }
    
    public function bookingFlightsFields($ticket, $itineraryId) {
        if(is_array($itineraryId)) {
            $tpApi = new TravelportApi($this->getLogger());
            $retval = $tpApi->bookingFlightsFields($itineraryId['recommendationId'], $itineraryId['fareId'], $itineraryId['options']);
        } else {
            $apiDespegar = new DespegarApi($this->getLogger());
            $retval = $apiDespegar->bookingFlightsFields($ticket, $itineraryId);
        }
    
    	return $retval;
    }
    
    public function bookingFlightsBook($jsonParameters) {
    	$apiDespegar = new DespegarApi($this->getLogger());
    	$retval = $apiDespegar->bookingFlightsBook($jsonParameters);
    
    	return $retval;
    }
		
}
