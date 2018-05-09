<?php

namespace BtcTrip\FlightsBundle\DocumentManager;

use BtcTrip\MainBundle\Service\BaseService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Administra los Documentos Airport.
 * 
 * AirportManager class
 *
 */
class AirportManager extends BaseService {

	private function getCollection() {
		$megahelper = $this->get('mega_helper');
		return $megahelper->getCollection('Airport');
	} 
	
	
	public function getByCode($code) {
		$airport = $this->getCollection()->findOne(array('id' => $code));
		
		return $airport;
	}
	
	
}
