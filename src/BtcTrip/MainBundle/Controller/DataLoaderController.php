<?php

namespace BtcTrip\MainBundle\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/dataloader")
 */
class DataLoaderController extends Controller
{
	
	/**
	 * @ Route("/downloadFlags")
	 */
	public function downloadFlagsAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$result = $dataLoaderService->downloadAirlineFlags();
	
		return new Response('<pre>' . print_r($result, true) . '</pre>');
	}

	/**
	 * @ Route("/addAirportManually")
	 */
	public function addAirportManuallyAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$result = $dataLoaderService->addAirportManually();
	
		return new Response('<pre>' . print_r($result, true) . '</pre>');
	}

	/**
	 * @ Route("/translateCities")
	 */
	public function translateCitiesAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$result = $dataLoaderService->translateCities();
	
		return new Response('<pre>' . print_r($result, true) . '</pre>');
	}

	/**
	 * @ Route("/translateCountries")
	 */
	public function translateCountriesAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$result = $dataLoaderService->translateCountries();
	
		return new Response('<pre>' . print_r($result, true) . '</pre>');
	}

	/**
	 * @ Route("/addPlaceToAirports")
	 */
	public function addPlaceToAirportsAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$result = $dataLoaderService->addPlaceToAirports();
	
		return new Response('<pre>' . print_r($result, true) . '</pre>');
	}

	/**
	 * @ Route("/addPlaceToCities")
	 */
	public function addPlaceToCitiesAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$result = $dataLoaderService->addPlaceToCities();
	
		return new Response('<pre>' . print_r($result, true) . '</pre>');
	}



	/**
	 * @ Route ( " / retrieveStates")
	 */
	public function statesAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$testLoad = $dataLoaderService->retrieveStates();

		return new Response('<pre>' . print_r($testLoad, true) . '</pre>');
	}

	/**
	 * @ Route( " / retrieveCountries")
	 */
	public function countriesAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$testLoad = $dataLoaderService->retrieveCountries();

		return new Response('<pre>' . print_r($testLoad, true) . '</pre>');
	}

	/**
	 * @ Route ( " / retrieveCities " )
	 */
	public function citiesAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$testLoad = $dataLoaderService->retrieveCities();

		return new Response('<pre>' . print_r($testLoad, true) . '</pre>');
	}

	/**
	 * @ Route ( " / retrieveAirports " )
	 */
	public function airportsAction() {
		$logger = $this->get('logger');
		$dataLoaderService = $this->get('data_loader');
		$testLoad = $dataLoaderService->retrieveAirports();

		return new Response('<pre>' . print_r($testLoad, true) . '</pre>');
	}


}
