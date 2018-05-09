<?php

namespace BtcTrip\FlightsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;


///  http://stackoverflow.com/questions/8822463/symfony2-templating-without-request

/**
 * Helper enviador de emails
 *
 */
class ReMailer {
	protected $container;
	protected $systemEmail;
	protected $adminsEmail;

	private $purchaseConfirmationTemplate = "BtcTripFlightsBundle:ReMailer:buyerPaymentConfirmation.html.php";
	private $paymentConfirmationTemplate = "BtcTripFlightsBundle:ReMailer:paymentConfirmationToAdmins.txt.php";
	private $tellafriendTemplate = "BtcTripFlightsBundle:ReMailer:tellafriend.txt.php";
	private $betterOfferTemplate = "BtcTripFlightsBundle:ReMailer:betterOffer.txt.php";
	private $betterOfferToAdminsTemplate = "BtcTripFlightsBundle:ReMailer:betterOfferToAdmins.txt.php";

	public function __construct(ContainerInterface $container, $systemEmail, $adminsEmail) {
		$this->container = $container;
		$this->systemEmail = $systemEmail;
		$this->adminsEmail = $adminsEmail;		
	}

	public function sendBestOffer($betteroffer) {
		$logger = $this->container->get('logger');
		$logger->info("Enviando aviso de recepcion de betteroffer por email con estos datos: " . print_r($betteroffer, true));
	
		$subject = "BTCTrip - Better offer received";
		
		$message = \Swift_Message::newInstance();

// 		$logger->debug('Imagen embebida: ' . $this->getEmbebedImage($message, '/../web/bundles/btctrip/images/bt.jpg')); 

		$content = $this->container->get('templating')->render( $this->betterOfferTemplate, 
				array("betteroffer" => $betteroffer, "logoEmbebedImage" => $this->getEmbebedImage($message, '/../web/bundles/btctrip/images/bt.jpg')) );

		$this->sendEmail($betteroffer['email'], $subject, $content, $message);
	
		$subject = "BTCTrip - Better offer received - " . $betteroffer['email'];
		//$content = $this->container->get('templating')->render($this->betterOfferToAdminsTemplate, array("betteroffer" => $betteroffer));
		$content = "La oferta para mejorar es: " . print_r($betteroffer, true);

		$this->sendEmail($this->adminsEmail, $subject, $content);
	}
	
	// path relativo al kernel.root_dir
	private function getEmbebedImage($message, $imagePath) {
		$logger = $this->container->get('logger');
		
		$localPath = $this->container->getParameter('kernel.root_dir') . $imagePath;

		$logger->debug('localPath: ' . $localPath);

		return $message->embed(\Swift_Image::fromPath($localPath));
	}

	public function sendTellAFriend($tellafriend) {
		$logger = $this->container->get('logger');
		$logger->info("Enviando TellAFriend email con estos datos: " . print_r($tellafriend, true));
	
		$subject = "BTCTrip - Good news from " . $tellafriend['name'];
		$content = $this->container->get('templating')->render($this->tellafriendTemplate, array("tellafriend" => $tellafriend));

		$this->sendEmailWithCC($tellafriend['email'], $subject, $content, $tellafriend['friendsemail']);
	}

	public function sendPaymentConfirmation($order, $bitpayInvoice) {
		$logger = $this->container->get('logger');
		$logger->debug("por enviar los emails...");

		if (isset($order) && isset($bitpayInvoice)) {
			$buyerEmail = $order['buyerInfo']['contactDefinition']['email'];
			
			$this->sendPaymentConfirmationToBuyer($buyerEmail, $order, $bitpayInvoice);
			
			$this->sendPaymentConfirmationToAdmins($order, $bitpayInvoice);
			
		} else {
			$logger->error('La orden o el comprobante de bitpay estan vacios.');
		}
	}

	private function sendPaymentConfirmationToBuyer($buyerEmail, $order, $bitpayInvoice) {
		$megahelper = $this->container->get('flights_helper');
		$itineraryBrief = $megahelper->getItineraryBrief($order['itinerary']);
		
		$subject = "BTCTrip - We are booking your ticket - " . $itineraryBrief;
		$content = $this->container->get('templating')->render($this->purchaseConfirmationTemplate, array('order' => $order, 'bitpayInvoice' => $bitpayInvoice));

// 		$logger = $this->container->get('logger');

		$this->sendEmail($buyerEmail, $subject, $content);
	}

	private function sendPaymentConfirmationToAdmins($order, $bitpayInvoice) {
		$subject = "BTCTrip - Se vendio un pasaje - ". $order['number'] ;
		
		$content = $this->container->get('templating')->render($this->paymentConfirmationTemplate, 
										array('order' => $order, 'bitpayInvoice' => $bitpayInvoice));

		$this->sendEmail($this->adminsEmail, $subject, $content);
	}

	public function sendEmailToAdmins($subject, $content) {
		$this->sendEmail($this->adminsEmail, $subject, $content);
	}
	
	private function sendEmail($target, $subject, $content, $message=NULL) {
		if (!isset($message)) {
			$message = \Swift_Message::newInstance();
		}
       	
       	$message->setSubject($subject)
			->setFrom($this->systemEmail)
			->setTo($target)
			->setBcc($this->adminsEmail)
			->setBody($content, 'text/html');

		$this->container->get('mailer')->send($message);
	}

	private function sendEmailWithCC($target, $subject, $content, $cc) {
		$message = \Swift_Message::newInstance()
        		->setSubject($subject)
			->setFrom($this->systemEmail)
			->setTo($target)
			->setCc($cc)
			->setBcc($this->adminsEmail)
			->setBody($content, 'text/html');

		$this->container->get('mailer')->send($message);
	}
	
	public function isAValidEmailAddress($email) {
		if(!\Swift_Validate::email($email)) {
			$logger = $this->container->get('logger');
			$logger->debug("Direccion de email invalida " . $email);
			
			return false;
		} else {
			return true;
		}
		
	}
}
