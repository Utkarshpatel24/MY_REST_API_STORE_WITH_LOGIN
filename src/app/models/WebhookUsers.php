<?php

use Phalcon\Mvc\Model;
use MongoDB\BSON\ObjectId;
class WebhookUsers extends Model
{
    public $collection;
    public function initialize()
    {
        $this->collection = $this->di->get("mongo");
        
        $this->collection = $this->collection->WebhookUsers;

    }
    public function insert($webhookData)
    {

        print_r($webhookData);
        print_r($webhookData['events']);
        foreach ($webhookData['events'] as $val) {
            if ($val == "when product is added") {
                $this->insertForAddEvent($webhookData['name'], $webhookData['url']);
            }
            if ($val == "when product is updated") {
                $this->insertForUpdateEvent($webhookData['name'], $webhookData['url']);
            }
        }
        
            
    }
    public function insertForAddEvent($name, $url)
    {
        $this->collection->OnAddProduct->insertOne(["name"=>$name, "url"=>$url]);
    }
    public function insertForUpdateEvent($name, $url)
    {
        $this->collection->OnUpdateProduct->insertOne(["name"=>$name, "url"=>$url]);
    }
    public function findForAddEvent()
    {
        return $this->collection->OnAddProduct->find();

    }
    public function findForUpdateEvent()
    {
        return $this->collection->OnUpdateProduct->find();

    }
}
