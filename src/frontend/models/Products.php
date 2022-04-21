<?php

use Phalcon\Mvc\Model;
use MongoDB\BSON\ObjectId;
class Products extends Model
{
    public $collection;
    public function initialize()
    {
        $this->collection = $this->di->get("mongo");
        
        $this->collection = $this->collection->store->products;

    }
   
    public function insert($productData)
    {

        $insert = $this->collection->insertOne($productData);
            
    }
    public function search($name = [])
    {
        if (count($name) > 0) {

            $result = $this->collection->find(["name"=>$name]);
        } else {
            $result = $this->collection->find();
        }
        return $result;
    }

    public function searchById($id)
    {

        return $this->collection->find(['_id'=>(new ObjectId($id))]);
    }
    public function deleteById($id)
    {
        return $this->collection->deleteOne(['_id'=>(new ObjectId($id))]);
    }
}