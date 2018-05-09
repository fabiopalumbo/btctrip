<?php

namespace BtcTrip\FlightsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Servicio de BitPay generado a partir de: bitpay-php-client-b731b00
 *
 */
class BitPayApi {
	protected $container;
	
	private $bpOptions = array();
	
	public function __construct(ContainerInterface $container, $bpApiKey, $bpNotificationURL, $bpNotificationEmail) {
		$this->container = $container;
	
		// Please look carefully through these options and adjust according to your installation.  
		// Alternatively, most of these options can be dynamically set upon calling the functions in bp_lib.
		
		
		// REQUIRED Api key you created at bitpay.com
		// example: $bpOptions['apiKey'] = 'L21K5IIUG3IN2J3';
		$this->bpOptions['apiKey'] = $bpApiKey;
		
		// whether to verify POS data by hashing above api key.  If set to false, you should
		// have some way of verifying that callback data comes from bitpay.com
		// note: this option can only be changed here.  It cannot be set dynamically. 
		$this->bpOptions['verifyPos'] = true;
		
		// email where invoice update notifications should be sent
		$this->bpOptions['notificationEmail'] = $bpNotificationEmail;
		
		// url where bit-pay server should send update notifications.  See API doc for more details.
		# example: $bpNotificationUrl = 'http://www.example.com/callback.php';
		$this->bpOptions['notificationURL'] = $bpNotificationURL;
		
		// url where the customer should be directed to after paying for the order
		# example: $bpNotificationUrl = 'http://www.example.com/confirmation.php';
		$this->bpOptions['redirectURL'] = '';
		
		// This is the currency used for the price setting.  A list of other pricing
		// currencies supported is found at bitpay.com
		// $bpOptions['currency'] = 'BTC';
		$this->bpOptions['currency'] = 'USD';
		
		// Indicates whether anything is to be shipped with
		// the order (if false, the buyer will be informed that nothing is
		// to be shipped)
		$this->bpOptions['physical'] = 'true';
		
		// If set to false, then notificaitions are only
		// sent when an invoice is confirmed (according the the
		// transactionSpeed setting). If set to true, then a notification
		// will be sent on every status change
		$this->bpOptions['fullNotifications'] = 'true';
		
		// transaction speed: low/medium/high.   See API docs for more details.
		// $this->bpOptions['transactionSpeed'] = 'medium'; 	
	
	}
	
	//------------------- BitPay lib -----------------------
	
	
	private function bpCurl($url, $apiKey, $post = false) {
		$logger = $this->container->get('logger');
			
		$curl = curl_init($url);
		$length = 0;
		if ($post)
		{	
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
			$length = strlen($post);
		}
		
		$uname = base64_encode($apiKey);
		$header = array(
			'Content-Type: application/json',
			"Content-Length: $length",
			"Authorization: Basic $uname",
			);
	
		curl_setopt($curl, CURLOPT_PORT, 443);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1); // verify certificate
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // check existence of CN and verify that it matches hostname
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
		
		$responseString = curl_exec($curl);
		
		$logger->info('String de respuesta de la bitpay invoice: ' . print_r($responseString, true));
		
