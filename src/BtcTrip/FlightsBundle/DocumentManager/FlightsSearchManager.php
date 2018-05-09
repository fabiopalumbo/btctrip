<?php

namespace BtcTrip\FlightsBundle\DocumentManager;

use BtcTrip\MainBundle\Service\BaseService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Administra FlightsSearch.
 * 
 * FlightsSearchManager class
 *
 */
class FlightsSearchManager extends BaseService {

	private function getCollection() {
		$megahelper = $this->get('mega_helper');
		return $megahelper->getCollection('SearchResult');
	} 
	
	
	public function save($search) {
		$this->getCollection()->save($search);
	}
	
	public function  getLastSearch($sessionid, $iHash) {
		$cursor = $this->getCollection()->find(array('sessionId' => $sessionid, 'metadata.ticket.hash' => $iHash))->sort(array('_id' => -1))->limit(1);
		
		return $cursor;
	}
}
