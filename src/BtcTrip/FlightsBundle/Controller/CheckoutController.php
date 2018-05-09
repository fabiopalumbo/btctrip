<?php

namespace BtcTrip\FlightsBundle\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use BtcTrip\FlightsBundle\Document\PreOrder;


/**
 * @Route("/checkout")
 */
class CheckoutController extends Controller {

	//
	// Compra
	//
	// http://www.us.despegar.com/shop/flights/checkouthandler/1544442388/1/-188658471/0/GDS/INTERNATIONAL
	// /shop/flights/checkouthandler/{hash}/{version}/{itineraryId}/{clusterIndexTraking}/{provider}/INTERNATIONAL'
	// 
	//
	
	
	/**
	 * @Route("/form/{iHash}/{iVersion}/{iItineraryId}/{iClusterIndexTraking}/{sType}", 
	 		name="checkout_form")
	 * @Method({"GET"})
	 * @Template(engine="php")	 		
	 */
	public function formAction($iHash, $iVersion, $iItineraryId, $iClusterIndexTraking, $sType) {	
		$logger = $this->get('logger');
		
		$sessionid = $this->get('session_manager')->getSession()->getId();

		// consultar por si hay alguna PreOrder activa
		$preOrder = $this->retrieveActivePreorder($sessionid, $iHash, $iVersion, $iItineraryId);
		
		if ( !$preOrder ) {
			$theResult = $this->retrieveActiveSearchResult($sessionid, $iHash);
			
			if ( $theResult ) {
                /**
                 * TRAVELPORT
                 */
                // despegar or travelport?
                if(substr_count($iItineraryId, '_') == 3) {
                    $tmpItineraryArray = explode('_', $iItineraryId);
                    $itineraryIdArray = array(
                        'recommendationId' => $tmpItineraryArray[0],
                        'fareId' => $tmpItineraryArray[1],
                        'options' => array(
                            $tmpItineraryArray[2],
                            $tmpItineraryArray[3],
                        ),
                    );
                    $requiredFields = $this->get('btctrip_api')->bookingFlightsFields($theResult['metadata']['ticket']['id'], $itineraryIdArray);
                } else {
                    $requiredFields = $this->get('btctrip_api')->bookingFlightsFields($theResult['metadata']['ticket']['id'], $iItineraryId);
                }
                /**
                 * END TRAVELPORT
                 */
				
				if (!isset($requiredFields->errors) && (@$requiredFields->TransactionCode != 1402)) {
					$preOrder = $this->buildAndPersistPreorderFromSearchResult($theResult, $iItineraryId, $iClusterIndexTraking, $sessionid, $requiredFields->data);
				} else {
					$logger->error("Error consultando los campos requeridos.");
					$logger->error(print_r($requiredFields, true));
				}
				
			}
		}
		
		if ( $preOrder ) {
			$passengersArray = $this->buildPassengersArray($preOrder);
			$isDocumentsRequired = isset($preOrder['requiredFields']['flightInputDefinition']['passengerDefinitions'][0]['nationality']);

            // travelport patch to request id if needed.
			$isDocumentsRequired = $isDocumentsRequired || isset($preOrder['requiredFields']['Passengers'][0]);
			
			$responseParameters = array(
					'searchAgainUrl' => $preOrder['search']['url'],
					'passengersArray' => $passengersArray,
					'outboundRoute' => $preOrder['outboundRoute'],
					'inboundRoute' => $preOrder['inboundRoute'],
					'itenerariesBoxPriceInfoList' => $preOrder['itenerariesBoxPriceInfoList'],
					'preOrderId' => $preOrder['_id'],
					'isDocumentsRequired' => $isDocumentsRequired);
		
			$response = $this->render('BtcTripFlightsBundle:Checkout:form.html.php', $responseParameters);

		} else {
            // travelport error. cannot confirm flight and get required fields.
            if(isset($requiredFields->TransactionCode)) {
                if($requiredFields == 1402) {
                    $responseParameters = array('message' => 'The flight you tried to buy isn\'t available right now. <br/><br/>Please choose another flight. Go back to your <a href="'. $lastSearchUrl .'">search</a> to continue with the booking.');
                }
            }
            // end tp error.
            
			// recuperar desde la sesion la ultima url de busqueda usada por el usuario.
			$lastSearchUrl = $this->get('session_manager')->getLastUserSearch();
			
			if ( $lastSearchUrl ) {
				$responseParameters = array('message' => 'Your search has been expired. <br/><br/>Please update your <a href="'. $lastSearchUrl .'">search</a> to continue with the booking.');
			} else {
				$responseParameters = array('message' => 'This flight offer has expired. <br/><br/>Please update your search to continue with the booking.');
			}
			
			$response = $this->render('BtcTripFlightsBundle:Checkout:error.html.php', $responseParameters);
		}
		
		return $response;
	}


