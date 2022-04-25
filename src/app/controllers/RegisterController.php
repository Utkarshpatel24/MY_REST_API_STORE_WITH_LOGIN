<?php

use Phalcon\Mvc\Controller;

class RegisterController extends Controller
{
    public function indexAction()
    {
        $postdata = $this->request->getPost();
        if (count($postdata) > 0) {
            print_r($postdata);
            $register = new WebhookUsers;
            $register->insert($postdata);
        }
    }
}
