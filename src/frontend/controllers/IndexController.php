<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        // $this->response->redirect("/products/dashboard");
        // $this->response->redirect("/user/login");
        $this->response->redirect('/frontend/order/orderDashboard/0');
    }
   
}
