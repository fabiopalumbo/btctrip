<?php

namespace BtcTrip\MainBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;


class BaseService {
	
	protected $container;
	protected $logger;
	
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
		
		$this->logger = $this->container->get('logger');
	}
	
	protected function get($serviceName) {
		return $this->container->get($serviceName);
	}
	
	public function getLogger() {
		return $this->logger;
	}
	
	public function setLogger($logger) {
		$this->logger = $logger;

		return $this;
	}

}