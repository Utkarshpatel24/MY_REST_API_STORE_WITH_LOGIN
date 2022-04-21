<?php

use Phalcon\Mvc\Model;
use MongoDB\BSON\ObjectId;
class Orders extends Model
{
    public $collection;
    public function initialize()
    {
        $this->collection = $this->di->get("mongo");
        
        $this->collection = $this->collection->store->orders;

    }
    public function insert($productData)
    {

        $insert = $this->collection->insertOne($productData);
            
    }
    public function search($status = "", $f_date ="", $t_date="" )
    {
        if ($status != "") {

            $result =  $this->collection->find(
                
                ['date' => ['$gte' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime($f_date)))), '$lte' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime($t_date))))], "status"=>$status]
            );
        } else {
            $result = $this->collection->find();
        }
       
        return $result;
    }
}