<?php

namespace BtcTrip\HotelsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use \BtcTrip\APIBtcTripBundle\Controller\APIBtcTripController;
use \BtcTrip\HotelsBundle\DocumentManager\HotelSearchResultManager;
use \BtcTrip\HotelsBundle\Transformer\AvailabilityResultTransformer as AvailabilityResultTransformer;

class CoreHotelsController extends Controller {

    public function resultHotelsAction($hotel_id, $check_in='', $check_out='', $distribution, $page, $filterParams = '') {

        if (!isset($page)) {
            $page = 1;
        }
        if (empty($check_in)){
            $check_in='';
        }
        if (empty($check_out)){
            $check_out='';
        }
        $enviromentPrefix = $this->get('mega_helper')->getEnviromentPrefix();
        $sFromName = $this->get('city_manager')->getCityName($hotel_id);
        return $this->render('BtcTripHotelsBundle:CoreHotels:resultHotels.html.php', array('hotel_id' => $hotel_id, 'checkinDate' => $check_in, 'checkoutDate' => $check_out, 'distribution' => $distribution, 'page' => $page, "sFromName" => $sFromName, 'enviromentPrefix' => $enviromentPrefix));
    }

    public function resultFacetsAction($hotel_id, $check_in='', $check_out='', $distribution, $page, $filterParams = '') {
        return $this->search($hotel_id, $check_in, $check_out, $distribution, $page, $filterParams);
    }

    private function search($hotel_id, $check_in='', $check_out='', $distribution, $page, $filterParams = "") {
        $logger = $this->get('logger');
        $btctripApi = $this->get('btctrip_api');
        $params = array();
        $filter_temp = '';
        
        if (isset($filterParams)) {
            $filter_temp = $filterParams;
            $filterParams = explode("||", $filterParams);
            foreach ($filterParams as $filter) {
                if (!empty($filter)) {
                    $filter = explode("|", $filter);
                    $params[] = array($filter[0] => $filter[1]);
                }
            }
        }
        $enviromentPrefix = $this->get('mega_helper')->getEnviromentPrefix();
        $searchParameters = array('check_in' => $check_in, 'check_out' => $check_out, 'hotel_id' => $hotel_id, 'distribution' => $distribution, 'page' => $page, 'filterParams' => $filterParams);

        $hotels = array();
        $apiResponse = array();
        
        $apiResponse = $btctripApi->getHotelsAvailability($hotel_id, $check_in, $check_out, $distribution, 0, $page, $params);
        
        if (isset($apiResponse->availability) && count($apiResponse->availability) == 0) {
        	$cityLocation = $this->get('city_manager')->getCityLocation($hotel_id);
        	
        	$apiResponse = $btctripApi->getHotelsAvailabilityByLocation($cityLocation['latitude'], $cityLocation['longitude'], $check_in, $check_out, $distribution, 0, $page, $params);
        }
        
        if (isset($apiResponse->availability) && count($apiResponse->availability) > 0) {
           	$response = $this->get('hotels_helper')->processAvailabilityResponse($apiResponse, $searchParameters, $filterParams);

           	$sFromName = $this->get('city_manager')->getCityName($hotel_id);
           	$hotelsResponse = $this->render('BtcTripHotelsBundle:CoreHotels:resultPartialHotels.html.php', array('hotels' => $response, 'hotel_id' => $hotel_id, 'checkinDate' => $check_in, 'checkoutDate' => $check_out, 'distribution' => $distribution, 'page' => $page, 'filterParams' => $filterParams, 'enviromentPrefix' => $enviromentPrefix, 'sFromName' => $sFromName));
            $filterResponse = $this->render('BtcTripHotelsBundle:CoreHotels:resultPartialFilters.html.php', array('hotels' => $response, 'hotel_id' => $hotel_id, 'checkinDate' => $check_in, 'checkoutDate' => $check_out, 'distribution' => $distribution, 'page' => $page, 'filterParams' => $filter_temp, 'enviromentPrefix' => $enviromentPrefix));
            $rawResponse = array('data' => array('filters' => $filterResponse->getContent(), 'hotels' => $hotelsResponse->getContent()));
        } else {
        	$hotelsResponse = $this->render('BtcTripHotelsBundle:CoreHotels:resultErrorPartialHotels.html.php', array('hotels' => $apiResponse, 'hotel_id' => $hotel_id, 'checkinDate' => $check_in, 'checkoutDate' => $check_out, 'distribution' => $distribution, 'page' => $page, 'filterParams' => $filterParams, 'enviromentPrefix' => $enviromentPrefix));
            $rawResponse = array('data' => array('hotels' => $hotelsResponse->getContent()));
        }
        
        $response = new Response();
        $response->setContent(json_encode($rawResponse));
        
        return $response;
    }

