<?php

use Phalcon\Mvc\Model;
use MongoDB\BSON\ObjectId;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Products extends Model
{
    public $collection;
    public function initialize()
    {
        $this->collection = $this->di->get("mongo");

        $this->collection = $this->collection->frontend->products;
    }

    public function insert()
    {

        $url = "192.168.2.25:8080/";
        $client = new Client(
            [
                'base_uri' => $url,
                'headers' => [
                    'Bearer' => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZXhhbXBsZS5vcmciLCJhdWQiOiJodHRwOi8vZXhhbXBsZS5jb20iLCJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMCwicm9sZSI6ImFkbWluIn0.73zdZihRYVg2Lb1ol6wd39RYtE_BpuAHxXq6WLmYDHk"
                ]
            ]
        );
        $response = $client->request('GET', '/api/products/get');
        $result = json_decode($response->getBody());
        echo "<pre>";
        print_r(json_decode(($result->data), 1));
        $products = json_decode(($result->data), 1);
        foreach ($products as $product) {
            $product = array_merge($product, ['_id'=>(new ObjectId($product['_id']['$oid']))]);
            $this->collection->insertOne($product);
        }
    }

        //___________________This Function was used to list product using API_________________________________________________

    // public function search($name = "")
    // {
    //     if ($name != "") {
    //         // $result = $this->collection->find(["name" => $name]);

    //         $url = "192.168.2.25:8080/";
    //         $client = new Client(
    //             [
    //                 'base_uri' => $url,
    //                 'headers' => [
    //                     'Bearer' => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZXhhbXBsZS5vcmciLCJhdWQiOiJodHRwOi8vZXhhbXBsZS5jb20iLCJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMCwicm9sZSI6ImFkbWluIn0.73zdZihRYVg2Lb1ol6wd39RYtE_BpuAHxXq6WLmYDHk"
    //                 ]
    //             ]
    //         );
    //         $response = $client->request('GET', '/api/products/search/'.$name);
    //         $result = $response->getBody()->getContents();
    //         echo "<pre>";
    //         // print_r(json_decode(json_decode($result)->data));
    //         return json_decode(json_decode($result)->data);
    //     } else {
    //         $url = "192.168.2.25:8080/";
    //         $client = new Client(
    //             [
    //                 'base_uri' => $url,
    //                 'headers' => [
    //                     'Bearer' => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZXhhbXBsZS5vcmciLCJhdWQiOiJodHRwOi8vZXhhbXBsZS5jb20iLCJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMCwicm9sZSI6ImFkbWluIn0.73zdZihRYVg2Lb1ol6wd39RYtE_BpuAHxXq6WLmYDHk"
    //                 ]
    //             ]
    //         );
    //         $response = $client->request('GET', '/api/products/get');
    //         $result = json_decode($response->getBody());
    //         return $result;
    //     }
    //     return $result;
    // }

    public function list()
    {
        return $this->collection->find();
    }

    public function searchById($id)
    {

        return $this->collection->find(['_id' => (new ObjectId($id))]);
    }
    public function deleteById($id)
    {
        return $this->collection->deleteOne(['_id' => (new ObjectId($id))]);
    }
    public function updateProduct($data)
    {
        // return $data;
        // print_r($data);
        // die;
        return $this->collection->updateOne(
            ["_id"=>(new ObjectId($data[0]['_id']['$oid']))],
            [
                '$set'=> ['stock'=>$data[0]['stock']]
            ]
        );
    }
    public function insertProduct($data)
    {
        // return $data;
        $result = $this->collection->insertOne($data);
        return $result;
    }
}
