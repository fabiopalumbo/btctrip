<?php
namespace BtcTrip\APIBtcTripBundle\Classes;

use BtcTrip\MainBundle\Service\BaseService;
class TravelportCurl {
    private $apiUrl = '';
    /*
	private $url;
	
    private $parameters;
    private $options;
    private $rawData;
    
    private $httpHeader;
    
    private function __construct($url) {
    	$this->url = $url;
        $this->parameters = array();
        $this->options = array();
        $this->rawData = '';
        
        $this->httpHeader = array(
           "Accept-Encoding: gzip",
           "Accept-Charset: ISO-8859-1, utf-8", 
           "X-Language: en",
           //'X-ApiKey: 343f1040cda04fcbbf01b6c5633fe34e',
            "X-ApiKey: 8f36692e-4bdb-4363-9fd1-2a88557e2e34"
        );
    }
    
    private function __clone() {
    }
    
    public function post($postJsonData = false) {
    	if ($postJsonData) {
    		$this->setOption(CURLOPT_HEADER, false);
    		$this->setOption(CURLOPT_CUSTOMREQUEST, "POST");
    		$this->setOption(CURLOPT_POSTFIELDS, $this->getRawData()); 
    		
    		$this->httpHeader[] = "Content-Type: application/json";
    	}
    	
        $this->setOption(CURLOPT_POST, 1);
        return $this->request();
    }
    
    private function buildParameters() {
        return http_build_query($this->getParameters());
    }
    
    private function request() {
    	$handler = curl_init($this->url);

        curl_setopt($handler, CURLOPT_RETURNTRANSFER, TRUE);
        
        $parameters = (count($this->parameters)>0 ? '?'.$this->buildParameters() : '');
       // echo $this->url.$parameters;
        curl_setopt($handler, CURLOPT_URL, $this->url.$parameters);
        
        // $this->httpHeader[] = $this->generateXUOW();
        
        curl_setopt($handler, CURLOPT_HTTPHEADER, $this->httpHeader);
        
        // agregar los parametros adicionales
        foreach ($this->options as $key => $value) {
        	curl_setopt($handler, $key, $value);
        }

        $response = curl_exec($handler); 
        $response = gzinflate(substr($response, 10, -8));
        
        return array(
            "response"   => $response,
            "http_code"  => curl_getinfo($handler, CURLINFO_HTTP_CODE),
            "error_code" => curl_errno($handler),
            "error_msg"  => curl_error($handler)
        );
    }
    
	public function getRawData() {
		return $this->rawData;
	}
	public function setRawData($rawData) {
		$this->rawData = $rawData;
		return $this;
	}
*/
    
}

