<?php

namespace BtcTrip\HotelsBundle\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use BtcTrip\HotelsBundle\Document\PreOrder;
use BtcTrip\HotelsBundle\DependencyInjection\Autoincrement;
use \BtcTrip\HotelsBundle\DocumentManager\HotelSearchResultManager;
use \BtcTrip\HotelsBundle\DocumentManager\HotelPreOrderManager;

class CheckoutController extends Controller {	
   
    public function formAction(Request $request) {	
    	$currencyPrecision = array('BTC' => 4, 'XDG' => 0, 'LTC' => 2);
		$hManager = new HotelSearchResultManager($this->container); 
        $preOrdenHotelManager=new HotelPreOrderManager($this->container); 
                
		$iTicket=$request->get("sessionTicket");
        $room_id=$request->get("room_id");
                
        $logger = $this->get('logger');
		
        $preOrder = $preOrdenHotelManager->retrieveActivePreorder($iTicket);
        if (!$preOrder) {
        	$theResult = $hManager->retrieveActiveSearchResult($iTicket);
            if ($theResult){
				$preOrder = $preOrdenHotelManager->buildAndPersistPreorderHotelFromSearchResult($theResult, $iTicket,$room_id);
            }
		}
		if ($preOrder) {
            $totalPrice = $preOrder['room']['prices']['totalPrice']['totalPrice']; 
			$totalPriceWithoutTaxes = $preOrder['room']['prices']['totalPrice']['priceWithoutTax'];
            $averagePriceWitoutTaxes = $preOrder['room']['prices']['averagePricesPerNight']['avgDiscountPrice']['priceWithoutTax'];
            $averagePrice = $preOrder['room']['prices']['averagePricesPerNight']['avgDiscountPrice']['totalPrice'];
                    
            // sacando las comas separadoras de miles, como para tener numeros, vio?.
            $unformattedTotalPrice = str_replace(',', '', $totalPrice);
            $unformattedTotalPriceWithoutTaxes = str_replace(',', '', str_replace(',', '', $totalPriceWithoutTaxes));
            $unformattedAvgDiscountPrice = str_replace(',', '', $averagePrice);

            $exchangeRateService = $this->get('exchange_rate');
            $xchgRates = $exchangeRateService->getLastExchangeRates();
                    
            // Si es false ERROOORRR!!!
            if (isset($xchgRates)) {
            	$cryptoPrices = array();
            	
            	foreach ($xchgRates['rates'] as $rate) {
            		$cryptoPrice['totalPrice'] = round($unformattedTotalPrice / $rate['rate'], $currencyPrecision[$rate['code']]);
            		$cryptoPrice['totalPriceWithoutTaxes'] = round($unformattedTotalPriceWithoutTaxes / $rate['rate'], $currencyPrecision[$rate['code']]);
            		$cryptoPrice['avgPriceWithoutTax'] = round($unformattedAvgDiscountPrice / $rate['rate'], $currencyPrecision[$rate['code']]);
            		$cryptoPrice['currency'] = $rate['code'];
            			
            		$cryptoPrices[] = $cryptoPrice;
            	}
            	
                $passengersArray = $this->buildPassengersArray($preOrder);
                
                $responseParameters = array(
	                  'searchAgainUrl' => $preOrder['searchUrl'],
	                  'passengersArray' => $passengersArray,
	                  'info' => $preOrder['info'],
	                  'room' => $preOrder['room'],
	                  'totalPrice' => $totalPrice,
                      'searchParameters' => $preOrder['searchParameters'] ,
	                  'preOrderId' => $preOrder['_id'],
                      'cantidad_habitacion' => count(explode("!", $preOrder['searchParameters']['distribution'])),
                	  'cryptoPrices' => $cryptoPrices);
                            
                      $response = $this->render('BtcTripHotelsBundle:Checkout:form.html.php', $responseParameters);
                        
			} else {
            	$logger->error('No se pudo recuperar el bitpay exchange rate');
				$responseParameters = array('message' => 'At this time we couldn\'t retrieve the exchange rate. <br><br> Please, try in a few minutes or contact us at support@btctrip.com .');
				
				$response = $this->render('BtcTripHotelsBundle:Checkout:form_error.html.php', $responseParameters);
            }
		} else {
			// recuperar desde la sesion la ultima url de busqueda usada por el usuario.
            $lastSearchUrl = $this->get('session_manager')->getLastUserSearch();
            if ( $lastSearchUrl ) {
            	$responseParameters = array('message' => 'Your search has been expired. <br/><br/>Please update your <a href="'. $lastSearchUrl .'">search</a> to continue with the booking.');
			} else {
				$responseParameters = array('message' => 'Your search has been expired. <br/><br/>Please update your search to continue with the booking.');
            }
            $response = $this->render('BtcTripHotelsBundle:Checkout:error.html.php', $responseParameters);
		}
		return $response;
    
	}

