<?php

namespace BtcTrip\SearchBundle\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use BtcTrip\SearchBundle\Document\Airport;

/**
 * @Route("/autocomplete")
 */
class AutocompleteController extends Controller {

	// const ACCENT_STRINGS = 'ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËẼÌÍÎÏĨÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëẽìíîïĩðñòóôõöøùúûüýÿ';
	// const NO_ACCENT_STRINGS = 'SOZsozYYuAAAAAAACEEEEEIIIIIDNOOOOOOUUUUYsaaaaaaaceeeeeiiiiionoooooouuuuyy';

	/**
	 * @Route("/find",
	 			defaults={"_format"="json"})
	 */
	public function findAction(Request $request) {
		$urlBaseDespegar = "http://www.us.despegar.com/frontendservices-web/Autocomplete/?product=flights&";
		$query = "query=" . urlencode($request->query->get('query'));
		$timestamp = "&_=" . $request->query->get('_'); // 1370916448267
		
		$webServiceUrl = $urlBaseDespegar . $query . $timestamp;
		
		$logger = $this->get('logger');
		$logger->debug( '	---> ' . $webServiceUrl );
		
		$megaHelper = $this->get('mega_helper');
		
		$remoteResponse = $megaHelper->executeRemoteRequest($webServiceUrl);
		
		$spanishWords = array('Ciudades', 'Aeropuertos', 'Estado/Provincia', 'Todos los aeropuertos', 
				'Hong Kong International Airport, Hong Kong, China');
		$englishWords = array('Cities', 'Airports', 'States/Province', 'All airports', 
				'Hong Kong International Airport, Hong Kong, Hong Kong');
		
	 	return new Response(str_replace($spanishWords, $englishWords, $remoteResponse));
	} 
	 
	/* 
	private function oldfindAction(Request $request) {
		$filter = $request->query->get('query');
	
		$logger = $this->get('logger');
		$megaHelper = $this->get('mega_helper');

		$regexFilter = new \MongoRegex("/\b".$this->accentToRegex($filter)."/i");
		$searchFilter = array( '$or' => array( array('id' => $regexFilter), array('place' => $regexFilter) ) );

		$response = array('data' => array());

		$airportCol = $megaHelper->getCollection('Airport');
		$airports = $airportCol->find( $searchFilter )->limit(5);
		
		foreach($airports as $airport) {
			$itemsAirport[] = array('code' => $airport['id'], 'place' => $airport['place']);
				
//			$logger->debug( '	---> ' . $airport['id'] . ' - ' . $airport['description'] . ' - ' . $airport['internalId'] );
		}
		
		if ( isset($itemsAirport) && count($itemsAirport) >  0 ) {
			$airportsResponse = array( 'type' => 'a', 'name' => 'Airports', 'items' => $itemsAirport);
			$response['data'][] = $airportsResponse;
		}
		
		$cityCol = $megaHelper->getCollection('City');
		$cities = $cityCol->find( $searchFilter )->limit(5);

		foreach($cities as $city) {
			$itemsCity[] = array('code' => $city['id'], 'place' => $city['place']);
				
//			$logger->debug( '	---> ' . $city['id'] . ' - ' . $city['name'] . ' - ' . $city['internalId'] );
		}
		
		if ( isset($itemsCity) && count($itemsCity) >  0 ) {
			$citesResponse = array( 'type' => 'c', 'name' => 'Cities', 'items' => $itemsCity);
			$response['data'][] = $citesResponse;
		}
		
		$logger->debug( ' La búsqueda fue: ' .$regexFilter . '	El resultado: ' . print_r($response, true));

		return new Response(json_encode($response));
	}   */

	/*
	private function findALaDoctrineAction($filter) {
		$logger = $this->get('logger');

		$dm = $this->get('doctrine_mongodb')->getManager();

		$filter = '/'.$filter.'/';
		
		$qb = $dm->createQueryBuilder('BtcTripSearchBundle:Airport');
		$qb->hydrate(false);
		$qb->addOr($qb->expr()->field('code')->equals(new \MongoRegex($filter)));
		$qb->addOr($qb->expr()->field('name')->equals(new \MongoRegex($filter)));
		$qb->addOr($qb->expr()->field('country')->equals(new \MongoRegex($filter)));
		$qb->addOr($qb->expr()->field('city')->equals(new \MongoRegex($filter)));
		$query = $qb->getQuery();

		$airports = $query->execute()->toArray();

		foreach($airports as $airport) {
			$logger->debug( '	---> ' . $airport['code'] . ' - ' . $airport['name'] . ' - ' . $airport['city'] . ' - ' . $airport['country'] );
		}

		return new Response('<pre>' . print_r($airports, true) . '</pre>');
	}   */
	
   /**
	* Returns a string with accent to REGEX expression to find any combinations
	* in accent insentive way
	*
	* @param string $text The text.
	* @return string The REGEX text.
	*/
	/*private function accentToRegex($text)	{
		$from = str_split(utf8_decode(self::ACCENT_STRINGS));
		$to   = str_split(strtolower(self::NO_ACCENT_STRINGS));
		$text = utf8_decode($text);
		$regex = array();
		
		foreach ($to as $key => $value) {
			if (isset($regex[$value])) {
				$regex[$value] .= $from[$key];
			} else {
				$regex[$value] = $value;
			}
		}
		 
		foreach ($regex as $rg_key => $rg) {
			$text = preg_replace("/[$rg]/", "_{$rg_key}_", $text);
		}
		 
		foreach ($regex as $rg_key => $rg) {
			$text = preg_replace("/_{$rg_key}_/", "[$rg]", $text);
		}
		 
		return utf8_encode($text);
	}  */
 

}
