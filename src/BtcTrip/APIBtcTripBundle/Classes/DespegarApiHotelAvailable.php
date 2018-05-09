<?php 
namespace BtcTrip\APIBtcTripBundle\Classes;
/*
 * Esta clase sirve para la disponibilidad del hotel con todos sus datos de las habitaciones
 */
class DespegarApiHotelAvailable extends DespegarApiHotel {

	private $data;

	public function __construct($json_obj) {
		parent::__construct($json_obj->availability[0]);
		$this->data = $json_obj;
	}

	protected function getMeta() {
		return $this->data->meta;
	}

	protected function getAvailability() {
		return $this->data->availability[0];
	}

	public function getReviewSummary() {
	  $ret = array(
            "overallRating" => 0,
            "rating" => array(
                "building" => 0,
                "location" => 0,
                "personal" => 0,
                "cleaning" => 0,
                "quality_price" => 0,
                "service" => 0
            ));
            
		$summary = $this->getAvailability()->hotel->reviewSummary;
    if (!empty($summary)) {
      $ret['overallRating'] = $summary->overallRating;
      $rating = $summary->rating;
      if (!empty($rating)) {
        $ret['building'] = $rating->building;
        $ret['location'] = $rating->location;
        $ret['personal'] = $rating->personal;
        $ret['cleaning'] = $rating->cleaning;
        $ret['quality_price'] = $rating->quality_price;
        $ret['service'] = $rating->service;
      }
    }
		return $ret;
	}

        public function getHotel(){
            
           $hotel= $this->getAvailability()->hotel;
           $h = array("id" => $hotel->id,
                      "description" => $hotel->description,
		      "name" => $hotel->name,
                      "pictureName"=> $hotel->pictureName,
                       "starRating"=>$hotel->starRating,
                       "commentsCount"=>$hotel->reviewSummary->commentsCount,
		);
            // print_r($hotel->name);
         // die;
           return $h;         
        }
        
        public function getAvailable(){
            
           $availability= $this->getAvailability();
           $available = array("suggestedRoom" => $availability->suggestedRoom,
                      "sessionTicket" => $availability->sessionTicket,
		      "ticket" => $availability->ticket,
                      "roomsInDetail"=> $availability->roomsInDetail,
                       "suggestedPaymentId"=>$availability->suggestedPaymentId,
                       "paymentType"=>$availability->paymentMethod->payments[0]->paymentType,
                       "installmentQuantity"=> $availability->paymentMethod->payments[0]->installmentQuantity,
		);
            // print_r($hotel->name);
         // die;
           return $available;         
        }
        
        
        
        
	public function getRoomsAvailable() {
		$rooms = array();
                foreach ($this->getAvailability()->rooms as $room) {
		    $newRoom = array(
				"id" => $room->id,
				"description" => $room->description,
				"penalty" => array(
					"hours" 	  => $room->penalty->hours,
					"description" => $room->penalty->description,
					"refundable"  => $room->penalty->refundable
				),
				"regimeCode" => $room->regimeCode,
				"regimeDescription" => $room->regimeDescription,
				"discountText" => $room->discountText,
				"price" => array(
			       "totalPrice" => $room->prices->totalPrice->totalPrice,
			       "priceWithoutTax" => $room->prices->totalPrice->priceWithoutTax,
			       "taxes" => $room->prices->totalPrice->taxes
				)
			);
      
                                $meta = $this->getMeta();
                                if (!empty($meta)) {
                                  $newRoom['currency'] = $meta->currencyCode;
                                }

                                $penalty = $room->penalty;
                                if (!empty($penalty)) {
                                  $newRoom["penalty"] = array(
                                    "hours"     => $penalty->hours,
                                    "description" => $penalty->description,
                                    "refundable"  => $penalty->refundable
                                  );
                                }

                                $prices = $room->prices;
                                if (!empty($prices)) {
                                  $totalPrice = $prices->totalPrice;
                                  if (!empty($totalPrice)) {
                                    $newRoom["price"] = array(
                                      "totalPrice"     => $totalPrice->totalPrice,
                                      "priceWithoutTax" => $totalPrice->priceWithoutTax,
                                      "taxes"  => $totalPrice->taxes
                                    );
                                  }
                                }
                                if(isset($room->roomsDetail[0]->amenities)){
                                    
                                
                                $roomsDetail=$room->roomsDetail[0]->amenities;
                                if (!empty($roomsDetail)) {
                                    $amenities=array();
                                    $cant=0;
                                    foreach($roomsDetail as $a){
                                        $amenities[$cant]['id']=$a->id;
                                        $amenities[$cant]['isPrimary']=$a->isPrimary;
                                        $amenities[$cant]['internalId']=$a->internalId;
                                        $amenities[$cant]['description']=$a->description;
                                        $cant++;
                                    }
                                    $newRoom['amenities']=$amenities;
                                }
                                }
                                if(isset($room->roomsDetail[0]->pictures)){
                                    $pictures=$room->roomsDetail[0]->pictures;
                                    if (!empty($pictures)) {
                                        $array_pictures=array();
                                        $cant=0;
                                        foreach($pictures as $p){
                                            $array_pictures[$cant]['imagen']=$p;
                                            $cant++;
                                        }
                                        $newRoom['pictures']=$array_pictures;
                                    }
                                }
                                if(isset($room->roomsDetail[0]->availableRooms)){
                                $availableRooms=$room->roomsDetail[0]->availableRooms;
                                    if (!empty($availableRooms)) {
                                        $newRoom['availableRooms']=$availableRooms;
                                    }
                                
                                    
                                } 
                                
                                $rooms[] = $newRoom;
		}
		
		return $rooms;
	}

} // DespegarApiHotelAvailable
