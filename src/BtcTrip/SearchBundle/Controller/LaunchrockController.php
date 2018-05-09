<?php

namespace BtcTrip\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LaunchrockController extends Controller
{
    public function indexAction()
    {
        return $this->render('BtcTripSearchBundle:Launchrock:index.html.php');
    }
}
