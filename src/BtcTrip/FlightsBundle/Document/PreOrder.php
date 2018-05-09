<?php 

namespace BtcTrip\FlightsBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class PreOrder 
{

    /**
     * @MongoDB\Id 
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $sessionId;
   

    /**
     * @MongoDB\ReferenceMany
     */
    public $outboundRoute;

    /**
     * @MongoDB\ReferenceMany
     */
    public $inboundRoute;
    
    /**
     * @MongoDB\ReferenceMany
     */
    public $itenerariesBoxPriceInfoList;

    /**
     * @MongoDB\ReferenceMany
     */
    public $bitpayInvoce;

    public function __construct()
    {
        $this->outboundRoute = new \Doctrine\Common\Collections\ArrayCollection();
        $this->inboundRoute = new \Doctrine\Common\Collections\ArrayCollection();
        $this->itenerariesBoxPriceInfoList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bitpayInvoce = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sessionId
     *
     * @param string $sessionId
     * @return \PreOrder
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    /**
     * Get sessionId
     *
     * @return string $sessionId
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Add outboundRoute
     *
     * @param $outboundRoute
     */
    public function addOutboundRoute($outboundRoute)
    {
        $this->outboundRoute[] = $outboundRoute;
    }

    /**
    * Remove outboundRoute
    *
    * @param <variableType$outboundRoute
    */
    public function removeOutboundRoute($outboundRoute)
    {
        $this->outboundRoute->removeElement($outboundRoute);
    }

    /**
     * Get outboundRoute
     *
     * @return Doctrine\Common\Collections\Collection $outboundRoute
     */
    public function getOutboundRoute()
    {
        return $this->outboundRoute;
    }

    /**
     * Add inboundRoute
     *
     * @param $inboundRoute
     */
    public function addInboundRoute($inboundRoute)
    {
        $this->inboundRoute[] = $inboundRoute;
    }

    /**
    * Remove inboundRoute
    *
    * @param <variableType$inboundRoute
    */
    public function removeInboundRoute($inboundRoute)
    {
        $this->inboundRoute->removeElement($inboundRoute);
    }

    /**
     * Get inboundRoute
     *
     * @return Doctrine\Common\Collections\Collection $inboundRoute
     */
    public function getInboundRoute()
    {
        return $this->inboundRoute;
    }

    /**
     * Add itenerariesBoxPriceInfoList
     *
     * @param $itenerariesBoxPriceInfoList
     */
    public function addItenerariesBoxPriceInfoList($itenerariesBoxPriceInfoList)
    {
        $this->itenerariesBoxPriceInfoList[] = $itenerariesBoxPriceInfoList;
    }

    /**
    * Remove itenerariesBoxPriceInfoList
    *
    * @param <variableType$itenerariesBoxPriceInfoList
    */
    public function removeItenerariesBoxPriceInfoList($itenerariesBoxPriceInfoList)
    {
        $this->itenerariesBoxPriceInfoList->removeElement($itenerariesBoxPriceInfoList);
    }

    /**
     * Get itenerariesBoxPriceInfoList
     *
     * @return Doctrine\Common\Collections\Collection $itenerariesBoxPriceInfoList
     */
    public function getItenerariesBoxPriceInfoList()
    {
        return $this->itenerariesBoxPriceInfoList;
    }

    /**
     * Add bitpayInvoce
     *
     * @param $bitpayInvoce
     */
    public function addBitpayInvoce($bitpayInvoce)
    {
        $this->bitpayInvoce[] = $bitpayInvoce;
    }

    /**
    * Remove bitpayInvoce
    *
    * @param <variableType$bitpayInvoce
    */
    public function removeBitpayInvoce($bitpayInvoce)
    {
        $this->bitpayInvoce->removeElement($bitpayInvoce);
    }

    /**
     * Get bitpayInvoce
     *
     * @return Doctrine\Common\Collections\Collection $bitpayInvoce
     */
    public function getBitpayInvoce()
    {
        return $this->bitpayInvoce;
    }
}
