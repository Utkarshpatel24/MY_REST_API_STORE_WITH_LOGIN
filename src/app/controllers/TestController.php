<?php

use Phalcon\Mvc\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class TestController extends Controller
{
    public function indexAction()
    {

    }
    public function getTokenAction()
    {
        $url = "192.168.2.25:8080/";
        $client = new Client(
            [

                'base_uri' => $url,
            ]
        ); 
        $response = $client->request('GET', '/api/getToken/admin');
        $result = json_decode($response->getBody());
        $this->view->result = $result->data;
        
    }
    public function getProductsAction()
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
        $this->view->result = json_decode($result->data);
    }
    public function productSearchAction()
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
        $response = $client->request('GET', '/api/products/search/Football Basketball Badminton');
        $result = $response->getBody()->getContents();
        echo "<pre>";
        print_r(json_decode(json_decode($result)->data));
        
    }
    public function placeOrderAction()
    {
        $postdata = $this->request->getPost();
        $this->view->result = "";
        if (count($postdata) > 0) {
            $url = '192.168.2.25:8080/';
            $client = new Client(
                [
                    'base_uri' => $url,
                    'headers' => [
                        'Bearer' => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZXhhbXBsZS5vcmciLCJhdWQiOiJodHRwOi8vZXhhbXBsZS5jb20iLCJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMCwiaWQiOnsiJG9pZCI6IjYyNjExMWRlNTlmOWUwM2ZjMDA2NjJmMiJ9LCJyb2xlIjoiYWRtaW4ifQ.M5kiqO_McWY8dRq39sVfKJfZwP4W8GkteBuVcbfX8KM"
                    ]
                ]
            );
            $response = $client->request('POST', '/api/placeOrder', ['form_params' => $postdata]);
            $result = $response->getBody()->getContents();
            // print_r(json_decode($result)->msg);
            // die;
            $this->view->result = json_decode($result)->msg;
        }
    }
    public function updateOrderAction()
    {
        $postdata = $this->request->getPost();
        $this->view->result = "";
        if (count($postdata) > 0) {
            // print_r($postdata);
            // die;
            $url = '192.168.2.25:8080/';
            $client = new Client(
                [
                    'base_uri' => $url,
                    'headers' => [
                        'Bearer' => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZXhhbXBsZS5vcmciLCJhdWQiOiJodHRwOi8vZXhhbXBsZS5jb20iLCJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMCwiaWQiOnsiJG9pZCI6IjYyNjExMWRlNTlmOWUwM2ZjMDA2NjJmMiJ9LCJyb2xlIjoiYWRtaW4ifQ.M5kiqO_McWY8dRq39sVfKJfZwP4W8GkteBuVcbfX8KM"
                    ]
                ]
            );
            $response = $client->request('PUT', '/api/orderUpdate', ['form_params' => $postdata]);
            $result = $response->getBody()->getContents();
            // print_r(json_decode($result)->msg);
            // die;
            $this->view->result = json_decode($result)->msg;
        }
    }
}
