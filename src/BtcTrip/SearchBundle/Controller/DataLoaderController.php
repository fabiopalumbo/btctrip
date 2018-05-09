<?php

namespace BtcTrip\SearchBundle\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
 * @ Route("/dataloader")
 */
class DataLoaderController extends Controller
{

	/**
	 * @Route("/templateTesting/{orderId}")
	 */
	public function templateTestingAction($orderId) {
		$logger = $this->get('logger');
		
		$collection = $this->get('mega_helper')->getCollection('Order');
		$order = $collection->findOne(array('_id' => new \MongoId($orderId)));
		
		$bpCollection = $this->get('mega_helper')->getCollection('BitpayInvoice');
		$bitpayInvoice = $bpCollection->findOne(array('_id' => $order['bitpayInfoId']));
		
		$subject = "BtcTrip - Se vendio un pasaje - ". $order['number'] . " - " . $order['_id'];

// 		$content = $this->get('templating')->render("BtcTripSearchBundle:ReMailer:paymentConfirmationToAdmins.txt.php", 
// 														array('order' => $order));

		$content = $this->get('templating')->render("BtcTripSearchBundle:ReMailer:buyerPaymentConfirmation.html.php",
				array('order' => $order, 'bitpayInvoice' => $bitpayInvoice));
		
		$this->get('remailer')->sendPaymentConfirmation($order, $bitpayInvoice, true);
		
		return new Response('<b>' . $subject . '</b> <br><br><br> ' . $content);
	}

	/**
	 * @ Route("/simulaBrowser")
	 */
	public function simulaBrowserAction() {
		$logger = $this->get('logger');
		$megaHelper = $this->get('mega_helper');

		$searchUrl = "http://www.us.despegar.com/shop/flights/results/oneway/AMS/TLV/2013-09-30/1/0/0";
		
		$ch = curl_init();

		//  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		//    'X-Language: en'
		//    ));

		curl_setopt($ch, CURLOPT_URL, $searchUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		
		$result = curl_exec($ch);

//		preg_match('/^Set-Cookie:\s*([^;]*)/mi', $result, $m);

		$cookies = array();
		preg_match_all('/Set-Cookie:(?<cookie>\s{0,}.*)$/im', $result, $cookies);

		$logger->info('Header: ' . print_r($cookies, true));

		$setCookie = explode(";", $cookies['cookie'][0]);
		$newCookie = $setCookie[0];

		$setCookie = explode(";", $cookies['cookie'][1]);
		$newCookie .= ';' . $setCookie[0];

		$logger->info('New Cookie: ' . print_r($newCookie, true) );
		
		// X-User-Id
		$xparameter = array();
		preg_match('/X-UOW:(.*)$/im', $result, $xparameter);
		
		$xuow = $xparameter[0];
		$xouw = explode(":", $xuow);
		$xouw = trim($xouw[1]);
		
		$logger->info('Parameter: ' . print_r($xparameter, true) . " XOUW:: " . $xouw);
		
		// X-UOW

		curl_close($ch);
		
		
		$ch = curl_init();
		// request del json
		$resultsUrl = "http://www.us.despegar.com/shop/flights/data/search/oneway/ams/tlv/2013-09-30/1/0/0/TOTALFARE/ASCENDING/NA/NA/NA/NA";
		
		curl_setopt($ch, CURLOPT_URL, $resultsUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_ENCODING, '');
		
		$cookieHeader = array();
		
		$cookieHeader[] = 'Accept: application/json, text/javascript, */*; q=0.01';
		$cookieHeader[] = 'Accept-Encoding: gzip, deflate';
		$cookieHeader[] = 'Accept-Language: es-ar,es;q=0.8,en-us;q=0.5,en;q=0.3';
		$cookieHeader[] = 'Connection: keep-alive';
		$cookieHeader[] = 'Host: www.us.despegar.com';
		$cookieHeader[] = 'Referer: ' . $searchUrl;
		$cookieHeader[] = 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:24.0) Gecko/20100101 Firefox/24.0';
		$cookieHeader[] = 'X-Requested-With: XMLHttpRequest';
		$cookieHeader[] = 'X-UOW: ' . $xouw;
		$cookieHeader[] = 'Cookie: ' . $newCookie;

		curl_setopt($ch, CURLOPT_HTTPHEADER, $cookieHeader);

		$resultJson = curl_exec($ch);

		curl_close($ch);

		//$response = '<pre>' . print_r($result, true) . '</pre><br><br>';
		$response = '<pre>-------<br>' . $resultJson . '<br>--------</pre>';
	
		return new Response('<pre>' . print_r($response, true) . '</pre>');
	}


	/**
	 * @ Route("/downloadFlags")
	 */
	public function downloadFlagsAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$result = $dataLoaderService->downloadAirlineFlags();
	
		return new Response('<pre>' . print_r($result, true) . '</pre>');
	}

	/**
	 * @ Route("/addAirportManually")
	 */
	public function addAirportManuallyAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$result = $dataLoaderService->addAirportManually();
	
		return new Response('<pre>' . print_r($result, true) . '</pre>');
	}

	/**
	 * @ Route("/translateCities")
	 */
	public function translateCitiesAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$result = $dataLoaderService->translateCities();
	
		return new Response('<pre>' . print_r($result, true) . '</pre>');
	}

	/**
	 * @ Route("/translateCountries")
	 */
	public function translateCountriesAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$result = $dataLoaderService->translateCountries();
	
		return new Response('<pre>' . print_r($result, true) . '</pre>');
	}

	/**
	 * @ Route("/addPlaceToAirports")
	 */
	public function addPlaceToAirportsAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$result = $dataLoaderService->addPlaceToAirports();
	
		return new Response('<pre>' . print_r($result, true) . '</pre>');
	}

	/**
	 * @ Route("/addPlaceToCities")
	 */
	public function addPlaceToCitiesAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$result = $dataLoaderService->addPlaceToCities();
	
		return new Response('<pre>' . print_r($result, true) . '</pre>');
	}



	/**
	 * @ Route ( " / retrieveStates")
	 */
	public function statesAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$testLoad = $dataLoaderService->retrieveStates();

		return new Response('<pre>' . print_r($testLoad, true) . '</pre>');
	}

	/**
	 * @ Route( " / retrieveCountries")
	 */
	public function countriesAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$testLoad = $dataLoaderService->retrieveCountries();

		return new Response('<pre>' . print_r($testLoad, true) . '</pre>');
	}

	/**
	 * @ Route ( " / retrieveCities " )
	 */
	public function citiesAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$testLoad = $dataLoaderService->retrieveCities();

		return new Response('<pre>' . print_r($testLoad, true) . '</pre>');
	}

	/**
	 * @ Route ( " / retrieveAirports " )
	 */
	public function airportsAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$testLoad = $dataLoaderService->retrieveAirports();

		return new Response('<pre>' . print_r($testLoad, true) . '</pre>');
	}


}
