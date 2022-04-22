<?php

use Phalcon\Mvc\Controller;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// require_once APP_PATH."/vendor/autoload.php";

class UserController extends Controller
{
    public function indexAction()
    {
    }
    public function signupAction()
    {
        $postdata = $this->request->getPOst();
        if (count($postdata) > 0) {
            $user = new Users;
            $user->insert($postdata);
            $results = $user->check($postdata);
            
            foreach ($results as $r) {
                
                $result = $r;
            }

            $key = "example_key";
            $payload = array(
                "iss" => "http://example.org",
                "aud" => "http://example.com",
                "iat" => 1356999524,
                "nbf" => 1357000000,
                "id" => $result['_id'],
                "role" => $result['role'],
            );
            $jwt = JWT::encode($payload, $key, 'HS256');
              
            $postdata = array_merge($postdata, ['token'=>$jwt]);
            $user->updateData($postdata);   
        }
    }
    public function loginAction()
    {
        $postdata = $this->request->getPost();
        if (count($postdata) > 0) {
            $user = new Users;
            $results = $user->check($postdata);
            foreach ($results as $r) {
                $result = $r;
            }
            if (count($result) > 0) {
                if ($result['role'] == 'admin') {
                    $this->response->redirect("/products/dashboard");
                } else {
                    // $this->response->redirect('/api/intro');
                    $this->response->redirect('/user/viewToken?token='.$result['token']);
                   
                }
            }
        }
    }
    public function viewTokenAction()
    {
        $this->view->token = $this->request->getQuery('token');
    }
}
