<?php

namespace BtcTrip\FlightsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;
use BtcTrip\FlightsBundle\Document\Airport;

/**
 * Helper cargador de datos
 *
 */
class DataLoader {
	protected $container;

	public function __construct(ContainerInterface $container) {
        	$this->container = $container;
	}

	public function downloadAirlineFlags() {
		$logger = $this->container->get('logger');
		$megaHelper = $this->container->get('mega_helper');

		$baseUrl = "http://ar.staticontent.com/img-versioned/1.23.6/common/airlines/25x25/";  //  QR.png;

		$logger->debug(" ----> baseUrl $baseUrl ");

		$airlineCollection = $megaHelper->getCollection('Airline');
		$airlines = $airlineCollection->find()->limit(500)->skip(1000);
		
		foreach ($airlines as $airline) {
			$imageName = $airline['codigo'] . ".png";
			$imageUrl = $baseUrl . $imageName;

			$logger->debug(" ----> buscando $imageUrl ");
		
			$ch = curl_init($imageUrl);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
			
			$rawdata = curl_exec($ch);
			
			$info = curl_getinfo($ch);
		//	$logger->debug('Curl info: ' . print_r($info, true));
			
			curl_close($ch);
			
		//	$logger->debug("rawdata for $imageName: " . $rawdata);

			if($info['http_code'] == 200) {
				$fp = fopen("/tmp/flags/" . $imageName,'w');
				fwrite($fp, $rawdata); 
				fclose($fp);
				
				$logger->debug("$imageName Imagen guardada!");
			}
		
		}
		
		return "All right!!";
	}

	public function addAirportManually() {
		$logger = $this->container->get('logger');
		
		$dm = $this->container->get('doctrine_mongodb')->getManager();
		$dm->getConnection()->initialize();
		$mongo = $dm->getConnection()->getMongo();
		$collection = $mongo->selectCollection($dm->getConfiguration()->getDefaultDB(), 'Airport');
		
		$newAirport = "{\"parentCity\":\"PAR\",\"internalId\":\"221542\",\"id\":\"XPG\",\"description\":\"Gare du Nord Rail Stn\",\"geoLocation\":{\"longitude\":0,\"latitude\":0}, \"place\":\"Gare du Nord Rail Stn, Paris, France\"}";
		
		$collection->save(json_decode($newAirport));
		
		return "All right!";
	}

	// Actualiza los nombres de las ciudades con su traduccion en ingles 
	public function translateCities() {
		$logger = $this->container->get('logger');
		$megaHelper = $this->container->get('mega_helper');

		$cityCollection = $megaHelper->getCollection('City');	
		$cities = $cityCollection->find();

		$translatedCityCollection = $megaHelper->getCollection('CitiesTranslated');

		foreach ($cities as $city) {
			$cityTranslated = $translatedCityCollection->findOne(array('code' => $city['id']));
			
			$ignoredCities = array('ABE', 'ABM', 'ABV', 'ACE', 'ADQ', 'ADX', 'ATW', 'AZO', 'BFS', 'CAE', 'EBB', 'EIS', 'HDN', 'HNN', 'ILE', 'JED'
					, 'IXW', 'JNB', 'JPA', 'KEL', 'KGL', 'KHH', 'KHI', 'KIN', 'KOA', 'KRK', 'KTA', 'KUL', 'KWI', 'LAD', 'LAP', 'LIM', 'LIS', 'LLW', 'LPB'
					, 'LSZ', 'LYR', 'MAD', 'MAR', 'MBA', 'MBS', 'MEL', 'MGA', 'MKK', 'MMY', 'MPA', 'MPL', 'MRU', 'MSR', 'MUC', 'MVD', 'MUH', 'RAK'
					, 'SEA', 'SEZ', 'SHD', 'SKB', 'SKG', 'SLU', 'SPK', 'SPS', 'STT', 'SUM', 'SUV', 'SVD', 'TMZ', 'TNR', 'TRF', 'UVL', 'YOW', 'YVA'
					, 'YWG', 'ZIH' );
			
			//$city['place'] = $city['name'] . ', ' . $countryOfCity['name'];
			
			if(isset($cityTranslated) && !in_array($city['id'], $ignoredCities)) {
				$recortamosElNombre = strpos($cityTranslated['cityAirport'], ':');
				if ($recortamosElNombre) {
					$newCityName = substr($cityTranslated['cityAirport'], 0, $recortamosElNombre);
				} else {
					$newCityName = $cityTranslated['cityAirport'];
				}
				
				$logger->debug("traduciendo: " . $city['id'] . ": " . $city['name'] . "-> " . $newCityName);  // print_r($countryOfCity, true)
			
				//$logger->debug(print_r($city['place'], true));
			
				$city['name'] = $newCityName;
				$cityCollection->save($city);
			}
		}
		
		return 'Todo bien!';
	}