    private function processResponse($apiResponse, $searchParameters, $filterParams) {
        $logger = $this->get('logger');
        $hManager = new HotelSearchResultManager($this->container);

        if (isset($apiResponse->availability)) {
            $page = 1;
            if (isset($filterParams) && isset($filterParams['page'])) {
                $page = $filterParams['page'];
            }
            // guardar lo relevante para la compra y para el tracking
            if (isset($apiResponse->availability)) {
                $hManager->persistInterestingResultParts($apiResponse, $apiResponse->availability[0]->sessionTicket, $searchParameters, $filterParams);
            } else {
                $logger->error('El resultado de busqueda no fue exitoso.');
            }
        } else {
            $apiResponse = $this->buildBasicResponse('NO_RESULTS');
        }
        return $apiResponse;
    }

    private function buildBasicResponse($statusCode) {
        $status = array('code' => $statusCode, 'message' => null);

        $response = array("messages" => null, 'result' => array('status' => $status,
                'data' => array('status' => $status, 'metadata' => array('status' => $status))));
        print_r($response);
        return $response;
    }

    public function searchHotelsAction() {
        return $this->render('BtcTripHotelsBundle:CoreHotels:searchHotels.html.php', array());
    }

    public function getHotelMapAction($latitude, $longitude) {
        return $this->render('BtcTripHotelsBundle:CoreHotels:showHotelMap.html.php', array('latitude' => $latitude, 'longitude' => $longitude));
    }