		if($responseString == false) {
			$response = curl_error($curl);
		} else {
			$response = json_decode($responseString, true);
		}
		curl_close($curl);
		return $response;
	}
	// $orderId: Used to display an orderID to the buyer. In the account summary view, this value is used to 
	// identify a ledger entry if present.
	//
	// $price: by default, $price is expressed in the currency you set in bp_options.php.  The currency can be 
	// changed in $options.
	//
	// $posData: this field is included in status updates or requests to get an invoice.  It is intended to be used by
	// the merchant to uniquely identify an order associated with an invoice in their system.  Aside from that, Bit-Pay does
	// not use the data in this field.  The data in this field can be anything that is meaningful to the merchant.
	//
	// $options keys can include any of: 
	// ('itemDesc', 'itemCode', 'notificationEmail', 'notificationURL', 'redirectURL', 'apiKey'
	//		'currency', 'physical', 'fullNotifications', 'transactionSpeed', 'buyerName', 
	//		'buyerAddress1', 'buyerAddress2', 'buyerCity', 'buyerState', 'buyerZip', 'buyerEmail', 'buyerPhone')
	// If a given option is not provided here, the value of that option will default to what is found in bp_options.php
	// (see api documentation for information on these options).
	public function bpCreateInvoice($orderId, $price, $posData, $orderType, $options = array()) {	
		$logger = $this->container->get('logger');
		
		$options = array_merge($this->bpOptions, $options);	// $options override any options found in bp_options.php
		
//		$posDataInnerArray['posData'] = $posData; 	
//		if ($this->bpOptions['verifyPos']) // if desired, a hash of the POS data is included to verify source in the callback
//			$posDataInnerArray['hash'] = crypt($posData, $options['apiKey']);

//		$options['posData'] = $posDataInnerArray;

		$options['posData'] = '{"posData": "' . $posData . '"';
		$options['posData'] .= ', "orderType": "' . $orderType . '"';
		if ($this->bpOptions['verifyPos']) // if desired, a hash of the POS data is included to verify source in the callback
			$options['posData'] .= ', "hash": "' . crypt($posData, $options['apiKey']).'"';
		$options['posData'] .= '}';
		
		$options['orderID'] = $orderId;
		$options['price'] = $price;
		
		$postOptions = array('orderID', 'itemDesc', 'itemCode', 'notificationEmail', 'notificationURL', 'redirectURL', 
			'posData', 'price', 'currency', 'physical', 'fullNotifications', 'transactionSpeed', 'buyerName', 
			'buyerAddress1', 'buyerAddress2', 'buyerCity', 'buyerState', 'buyerZip', 'buyerEmail', 'buyerPhone');
		foreach($postOptions as $o)
			if (array_key_exists($o, $options))
				$post[$o] = $options[$o];
		
		$post = json_encode($post);
		$post = str_replace('\/', '/', $post);
		
		$logger->info('Generando esta bitpay invoice: ' . print_r($post, true));
		
		$response = $this->bpCurl('https://bitpay.com/api/invoice/', $options['apiKey'], $post);
	
		$logger->info('Respuesta de la generacion de la bitpay invoice: ' . print_r($response, true));
	
		return $response;
	}
	
	// Call from your notification handler to convert $_POST data to an object containing invoice data
	public function bpVerifyNotification($apiKey = false) {
		if (!$apiKey)
			$apiKey = $this->bpOptions['apiKey'];		
		
		$post = file_get_contents("php://input");
		if (!$post)
			return 'No post data';
			
		$json = json_decode($post, true);
		
		if (is_string($json))
			return $json; // error
	
		if (!array_key_exists('posData', $json)) 
			return 'no posData';
			
		$posData = json_decode($json['posData'], true);
		if($this->bpOptions['verifyPos'] and $posData['hash'] != crypt($posData['posData'], $apiKey)) 
			return 'authentication failed (bad hash)';
		
		$json['posData'] = $posData['posData'];
		$json['orderType'] = $posData['orderType'];
			
		return $json;
	}
	
	// $options can include ('apiKey')
	public function bpGetInvoice($invoiceId, $apiKey=false) {
		if (!$apiKey)
			$apiKey = $this->bpOptions['apiKey'];		
	
		$response = bpCurl('https://bitpay.com/api/invoice/'.$invoiceId, $apiKey);
		if (is_string($response))
			return $response; // error
		$response['posData'] = json_decode($response['posData'], true);
		return $response;	
	}
		
	public function bpGetExchangeRate() {
		$logger = $this->container->get('logger');
		
		$retval = false;
		
		try {
			$url = "https://bitpay.com/api/rates";

			$curl = curl_init();

			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_PORT, 443);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

			$responseString = curl_exec($curl);
				
			if ($responseString == false) {
				$logger->error("Error consultando el precio de Bitpay contra la API.");
			} else {
		
				$response = json_decode($responseString, true);
		
				if (!$response) {
					$logger->error("Error consultando el precio de Bitpay al decodificar la respuesta de Bitpay.");
				} else {

					$retval = $response[0]['rate'];
					
				}
			}
				
			curl_close($curl);
				
		} catch (Exception $e) {
			curl_close($curl);
				
			$logger->error("Error consultando el precio de Bitpay. \n " . $e->getMessage());
		}
		
		return $retval;
	}
		
}