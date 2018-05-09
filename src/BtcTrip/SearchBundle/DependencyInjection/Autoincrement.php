<?php

namespace BtcTrip\SearchBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * A Mongodb auto increment helper class, returns the next available auto 
 * incremented id. <br />
 * This class also supports re-use of the deleted ids @see getNextAvailable()
 * in order to use this feature, you need to call removeId($id) method when you
 * delete an item from your collection
 * 
 * @author suleymanmelikoglu <suleyman [at] melikoglu.info>
 * 
 * Modificaciones para convertirlo en servicio de symfony
 * 
 */
class Autoincrement {
    private $_counterCollectionName = "Counters";
    private $_dbName;
    
    protected $container;
    
    public function __construct(ContainerInterface $container) {
    	$this->container = $container;
    	$this->_dbName = $dbName = "btctrip";
    }
    
    /**
     * returns the next available auto incremented id
     * 
     * @return integer
     */
    public function getNext($collName) {
        $m = $this->getMongo();
        $dbName = $this->_dbName;
        $counterCollName = $this->_counterCollectionName;
        
        // get the next available id
        $nextAvailableId = $this->_getNextAutoIncrementId($m->$dbName, $collName);

        // if it's null, then there is no entry in the db, create one
        if(!$nextAvailableId) {
            $this->_createTheObject($m->$dbName, $collName);
            return 1;
        }

        return $nextAvailableId;
    }
    
    /**
     * return the next available unique id
     * if there is any deleted id's before, returns it for you to reuse it.
     * otherwise returns the next available auto increment id
     * 
     * @return integer
     */
    public function getNextUnique($collName) {
        $m = $this->getMongo();
        $dbName = $this->_dbName;
        $counterCollName = $this->_counterCollectionName;
        
        // get the first deleted row if one
        $object = $m->$dbName->$counterCollName->findOne(array("_id" => $collName));
        
        // if no removed id, return the next available
        if($object == null || count($object["removedIds"]) == 0)
            return $this->getNext();
        
        // sort the removed ids low to high, because we'll delete the 1st one
        sort($object["removedIds"]);
        
        // find the first item on the array and delete it
        $return = $object["removedIds"][0];
        unset($object["removedIds"][0]);
        $m->$dbName->$counterCollName->update(array("_id" => $collName), $object);
        return $return;

    }
    
    /**
     * adds the id to the "removed ids" list so we can reuse them
     * 
     * @param integer $id 
     */
    public function removeId($collName, $id) {
        $m = $this->getMongo();
        $dbName = $this->_dbName;
        $counterCollName = $this->_counterCollectionName;
        
        $collection = $m->$dbName->$counterCollName;
        
        // fetch the object
        $objectToUpdate = $collection->findOne(array("_id" => $collName));
        
        // add the id to the removed ids stack
        array_push($objectToUpdate["removedIds"], $id);
        $collection->update(array("_id" => $collName), $objectToUpdate);
    }
    
    private function _createTheObject(\MongoDB $db, $collName) {
        $counterCollName = $this->_counterCollectionName;
        $db->$counterCollName
                    ->insert(array(
                        "_id" => $collName, 
                        "seq" => new \MongoInt32("1"),
                        "removedIds" => array()
                        ));
    }
    
    /**
     * finds the next available id and increases the counter
     * 
     * @param MongoDb $db
     * @return integer 
     */
    private function _getNextAutoIncrementId(\MongoDb $db, $collName) {
        $res = $db->command(
                    array(
                        'findandmodify' => $this->_counterCollectionName,
                        'query' => array('_id' => $collName),
                        'update' => array('$inc' => array('seq' => 1)),
                        'new' => TRUE
                    )
               );
        
        // check if there is an error
        if($res["ok"] != 1)
            return false;
        
        return $res["value"]["seq"];
    }
    
    private function getMongo() {
    	$dm = $this->container->get('doctrine_mongodb')->getManager();
    	$dm->getConnection()->initialize();
    	$mongo = $dm->getConnection()->getMongo();
    	
    	return $mongo;
    }
    
}