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
            $data=array_merge($data, ["name"=>$postdata['p_name']]);
            $data=array_merge($data, ["category"=>$postdata['p_category']]);
            $data=array_merge($data, ["price"=>$postdata['p_price']]);
            $data=array_merge($data, ["stock"=>$postdata['p_stock']]);
            $metaData = array();
            for ($i=0;$i<=$postdata['metaCount'];$i++) {
                $pair = [$postdata["l_name".$i]=>$postdata["l_value".$i]];
                $metaData = array_merge($metaData, $pair);
            }
            $data = array_merge($data, ["metaData"=>$metaData]);
            print_r($data);
            // die;
            $variationData = array();
            for ($i=0;$i<=$postdata['variationCount'];$i++) {
                $v= array();
                for ($j=1;$j<=$postdata['variation-f-count-'.$i];$j++) {
                    $v =array_merge($v, [$postdata['a_name-'.$i.'-'.$j]=>$postdata['a_value-'.$i.'-'.$j]]);
                }
                $variationData = array_merge($variationData, ['variation-'.$i => $v]);
                $variationData = array_merge($variationData, ['price-'.$i => $postdata['a_price-'.$i]]);                
               
            }
            print_r($variationData);
            // die;
            $data = array_merge($data, ["variationData"=>$variationData]);
            $product = new Products();
            $product->insert($data);
            $this->response->redirect("/products/dashboard");
        }
    }
    public function dashboardAction()
    {
        $this->assets->addJs("js/popupJs.js");
        $postdata = $this->request->getPost();
        if (count($postdata) > 0) {
            $products = new Products;
            $searchResult = $products->search($postdata['searchValue']);

            $displayResult = "";
            foreach ($searchResult as $val) {
                $val = json_decode(json_encode($val), 1);
                print_r(json_decode(json_encode($val), 1));

                $displayResult .= '<div for="card" class="p-2 shadow-lg m-1 border w-30 text-wrap col-4">
                <dl class="row fw-bolder pl-3 d-flex text-wrap">
                    <dt class="col-sm-3">Name</dt>
                    <dd class="col-sm-9">'.$val['name'].'</dd>
                    <dt class="col-sm-3">Id</dt>
                    <dd class="col-sm-9">'.$val['_id']['$oid'].'</dd>
                    <dt class="col-sm-3">Category</dt>
                    <dd class="col-sm-9">'.$val['category'].'</dd>
                    <dt class="col-sm-3">Price</dt>
                    <dd class="col-sm-9">'.$val['price'].'</dd>
                    <dt class="col-sm-3">Stock</dt>
                    <dd class="col-sm-9">'.$val['stock'].'</dd>
                </dl>
                <div class="d-flex justify-content-around">
                <a href="#" onclick="abc(`'.$val['_id']['$oid'].'`)" data-bs-toggle="modal" data-bs-target="#staticBackdrop" ><ion-icon size="large" name="eye-outline"></ion-icon></a>
                <a href="#"><i class="fa fa-edit" style="font-size:38px;color:light-blue"></i></a>
                <a href="/products/deleteProduct/'.$val['_id']['$oid'].'"><ion-icon size="large"  name="trash-outline"></ion-icon></a>
            </div>
                <input style="display:none" name="information" value="hjbdjgnfkdngf">
            </div>';

            }
   
            $this->view->displayResult = $displayResult;
        } else {
            $products = new Products;
            $searchResult = $products->search();

            $displayResult = "";
            foreach ($searchResult as $val) {
                $val = json_decode(json_encode($val), 1);
                print_r(json_decode(json_encode($val), 1));
             
                $displayResult .= '<div for="card" class="p-2 shadow-lg m-1 border  text-wrap col-4">
                <dl class="row fw-bolder pl-3 d-flex text-wrap">
                    <dt class="col-sm-3">Name</dt>
                    <dd class="col-sm-9">'.$val['name'].'</dd>
                    <dt class="col-sm-3">Id</dt>
                    <dd class="col-sm-9 text-wrap">'.$val['_id']['$oid'].'</dd>
                    <dt class="col-sm-3">Category</dt>
                    <dd class="col-sm-9">'.$val['category'].'</dd>
                    <dt class="col-sm-3">Price</dt>
                    <dd class="col-sm-9">'.$val['price'].'</dd>
                    <dt class="col-sm-3">Stock</dt>
                    <dd class="col-sm-9">'.$val['stock'].'</dd>
                </dl>
                <div class="d-flex justify-content-around">
                    <a href="#" onclick="abc(`'.$val['_id']['$oid'].'`)" data-bs-toggle="modal" data-bs-target="#staticBackdrop" ><ion-icon size="large" name="eye-outline"></ion-icon></a>
                    <a href="#"><i class="fa fa-edit" style="font-size:38px;color:light-blue"></i></a>
                    <a href="/products/deleteProduct/'.$val['_id']['$oid'].'"><ion-icon size="large"  name="trash-outline"></ion-icon></a>
                </div>
              
            </div>';

            }
  
            $this->view->displayResult = $displayResult;
        }
    }

    public function deleteProductAction($id)
    {
        echo $id;
        $product = new Products;
        $product->deleteById($id);
        $this->response->redirect("/products/dashboard");

    }

  

}