	/**
	 * @Route("/form", name="checkout_form_submit")
	 * @Method({"POST"})
	 */
	public function submitAction() {
		$logger = $this->get('logger');
	
		$logger->debug('Entrando al submitAction...');
	
		$session = $this->get('request')->getSession();
		$session->start();
		$sessionid = $session->getId();
	
		// levantar datos del formularios
		$request = $this->getCustomRequest();
	
		$preOrderId = $request['poi'];
	
		// puede haber muchas PreOrders para una misma sesion y cada PreOrder tiene una unica BitpayInvoice
		// cada PreOrder dura 15 minutos y tiene una unica BitpayInvoice que se crea cuando el usuario presiona el boton Pay.
		// si cierra el popup y lo vuelve a abrir se mostrara la misma BitpayInvoice creada antes.
	
		// recuparar la preOrder para agregarle los paxs
		$collection = $this->get('mega_helper')->getCollection('PreOrder');
		$preorder = $collection->findOne(array('_id' => new \MongoId($preOrderId), 'sessionId' => $sessionid));
	
		if ( isset($preorder) ) {
			
			// en caso de que el usuario refresque el formulario de checkout y envie los datos del 
			// formulario por segunda vez, se pisaran.
			$preorder['buyerInfo'] = $request;

 			$collection = $this->get('mega_helper')->getCollection('PreOrder');
 			$collection->save($preorder);

			// pero no se pisa la bitpay invoice, que es œnica por preorder por lo que si existe se devuelve la misma.

			// si no existe la invoice, crearla, guardarla y enviarla
 			if ( !isset($preorder['invoice']) ||
 				 (isset($preorder['invoice']) && $preorder['invoice']['currency'] != $request['paymentOption']) ) {
				
				$preorderId = (string)$preorder['orderNumber'];
				$posData = (string)$preorder['_id'];
			 	$totalPrice = $preorder['itenerariesBoxPriceInfoList'][0]['total']['fare']['formatted']['amount'];
					
				$testingPrice = $this->container->getParameter('testing_price');
				if ($testingPrice) {
// 					$totalPrice = $totalPrice / 10000;
					$totalPrice = "0.01";
					$logger->info("ATENCION: USANDO EL PRECIO DE TESTING.");
					
					$preorderId = 'Test - ' . $preorderId;
				}
				
				// sacando las comas porque Bitpay no los usa.
				$unformattedTotalPrice = str_replace(',', '', $totalPrice);

				$invoice = $this->get('payment_manager')->retrieveOrCreateInvoice($request['paymentOption'], $preorderId, $unformattedTotalPrice, $posData, 'flight');
				
				if (isset($invoice)) {
					$preorder['invoice'] = $invoice;
					$collection->save($preorder);
					
					$response = array('success' => true, 'url' => $invoice['url'], 'gateway' => $invoice['gateway']);
				} else {
					$logger->error('No se pudo crear la bitpay invoice para la sessionid: ' . $sessionid);
					$response = array('success' => false, 'message' => 'At this moment, the invoice can\'t created. Please, try in a minutes.');
				}
		
			} 
			// si es la misma que vio en el ultimo request devolverle esa
			else {
				$response = array('success' => true, 'url' => $preorder['invoice']['url'], 'gateway' => $preorder['invoice']['gateway']);
			}
			
		} else {
			$logger->error("No se encontr— la preOrder con Id: " . $preOrderId);
	
			$response =  array('success' => false, 'message' => 'Have been occurred an issue. Please try again in a moment or inform us at support@btctrip.com');
		}
	
		return new JsonResponse($response);
		
	}
	
