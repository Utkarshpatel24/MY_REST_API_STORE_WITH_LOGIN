<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function indexAction()
    {
        $this->assets->addJs("js/productJs.js");
        $postdata = $this->request->getPost();
    }

    public function insertAction()
    {
        $postdata = $this->request->getPost();
        if (count($postdata) > 0) {
            echo "<pre>";
            print_r($postdata);
            // die;
            $data = array();
            $data = array_merge($data, ["name" => $postdata['p_name']]);
            $data = array_merge($data, ["category" => $postdata['p_category']]);
            $data = array_merge($data, ["price" => $postdata['p_price']]);
            $data = array_merge($data, ["stock" => $postdata['p_stock']]);
            $metaData = array();
            for ($i = 0; $i <= $postdata['metaCount']; $i++) {
                $pair = [$postdata["l_name" . $i] => $postdata["l_value" . $i]];
                $metaData = array_merge($metaData, $pair);
            }
            $data = array_merge($data, ["metaData" => $metaData]);
            print_r($data);
            // die;
            $variationData = array();
            for ($i = 0; $i <= $postdata['variationCount']; $i++) {
                $v = array();
                for ($j = 1; $j <= $postdata['variation-f-count-' . $i]; $j++) {
                    $v = array_merge($v, [$postdata['a_name-' . $i . '-' . $j] => $postdata['a_value-' . $i . '-' . $j]]);
                }
                $variationData = array_merge($variationData, ['variation-' . $i => $v]);
                $variationData = array_merge($variationData, ['price-' . $i => $postdata['a_price-' . $i]]);
            }
            print_r($variationData);
            // die;
            $data = array_merge($data, ["variationData" => $variationData]);
            $product = new Products();
            $product->insert($data);
            $this->response->redirect("/products/dashboard");
        }
    }
    public function dashboardAction()
    {

        $products = new Products;
        $searchResult = $products->list();
        echo "<pre>";
        // print_r($searchResult->toArray());
        // die;
        $displayResult = "";
        foreach ($searchResult->toArray() as $val) {
            $val = json_decode(json_encode($val), 1);
            // print_r($val);
            // die;
            $displayResult .= '<div for="card" class="p-2 shadow-lg m-1 border  text-wrap col-4">
                <dl class="row fw-bolder pl-3 d-flex text-wrap">
                    <dt class="col-sm-3">Name</dt>
                    <dd class="col-sm-9">' . $val['name'] . '</dd>
                    <dt class="col-sm-3">Id</dt>
                    <dd class="col-sm-9 text-wrap">' . $val['_id']['$oid'] . '</dd>
                    <dt class="col-sm-3">Category</dt>
                    <dd class="col-sm-9">' . $val['category'] . '</dd>
                    <dt class="col-sm-3">Price</dt>
                    <dd class="col-sm-9">' . $val['price'] . '</dd>
                    <dt class="col-sm-3">Stock</dt>
                    <dd class="col-sm-9">' . $val['stock'] . '</dd>
                </dl>
                <div class="d-flex justify-content-around">';

            if ($val['stock'] > 0) {
                $displayResult .= '<button class="btn btn-danger">Buy Now</button>';
            } else {
                $displayResult .= '<h4>Out of stock</h4>';
            }
            $displayResult .= '</div></div>';
        }

        $this->view->displayResult = $displayResult;
    }


    public function deleteProductAction($id)
    {
        echo $id;
        $product = new Products;
        $product->deleteById($id);
        $this->response->redirect("/products/dashboard");
    }
}
