<?php

namespace BtcTrip\HotelsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;
use \BtcTrip\HotelsBundle\Transformer\AvailabilityResultTransformer as AvailabilityResultTransformer;
use BtcTrip\MainBundle\Service\BaseService;

/**
 * Helper para Hotels
 *
 */
class HotelsHelper extends BaseService {

    public function processAvailabilityResponse($apiResponse, $searchParameters, $filterParams) {
        $logger = $this->get('logger');
        $megaHelper = $this->get('mega_helper');
        $page = 1;
        if (isset($filterParams) && isset($filterParams['page'])) {
            $page = $filterParams['page'];
        }
        $transformer = new AvailabilityResultTransformer($this->container);
        $response = $transformer->transform($apiResponse, $page, $searchParameters);
        return $response;
    }

    // Warning: Cuenta SOLO adultos!
    public function countAdults($orderItem) {
    	$array_distribution = explode("!", $orderItem['search']['parameters']['distribution']);
    	$cantidad_habitacion = count($array_distribution);
    	$cantidad_adultos = 0;
    	if ($cantidad_habitacion > 1) {
    		foreach($array_distribution as $h){
    			$text = explode("-", $h);
    			$cantidad_adultos = $cantidad_adultos + $text[0];
    		}
    	}else{
    		$cantidad_adultos = $array_distribution[0];
    	}
    	
        return $cantidad_adultos;
    }
    
    public function countRooms($orderItem) {
    	$array_distribution = explode("!", $orderItem['search']['parameters']['distribution']);
    	$cantidad_habitacion = count($array_distribution);
    	
    	return $cantidad_habitacion;
    }
	

}
