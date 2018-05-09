<?php

namespace BtcTrip\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class HomeController extends Controller  {
    /**
     * @Route("/home", name="oldHome")
     */
    public function oldHomeAction()	{
    	return $this->redirect($this->generateUrl('home'));
    }
    
    /**
     * @Route("/", name="home")
     * @Template(engine="php")
     */
    public function homeAction() {
    	$enviromentPrefix = $this->get('mega_helper')->getEnviromentPrefix();
    
    	return array('enviromentPrefix' => $enviromentPrefix);
    }
    
}
