<?php

use Phalcon\Mvc\Controller;
// use MongoDB\BSON\UTCDateTime;
class OrderController extends Controller
{
    public function indexAction()
    {
        // $this->assets->addJs("js/productJs.js");
        // $postdata = $this->request->getPost();

    }

    public function placeOrderAction()
    {
        $postdata = $this->request->getPost();
        $product = new Products;
        $results = $product->search();
        
        $dropdown_d = "";
        $dropdown_v = "";
        foreach ($results as $result) {
            $result = json_decode(json_encode($result), 1);
            $dropdown_d .= '<option value="' . $result['_id']['$oid'] . '">' . $result['name'] . '</option>';
            // echo "<pre>";
            // print_r($result);
        }

        // foreach

        // die;
        $this->view->dropdown_d = $dropdown_d;
        if (count($postdata) > 0) {
            $postdata = array_merge($postdata, ["status" => "placed"]);
            $postdata = array_merge($postdata, ["date" => new \MongoDB\BSON\UTCDateTime(new \DateTime())]);
            $postdata = array_merge($postdata, ["time" => date("h:i:sa")]);
            $order = new Orders;
            $order->insert($postdata);
            $this->response->redirect("/order/orderDashboard/0");
        }
        $this->view->postdata = $postdata;
    }
    public function orderDashboardAction($check)
    {
        $this->assets->addJs("js/popupJs.js");
        $order = new Orders;
        // $this->view->pp = json_decode(json_encode($order->search()->toArray()), 1);
        $this->view->pp = array();
        $postdata = $this->request->getPost();
       
        if ($check == 1) {
            $this->view->d_drop = "none";
            $this->view->d_cust = "block";
        } else {
            $this->view->d_drop = "block";
            $this->view->d_cust = "none";
        }
        if (count($postdata) > 0) {

           
            print_r($postdata);
            if ($postdata['date_from'] != "") {
                $result = $order->search($postdata["order_status"], $postdata["date_from"], $postdata["date_to"]);
            } else {
                if ($postdata['order_date'] == "today") {
                                        // echo date("Y-m-d", strtotime("today"));
                                        // die;
                    $result = $order->search($postdata["order_status"], date("Y-m-d"), date("Y-m-d"));
                } elseif ($postdata['order_date'] == "this week") {

                    $result = $order->search($postdata["order_status"], date("Y-m-d"), date("Y-m-d", strtotime("+6 day")));
                } else {

                    $result = $order->search($postdata["order_status"], date("Y-m-d", strtotime("first day of this month")), date("Y-m-d", strtotime("last day of this month")));
                }
            }
            
            $this->view->pp = json_decode(json_encode($result->toArray()), 1) ;
        }
        $this->view->postdata =  $postdata;
        $this->view->check = $check;
    }

    public function orderFilterAction()
    {
        
        $postdata = $this->request->getPost();
        print_r($postdata);
        $order = new Orders;
        if ($postdata['date_from'] != "") {
            $result = $order->search($postdata["order_status"], $postdata["date_from"], $postdata["date_to"]);
        } else {
            if ($postdata['order_date'] == "today") {

                $result = $order->search($postdata["order_status"], date("Y-m-d"), date("Y-m-d"));
            } elseif ($postdata['order_date'] == "this week") {

                $result = $order->search($postdata["order_status"], date("Y-m-d"), date("Y-m-d", strtotime("+6 day")));
            } else {

                $result = $order->search($postdata["order_status"], date("Y-m-d", strtotime("first day of this month")), date("Y-m-d", strtotime("last day of this month")));
            }
        }
        // $order = new Orders;
        // $result = $order->search("placed", "2022-04-16", "2022-04-20");
        // // var_dump($result);
        echo "<pre>";
        print_r($result->toArray());
        // foreach ($result as $r) {
        //     print_r(json_decode(json_encode($r), 1));
        //     // echo json_encode($r);
        // }
        // echo $result;
    }
}
