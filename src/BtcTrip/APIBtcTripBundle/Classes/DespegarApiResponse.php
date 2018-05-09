<?php
namespace BtcTrip\APIBtcTripBundle\Classes;

/*
 * Este objecto maneja la respuesta , error, datos, cantidad de registro
 */

class DespegarApiResponse {
    
    
    public $resultCount = 0;
    private $hotels = array();
    private $pagesize = 0;
    
    public function __construct($json_obj, $pagesize=0) {
        $this->resultCount = $json_obj->meta->total;
        $this->pagesize = $pagesize;
        foreach ($json_obj->availability as $hotelInfo) {
            $this->hotels[] = new DespegarApiHotel($hotelInfo);
        }
    }
    
    /**
     * @return Integer
     */
    public function count() {
        return $this->resultCount;
    }
    
    /**
     * @return DespegarApiHotel
     */
    public function getHotel($number) {
        return $this->hotels[$number];
    }
    
    public function getAll() {
      return $this->hotels;
    }
    
    public function getPage($page) {
      $offset = $this->getPageSize() * ($page - 1);
      $size = $this->getPageSize();
      
      if ($offset > $this->count())
        return array();
      
      if ($size == 0)
        $size = NULL;
      
      return array_slice($this->hotels, $offset, $size);
    }
    
    public function getPageCount() {
      if ($this->pagesize == 0)
        return 1;
      return $this->count() / $this->pagesize;
    }
    
    public function getPageSize() {
      return $this->pagesize;
    }
    
} // DespegarApiResponse