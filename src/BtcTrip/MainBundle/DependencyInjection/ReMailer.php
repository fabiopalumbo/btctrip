<?php

namespace BtcTrip\MainBundle\DependencyInjection;

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

	public function __construct(ContainerInterface $container, $systemEmail, $adminsEmail) {
		$this->container = $container;
		$this->systemEmail = $systemEmail;
		$this->adminsEmail = $adminsEmail;		
	}
	
	// path relativo al kernel.root_dir
	private function getEmbebedImage($message, $imagePath) {
		$logger = $this->container->get('logger');
		
		$localPath = $this->container->getParameter('kernel.root_dir') . $imagePath;

		$logger->debug('localPath: ' . $localPath);

		return $message->embed(\Swift_Image::fromPath($localPath));
	}

	public function sendPaymentConfirmation($order) {
		$logger = $this->container->get('logger');
		$logger->debug("por enviar los emails...");

		if (isset($order)) {
			$buyerEmail = $order['buyerInfo']['contactDefinition']['email'];
			
			$this->sendPaymentConfirmationToBuyer($buyerEmail, $order);
			
			$this->sendPaymentConfirmationToAdmins($order);
			
		} else {
			$logger->error('La orden esta vacia.');
		}
	}

	private function sendPaymentConfirmationToBuyer($buyerEmail, $order) {
		$subject = "✈ BTCTrip - We are processing your booking - Order " . $order['number'];
		
		// modularizacion loca!
		$mailTemplateManager = $this->container->get($order['type'].'_mail_template_manager');
		
		$content = $mailTemplateManager->generateContentForBuyerPaymentConfirmation($order);	
		
		$this->sendEmail($buyerEmail, $subject, $content);
	}

	private function sendPaymentConfirmationToAdmins($order) {
		$subject = "BTCTrip - Nueva reserva de ". $order['type'] . " - " . $order['number'] ;
		
		$mailTemplateManager = $this->container->get($order['type'].'_mail_template_manager');
		
		$content = $mailTemplateManager->generateContentForAdminsPaymentConfirmation($order);

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
