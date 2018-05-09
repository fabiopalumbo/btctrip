<?php

namespace BtcTrip\MainBundle\DocumentManager;

use BtcTrip\MainBundle\Service\BaseService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Administra los Documentos Order.
 * 
 * OrderManager class
 *
 */
class OrderManager extends BaseService {

	private function getCollection() {
		$megahelper = $this->get('mega_helper');
		return $megahelper->getCollection('Order');
	} 
	
	/**
	 * @return Cursor de Orders
	 */
	public function getAll() {
		$collection = $this->getCollection();
		$orders = $collection->find()->sort(array('_id' => -1))->limit(50);
		
		return $orders;
		
	}
	
	public function getById($orderId) {
		$collection = $this->getCollection();
		$order = $collection->findOne(array('_id' => new \MongoId($orderId)));
		
		return $order;
	}
	
	public function save($order) {
		$collection = $this->getCollection();
		$collection->save($order);
	}
	
	
}
