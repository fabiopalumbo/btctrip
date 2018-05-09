<?php
namespace BtcTrip\APIBtcTripBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \BtcTrip\APIBtcTripBundle\Classes\DespegarApi as DespegarApi;


class APIBtcTripController extends Controller
{
    public function indexAction()
    {
        return $this->render('BtcTripAPIBtcTripBundle:APIBtcTrip:index.html.twig', array());
    }
}