    public function searchAvailableHotelAction($hotel_id, $check_in='', $check_out='', $distribution) {
        $filterParams = array();
        $searchParameters = array('check_in' => $check_in, 'check_out' => $check_out, 'hotel_id' => $hotel_id, 'distribution' => $distribution, 'filterParams' => $filterParams);

        $btctrip = $this->get('btctrip_api');


        /*
         * @method getHotelAvailability
         * Busca la disponibilidad del hotel
         */
        $hotels = $btctrip->getHotelAvailability($hotel_id, $check_in, $check_out, $distribution);
        $responseAvailability = $this->processResponse($hotels, $searchParameters, $filterParams);
        /* @var $rooms listado de rooms */
        $rooms = $responseAvailability->availability[0]->rooms;

        if (count($rooms) > 0) {
	        $room_first = '';
	        if (isset($rooms[$responseAvailability->availability[0]->suggestedRoom])) {
	            foreach ($rooms as $r) {
	                if ($r->id == $responseAvailability->availability[0]->suggestedRoom) {
	                    $room_first = $r;
	                    break;
	                }
	            }
	        } else {
	            $room_first = array();
	            if (count($rooms) > 0) {
	                $room_first = $rooms[0];
	            }
	        }
	
	        // sacando rooms repetidas
	        $roomsSinRepetir = array();
	        foreach ($rooms as $room) {
	            if (!$this->roomEstaIncluida($room, $roomsSinRepetir)) {
	                $roomsSinRepetir[] = $room;
	            }
	        }
	        $rooms = $roomsSinRepetir;
	
	        // Ordena el listado de habitaciones disponibles
	        $i = 1;
	        $array_ordenado = array();
	        $array_para_ordenar_indice = array();
	
	        foreach ($rooms as $r) {
	            $array_para_ordenar_indice[$r->id] = ceil($r->prices->averagePricesPerNight->avgDiscountPrice->priceWithoutTax);
	            $i++;
	        }
	        asort($array_para_ordenar_indice);
	        foreach ($array_para_ordenar_indice as $key => $value) {
	            foreach ($rooms as $r) {
	                if ($r->id == $key) {
	                    $array_ordenado[] = $r;
	                    break;
	                }
	            }
	        }
	
	        $rooms = $array_ordenado;
	        
         }
        

        $array_distribution = explode("!", $distribution);
        $cantidad_habitacion = count($array_distribution);
        $cantidad_adultos = 0;
        if ($cantidad_habitacion > 1) {
             foreach ($array_distribution as $h) {
                 $text = explode("-", $h);
                 $cantidad_adultos = $cantidad_adultos + $text[0];
             }
        } else {
             $cantidad_adultos = $array_distribution[0];
        }
        
        $enviromentPrefix = $this->get('mega_helper')->getEnviromentPrefix();
        $transformer = new AvailabilityResultTransformer($this->container);
        $responseTransformerPrice = (count($rooms) > 0 ? $transformer->transformPriceHotel($room_first) : null);
        $responseTransformerRoomPrice = (count($rooms) > 0 ? $transformer->transformRoomPriceHotel($rooms) : null);
         
        // Template que muestra si tiene o no resultados
        $availableResponse = $this->render('BtcTripHotelsBundle:CoreHotels:textAvailable.html.php', array('hotelAvailable' => $responseAvailability, 'hotel_id' => $hotel_id,
        		 'checkinDate' => $check_in, 'checkoutDate' => $check_out, 'distribution' => $distribution, 'enviromentPrefix' => $enviromentPrefix));

        // Template que muestra la lista de habitaciones disponibles
        $roomsAvailableHotelsResponse = $this->render('BtcTripHotelsBundle:CoreHotels:roomsAvailableHotel.html.php', 
        		array('hotelAvailable' => $responseAvailability, 'hotel_id' => $hotel_id, 'checkinDate' => $check_in, 'checkoutDate' => $check_out, 
        				'distribution' => $distribution, 'enviromentPrefix' => $enviromentPrefix, 'rooms' => $responseTransformerRoomPrice, 
        				'cantidad_adultos' => $cantidad_adultos,'cantidad_habitacion' => $cantidad_habitacion));

        // Template que muestra si esta agotado o los precios de la habitacion sugerida
        $showAvailableResponse = $this->render('BtcTripHotelsBundle:CoreHotels:showAvailableHotel.html.php', array('hotelAvailable' => $responseAvailability,
        		 'hotel_id' => $hotel_id, 'checkinDate' => $check_in, 'checkoutDate' => $check_out, 'distribution' => $distribution, 'enviromentPrefix' => $enviromentPrefix, 
        		'room_first' => $responseTransformerPrice, 'cantidad_habitacion' => $cantidad_habitacion));
        
        $rawResponse = array('data' => array('textAvailable' => $availableResponse->getContent(),
        		 'roomsAvailable' => $roomsAvailableHotelsResponse->getContent(),
        		 'showAvailable' => $showAvailableResponse->getContent()));
        
        $response = new Response();
        $response->setContent(json_encode($rawResponse));
        
        return $response;
    }

