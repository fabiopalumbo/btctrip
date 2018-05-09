<?php

namespace BtcTrip\BackofficeBundle\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use BtcTrip\FlightsBundle\Transformer\AvailabilityResultTransformer;


/**
 * @Route("/flights")
 */
class FlightsController extends Controller {
	
	/**
	 * @Route("/detail/{orderId}", name="flight_detail")
	 * @Template(engine="php")
	 */
	public function detailAction($orderId) {
		$order = $this->get('order_manager')->getById($orderId);
		
		return array( 'order' => $order, 'invoice' => $order['invoice'] );
	}
	
	/**
	 * @Route("/confirm_price/{orderId}", name="confirm_order_price")
	 * @Template(engine="php")
	 */
    public function confirmOrderPriceAction($orderId) {
    	$order = $this->get('order_manager')->getById($orderId);
    	
    	$btctripApi = $this->get('btctrip_api');

    	$ticket = $order['itinerary']['metadata']['ticket']['id'];
    	$itineraryId = $order['itinerary']['id'];
    	
    	$repricedFlight = $btctripApi->availabilityFlightsReprice($ticket, $itineraryId);
    	
    	if (isset($repricedFlight->flights)) {
    		// $requiredFields = $btctripApi->bookingFlightsFields($ticket, $itineraryId);
    		 
    		$isSamePrice = $this->isSamePrice($order, $repricedFlight);
    		 
    		$message = $ticket . ', ' . $itineraryId . ' -> is same price: ' . $isSamePrice ;
    		 
    		$response = array("result" => array('message' => $message, 'code' => 'SUCCESS'));
    	} else {
    		
    		$message = $repricedFlight->errors[0]->code . ': ' . $repricedFlight->errors[0]->description;
    		
    		$response = array("result" => array('message' => $message, 'code' => 'ERROR'));
    	}
    	
    	//   array('message' => $message, 'isSamePrice' => $isSamePrice, 'order' => $order, 'retval' => $repricedFlight);
    	
    	return new Response(json_encode($response));
    }
    
    private function isSamePrice($order, $repricedFlight) {
    	return ($order['itinerary']['itenerariesBoxPriceInfoList'][0]['total']['fare']['raw'] == $repricedFlight->flights->priceInfo->total->fare);
    }
    
    
    /**
     * @Route("/book/{orderId}", name="book")
     * @Template(engine="php")
     */
    public function bookAction($orderId) {
    	$logger = $this->get("logger");
    	
    	// levantar los datos requeridos para la reserva
    	
    	// 		order
    	$order = $this->get('order_manager')->getById($orderId);
    	
    	$ticket = $order['requiredFields']['ticket'];
    	
    	// info del cupon y la tarjeta
    	$paymentInfo = $this->container->get('accounting_manager')->getLast();
    	
    	$jsonParameters = $this->buildBookingJsonParameters($ticket, $order['buyerInfo'], $paymentInfo);
		
    	$logger->debug($jsonParameters);
    	
		// invocar al servicio con todo esto
    	$bookingResponse = $this->get('btctrip_api')->bookingFlightsBook($jsonParameters);
    	
    	$order['bookResponse'] = $bookingResponse;
    	$order['status'] = 'active';
    	$order = $this->get('order_manager')->save($order);

    	if (isset($bookingResponse->data->status) && $bookingResponse->data->status == 'OK') {
	    	$message = "Reserva emitida. Codigo despegar: " . $bookingResponse->data->checkoutId; 
    		$response = array("result" => array('message' => $message, 'code' => 'SUCCESS'));
    		
    	} else {
    		$message = "Hubo un error en la reserva.";
    		if (isset($bookingResponse->data->checkoutId)) {
    			$message .= "Codigo de reserva despegar: " . $bookingResponse->data->checkoutId;
    		}
    		
    		$response = array("result" => array('message' => $message, 'code' => 'ERROR'));
    		
    	}
    	
    	$logger->info($message);
    	$logger->info(print_r($bookingResponse, true));
    	
    	return new Response(json_encode($response));    	
    }
    
