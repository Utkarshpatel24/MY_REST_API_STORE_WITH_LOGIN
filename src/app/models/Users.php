<?php

use Phalcon\Mvc\Model;
use MongoDB\BSON\ObjectId;
class Users extends Model
{
    public $collection;
    public function initialize()
    {
        $this->collection = $this->di->get("mongo");
        
        $this->collection = $this->collection->store->users;

    }
    public function insert($userData)
    {

        $insert = $this->collection->insertOne($userData);
            
    }
    public function check($userData)
    {
        $result = $this->collection->find(["email" => $userData['email'], "password" => $userData['password']]);
        return $result;
    }
    public function updateData($postdata)
    {
        $result = $this->collection->updateOne(
            [
                // "_id" => (new ObjectId($postdata['']))
                "email" => $postdata['email']
            ],
            [
                '$set'=>["token" => $postdata['token']]
            ]
        );
    }
}