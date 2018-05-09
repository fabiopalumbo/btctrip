<?php

namespace BtcTrip\MainBundle\DependencyInjection;

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
// 	public function getActualExchangeRate() {
// 		$logger = $this->container->get('logger');
		
// 		$megahelper = $this->container->get('mega_helper');
// 		$collection = $megahelper->getCollection('BitpayExchangeRate');
		
// 		$rateCursor = $collection->find()->sort(array('timestamp' => -1))->limit(1);
// 		$rate = $rateCursor->getNext();
		
// 		// el ultimo muestreo se hizo hace menos de un minuto
// 		if (isset($rate) && $rate['timestamp'] >= (time() - 60)) {
// 			$retval = $rate['rate'];
// 		} else {
// 			// pedirlo a demanda
// 			$bitpayService = $this->container->get('bit_pay_api');
			
// 			// devuelve false si no pudo recueperar el exchange rate
// 			$now = new \DateTime('now');
// 			$bitpayExchangeRate['timestamp'] = $now->getTimestamp();
// 			$bitpayExchangeRate['rate'] = $bitpayService->bpGetExchangeRate();
			
// 			$collection->save($bitpayExchangeRate);
			
// 			$retval = $bitpayExchangeRate['rate'];
// 		}
		
// 		$logger->debug('Bitpay Exchange Rate: ' . $retval);
		
// 		return number_format($retval, 2, '.', ',');
// 	}
	
	/**
	 * Devuelve los ultimos rates conseguidos o busca uno.
	 * Tiene la siguiente forma:
	 * 
	 * {
	 * 	'timestamp': 231232132,
	 *  'rates' : [
	 *  	{'code' : 'BTC',
	 *  	'rate': 2334.23,
	 *  	'source': 'bitpay'},
	 *  	{}, {}
	 *  ]
	 * }
	 * 
	 */
	public function getLastExchangeRates() {
		$logger = $this->container->get('logger');
		
		$megahelper = $this->container->get('mega_helper');
		$collection = $megahelper->getCollection('ExchangeRate');
		
		$rateCursor = $collection->find()->sort(array('timestamp' => -1))->limit(1);
		$lastPersistedRate = $rateCursor->getNext();
		
		// el ultimo muestreo se hizo hace menos de un minuto
		if (isset($lastPersistedRate) && $lastPersistedRate['timestamp'] >= (time() - 60)) {
			$retval = $lastPersistedRate;
		} else {
			$now = new \DateTime('now');
			$fullXchgRate['timestamp'] = $now->getTimestamp();

			$fullXchgRate['rates'] = $this->getLastExchangeRateBitpay();
			$fullXchgRate['rates'] = array_merge($this->getLastExchangeRateGocoin(), $fullXchgRate['rates']);
			
			$collection->save($fullXchgRate);
			
			$retval = $fullXchgRate;
		}
		
		return $retval;
	}
	
	/**
	 * 
	 * 
	 * @return array asi:
	 *  
	 *	Array (
	 *	    [XDG] => 0.000134
	 *	    [LTC] => 4.94
	 *	    [BTC] => 517.00
	 *	)
	 */
	public function getLastExchangeRatesCurrencyIndexed() {
		$retval = $this->getLastExchangeRates();
		 
		$retvalIndexed = array();
		
		foreach ($retval['rates'] as $rate) {
			$indexedRate[$rate['code']] = $rate['rate']; 
		}
		
		return $indexedRate;
		
	}
	
	private function getLastExchangeRateBitpay() {
		$retval = array();
		
		// pedirlo a demanda
		$bitpayService = $this->container->get('bit_pay_api');
			
		// devuelve false si no pudo recueperar el exchange rate
		//$xchrate['rate'] = 2;//number_format($bitpayService->bpGetExchangeRate(), 2, '.', ',');
		//$xchrate['code'] = 'BTC';
		//$xchrate['source'] = 'bitpay';
		
		//$retval[] = $xchrate;
		
		return $retval;
	}
	
	private function getLastExchangeRateGocoin() {
		$retval = array();
		
		// pedirlo a demanda
		$gocoinService = $this->container->get('go_coin_api');

		$gocoinXchgRate = $gocoinService->getExchangeRates();
		
		// devuelve false si no pudo recueperar el exchange rate
		$xchrate['rate'] = number_format($gocoinXchgRate->prices->XDG->USD, 6, '.', ',');
		$xchrate['code'] = 'XDG';
		$xchrate['source'] = 'gocoin';

		$retval[] = $xchrate;
		
		$xchrate2['rate'] = number_format($gocoinXchgRate->prices->LTC->USD, 2, '.', ',');
		$xchrate2['code'] = 'LTC';
		$xchrate2['source'] = 'gocoin';
		
		$retval[] = $xchrate2;

		$xchrate3['rate'] =  number_format($gocoinXchgRate->prices->BTC->USD, 0, '', ''); //dot and comma
		$xchrate3['code'] = 'BTC';
		$xchrate3['source'] = 'gocoin';
		
		$retval[] = $xchrate3;
		
		return $retval;
	}
	
}