    private function  retrieveTicketFromFields($searchTicket, $itineraryId) {
    	$requiredFieldsResponse = $this->get('btctrip_api')->bookingFlightsFields($searchTicket, $itineraryId);
    	
    	return  $requiredFieldsResponse->data->ticket;
    }
    
    
    private function buildBookingJsonParameters($ticket, $buyerInfo, $paymentInfo) {
    	$jsonParameters = array();

    	$jsonParameters['ticket'] = $ticket;
    	
    	$jsonParameters['flightInputDefinition'] = array();
    	
    	// basic parameters
    	
    	// contactDefinitions:  la de la agencia!
    	$contactDefinition = array();
    	$contactDefinition['email']['value'] = $paymentInfo['agency']['email'];
    	$contactDefinition['phoneDefinitions'][0]['type']['value'] = $paymentInfo['agency']['phone']['type'];
    	$contactDefinition['phoneDefinitions'][0]['countryCode']['value'] = $paymentInfo['agency']['phone']['countryCode'];
    	$contactDefinition['phoneDefinitions'][0]['areaCode']['value'] = $paymentInfo['agency']['phone']['areaCode'];
    	$contactDefinition['phoneDefinitions'][0]['number']['value'] = $paymentInfo['agency']['phone']['number'];

    	$jsonParameters['flightInputDefinition']['contactDefinition'] = $contactDefinition;
    	
    	// passengerDefinitions
    	$passengersDefinitions = array();
    	foreach ($buyerInfo['passengerDefinitions'] as $buyerInfoPassengerDefinition) {
    		$passengerDefinitions['type'] = $buyerInfoPassengerDefinition['type'];
    		
    		$passengerDefinitions['firstName']['value'] = $buyerInfoPassengerDefinition['firstName'];
    		$passengerDefinitions['lastName']['value'] = $buyerInfoPassengerDefinition['lastName'];
    		$passengerDefinitions['gender']['value'] = $buyerInfoPassengerDefinition['gender'];
    		$passengerDefinitions['birthday']['value'] = $this->getFormattedDate($buyerInfoPassengerDefinition['birthday']);

    		if(isset($buyerInfoPassengerDefinition['nationality'])) {
    			$passengerDefinitions['nationality']['value'] = $buyerInfoPassengerDefinition['nationality'];
    		}
    		if(isset($buyerInfoPassengerDefinition['documentDefinition'])) {
    			$passengerDefinitions['documentDefinition']['type']['value'] = $buyerInfoPassengerDefinition['documentDefinition']['type'];
    			$passengerDefinitions['documentDefinition']['number']['value'] = $buyerInfoPassengerDefinition['documentDefinition']['number'];
    		}
    		
    		$passengersDefinitions[] = $passengerDefinitions;
    	}
    	
    	$jsonParameters['flightInputDefinition']['passengerDefinitions'] = $passengersDefinitions;
    	
    	// paymentDefinition
    	$paymentDefinition = array();
    	
    	$installmentDefinition = array();
    	$installmentDefinition['quantity']['value'] = 1;
    	$installmentDefinition['completeCardCode']['value'] = 'CA';
    	$installmentDefinition['cardCode']['value'] = 'CA';
    	$installmentDefinition['cardType']['value'] = 'CREDIT';
    	
    	$paymentDefinition['installmentDefinition'] = $installmentDefinition;
    	
    	$cardDefinition = array();
    	$cardDefinition['number']['value'] = $paymentInfo['creditcard']['number'];
    	$cardDefinition['expiration']['value'] = $paymentInfo['creditcard']['expirationDate'];
    	$cardDefinition['securityCode']['value'] = $paymentInfo['creditcard']['securityCode'];
    	$cardDefinition['ownerName']['value'] = $paymentInfo['creditcard']['holderName'];
    	$cardDefinition['ownerType']['value'] = 'PERSON';
    	$cardDefinition['ownerGender']['value'] = 'MALE';
    
    	$paymentDefinition['cardDefinition'] = $cardDefinition;
    	
    	$jsonParameters['flightInputDefinition']['paymentDefinition'] = $paymentDefinition;
    	
    	// voucherDefinitions
    	$jsonParameters['flightInputDefinition']['voucherDefinitions'] = array();
    	$jsonParameters['flightInputDefinition']['voucherDefinitions'][] = array('value' => $paymentInfo['voucher']['code']);
    	
    	return json_encode($jsonParameters);
    }

    private function getFormattedDate($dateArray) {
    	return $dateArray['year'] . '-' . str_pad($dateArray['month'], 2, "0", STR_PAD_LEFT) . '-' . str_pad($dateArray['day'], 2, "0", STR_PAD_LEFT);
    }
    
    
    /**
     * @Route("/update_flight_availability/{orderId}", name="update_flight_availability")
     * @Template(engine="php")
     */
    public function updateFlightAvailabilityAction($orderId) {
    	$logger = $this->get("logger");

    	$updateResult = $this->get('flights_helper')->updateFlightAvailability($orderId);
	
    	// si no se encontr— avisar
    	if($updateResult) {
    		$message = 'Vuelo encontrado y acutalizado.';
    		$response = array("result" => array('message' => $message, 'code' => 'SUCCESS'));
    		
    	} else {
    		$message = 'Vuelo NO encontrado.';
    		$response = array("result" => array('message' => $message, 'code' => 'ERROR'));

    	}
	    	
    	//$logger->debug(print_r($flight, true));
    	 
//     	} else {
//     		$message = 'Error en la bœsqueda.';
//     		$response = array("result" => array(
//     				'message' => $searchResult->errors[0]->code . ': ' . $searchResult->errors[0]->description ,
//     				'code' => 'ERROR'));
//     	}
    	
    	return new Response(json_encode($response));
    }
    

}
