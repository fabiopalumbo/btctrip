<?php

namespace BtcTrip\MainBundle\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use \BtcTrip\APIBtcTripBundle\Classes\TravelportApi as TravelportApi;

/**
 * @Route("/ph")
 */
class PaymentHandlerController extends Controller
{

	/**
	 *  @ Route("/updateInvoceStatus/{preorderid}/{status}", name="payment_handler_pay_preorder")
	 */
	private function updateAndReturnInvoceStatusBitpay($preorderid, $orderType, $status) {	
		$logger = $this->get('logger');
		$collection = $this->get('mega_helper')->getCollection('BitpayInvoice');
		
		$invoce = $collection->findOne(array('posData' => new \MongoRegex("/".$preorderid.".*".$orderType."/")));
		
		if (isset($invoce)) {
			
			$invoce['status'] = $status;
			
			$collection->save($invoce);
			
			$retval = $invoce;

		} else {
			$logger->error("No se encontro bitpayInvoce de alguna preOrder con id: " . $preorderid);

			$retval = false;
		} 
		
		return $retval;
	}

	private function updateAndReturnInvoceStatusGocoin($preorderid, $orderType, $status) {
		$logger = $this->get('logger');
		$collection = $this->get('mega_helper')->getCollection('GocoinInvoice');
	
		$invoce = $collection->findOne(array('data' => new \MongoRegex("/".$preorderid.".*".$orderType."/")));
	
		if (isset($invoce)) {
				
			$invoce['status'] = $status;
				
			$collection->save($invoce);
				
			$retval = $invoce;
	
		} else {
			$logger->error("No se encontro GocoinInvoce de alguna preOrder con id: " . $preorderid);
	
			$retval = false;
		}
	
		return $retval;
	}
	
	/**
	 * @Route("/gcNotification", name="payment_handler_gc_notification")
	 * @Method({"POST"})
	 */
	public function gcNotificationHandlerAction() {
		$logger = $this->get('logger');
	
		$logger->info('Entrando al NotificationHandler de GoCoin...');
	
		$gocoinService = $this->get('go_coin_api');
		
		$response = $gocoinService->verifyNotification();
		
		// TODO: chequear resultado correcto		
		$preorderid = $response['posData'];
		$orderType = $response['orderType'];
		
		$gocoinInvoice = $this->updateAndReturnInvoceStatusGocoin($preorderid, $orderType, $response['status']);
			
		$logger->info('Actualizacion del estado de la invoce de la preorden type: ' . $orderType . ', id: ' . $preorderid . ' -> ' . $response['status'] );
			
		// TODO: evaluar otros chequeos de seguridad, aca o cuando se verifica la notificacion.
			
		// Bitpay envia varias notificaciones de paid y la Order se crea con la primera
		if ($response['status'] == 'paid' && !$this->existsOrder($preorderid, $orderType)) {
			// Crear Order a partir de la PrePrder
			$order = $this->createAndPersistOrder($preorderid, $orderType);
		
			// notificar al usuario y a nos
			if ($order) {
				$this->get('remailer')->sendPaymentConfirmation($order);

                // realiza la reserva.
                $this->bookFlight($order);
			} else {
				$message = 'Error grave creando order para la preOrder type: ' . $orderType . ', id:' . $preorderid;
					
				$logger->error($message);
				$this->get('remailer')->sendEmailToAdmins($message, 'A revisar los logs!');
			}
		}
		
		
		return new Response('Thanks!');
	}
	
	/**
	 * @Route("/bpNotification", name="payment_handler_bp_notification")
	 * @Method({"POST"})
	 */
	public function bpNotificationHandlerAction() {
		$logger = $this->get('logger');

        $logger->info('Entrando al NotificationHandler...');

        $bitpayService = $this->get('bit_pay_api');
                
        $response = $bitpayService->bpVerifyNotification();

		if (isset($response['error'])) {
			$logger->error($response);
		} else {
			$preorderid = $response['posData'];
			$orderType = $response['orderType'];

			$bitpayInvoice = $this->updateAndReturnInvoceStatusBitpay($preorderid, $orderType, $response['status']);
			
			$logger->info('Actualizacion del estado de la invoce de la preorden type: ' . $orderType . ', id: ' . $preorderid . ' -> ' . $response['status'] );
			
			// TODO: evaluar otros chequeos de seguridad, aca o cuando se verifica la notificacion.
			
			// Bitpay envia varias notificaciones de paid y la Order se crea con la primera
			if ($response['status'] == 'paid' && !$this->existsOrder($preorderid, $orderType)) {
				// Crear Order a partir de la PrePrder
				$order = $this->createAndPersistOrder($preorderid, $orderType);
				
				// notificar al usuario y a nos
				if ($order) {
					$this->get('remailer')->sendPaymentConfirmation($order);

                    // realiza la reserva.
                    $this->bookFlight($order);
				} else {
					$message = 'Error grave creando order para la preOrder type: ' . $orderType . ', id:' . $preorderid;
					
					$logger->error($message);
					$this->get('remailer')->sendEmailToAdmins($message, 'A revisar los logs!');
				}
			}
		}

		return new Response('Thanks!');
	}

    protected function bookFlight($order) {
        $itineraryId = $order['itinerary']['id'];
        if(substr_count($itineraryId, '_') == 3) {
            $this->bookTravelport($order);
        } else {
        }
        return true;
    }

    protected function ageFromBday($bday) {
        $then = date('Ymd', strtotime($bday));
        $diff = date('Ymd') - $then;
        return substr($diff, 0, -4);
    }

