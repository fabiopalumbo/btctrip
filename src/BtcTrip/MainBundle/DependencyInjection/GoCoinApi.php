<?php

namespace BtcTrip\MainBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Interfaz BTCTrip - API de GoCoin 
 *
 */
class GoCoinApi {
	protected $container;
	protected $token;
	protected $clientId;
	protected $clientSecret;
	protected $merchantId;
	protected $callbackUrl;
	
	
	public function __construct(ContainerInterface $container, $token, $notificationURL, $clientId, $clientSecret, $merchantId) {
		$this->container = $container;
		$this->token = $token;
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
		$this->merchantId = $merchantId;
		$this->callbackUrl = $this->container->get('router')->getContext()->getScheme() . '://' . 
					$this->container->get('router')->getContext()->getHost() . 
					$this->container->get('router')->generate('payment_handler_gc_notification');
	}
	
	
	public function createInvoice($currency, $orderId, $price, $posData, $orderType, $options = array()) {	
		$logger = $this->container->get('logger');
		
		$data = '{"posData": "' . $posData . '"';
		$data .= ', "orderType": "' . $orderType . '"}';
		
		//create a new invoice
		$parameters = array(
				'order_id' => $orderId,
				'price_currency' => $currency,
				'base_price' => $price,
				'base_price_currency' => 'USD',
				'notification_level' => 'all',
				'confirmations_required' => 1,
				'data' => $data,
				'callback_url' => $this->callbackUrl
		);
		$new_invoice = \GoCoin::createInvoice($this->token, $this->merchantId, $parameters);

		$logger->info('GoCoin invoice: ' . print_r($new_invoice, true));
	
		return $new_invoice;
	}
	
	// Call from your notification handler to convert $_POST data to an object containing invoice data
	public function verifyNotification() {
		$post = file_get_contents("php://input");
		if (!$post)
			return 'No post data';
			
		$postData = json_decode($post, true);
		
		// TODO: chequear tipo de evento y proceder a consecuencia
		
		$laData = json_decode($postData['payload']['data'], true);
		
// 		TODO: Verify notification segun: http://help.gocoin.com/kb/setup-integration/verify-webhook-authenticity-create-a-signature
// 		if($this->bpOptions['verifyPos'] and $laData['hash'] != crypt($laData['posData'], $apiKey))
// 			return 'authentication failed (bad hash)';
		
		$json['posData'] = $laData['posData'];
		$json['orderType'] = $laData['orderType'];
		$json['status'] = $postData['payload']['status'];
		
		return $json;
	}
	
	public function getInvoice($invoiceId) {
		
		return $response;	
	}
		
	public function getExchangeRates() {
		$exchangeRates = \GoCoin::getExchangeRates();
		
		return $exchangeRates;
	}
		
}