	// Actualiza los nombres de los paises con su traduccion en ingles 
	public function translateCountries() {
		$logger = $this->container->get('logger');
		$megaHelper = $this->container->get('mega_helper');
		
		$countryCollection = $megaHelper->getCollection('Country');	
		$countries = $countryCollection->find();
		
		$translatedCountryCollection = $megaHelper->getCollection('CountriesTranslated');
		
		foreach ($countries as $country) {
			$translatedCountry = $translatedCountryCollection->findOne(array('code' => $country['id']));
			
			//$logger->info("pais traducido por el id: " . $country['id'] . ", " . $country['name'] . " -> " . $translatedCountry['name'] /* print_r($translatedCountry , true)*/);
				
			if (isset($translatedCountry)) {
				$country['name'] = $translatedCountry['name'];
				$countryCollection->save($country);
				$logger->info('Se actualizo el pais: ' . $country['id'] . ", " . $country['name']/* print_r($country, true)*/);
			}
			
		//	break;
		}
	
		return 'Todo bien!';
	}

	public function removeCitiesWithoutAirport() {
		$logger = $this->container->get('logger');
		$megaHelper = $this->container->get('mega_helper');
		
		$cityCollection = $megaHelper->getCollection('City');	
		$cities = $cityCollection->find();
		
		$airportCollection = $megaHelper->getCollection('Airport');
		
		foreach ($cities as $city) {
			$cityOfAirport = $airportCollection->find(array('parentCity' => $city['id']));
			
			// $logger->info(print_r($cityOfAirport , true));
				
			if (!$cityOfAirport->hasNext()) {
				$cityCollection->remove(array('_id' => $city['_id']));
				$logger->info('Se borro la ciudad: ' . print_r($city, true));
			}
			
		//	break;
		}
	
		return 'Todo bien!';
	}

	public function addPlaceToAirports() {
		$logger = $this->container->get('logger');
		$megaHelper = $this->container->get('mega_helper');

		$cityCollection = $megaHelper->getCollection('City');	

		$airportCollection = $megaHelper->getCollection('Airport');
		$airports = $airportCollection->find();

		foreach ($airports as $airport) {
			$cityOfAirport = $cityCollection->findOne(array('id' => $airport['parentCity']));
			$airport['place'] = $airport['description'] . ', ' . $cityOfAirport['place'];
			
			// $logger->debug(print_r($countryOfCity, true));
			
			$logger->debug(print_r($airport['place'], true));
			
			$airportCollection->save($airport);
		}
		
		return 'Todo bien!';
	}


	public function addPlaceToCities() {
		$logger = $this->container->get('logger');
		$megaHelper = $this->container->get('mega_helper');

		$countryCollection = $megaHelper->getCollection('Country');	

		$cityCollection = $megaHelper->getCollection('City');
		$cities = $cityCollection->find();

		foreach ($cities as $city) {
			$countryOfCity = $countryCollection->findOne(array('id' => $city['countryId']));
			$city['place'] = $city['name'] . ', ' . $countryOfCity['name'];
			
			// $logger->debug(print_r($countryOfCity, true));
			
			$logger->debug(print_r($city['place'], true));
			
			$cityCollection->save($city);
		}
		
		return 'Todo bien!';
	}


	//  http://api.despegar.com/{id}/states
	public function retrieveStates() {
		$logger = $this->container->get('logger');
		$megaHelper = $this->container->get('mega_helper');
		
		$countryCollection = $megaHelper->getCollection('Country');
		$allCountries = $countryCollection->find(); 

		$stateCollection = $megaHelper->getCollection('State');

		// for ($p=$firstPage; $p<=$pageCount; $p++) {
		foreach($allCountries as $country) {
			// $data = array('page' => $p, 'pagesize' => $pageSize);
			
			$countryId = $country['id'];
			$url = "http://api.despegar.com/countries/$countryId/states";
			
			$response = $this->sendJsonRequest($url, null);
			
			//$logger->info(print_r($response['meta'], true));
			
			$logger->info($url);
			$logger->info(print_r($response, true));
			
			if (isset($response['states']) && count($response['states'])>=1) {
				$stateCollection->batchInsert($response['states']);
			}
			
			$message = "last page is ";
			
			sleep(rand(1, 3));
		 }
		
		
		return $message;
	}


	//  http://api.despegar.com/countries
	public function retrieveCountries() {
		$logger = $this->container->get('logger');
		
		$url = "http://api.despegar.com/countries";

		$pageSize = 100;
		$firstPage = 1;
		$pageCount = 3;

		for ($p=$firstPage; $p<=$pageCount; $p++) {
			$data = array('page' => $p, 'pagesize' => $pageSize);
			$response = $this->sendJsonRequest($url, $data);
			
			$logger->info(print_r($response['meta'], true));
			
			$dm = $this->container->get('doctrine_mongodb')->getManager();
			$dm->getConnection()->initialize();
			$mongo = $dm->getConnection()->getMongo();
			$collection = $mongo->selectCollection($dm->getConfiguration()->getDefaultDB(), 'Country');
			
			$collection->batchInsert($response['countries']);
			
			$message = "last page is " . $p;
			
			sleep(rand(1, 3));
		}
		
		return $message;
	}


