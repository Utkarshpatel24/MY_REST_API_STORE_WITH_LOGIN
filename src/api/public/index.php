<?php


use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config;
use Phalcon\Mvc\Micro;



//Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH);

require '../../vendor/autoload.php';

// Register an autoloader
$loader = new Loader();

// $loader->registerDirs(
//     [
//         APP_PATH . "/controllers/",
//         APP_PATH . "/models/",
//     ]
// );

$loader->registerNamespaces(
    [
        'API\Handler' => '../handlers/',
        'API\MiddleWare' => '../middleware/'
    ]
);


$loader->register();

$container = new FactoryDefault();
$application = new Application($container);


$container->set(
    'mongo',
    function () {
        $mongo = new \MongoDB\Client("mongodb://mongo", array("username"=>'root', "password"=>"password123"));
        return $mongo;
    },
    true
);

$prod = new \API\Handler\Product();
$app = new Micro();


$app->get(
    '/api/intro',
    [
        $prod,
        'check'
    ]
);

// $app->get(
//     '/api/getToken/{role}',
//     [
//         $prod,
//         'getToken'
//     ]
// );

$app->get(
    '/api/products/get',
    [
        $prod,
        'allProduct'
    ]
);

$app->get(
    '/api/products/search/{name}',
    [
        $prod,
        'searchProduct'
    ]
);

$app->post(
    '/api/placeOrder',
    [
        $prod,
        'placeOrder'
    ]
);

$app->put(
    '/api/orderUpdate',
    [
        $prod,
        'orderUpdate'
    ]
);

$app->before(
    function() use ($app) {
        if ($_SERVER["REQUEST_URI"] != '/api/intro') {

            $firewall = new \API\MiddleWare\FireWall();
            $header = $app->request->getHeaders();
            $result = $firewall->check($header);
            // echo $result;
            if ($result == 1) {
                echo "<h1>Access Token Not Passed  !!!!</h1>";
                die;
            } elseif ($result == 2) {
                echo "<h1>Access Denied !!!!!</h1>";
                die;
            } else {

            }
        }
    }
);




try {
    // Handle the request
    $response = $app->handle(
        $_SERVER["REQUEST_URI"]
    );


} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
