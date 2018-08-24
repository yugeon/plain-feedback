<?php

require_once '../vendor/autoload.php';

use App\Library\HttpRequest;
use App\Library\Router;

const APP_DIR = __DIR__;

$request = new HttpRequest();
$router = new Router($request);

$router->get('/', 'IndexController@index');
$router->post('api/feedback', 'IndexController@feedback');

try {
    /** @var App\Library\HttpResponse $response */
    $response = $router->processRequest();
    echo $response->getBody();
} catch (\Exception $e) {
    // 404 or 500 http error code
}