	/**
	 * @Route("/payment", name="checkout_form_payment_notification")
	 * @Method({"POST"})
	 */
	public function paymentAction() {
		$logger = $this->get('logger');
	
		$session = $this->get('request')->getSession();
		$session->start();
		$sessionid = $session->getId();
		
		$preorderid = $this->get('request')->get('poi');
		
		// levantar la Order
 		$collection = $this->get('mega_helper')->getCollection('Order');
 		$order = $collection->findOne(array('preOrderId' => $preorderid));
	
		// verificar que la factura estŽ paga
		if ( isset($order) ) {
			$responseParameters = array('order' => $order);
			
			$response = $this->render('BtcTripFlightsBundle:Checkout:success.html.php', $responseParameters);
	
		} else {
			$logger->error('Aun no recibimos la notificacion de la invoice de Bitpay de la preOrderId: ' . $preorderid);
			
			$preOrderCollection = $this->get('mega_helper')->getCollection('PreOrder');
			$preOrder = $preOrderCollection->findOne(array('_id' => new \MongoId($preorderid), 'sessionId' => $sessionid));
	
			if (isset($preOrder)) {
				$responseParameters = array('success' => false, 'message' => 'BTCTrip still didn\'t receive the Bitpay payment notification. <br><br>Please contact us at support@btctrip.com with the BTCTrip booking number <b>' . $preOrder['orderNumber'] . '</b>.');
			} else {
				$responseParameters = array('success' => false, 'message' => 'BTCTrip still didn\'t receive the Bitpay payment notification. <br><br>Please contact us at support@btctrip.com.');
			}
			
			$response = $this->render('BtcTripFlightsBundle:Checkout:error.html.php', $responseParameters);
		}
	
		return $response;
	}
	
	
	// por la imposibilidad de parse_str de manejar los nombres de variables con . los reemplazo por corchetes
	private function getCustomRequest() {
		$content = $this->get('request')->getContent();
		$decoded = urldecode($content);
		
		$source = array('.value', '.firstName', '.lastName', '.nationality', '.documentDefinition.type', '.documentDefinition.number', 
						'.birthday.day','.birthday.month','.birthday.year','.gender',
						'.contactFullName', '.emailRepeat', '.email', '.phoneDefinitions',
						'.type', '.countryCode', '.areaCode', '.number', '.codes');
		$target = array('', '[firstName]', '[lastName]','[nationality]','[documentDefinition][type]','[documentDefinition][number]',
						'[birthday][day]','[birthday][month]','[birthday][year]','[gender]',
						'[contactFullName]', '[emailRepeat]', '[email]', '[phoneDefinitions]',
						'[type]', '[countryCode]', '[areaCode]', '[number]', '[codes]');
		
		$touched = str_replace($source, $target, $decoded);
		parse_str($touched, $ladata);
		
		return $ladata;		
	}
	
	/**
	 * Toma un timestamp y devuelve si se creo hace m‡s de 15 minutos
	 */
	private function isActiveTimestamp($sessionTimestamp) {
		
		$referenceDate = new \DateTime('now');
		// TODO: parametrizar los minutos de expiracion de la sesion
		$referenceDate->modify("-15 minute"); 

		$sessionDate = new \DateTime('@'.$sessionTimestamp);
		$sessionDate->setTimezone(new \DateTimeZone(date_default_timezone_get()));
		
		return $sessionDate > $referenceDate;
	}
	
	
	private function buildPassengersArray($preOrder) {
		$adultsCount = $preOrder['itenerariesBoxPriceInfoList'][0]['adult']['quantity'];
		for ($p=0; $p<$adultsCount; $p++) {
			$passengersArray[] = array('adult', $p);
		}
			
		if ($preOrder['itenerariesBoxPriceInfoList'][0]['child'] != null ) {
			$childsCount = $preOrder['itenerariesBoxPriceInfoList'][0]['child']['quantity'];
			for ($p=0; $p<$childsCount; $p++) {
				$passengersArray[] = array('child', $p);
			}
		}
		
		if ($preOrder['itenerariesBoxPriceInfoList'][0]['infant'] != null ) {
			$infantCount = $preOrder['itenerariesBoxPriceInfoList'][0]['infant']['quantity'];
			for ($p=0; $p<$infantCount; $p++) {
				$passengersArray[] = array('infant', $p);
			}
		}
		
		return $passengersArray;
	}
	
