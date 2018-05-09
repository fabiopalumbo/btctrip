<?php
namespace BtcTrip\HotelsBundle\DependencyInjection;

use BtcTrip\MainBundle\Service\BaseService;

class MailTemplateManager extends BaseService {
	
	private $purchaseConfirmationTemplate = "BtcTripHotelsBundle:MailTemplate:buyerPaymentConfirmation.html.php";
	private $paymentConfirmationTemplate = "BtcTripHotelsBundle:MailTemplate:paymentConfirmationToAdmins.txt.php";
	
	public function generateContentForBuyerPaymentConfirmation($order) {
		
// 		$subject = "BTCTrip - We are booking your place - " . $itineraryBrief;
                $hotel_id=$order['item']['hotel']['cityId']; 
                $city = $this->get('city_manager')->getCityName($hotel_id);
		$content = $this->get('templating')->render($this->purchaseConfirmationTemplate, array('order' => $order, 'city'=>$city));
		
		return $content;
	}
	
	public function generateContentForAdminsPaymentConfirmation($order) {
		$content = $this->container->get( 'templating' )->render( $this->paymentConfirmationTemplate, array(
				'order' => $order
		) );
	
		return $content;
	}
	
}

