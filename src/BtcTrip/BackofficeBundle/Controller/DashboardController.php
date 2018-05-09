<?php

namespace BtcTrip\BackofficeBundle\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DashboardController extends Controller {
	
	/**
	 * @Route("/", name="dashboard")
	 * @Template(engine="php")
	 */
    public function indexAction() {
    	$orders = $this->container->get('order_manager')->getAll();
    	
        return $this->render('BtcTripBackofficeBundle:Dashboard:index.html.php', array('orders' => $orders));
    }
}