    protected function bookTravelport($order) {
		$logger = $this->get('logger');

        $itineraryId = $order['itinerary']['id'];
        $tmpItineraryArray = explode('_', $itineraryId);

        if(!empty($tmpItineraryArray[3])) {
            $options = array(
                $tmpItineraryArray[2],
                $tmpItineraryArray[3],
            );
        } else {
            $options = array(
                $tmpItineraryArray[2],
            );
        }

        $travelportApi = new TravelportApi($logger);
        $confResponse = $travelportApi->confirmFlightAvailability($tmpItineraryArray[0], $tmpItineraryArray[1], $options);

        if(empty($confResponse->BookingFare)) {
            // TODO: ERROR
            return false;
        }

        // create passenger array
        $passengerArray = array();
        $psgIdx = 1;
        $psgGender = '';
        foreach($order['buyerInfo']['passengerDefinitions'] as $passenger) {
            switch($passenger['gender']) {
                case 'MALE':
                    $psgGender = 'MR';
                    break;
                default:
                    $psgGender = 'MS';
                    break;
            }

            $bday = $passenger['birthday']['year'] . '-' . str_pad($passenger['birthday']['month'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($passenger['birthday']['day'], 2, '0', STR_PAD_LEFT);
            switch($this->ageFromBday($bday)) {
                case ($this->ageFromBday($bday) < 2):
                    $psgType = 'INF';
                    break;
                case (($this->ageFromBday($bday) >= 2) && ($this->ageFromBday($bday) < 12)):
                    $psgType = 'CHD';
                    break;
                default:
                    $psgType = 'ADT';
                    break;
            }

            $passengerArray[] = array(
                'Type' => $psgType,
                'SubType' => '',
                'Number' => $psgIdx,
                'FirstName' => $passenger['firstName'],
                'LastName' => $passenger['lastName'],
                'DateOfBirth' => $bday,
                'Gender' => $psgGender,
                //'RequiredInformations' => $requiredInfo,
            );

            $psgIdx++;
        }

        $params = array(
            'TransactionID' => $confResponse->TransactionID,
            'TransactionCode' => $confResponse->TransactionCode,
            'TransactionMessage' => $confResponse->TransactionMessage,
            'RecommendationID' => $confResponse->RecommendationID,
            'BookingFare' => $confResponse->BookingFare,
            'Passengers'=> $passengerArray,
            'Buyer' => array(
                'LastName' => 'BtcTrip',
                'FirstName' => 'BtcTrip',
                'Telephone' => '61275705',
                'TelephoneCountry' => '54',
                'TelephoneArea' => '911',
                'Email' => 'martin@btctrip.com',
                'City' => 'Miami Beach',
                'StreetAddress' => '2609 Collins Ave',
                'ZipCode' => '33140',
                'State' => 'FL',
                'Country' => 'US',
            ),
        );

        $response = $travelportApi->bookFlight($params);

    }

	/**
	 * Crea una Order a partir de la ProOrder con el id preorderid.
	 * 
	 * @param string $preorderid
	 * @return multitype:|boolean
	 */
	private function createAndPersistOrder($preorderid, $orderType) { 
		$collectionNames = array('flight' => 'PreOrder', 'hotel' => 'PreOrderHotel');
		
		$preOrderCollection = $this->get('mega_helper')->getCollection($collectionNames[$orderType]);
		$preorder = $preOrderCollection->findOne(array('_id' => new \MongoId($preorderid)));
		
		if ( isset($preorder) ) {
			// generar la orden de reserva, organizando un poco el modelo
			$order = array();
			$order['number'] = $preorder['orderNumber'];
			$order['type'] = $orderType;
			$order['status'] = 'recieved';
			$order['preOrderId'] = $preorderid;
			// $order['bitpayInfoId'] = $preorder['bitpayInfoId'];
			$order['invoice'] = $preorder['invoice'];
			$order['buyerInfo'] = $preorder['buyerInfo'];
			
			if ($orderType == 'flight') {
				$order['sessionId'] = $preorder['sessionId'] ;
				$order['requiredFields'] = $preorder['requiredFields'];
				
				$order['itinerary']['outboundRoute'] = $preorder['outboundRoute'];
				$order['itinerary']['inboundRoute'] = $preorder['inboundRoute'];
				$order['itinerary']['itenerariesBoxPriceInfoList'] = $preorder['itenerariesBoxPriceInfoList'];
				$order['itinerary']['search'] = $preorder['search'];
				$order['itinerary']['metadata'] = $preorder['metadata'];
				$order['itinerary']['id'] = $preorder['itineraryId'];
				$order['itinerary']['wishList'] = $preorder['wishList'];
				
			} else if ($orderType == 'hotel') {
 				$order['item']['hotel'] = $preorder['hotel'];
 				$order['item']['hotel']['room'] = $preorder['room'];
 				$order['item']['metadata'] = $preorder['metadata'];
 				$order['item']['metadata']['ticket'] = $preorder['ticket'];
 				$order['item']['search']['url'] =  $preorder['searchUrl'];
 				$order['item']['search']['parameters'] = $preorder['searchParameters'];
				
			} else {
				return false;
			}
			
			$orderCollection = $this->get('mega_helper')->getCollection('Order');
			$orderCollection->save($order);
			
			return $order;
			
		}  else {
			return false;
		}
		
	}
	
	private function existsOrder($preorderid, $orderType) {
		$orderCollection = $this->get('mega_helper')->getCollection('Order');
		$order = $orderCollection->findOne(array('preOrderId' => $preorderid, 'type' => $orderType));
		
		return isset($order);
	}	
	
}
