<?php

namespace BtcTrip\FlightsBundle\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/ph")
 */
class PaymentHandlerController extends Controller
{

	/**
	 *  @ Route("/updateInvoceStatus/{preorderid}/{status}", name="payment_handler_pay_preorder")
	 */
	private function updateAndReturnInvoceStatus($preorderid, $status) {	
		$logger = $this->get('logger');
		$collection = $this->get('mega_helper')->getCollection('BitpayInvoice');
		
		$invoce = $collection->findOne(array('posData' => new \MongoRegex("/".$preorderid."/")));
		
		if (isset($invoce)) {
			
			$invoce['status'] = $status;
			
			$collection->save($invoce);
			
			$retval = $invoce;

		} else {
			$logger->error("No se encontro bitpayInvoce de alguna preOrder con sessionid: " . $preorderid);

			$retval = false;
		} 
		
		return $retval;
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

        $logger->info(print_r($response, true));


		if (isset($response['error'])) {
			$logger->error($response);
		} else {
			$preorderid = $response['posData'];

			$bitpayInvoice = $this->updateAndReturnInvoceStatus($preorderid, $response['status']);
			
			$logger->info('Actualizacion del estado de la invoce de la preorden ' . $preorderid . ' -> ' . $response['status'] );
			
			// TODO: evaluar otros chequeos de seguridad, aca o cuando se verifica la notificacion.
			
			// Bitpay envia varias notificaciones de paid y la Order se crea con la primera
			if ($response['status'] == 'paid' && !$this->existsOrder($preorderid)) {
				// Crear Order a partir de la PrePrder
				$order = $this->createAndPersistOrder($preorderid);
				
				// notificar al usuario y a nos
				if ($order) {
					$this->get('remailer')->sendPaymentConfirmation($order, $bitpayInvoice);
				} else {
					$message = 'Error grave creando order para la preOrder id:' . $preorderid;
					
					$logger->error($message);
					$this->get('remailer')->sendEmailToAdmins($message, 'A revisar los logs!');
				}
			}
		}

		return new Response('Thanks!');
	}

	/**
	 * Crea una Order a partir de la ProOrder con el id preorderid.
	 * 
	 * @param string $preorderid
	 * @return multitype:|boolean
	 */
	private function createAndPersistOrder($preorderid) { 

		$preOrderCollection = $this->get('mega_helper')->getCollection('PreOrder');
		$preorder = $preOrderCollection->findOne(array('_id' => new \MongoId($preorderid)));
		
		if ( isset($preorder) ) {
			// generar la orden de reserva, organizando un poco el modelo
			$order = array();
			$order['number'] = $preorder['orderNumber'];
			$order['type'] = 'flight';
			$order['status'] = 'recieved';
			$order['preOrderId'] = $preorderid;
			$order['sessionId'] = $preorder['sessionId'] ;
			$order['requiredFields'] = $preorder['requiredFields'];
			$order['bitpayInfoId'] = $preorder['bitpayInfoId'];
			$order['buyerInfo'] = $preorder['buyerInfo'];
			
			$order['itinerary']['outboundRoute'] = $preorder['outboundRoute'];
			$order['itinerary']['inboundRoute'] = $preorder['inboundRoute'];
			$order['itinerary']['itenerariesBoxPriceInfoList'] = $preorder['itenerariesBoxPriceInfoList'];
			$order['itinerary']['search'] = $preorder['search'];
			$order['itinerary']['metadata'] = $preorder['metadata'];
			$order['itinerary']['id'] = $preorder['itineraryId'];
			$order['itinerary']['wishList'] = $preorder['wishList'];
			
			$orderCollection = $this->get('mega_helper')->getCollection('Order');
			$orderCollection->save($order);
			
			return $order;
			
		}  else {
			return false;
		}
		
	}
	
	private function existsOrder($preorderid) {
		$orderCollection = $this->get('mega_helper')->getCollection('Order');
		$order = $orderCollection->findOne(array('preOrderId' => $preorderid));
		
		return isset($order);
	}	
	
}
