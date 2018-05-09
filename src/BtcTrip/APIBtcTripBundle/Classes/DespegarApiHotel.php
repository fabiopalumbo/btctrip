<?php
namespace BtcTrip\APIBtcTripBundle\Classes;

class DespegarApiHotel {
    
    /*
     * TODO
     * Poner todas las propiedades que tengo el hotel
     * 
     */
    
    private $id;
    private $name;
    private $avgPriceWithoutTax;
    private $starRating;
    private $description;
    private $address;
    private $latitude;
    private $longitude;
    private $distance;
    private $commentsCount;
    private $avgDiscountPriceWithoutTax;
    private $picture;
    

    public function __construct($json_obj) {
        //print_r($json_obj);
        $this->id = $json_obj->hotel->id;
        $this->name = $json_obj->hotel->name;
        
        $this->avgPriceWithoutTax = !empty($json_obj->avgPriceWithoutTax) ? $json_obj->avgPriceWithoutTax : 0;
        $this->starRating = $json_obj->hotel->starRating;
        $this->description = $json_obj->hotel->description;
        $this->address = $json_obj->hotel->address;
        $this->latitude = $json_obj->hotel->geoLocation->latitude;
        $this->longitude = $json_obj->hotel->geoLocation->longitude;
        $this->picture = $json_obj->hotel->pictureName;
        $this->commentsCount=$json_obj->hotel->reviewSummary->commentsCount;
        if ( property_exists($json_obj, 'distance') )
          $this->distance = $json_obj->distance;
        else
          $this->distance = DespegarApi::RADIUS;

        if ( property_exists($json_obj, 'avgDiscountPriceWithoutTax') )
          $this->avgDiscountPriceWithoutTax = $json_obj->avgDiscountPriceWithoutTax;
        else
          $this->avgDiscountPriceWithoutTax = "";

        
    }
    
    /**
     * @return Integer
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @return String
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * @return String
     */
    public function getCommentsCount() {
        return $this->commentsCount;
    }
    
    
    /**
     * @return String
     */
    public function getAvgPriceWithoutTax() {
        return $this->avgPriceWithoutTax;
    }
    /**
     * @return String
     */
    public function getAvgDiscountPriceWithoutTax() {
        return $this->avgDiscountPriceWithoutTax;
    }
    /**
     * @return String
     */
    public function getStarRating() {
        return $this->starRating;
    }
    
    /**
     * @return String
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return String
     */
    public function getAddress() {
        return $this->address;
    }
    
    /**
     * @return String
     */
    public function getLatitude() {
        return $this->latitude;
    }
    
    /**
     * @return String
     */
    public function getLongitude() {
        return $this->longitude;
    }
    
    /**
     * @return String
     */
    public function getDistance() {
        return $this->distance;
    }
    
    public function setDistance($distance) {
        $this->distance = $distance;
    }

    public function getPicture() {
        return DespegarApi::getStaticContentUrl() . $this->picture;
    }

} // DespegarApiHotel

