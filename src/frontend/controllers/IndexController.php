<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->response->redirect("/frontend/products/dashboard");
    }
    public function createDatabaseAction()
    {
        $product = new Products;
        $product->insert();
    }
}
