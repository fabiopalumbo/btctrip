<?php
namespace BtcTrip\APIBtcTripBundle\Classes;

use BtcTrip\MainBundle\Service\BaseService;
/*
 * Hace la conexion por curl con la api pasando la clave y el lenguage
 * 
 */
class DespegarCurl {
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
            /** API V1
             */
            "X-ApiKey: 8f36692e-4bdb-4363-9fd1-2a88557e2e34"
            /** API V3
           'X-ApiKey: 343f1040cda04fcbbf01b6c5633fe34e',
             */
        );
    }
    
    private function __clone() {
    }
    
    /**
     * @param string $url
     * @return DespegarCurl 
     */
    public static function create($url) {
       
        return new static($url);
    }
    
    /**
     * @param string $name
     * @param mixed $value
     * @return DespegarCurl 
     */
    public function setParameter($name, $value) {
        $this->parameters[$name] = $value;
        return $this;
    }
    
    public function getParameter($name, $default = null) {
        return !empty($this->parameters[$name]) ? $this->parameters[$name] : $default;
    }
    
    /**
     * @param array $params
     * @return DespegarCurl 
     */
    public function setParameters(array $params) {
        $this->parameters = $params;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getParameters() {
        return $this->parameters;
    }
    
    /**
     * @param mixed $staticName
     * @param mixed $value
     * @return DespegarCurl 
     */
    public function setOption($staticName, $value) {
        $this->options[$staticName] = $value;
        return $this;
    }
    
    public function getOption($staticName) {
        return $this->options[$staticName];
    }
    
    /**
     * 
     */
    public function get() {
        return $this->request();
    }
    
    /**
     * TODO
     */
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
    
    /**
     * TODO: Modificar para que pueda hacer consultas con cualquier http method.
     * 
     * @return array
     */
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
	
	private function generateXUOW() {
		/**
		 * Create an empty text file called counterlog.txt and
		 * upload to the same directory as the page you want to
		 * count hits for.
		 *
		 * Add this line of code on your page:
		 * <?php include "text_file_hit_counter.php"; ?>
		 */
		
		// Open the file for reading
		$fp = fopen("/tmp/counterlog.txt", "r");
		
		// Get the existing count
		$count = fread($fp, 1024);
		
		// Close the file
		fclose($fp);
		
		// Add 1 to the existing count
		//$count = $count + 1;
		
		// Reopen the file and erase the contents
		//$fp = fopen("/tmp/counterlog.txt", "w");
		
		// Write the new count to the file
		//fwrite($fp, $count);
		
		// Close the file
		//fclose($fp);
		
		
		return "X-UOW: btctrip-" . $count;
	}
    
}

