<?php
namespace API\MiddleWare;

use Phalcon\Mvc\Controller;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// require_once"../vendor/autoload.php";


class FireWall extends Controller
{

    function check($header)
    {
        if(!array_key_exists('Bearer', $header))
        return 1;
        else
        return $this->check2($header['Bearer']);
    }
    function check2($token)
    {
        
        $key = "example_key";
        $token = JWT::decode($token, new Key($key, 'HS256'));
        if ($token->role != 'admin' && $token->role != 'customer') {
            return 2;
        } else {
            return 3;
        }
    }
}