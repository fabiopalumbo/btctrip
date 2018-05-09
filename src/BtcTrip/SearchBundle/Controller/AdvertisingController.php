<?php

namespace BtcTrip\SearchBundle\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class AdvertisingController extends Controller {

	/**
	 * @ Route (" /tellafriend", name="_tellafriend")
	 */
// 	public function tellafriendAction(Request $request) {
// 		$logger = $this->get('logger');

// 		$name = $request->request->get('yourname');
// 		$email = $request->request->get('youremail');
// 		$friendsname = $request->request->get('friendsname');
// 		$friendsemail = $request->request->get('friendsemail');

// 		$tellafriend = array("name" => $name, "email" => $email, "friendsname" => $friendsname, "friendsemail" => $friendsemail );
		
// 		$logger->info("Telling a friend with this data: " . print_r($tellafriend, true));
		

// 		$session->set($this->session_var, $text);
		
// 		if (isset($name) && isset($email) && isset($friendsname) && isset($friendsemail) ) {
// 			$session = new Session();
// 			$session->start();
			
// 			if($captcha == $session->get()) {
					
// 				// guardar el contacto
// 				$megaHelper = $this->get('mega_helper');
// 				$tafCollection = $megaHelper->getCollection('TellAFriend');
// 				$tafCollection->save($tellafriend);
				
// 				// enviar el email
// 				$this->get('remailer')->sendTellAFriend($tellafriend);
	
// 			 	return new Response("Good news sended!");
			 	
// 			} else {
				
// 			}

// 		} else {
// 			return new Response("We need all the fields filled.");	
// 		}
// 	} 


	/**
	 * @Route("/betteroffer", name="_betteroffer")
	 */
	public function betterpriceAction(Request $request) {
		$logger = $this->get('logger');

		$offerlink = $request->request->get('offerlink');
		$airfareprice = $request->request->get('airfareprice');
		$name = $request->request->get('name');
		$email = $request->request->get('email');
		$captcha = $request->request->get('captcha');

		$betteroffer = array("name" => $name, "email" => $email, "offerlink" => $offerlink, "airfareprice" => $airfareprice, "captcha" => $captcha);
		
		$logger->info("We received a best offer: " . print_r($betteroffer, true));

		// validacion de campos
		if (empty($name) || empty($email) || empty($offerlink) || empty($airfareprice) || empty($captcha)) {
			return new Response("All fields are required.");	
		}
					
		$session = new Session();
		$session->start();

		$logger->debug("Generated captcha code: " . $session->get('captcha'));
		
		// validacion del captcha
		if( $captcha != $session->get('captcha') ) {
		 	return new Response("Wrong captcha code.");
		} 
		
		// validacion del email
		if ( !$this->get('remailer')->isAValidEmailAddress($email) ) {
			return new Response("A valid email address is required.");
		}
		
		// guardar la mejor oferta
		$megaHelper = $this->get('mega_helper');
		$betterofferCollection = $megaHelper->getCollection('BetterOffer');
		$betterofferCollection->save($betteroffer);
		
		// enviar el email
		$this->get('remailer')->sendBestOffer($betteroffer);

	 	return new Response("Best offer sent.");
			 	
	} 

}
