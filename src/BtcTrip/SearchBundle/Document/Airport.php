<?php 

namespace BtcTrip\SearchBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Airport 
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Int
     */
    protected $openflightId;
   

    /**
     * @MongoDB\String
     */
    public $code;

    /**
     * @MongoDB\String
     */
    public $codeIcao;
    
    /**
     * @MongoDB\String
     */
    public $name;

    /**
     * @MongoDB\String
     */
    public $city;

    /**
     * @MongoDB\String
     */
    protected $country;

    /**
     * @MongoDB\Float
     */
    protected $latitud;

    /**
     * @MongoDB\Float
     */
    protected $longitud;

         /**
     * @MongoDB\Float
     */
    protected $timezone;

    /**
     * @MongoDB\String
     */
    protected $dst;



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
     * Set openflightId
     *
     * @param int $openflightId
     * @return \Airport
     */
    public function setOpenflightId($openflightId)
    {
        $this->openflightId = $openflightId;
        return $this;
    }

    /**
     * Get openflightId
     *
     * @return int $openflightId
     */
    public function getOpenflightId()
    {
        return $this->openflightId;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return \Airport
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get code
     *
     * @return string $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set codeIcao
     *
     * @param string $codeIcao
     * @return \Airport
     */
    public function setCodeIcao($codeIcao)
    {
        $this->codeIcao = $codeIcao;
        return $this;
    }

    /**
     * Get codeIcao
     *
     * @return string $codeIcao
     */
    public function getCodeIcao()
    {
        return $this->codeIcao;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return \Airport
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return \Airport
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get city
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return \Airport
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get country
     *
     * @return string $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set latitud
     *
     * @param float $latitud
     * @return \Airport
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;
        return $this;
    }

    /**
     * Get latitud
     *
     * @return float $latitud
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * Set longitud
     *
     * @param float $longitud
     * @return \Airport
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;
        return $this;
    }

    /**
     * Get longitud
     *
     * @return float $longitud
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * Set timezone
     *
     * @param float $timezone
     * @return \Airport
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
        return $this;
    }

    /**
     * Get timezone
     *
     * @return float $timezone
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set dst
     *
     * @param string $dst
     * @return \Airport
     */
    public function setDst($dst)
    {
        $this->dst = $dst;
        return $this;
    }

    /**
     * Get dst
     *
     * @return string $dst
     */
    public function getDst()
    {
        return $this->dst;
    }
}
