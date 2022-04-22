<?php

namespace API\Handler;

use Exception;
use Phalcon\Mvc\Controller;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use MongoDB\BSON\ObjectId;
use Phalcon\Http\Response;
// require_once "../../vendor/autoload.php";


class Product extends Controller
{

    function check()
    {
        echo "Hello Buddy !!! <br>";
        echo "Ready to use API of My Product APP <br>";
        echo "To use My api you must have access token with you !!!<br>
        To get list of all product Hit this end point '<strong>/api/products/get'</strong><br>
        To search products hit this end point '<strong>/api/products/search/{name}</strong><br>
        To Place Order Hit this end point '<strong>/api/placeOrder</strong>'<br>
            Form params keys will be 'token' 'p_quantity' 'product_id' <br>
        To Update Order Hit this end point '<strong>/api/updateOrder</strong>'<br>
            Form params keys will be 'order_id'  'status'
        ";
    }

    function getToken($role)
    {
        // echo "Ready to get your Access Token  for role " . $role . "<br>";
        $key = "example_key";
        $payload = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "role" => $role
        );
        $jwt = JWT::encode($payload, $key, 'HS256');
        $response = new Response();
        $response->setStatusCode(200, 'OK')
            ->setJsonContent(
                [
                    'status' => 200,
                    'data' => $jwt //$mongo->read("products", [], $per_page, is_null($data) ? [] : $data, $page)
                ],
                JSON_PRETTY_PRINT
            );
        $response->send();
    }

    function allproduct()
    {
        $products = $this->mongo->store->products->find();
        $response = new Response();
        $response->setStatusCode(200, 'OK')
            ->setJsonContent(
                [
                    'status' => 200,
                    'data' => json_encode($products->toArray()) //$mongo->read("products", [], $per_page, is_null($data) ? [] : $data, $page)
                ],
                JSON_PRETTY_PRINT
            );
        $response->send();
    }

    function searchProduct($name)
    {
        // $limit = $this->request->getQuery('limit');
        // if ($limit != '') {

        //     $limit = intval($limit);
        // } else {

        //     $limit = -1;
        // }
        $name = urldecode($name);
        $array = explode(" ", $name);
        $result = array();
        
        foreach ($array as $val) {
            
            // array_push($searchBy, "/".$val."/");
            // $product = $this->mongo->store->products->find(['$or' => [['name' => $val], []]]);
            // echo "<pre>";
            // foreach ($product as $p) {

            //     // print_r($p);
            //     if ($limit > 0 || $limit === -1)
            //         $result .= json_encode($p);
            //     if ($limit > 0)
            //         $limit--;
            // }
            $product = $this->mongo->store->products->find(['name' => $val]);
            $p =$product->toArray();
            if (count($p) > 0)
            array_push($result, $p);
        }
       
        // echo($searchBy1);
        // print_r($result);
        $response = new Response();
        $response->setStatusCode(200, 'OK')
            ->setJsonContent(
                [
                    'status' => 200,
                    'data' => json_encode($result)
                ],
                JSON_PRETTY_PRINT
            );
        $response->send();
    }

    function placeOrder()
    {
        $postdata = $this->request->getPost();
        $token = $postdata['token'];
        $key = "example_key";
        $token = JWT::decode($token, new Key($key, 'HS256'));
        $token = json_decode(json_encode($token), 1);
        $id = $token['id']['$oid'];
        $postdata = array_merge($postdata, ['c_id' => $id]);
        $postdata = array_merge($postdata, ['c_name' => $postdata['name']]);
        $postdata = array_merge($postdata, ['status' => 'paid']);
        $postdata = array_merge($postdata, ["date" => new \MongoDB\BSON\UTCDateTime(new \DateTime())]);
        $postdata = array_merge($postdata, ["time" => date("h:i:sa")]);
        $this->mongo->store->orders->insertOne($postdata);
        $response = new Response();
        $response->setStatusCode(200, 'OK')
            ->setJsonContent(
                [
                    'status' => 200,
                    'msg' => 'Order Placed Successfully' //$mongo->read("products", [], $per_page, is_null($data) ? [] : $data, $page)
                ],
                JSON_PRETTY_PRINT
            );
        $response->send();
    }


    function orderUpdate()
    {
        parse_str(file_get_contents("php://input"), $postdata);
        // print_r($postdata);
        $this->mongo->store->orders->updateOne(
            [
                '_id' => new ObjectId($postdata['order_id'])
            ],
            [
                '$set' => ["status" => $postdata['status']]
            ]
        );

        $response = new Response();
        $response->setStatusCode(200, 'OK')
            ->setJsonContent(
                [
                    'status' => 200,
                    'msg' => 'Order Updated Successfully' //$mongo->read("products", [], $per_page, is_null($data) ? [] : $data, $page)
                ],
                JSON_PRETTY_PRINT
            );
        $response->send();
    }
}
