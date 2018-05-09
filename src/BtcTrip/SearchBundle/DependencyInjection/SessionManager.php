<?php
namespace BtcTrip\SearchBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Administra el acceso a la session de usuario.
 * 
 * @author yamil
 *
 */
class SessionManager {
	const LAST_FLIGHT_SEARCH_URL = 'last_flight_search_url';
	
	protected $container;
	
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	public function getSession() {
		$session = $this->container->get('request')->getSession();
		$session->start();
		
		return $session;
	}
	
	public function getLastUserSearch() {
		$lastSearchUrl = $this->getSession()->get(self::LAST_FLIGHT_SEARCH_URL);
	
		if (isset($lastSearchUrl)) {
			return $lastSearchUrl;
		} else {
			return false;
		}
	}
	
	public function setLastUserSearch($searchUrl) {
		$this->getSession()->set(self::LAST_FLIGHT_SEARCH_URL, $searchUrl);
	}
}