    public function showHotelAction($hotel_id, $check_in='', $check_out='', $distribution,$ciudad='') {
        $filterParams = array();
        $searchParameters = array('check_in' => $check_in, 'check_out' => $check_out, 'hotel_id' => $hotel_id, 'distribution' => $distribution, 'filterParams' => $filterParams);

        $btctrip = $this->get('btctrip_api');

        // getHotel Retorna la informacion basica del hotel
        $hotel = $btctrip->getHotel($hotel_id);
        
        // Toma las comodidades del servicio getHotel- En caso de no devolver ninguno llamo al servicio de GetHotelAmenities
        if (count($hotel->amenities)>0){
            $hotelAmenities = $hotel->amenities;
        }else{
      		// getHotelAmenities  Retorna los servicios del hotel 
            $hotelAmenities = $btctrip->getHotelAmenities($hotel_id);
            $hotelAmenities=$hotelAmenities->hotels[0];
        }
        
        $cantidad_comentarios = 10;

        $page = 1;
        //getHotelReviews  Retorna los comentarios 
        $hotelReviews = $btctrip->getHotelReviews($hotel_id, $cantidad_comentarios,$page);
        
        // @getHotelPointSofInterest  Retorna los puntos de interes
        $hotelPoint = $btctrip->getHotelPointSofInterest($hotel_id, 'U');

        $array_distribution = explode("!", $distribution);
        $cantidad_habitacion = count($array_distribution);
        $cantidad_adultos = 0;
        if ($cantidad_habitacion > 1) {
            foreach ($array_distribution as $h) {
                $text = explode("-", $h);
                $cantidad_adultos = $cantidad_adultos + $text[0];
            }
        } else {
            $cantidad_adultos = $array_distribution[0];
        }
        $enviromentPrefix = $this->get('mega_helper')->getEnviromentPrefix();

        return $this->render('BtcTripHotelsBundle:CoreHotels:showHotel.html.php', array('hotel' => $hotel, 'hotelAmenities' => $hotelAmenities, "hotelReviews" => $hotelReviews, 'hotel_id' => $hotel_id, 'checkinDate' => $check_in, 'checkoutDate' => $check_out, 'distribution' => $distribution, 'cantidad_adultos' => $cantidad_adultos, 'cantidad_habitacion' => $cantidad_habitacion, 'enviromentPrefix' => $enviromentPrefix, 'hotelPoint' => $hotelPoint,'page'=>$page));
    }

    public function showMoreCommentsAction($hotel_id,$cantidad_comentarios,$page,$parcial_comentarios,$total_comentarios){
         $btctrip = $this->get('btctrip_api');
         $hotelReviews = $btctrip->getHotelReviews($hotel_id, $cantidad_comentarios,$page);
         $cant_coment=count($hotelReviews->reviews);
         $parcial_comentarios=$parcial_comentarios+$cant_coment;
         $enviromentPrefix = $this->get('mega_helper')->getEnviromentPrefix();
         $showMoreComments= $this->render('BtcTripHotelsBundle:CoreHotels:showMoreComments.html.php', array('hotelReviews' => $hotelReviews, 'hotel_id' => $hotel_id, 'cantidad_comentarios' => $cantidad_comentarios, 'enviromentPrefix' => $enviromentPrefix,'page'=>$page));
         $showButtonMoreComments= $this->render('BtcTripHotelsBundle:CoreHotels:showButtonMoreComments.html.php', array('hotelReviews' => $hotelReviews,'hotel_id' => $hotel_id, 'cantidad_comentarios' => $cantidad_comentarios, 'enviromentPrefix' => $enviromentPrefix,'page'=>$page,'total_comentarios'=>$total_comentarios,'parcial_comentarios'=>$parcial_comentarios));
         
         $rawResponse = array('data' => array('showMoreComments' => $showMoreComments->getContent(),'showButtonMoreComments'=>$showButtonMoreComments->getContent(),'cant_coment'=>$cant_coment,'parcial_comentarios'=>$parcial_comentarios));
         $response = new Response();
         $response->setContent(json_encode($rawResponse));
         return $response;
         
    }
    
    private function roomEstaIncluida($room, $roomsSinRepetir) {
        $retval = false;

        foreach ($roomsSinRepetir as $roomUnica) {
            if (($room->roomsDetail[0]->typeCode == $roomUnica->roomsDetail[0]->typeCode) &&
                    ($room->penalty->refundType == $roomUnica->penalty->refundType &&
         			$room->regimeCode == $roomUnica->regimeCode)) {
                return true;
            }
        }

        return $retval;
    }

}