<?php

namespace BtcTrip\FlightsBundle\DocumentManager;

use BtcTrip\MainBundle\Service\BaseService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Administra los Documentos City.
 * 
 * CityManager class
 *
 */
class CityManager extends BaseService {

	private function getCollection() {
		$megahelper = $this->get('mega_helper');
		return $megahelper->getCollection('City');
	} 
	
	
	public function getByCode($code) {
		$city = $this->getCollection()->findOne(array('id' => $code));
		
		return $city;
	}
	
	
}
