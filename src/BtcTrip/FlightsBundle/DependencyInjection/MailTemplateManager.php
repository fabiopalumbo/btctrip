<?php

namespace BtcTrip\FlightsBundle\DependencyInjection;

use BtcTrip\MainBundle\Service\BaseService;

class MailTemplateManager extends BaseService {
	private $purchaseConfirmationTemplate = "BtcTripFlightsBundle:MailTemplate:buyerPaymentConfirmation.html.php";
	private $paymentConfirmationTemplate = "BtcTripFlightsBundle:MailTemplate:paymentConfirmationToAdmins.txt.php";
	
	public function generateContentForBuyerPaymentConfirmation($order) {
// 		$megahelper = $this->get( 'flights_helper' );
// 		$itineraryBrief = $megahelper->getItineraryBrief( $order ['itinerary'] );
		
		// $subject = "BTCTrip - We are booking your ticket - " . $itineraryBrief;
		$content = $this->get( 'templating' )->render( $this->purchaseConfirmationTemplate, array(
				'order' => $order
		) );
		
		return $content;
	}
	public function generateContentForAdminsPaymentConfirmation($order) {
		$content = $this->container->get( 'templating' )->render( $this->paymentConfirmationTemplate, array(
				'order' => $order
		) );
		
		return $content;
	}
}