	//  http://api.despegar.com/docs/method/hotels-cities
	//  http://api.despegar.com/cities
	public function retrieveCities() {
		$logger = $this->container->get('logger');
		
		$url = "http://api.despegar.com/cities";

		$pageSize = 100;
		$firstPage = 51;
		$pageCount = 200;

		for ($p=$firstPage; $p<=$pageCount; $p++) {
			$data = array('page' => $p, 'pagesize' => $pageSize);
			$response = $this->sendJsonRequest($url, $data);
			
			$logger->info(print_r($response['meta'], true));
			
			$dm = $this->container->get('doctrine_mongodb')->getManager();
			$dm->getConnection()->initialize();
			$mongo = $dm->getConnection()->getMongo();
			$collection = $mongo->selectCollection($dm->getConfiguration()->getDefaultDB(), 'City');
			
			$collection->batchInsert($response['cities']);
			
			$message = "last page is " . $p;
			
			sleep(rand(1, 3));
		}
		
		return $message;
	}
	
	
	//  http://api.despegar.com/airports
	public function retrieveAirports() {
		$logger = $this->container->get('logger');
		
		$url = "http://api.despegar.com/airports";

		$pageSize = 100;
		$firstPage = 81;
		$pageCount = 82;

		for ($p=$firstPage; $p<=$pageCount; $p++) {
			$data = array('page' => $p, 'pagesize' => $pageSize);
			$response = $this->sendJsonRequest($url, $data);
			
			$logger->info(print_r($response['meta'], true));
			
			$dm = $this->container->get('doctrine_mongodb')->getManager();
			$dm->getConnection()->initialize();
			$mongo = $dm->getConnection()->getMongo();
			$collection = $mongo->selectCollection($dm->getConfiguration()->getDefaultDB(), 'Airport');
			
			$collection->batchInsert($response['airports']);
			
			$message = "last page is " . $p;
			
			sleep(rand(1, 3));
		}
		
		return $message;
	}


	private function sendJsonRequest($url, $data) {
		$targetUrl = $url;
		
		if (isset($data)) {
        	$parameters = http_build_query($data);
        	$targetUrl .= '?' . $parameters;
		}
		
        $curl = curl_init($targetUrl);
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


	public function loadAirportsFromFile() {
		/**
		 * http://openflights.org/data.html
		 *
Airport ID	Unique OpenFlights identifier for this airport.
Name		Name of airport. May or may not contain the City name.
City		Main city served by airport. May be spelled differently from Name.
Country		Country or territory where airport is located.
IATA/FAA	3-letter FAA code, for airports located in Country "United States of America".
		3-letter IATA code, for all other airports.
		Blank if not assigned.
ICAO		4-letter ICAO code.
		Blank if not assigned.
Latitude	Decimal degrees, usually to six significant digits. Negative is South, positive is North.
Longitude	Decimal degrees, usually to six significant digits. Negative is West, positive is East.
Altitude	In feet.
Timezone	Hours offset from UTC. Fractional hours are expressed as decimals, eg. India is 5.5.
DST		Daylight savings time. One of E (Europe), A (US/Canada), S (South America), 
		O (Australia), Z (New Zealand), N (None) or U (Unknown). See also: Help: Time
		*
		*  The data is ISO 8859-1 (Latin-1) encoded, with no special characters.
		*
		 * Sample
		 *
		 * 507,"Heathrow","London","United Kingdom","LHR","EGLL",51.4775,-0.461389,83,0,"E"
		 *
		 *
		 **/

		$logger = $this->container->get('logger');

		$dm = $this->container->get('doctrine_mongodb')->getManager();

		$airportsPath = '@BtcTripFlightsBundle/Resources/data/airports.dat';

		$kernel = $this->container->get('kernel');
		$path = $kernel->locateResource($airportsPath);

		$fp = fopen($path, 'r');

		$logger->debug('Levantando Airports desde ' . $path);

		while ( !feof($fp) ) {
			$line = fgets($fp, 2048);
			$data = str_getcsv($line);

			// $logger->debug(print_r($data, true)); 

			if (count($data) == 11) {
				$airport = new Airport();
				$airport->setOpenflightId($data[0]);
				$airport->setName($data[1]);
				$airport->setCity($data[2]);
				$airport->setCountry($data[3]);
				$airport->setCode($data[4]);
				$airport->setCodeIcao($data[5]);
				$airport->setLatitud($data[6]);
				$airport->setLongitud($data[7]);
				$airport->setTimezone($data[9]);
				$airport->setDst($data[10]);

				$dm->persist($airport);

				$logger->debug('	Persistiendo el Airport ' . $airport->getId() . ' - ' . $airport->getCode() . ' - ' . $airport->getName());

//				if ( $airport->getCode() == 'HFN' ) {
//					break;
//				}

			}
		} 

		$logger->debug('	Guardado el Airport ' . $airport->getId() . ' - ' . $airport->getCode() . ' - ' . $airport->getName());

		$dm->flush(); 

		$logger->debug('Carga exitosa! ');


	}

		
}
