<?php

use Phalcon\Mvc\Controller;
use MongoDB\BSON\ObjectId;

class ResponseController extends Controller
{
    public function indexAction()
    {
    }
    public function updateProductAction()
    {
        // print_r($this->request->getPost());
        $response = $this->request->getPost();
        // var_dump($response);

        $product = new Products;
        $result = ($product->updateProduct($response));
        var_dump($result);
        return ;
        // file_put_contents(APP_PATH."log", $response);
        // print_r($product);
        // $this->response->redirect('/user/login');
        // return $product;
    }
    public function addedProductAction()
    {
        $response = $this->request->getPost();
        $response = $response[0];


        $response = array_merge($response, ['_id'=>(new ObjectId($response['_id']['$oid']))]);
        $product = new Products;

        $result = $product->insertProduct($response);
        var_dump($result);
        return;
    }
}