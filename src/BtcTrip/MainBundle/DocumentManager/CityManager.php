<?php

namespace BtcTrip\MainBundle\DocumentManager;

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
	
	public function getCityName($cityId) {
		$cityCollection = $this->getCollection();
	
		$city = $cityCollection->findOne(array('id' => $cityId));
		$cityName = (isset($city['place']) ? $city['place'] : '');
	
		if ($cityName == '') {
			$airportCollection = $this->get('mega_helper')->getCollection('Airport');
				
			$airport = $airportCollection->findOne(array('id' => $cityId));
			$city = $cityCollection->findOne(array('id' => $airport['parentCity']));
				
			$cityName = (isset($city['place']) ? $city['place'] : '');
		}
	
		return $cityName;
	}
	
	public function getCityLocation($cityId) {
		$cityCollection = $this->getCollection();
		
		$city = $cityCollection->findOne(array('id' => $cityId));
		$location = $city['geoLocation'];
		
		return $location;
	}
	
	
}
