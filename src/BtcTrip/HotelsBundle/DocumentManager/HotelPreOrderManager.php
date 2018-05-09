<?php

namespace BtcTrip\HotelsBundle\DocumentManager;

use BtcTrip\MainBundle\Service\BaseService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Administra los Documentos Order.
 * 
 * HotelSerachResultManager class
 *
 */
class HotelPreOrderManager extends BaseService {

    private function getCollection() {
        $megahelper = $this->get('mega_helper');
	return $megahelper->getCollection('PreOrderHotel');
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
    public function retrieveActivePreorder($iTicket) {
        $collection = $this->getCollection();
        $preorderCursor = $collection->find(array('ticket' => $iTicket))->sort(array('_id' => -1))->limit(1);
        if ($preorderCursor->hasNext()) {
            $preorder = $preorderCursor->getNext();	
            // chequear vigencia de preorder menor a 15 minutos de vida.
            if ( !$this->isActiveTimestamp($preorder['_id']->getTimestamp()) ) {
                $preorder = false;
            }
        }else{
            $preorder = false; 
        }
        return $preorder;
    }   
        /**
	 * Toma un timestamp y devuelve si se creo hace m�s de 15 minutos
         * 
         * TODO ESTO SERIA UNA FUNCION GENERICA PARA AGREGAR EN OTRA TABLA
	 */
	private function isActiveTimestamp($sessionTimestamp) {
            $referenceDate = new \DateTime('now');
            // TODO: parametrizar los minutos de expiracion de la sesion
            $referenceDate->modify("-15 minute"); 
            $sessionDate = new \DateTime('@'.$sessionTimestamp);
            $sessionDate->setTimezone(new \DateTimeZone(date_default_timezone_get()));
            return $sessionDate > $referenceDate;
	}
        
        
        
       public function buildAndPersistPreorderHotelFromSearchResult($theResult, $iTicket,$room_id) {
		$preOrderHotel = false;
		if (isset($iTicket)) {
                    
                    $rooms=$theResult['items'][0]['rooms'];
                  
                    $room_first=array();
                    foreach ($rooms as $r) {
                        if($r['id'] == $room_id) {
                              $room_first=$r;
                              break;
                        }   	
                     }
                    
                    
                    $preOrderHotel = array();
                    $preOrderHotel['orderNumber'] = $this->generateOrderNumber();
                    $preOrderHotel['hotel'] = $theResult['items'][0]['hotel'];
                    $preOrderHotel['room']=$room_first;
                    $preOrderHotel['info']=$theResult['items'][0];
                    $preOrderHotel['boxPriceInfoList'] = $theResult['items'][0]['paymentMethod'];
                    $preOrderHotel['searchUrl'] = $theResult['search']['url'];
                    $preOrderHotel['ticket'] = $iTicket;
                    $preOrderHotel['metadata'] = $theResult['metadata'];
                    $preOrderHotel['searchParameters'] = $theResult['searchParameters'];
                    $poCollection = $this->getCollection();
                    $poCollection->save($preOrderHotel);
		}
               return $preOrderHotel;
	}
        
        public function persistInterestingResultParts($resultArray, $ticket, $searchParameters, $optionalParameters, $filterParams="") {
		
                
                $rooms= $resultArray->availability[0]->rooms;
                $room_first='';
                if (isset($rooms[$resultArray->availability[0]->suggestedRoom])) {
                        foreach ($rooms as $r) {
                           if($r->id == $resultArray->availability[0]->suggestedRoom) {
                                   $room_first=$r;
                                   break;
                           }   	
                        }
                } else {
                   $room_first = $rooms[0];
                }  
            
            
            
                $session = $this->get('session_manager')->getSession();
		$sessionid = $session->getId();
		$collection = $this->getCollection();
		$aResult['sessionId'] = $sessionid;
		
              
                $aResult['room']=$room_first;
                $aResult['items'] = $resultArray->availability;
		$aResult['metadata'] = $resultArray->meta;
		// este es el ticket del resultado de la busqueda via api
                if (isset($ticket)){
                   
                    $aResult['ticket'] = $ticket;
		}
                $searchUrl = $this->container->get('request')->headers->get('referer');
                $distribution=$searchParameters['distribution'];
                $array_distribution=explode("!", $distribution);
                $cantidad_habitacion=count($array_distribution);
                $cantidad_adultos=0;
                $cantidad_ninos=0;
                foreach($array_distribution as $h){
                    $text=explode("-", $h);
                    $cantidad_adultos=$cantidad_adultos+$text[0];
                    for($i=1;$i<sizeof($text);$i++){
                        $cantidad_ninos=$cantidad_ninos+1;
                    }                  
                    
                }
                $cantidad_huesped=$cantidad_adultos+$cantidad_ninos;
                $aResult['search'] = array('url' => $searchUrl, 'optionals' => $optionalParameters, 'filters' => $filterParams,'cantidad_huesped'=>$cantidad_huesped);
                $aResult['searchParameters'] = $searchParameters;
                $collection->save($aResult);
	}
        // TODO: esto debe ir en el Manager o Dao de la order
	private function generateOrderNumber() {
		$autoincrementer = $this->get('autoincrement');
		$nextNumber = $autoincrementer->getNext('Order');
		
		return $nextNumber;
	}
        
        public function updatePreOrder($preorder, $request){
            $preorder['buyerInfo'] = $request;
            $collection = $this->getCollection();
            $collection->save($preorder);
            
            return $preorder;
        }
        
        public function updatePreOrderWith($preorder, $invoice){
            $preorder['invoice'] = $invoice;
            $collection = $this->getCollection();
            $collection->save($preorder);

            return $preorder;
        }
}
