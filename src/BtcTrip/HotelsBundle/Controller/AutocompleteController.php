<?php

namespace BtcTrip\HotelsBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use \BtcTrip\APIBtcTripBundle\Controller\APIBtcTripController;

class AutocompleteController extends Controller
{
    public function indexAction()
    {
       return $this->render('BtcTripHotelsBundle:Default:index.html.twig',array());
    }
    
    public function Autocomplete(){
        $this->apibtctrip=new \BtcTrip\APIBtcTripBundle();
    } 

    public function getHotelsByAjaxAction(Request $request){
    	$value = $request->get('query');
    	$btctrip=$this->get('btctrip_api');
    	
    	$search = $btctrip->autoCompleteHotels($value);
    	 
    	$array_search = array();
    	$array_search['data'] = $this->buildData($search->autocomplete);
    	
    	$response = new Response();
    	$response->setContent(json_encode($array_search));
    	
    	return $response;
    
    }
    
    private function buildData($searchResult) {
    	$dataTypes = array();
    	
    	foreach($searchResult as $s) {
    		switch ($s->type) {
    			// se ignoran los 'airport' para los hoteles, esto se podria sacar solo en el autocomplete de hoteles
    			case 'airport':
    				break;
    			case 'city':
    				if (!isset($dataTypes['city'])) {
						$dataTypes['city'] = array('type' => 'c', 'name' => 'Cities', 'items' => array());
    				}
    				$dataTypes['city']['items'][] = array('code' => $s->id, 'place' => $s->name);
    				break;
    			case 'hotel':
    				if (!isset($dataTypes['hotel'])) {
    					$dataTypes['hotel'] = array('type' => 'h', 'name' => 'Hotels', 'items' => array());
    				}
    				$dataTypes['hotel']['items'][] = array('code' => $s->id, 'place' => $s->name);
    				break;
    		}
    	}
    	
    	$allData = array();
    	
    	foreach ($dataTypes as $dt) {
    		// devolver a lo sumo los primeros 4 elementos de cada tipo
    		$dt['items'] = array_slice($dt['items'], 0, 4);
    		
    		$allData[] = $dt;
    	}
    	
    	return $allData;
    }
    
    public function getFlightsByAjaxAction(Request $request){
         $value = $request->get('term');
         $this->apibtctrip=new APIBtcTripController();
         $search = $this->apibtctrip->autoCompleteFlights($value);
         $response = new Response();
         $response->setContent(json_encode($search));
         return $response;
        
        
    }
    
    
}
