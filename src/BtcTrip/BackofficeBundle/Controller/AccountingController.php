<?php

namespace BtcTrip\BackofficeBundle\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/accounting")
 */
class AccountingController extends Controller {
	
	/**
	 * @Route("/form", name="accounting_form")
	 * @Template(engine="php")
	 */
    public function formAction() {
    	$paymentInfo = $this->container->get('accounting_manager')->getLast();
    	
        return $this->render('BtcTripBackofficeBundle:Accounting:form.html.php', array('paymentInfo' => $paymentInfo));
    }
    
    /**
     * @Route("/submit", name="accounting_submit")
     * @Template(engine="php")
     * @Method({"POST"})
     */
    public function submitAction() {
    	// get paymentInfo from request
    	$content = $this->get('request')->getContent();
    	$decoded = urldecode($content);

    	parse_str($decoded, $paymentInfo);

    	$paymentInfo = $this->container->get('accounting_manager')->savePaymentInfo($paymentInfo);
    	
    	$response = array('result' => array('message' => 'Updated!', 'code' => 'SUCCESS'));
    	
    	return new Response(json_encode($response));
    }
    
    
}