	public function submitAction() {
		$logger = $this->get('logger');
		$logger->debug('Entrando al submitAction...');
		$session = $this->get('request')->getSession();
		$session->start();
		$sessionid = $session->getId();
		// levantar datos del formularios
		$request = $this->getCustomRequest();
        $preOrderId=$request['poi'];
        $preOrdenHotelManager=new HotelPreOrderManager($this->container); 
        $preorder=$preOrdenHotelManager->getById($preOrderId);
        
       if ( isset($preorder) ) {
			// en caso de que el usuario refresque el formulario de checkout y envie los datos del 
			// formulario por segunda vez, se pisaran.
			$preorder = $preOrdenHotelManager->updatePreOrder($preorder,$request);
 			
 			// pero no se pisa la bitpay invoice, que es �nica por preorder por lo que si existe se devuelve la misma.

			// si no existe la bitpay invoice, crearla, guardarla y enviarla
			if ( !isset($preorder['invoice']) ||
 				 (isset($preorder['invoice']) && $preorder['invoice']['currency'] != $request['paymentOption']) ) {
				
				$preorderId = (string)$preorder['orderNumber'];
				$posData = (string)$preorder['_id'];
			 	$totalPrice = $preorder['room']['prices']['totalPrice']['totalPrice'];
					
				$testingPrice = $this->container->getParameter('testing_price');
				if ($testingPrice) {
					$totalPrice = $totalPrice / 10000;
					$logger->info("ATENCION: USANDO EL PRECIO DE TESTING.");
					
					$preorderId = 'Test - ' . $preorderId;
				}
				
				// sacando las comas porque Bitpay no los usa.
				$unformattedTotalPrice = str_replace(',', '', $totalPrice);
		
				$invoice = $this->get('payment_manager')->retrieveOrCreateInvoice($request['paymentOption'], $preorderId, $unformattedTotalPrice, $posData, 'hotel');
				
				if (is_array($invoice)) {
                    $preorder = $preOrdenHotelManager->updatePreOrderWith($preorder, $invoice);
					$logger->debug('Invoice: ' . print_r($invoice, true));
		
					$response = array('success' => true, 'url' => $invoice['url'], 'gateway' => $invoice['gateway']);
				
				} else {
					$logger->error('No se pudo crear la invoice para la sessionid: ' . $sessionid);
					$response = array('success' => false, 'message' => 'At this moment, the invoice can\'t created. Please, try in a minutes.');
				}

			} // si existe devolver la existente
			else {
				$response = array('success' => true, 'url' => $preorder['invoice']['url'], 'gateway' => $preorder['invoice']['gateway']);
			}
			
		} else {
			$logger->error("No se encontr� la preOrder con Id: " . $preOrderId);
	
			$response =  array('success' => false, 'message' => 'Have been occurred an issue. Please try again in a moment or inform us at support@btctrip.com');
		}
	
		return new JsonResponse($response);
	}
	
	
	public function paymentAction() {
		$logger = $this->get('logger');
	
		$session = $this->get('request')->getSession();
		$session->start();
		$sessionid = $session->getId();
		
		$preorderid = $this->get('request')->get('poi');
		
		// levantar la Order
 		$collection = $this->get('mega_helper')->getCollection('Order');
 		$order = $collection->findOne(array('preOrderId' => $preorderid));
	
		// verificar que la factura est� paga
		if ( isset($order) ) {
			$responseParameters = array('order' => $order, 'cantidad_adultos' => $this->get('hotels_helper')->countAdults($order['item']));
			
			$response = $this->render('BtcTripHotelsBundle:Checkout:success.html.php', $responseParameters);
	
		} else {
			$logger->error('Aun no recibimos la notificacion de la invoice de Bitpay de la preOrderId: ' . $preorderid);
			
			$preOrderCollection = $this->get('mega_helper')->getCollection('PreOrderHotel');
			$preOrder = $preOrderCollection->findOne(array('_id' => new \MongoId($preorderid)));
	
			if (isset($preOrder)) {
				$responseParameters = array('success' => false, 'message' => 'BTCTrip still didn\'t receive the Bitpay payment notification. <br><br>Please contact us at support@btctrip.com with the BTCTrip booking number <b>' . $preOrder['orderNumber'] . '</b>.');
			} else {
				$responseParameters = array('success' => false, 'message' => 'BTCTrip still didn\'t receive the Bitpay payment notification. <br><br>Please contact us at support@btctrip.com.');
			}
			
			$response = $this->render('BtcTripHotelsBundle:Checkout:error.html.php', $responseParameters);
		}
	
		return $response;
	}
	
	
	// por la imposibilidad de parse_str de manejar los nombres de variables con . los reemplazo por corchetes
	private function getCustomRequest() {
		$content = $this->get('request')->getContent();
                $decoded = urldecode($content);
		
		$source = array('.value', '.firstName', '.lastName','.contactFullName', '.emailRepeat', '.email', '.phoneDefinitions',
						'.type', '.countryCode', '.areaCode', '.number', '.codes');
		$target = array('', '[firstName]', '[lastName]','[contactFullName]', '[emailRepeat]', '[email]', '[phoneDefinitions]',
						'[type]', '[countryCode]', '[areaCode]', '[number]', '[codes]');
		
		$touched = str_replace($source, $target, $decoded);
		parse_str($touched, $ladata);

		return $ladata;		
	}
	
	private function buildPassengersArray($preOrder) {
		$distribution = $preOrder['searchParameters']['distribution'];
		$array_distribution = explode("!", $distribution);
		$cantidad_habitacion = count($array_distribution);
		
        $adultsCount = $array_distribution[0];

		if ($cantidad_habitacion > 1){
        	foreach($array_distribution as $h){
            	$text = explode("-", $h);
				$adultsCount = $adultsCount + $text[0];
			}
        }
        
        $passengersArray['adult'] = count($array_distribution);
		
        return $passengersArray;
	}
	
}


