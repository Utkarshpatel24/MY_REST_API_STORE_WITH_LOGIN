<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config;
use Phalcon\Mvc\Micro;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use API\Webhook\Webhook;

$config = new Config([]);

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH);
// echo APP_PATH;
// die;
require '../../vendor/autoload.php';

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . "/controllers/",
        APP_PATH . "/models/",
        APP_PATH . "/listeners/"
    ]
);

$loader->registerNamespaces(
    [
        'API\Webhook' => '../listener/',
        // 'API\MiddleWare' => '../middleware/'
    ]
);


$loader->register();

$container = new FactoryDefault();
$application = new Application($container);

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$container->set(
    'mongo',
    function () {
        $mongo = new \MongoDB\Client("mongodb://mongo", array("username"=>'root', "password"=>"password123"));
        return $mongo;
    },
    true
);

// $prod = new \API\Handler\Product();
// $app = new Micro();

// // print_r($prod);
// // $prod->check();

// $app->get(
//     '/api',
//     [
//         $prod,
//         'check'
//     ]
// );

// $app->get(
//     '/api/getToken/{role}',
//     [
//         $prod,
//         'getToken'
//     ]
// );

// $app->get(
//     '/api/products/get',
//     [
//         $prod,
//         'allProduct'
//     ]
// );

// $app->get(
//     '/api/products/search/{name}',
//     [
//         $prod,
//         'searchProduct'
//     ]
// );
// $app->before(
//     function() use ($app) {
//         if ($_SERVER["REQUEST_URI"] != '/api') {

//             $firewall = new \API\MiddleWare\FireWall();
//             $header = $app->request->getHeaders();
//             $result = $firewall->check($header);
//             // echo $result;
//             if ($result == 1) {
//                 echo "<h1>Access Token Not Passed  !!!!</h1>";
//                 die;
//             } elseif ($result == 2) {
//                 echo "<h1>Access Denied !!!!!</h1>";
//                 die;
//             } else {

//             }
//         }
//     }
// );

$eventsManager = new EventsManager();
$container->set(
    "eventsManager",
    function () use ($eventsManager) {
        $eventsManager->attach(
            'webhookEvent',
            new Webhook()
        );
        return $eventsManager;
    }
);



try {
    //Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
    
}
// try {
//     // Handle the request
//     $response = $app->handle(
//         $_SERVER["REQUEST_URI"]
//     );

//     // $response->send();
// } catch (\Exception $e) {
//     echo 'Exception: ', $e->getMessage();
// }
// try {
//     $app->handle(
//         $_SERVER['REQUEST_URI']
//     );

// } catch (\Exception $e)  {
//     // echo "hello error";
//     $response = $application->handle(
//         $_SERVER["REQUEST_URI"]
//     );
//     $response->send();

// }