	private function retrieveActivePreorder($sessionid, $iHash, $iVersion, $iItineraryId) {
		$collection = $this->get('mega_helper')->getCollection('PreOrder');
		
		// TODO: revisar el criterio por el cual se busca la preorder activa
		// si se eligio otro vuelo distinto al encontrado antes es una nueva preorder!!!!
		$preorderCursor = $collection->find(array('sessionId' => $sessionid, 'metadata.ticket.hash' => $iHash, 
													'metadata.ticket.version' => $iVersion, 'itineraryId' => $iItineraryId))
									->sort(array('_id' => -1))
									->limit(1);
		
		if ($preorderCursor->hasNext()) {
			$preorder = $preorderCursor->getNext();	

			// chequear vigencia de preorder menor a 15 minutos de vida.
			if ( !$this->isActiveTimestamp($preorder['_id']->getTimestamp()) ) {
				$preorder = false;
			}
			
		} else {
			$preorder = false; 
		}
		
		return $preorder;
	}

	private function retrieveActiveSearchResult($sessionid, $iHash) {
		$theResultCursor = $this->get('flights_search_manager')->getLastSearch($sessionid, $iHash);
		
		if ( $theResultCursor->hasNext() ) {
			$theResult = $theResultCursor->getNext();
			
			if ( !$this->isActiveTimestamp($theResult['_id']->getTimestamp()) ) {
				$theResult = false;
			}
			
		} else {
			$theResult = false;
		}
		
		return $theResult;
	}
	
	private function buildAndPersistPreorderFromSearchResult($theResult, $iItineraryId, $iClusterIndexTraking, $sessionid, $requiredFields) {
		$preOrder = false;

        /*
        $theItem = $theResult['items'][$iClusterIndexTraking];
		$matchingInfoMaps = $theItem['itinerariesBox']['matchingInfoMap'];
         */
			
        foreach($theResult['items'] as $theItem) {
            $matchingInfoMaps = $theItem['itinerariesBox']['matchingInfoMap'];

		foreach ($matchingInfoMaps as $key => $matchingInfo) {
			if($matchingInfo['id'] == $iItineraryId) {
				
				$pieces = explode("_", $key);
				$outboundIndex = $pieces[1];
				
				// ATENTI! : Si inboundIndex es -1 es un pasaje ONEWAY y no tiene inbound routes
				// 			 el inboundRoute queda indefinido
				$inboundIndex = $pieces[2];
				
                // TODO: check inboundroute thing.
				$preOrder = array();
				$preOrder['sessionId'] = $sessionid;
				$preOrder['orderNumber'] = $this->generateOrderNumber();
				$preOrder['outboundRoute'] = $theItem['itinerariesBox']['outboundRoutes'][$outboundIndex];
				$preOrder['inboundRoute'] = ($inboundIndex != -1) ? $theItem['itinerariesBox']['inboundRoutes'][$inboundIndex] : null;
				$preOrder['itenerariesBoxPriceInfoList'] = $theItem['itinerariesBox']['itinerariesBoxPriceInfoList'];
				$preOrder['search'] = $theResult['search'];
				$preOrder['itineraryId'] = $iItineraryId;
				$preOrder['wishList'] = $matchingInfo['wishList'];
				$preOrder['metadata'] = $theResult['metadata'];
				$preOrder['requiredFields'] = json_decode(json_encode($requiredFields), true);
				
				$poCollection = $this->get('mega_helper')->getCollection('PreOrder');
				$poCollection->save($preOrder);
			}
		}
        }
		
		return $preOrder;
	}
	
	// TODO: esto debe ir en el Manager o Dao de la order
	private function generateOrderNumber() {
		$autoincrementer = $this->get('autoincrement');
		$nextNumber = $autoincrementer->getNext('Order');
		
		return $nextNumber;
	}
	
}


