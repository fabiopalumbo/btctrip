<?php

namespace BtcTrip\SearchBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * ExchangeRate class
 *
 */
class ExchangeRate {
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	/**
	 * Devuelve el actual bitpay exchange rate levantado de 
	 * la base de datos propia si se actualizo hace menos de un minuto.
	 * Sino devuelve false.
	 * 
	 * @return double|boolean
	 */
	public function getActualExchangeRate() {
		$logger = $this->container->get('logger');
		
		$megahelper = $this->container->get('mega_helper');
		$collection = $megahelper->getCollection('BitpayExchangeRate');
		
		$rateCursor = $collection->find()->sort(array('timestamp' => -1))->limit(1);
		$rate = $rateCursor->getNext();
		
		// el ultimo muestreo se hizo hace menos de un minuto
		if (isset($rate) && $rate['timestamp'] >= (time() - 60)) {
			$retval = $rate['rate'];
		} else {
			// pedirlo a demanda
			$bitpayService = $this->container->get('bit_pay_api');
			
			// devuelve false si no pudo recueperar el exchange rate
			$retval = $bitpayService->bpGetExchangeRate();
				
		}
		
		$logger->debug('Bitpay Exchange Rate: ' . $retval);
		
		return $retval;
		
	}
	
}
