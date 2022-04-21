<?php

use Phalcon\Mvc\Controller;

class ApiController extends Controller
{
    public function indexAction()
    {

    }
    public function itemAction($id)
    {
        $product = new Products();
        $product->initialize();
        $result = $product->searchById($id);
        foreach($result as $r)
        {
            $r = json_encode($r);
            echo $r;
            die;
        }
         
    }
}