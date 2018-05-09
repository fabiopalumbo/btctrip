<?php

namespace BtcTrip\MainBundle\DocumentManager;

use BtcTrip\MainBundle\Service\BaseService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Administra los Documentos relacionados a la contabilidad, por el momento solo es el PaymentInfo.
 * 
 * OrderManager class
 *
 */
class AccountingManager extends BaseService {

	private function getCollection() {
		$megahelper = $this->get('mega_helper');
		return $megahelper->getCollection('PaymentInfo');
	} 
	
	/**
	 * @return El ultimo paymentInfo
	 */
	public function getLast() {
		$collection = $this->getCollection();
		$paymentInfoCursor = $collection->find()->sort(array('_id' => -1))->limit(1);
		$paymentInfo = $paymentInfoCursor->getNext();
		
		return $paymentInfo;
	}
	
	public function savePaymentInfo($paymentInfo) {
		$collection = $this->getCollection();
		$collection->save($paymentInfo);
	}
	
	
}
