<?php

namespace BtcTrip\FlightsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Helper para asuntos vaaarios
 *
 */
class MegaHelper {
	protected $container;

	public function __construct(ContainerInterface $container) {
        	$this->container = $container;
	}

	public function getEnviromentPrefix() {
		$enviroment = $this->container->get( 'kernel' )->getEnvironment();
		$enviromentPrefix = '';
		if ($enviroment == 'dev') {
			$enviromentPrefix = '/app_dev.php';
		}
	
		return $enviromentPrefix;
	}

	public function getCollection($name) {
		$dm = $this->container->get('doctrine_mongodb')->getManager();
		$dm->getConnection()->initialize();
		$mongo = $dm->getConnection()->getMongo();
		$collection = $mongo->selectCollection($dm->getConfiguration()->getDefaultDB(), $name);

		return $collection;	
	}

	public function retrieveCities() {
		$logger = $this->container->get('logger');
		
		$url = "http://api.despegar.com/cities";

		$pageSize = 100;
		$firstPage = 100;
		$pageCount = 100;

		for ($p=$firstPage; $p<=$pageCount; $p++) {
			$data = array('page' => $p, 'pagesize' => $pageSize);
			$response = $this->sendJsonRequest($url, $data);
			
			$logger->info(print_r($response['meta'], true));
			
			$collection = $this->getCollection('City');
			//$collection->batchInsert($response['cities']);
			
			$message = "last page is " . $p;
			
			sleep(rand(1, 3));
		}
		
		return $message;
	}


	private function getJsonZippedRequest($url, $data) {
        $parameters = http_build_query($data);

        $curl = curl_init($url . '?' . $parameters);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json", "Accept-Encoding: gzip"));
        curl_setopt($curl, CURLOPT_ENCODING, 1);

        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ( $status != 201 && $status != 200 ) {
            die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }

        curl_close($curl);

        $response = json_decode($json_response, true);
        
        return $response;
	}

	/* gets the data from a URL */
	public function executeRemoteRequest($url) {
		$usingProxy = false;

		$ch = curl_init();
		$timeout = 5;

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		   'X-Lang: en', 'PLAY_LANG: en'
	 	));

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

		if ($usingProxy) {
			curl_setopt($ch, CURLOPT_PROXY, 'proxypool1.mecon.ar:8080');
		}			

		$data = curl_exec($ch);
		curl_close($ch);

		return $data;
	}

	/*
	// gets the data from a URL 
	public function executeSmartRemoteRequest($resultsUrl, $searchUrl) {
		$logger = $this->container->get('logger');

		// $searchUrl = "http://www.us.despegar.com/shop/flights/results/oneway/AMS/TLV/2013-09-30/1/0/0";
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $searchUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		
		$result = curl_exec($ch);

		$cookies = array();
		preg_match_all('/Set-Cookie:(?<cookie>\s{0,}.*)$/im', $result, $cookies);
		preg_match_all("/hashForData=(.*)'/", $result, $hashForData);

// 		$logger->debug('All page: ' . print_r($result, true));
		
		$logger->debug('Header: ' . print_r($cookies, true));
		$logger->debug('HashForData: ' . print_r($hashForData, true));
		
		$setCookie = explode(";", $cookies['cookie'][0]);
		$newCookie = $setCookie[0];

		if (isset($cookies['cookie'][1])) {
			$setCookie = explode(";", $cookies['cookie'][1]);
			$newCookie .= ';' . $setCookie[0];
		}
		
		$logger->debug('New Cookie: ' . print_r($newCookie, true) );
		
		// X-UOW
		$xparameter = array();
		preg_match('/X-UOW:(.*)$/im', $result, $xparameter);
		
		$xuow = $xparameter[0];
		$xouw = explode(":", $xuow);
		$xouw = trim($xouw[1]);
		
		$logger->debug('Parameter: ' . print_r($xparameter, true) . " XOUW:: " . $xouw);
		
		curl_close($ch);
		
		// $resultsUrl = "http://www.us.despegar.com/shop/flights/data/search/oneway/ams/tlv/2013-09-30/1/0/0/TOTALFARE/ASCENDING/NA/NA/NA/NA";
		// 		/shop/flights/data/search/roundtrip/mia/bue/2013-11-14/2013-11-15/1/0/0/TOTALFARE/ASCENDING/NA/NA/NA/NA/NA?hashForData=3e14d3873bba31c3260fd0491d8c8138'
		
		// por el cambio del hashForData en el search
		if ( strpos($resultsUrl, 'search') !== false ) { 
			if ( isset($hashForData[1][0]) ) {
				$resultsUrl .= '?hashForData=' . $hashForData[1][0];
			}
		}
		
		// lowercase a los aeropuertos 
		$parts = explode('/', $resultsUrl);
		$parts[8] = strtolower($parts[8]);
		$parts[9] = strtolower($parts[9]);
		$resultsUrl = implode('/', $parts);
		
		$logger->debug('New url: ' . $resultsUrl);
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $resultsUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_ENCODING, '');
		
		$cookieHeader = array();
		$cookieHeader[] = 'Accept: application/json, text/javascript, * /*; q=0.01';
		$cookieHeader[] = 'Accept-Encoding: gzip, deflate';
		$cookieHeader[] = 'Accept-Language: es-ar,es;q=0.8,en-us;q=0.5,en;q=0.3';
		$cookieHeader[] = 'Connection: keep-alive';
		$cookieHeader[] = 'Host: www.us.despegar.com';
		$cookieHeader[] = 'Referer: ' . $searchUrl;
		$cookieHeader[] = 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:24.0) Gecko/20100101 Firefox/24.0';
		$cookieHeader[] = 'X-Requested-With: XMLHttpRequest';
		$cookieHeader[] = 'X-UOW: ' . $xouw;
		$cookieHeader[] = 'X-Lang: en';
		$cookieHeader[] = 'Cookie: ' . $newCookie;

		curl_setopt($ch, CURLOPT_HTTPHEADER, $cookieHeader);

		$resultJson = curl_exec($ch);

		curl_close($ch);

		return $resultJson;
	}
	*/
	

	public function generateResponseError() {
		$responseError["result"]["data"]["metadata"]["status"]["code"] = "ERROR";
		$responseError["result"]["data"]["metadata"]["status"]["message"] = "See messages for details";

		$responseError["messages"][0]["code"] = "SEARCH_ENGINE_UNAVAILABLE";
		$responseError["messages"][0]["value"] = "Search engine temporally unavailable";
		$responseError["messages"][0]["description"] = "The search engine is temporally unavailable. Please, try again in a few minutes.";
		
		return $responseError;	
	}

		
	public function getJsonDummy() {
		$logger = $this->get('logger');
	
		//$kernel = $this->get('kernel');
		//$innerPath = $kernel->locateResource('@BtcTripFlightsBundle/Resources/data/aBig.json');
		//$innerPath = '@BtcTripFlightsBundle/Resources/data/airports.dat';
	
		//$path = $kernel->locateResource($innerPath);
	
		$path = $this->container->getParameter('kernel.root_dir') . '/Resources/data/aBig.json';
	
		$logger->debug($path);
	
		$data = file_get_contents($path, "r");
	
		return $data;
	}
		

	
}
