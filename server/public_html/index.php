<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 19.02.18
 * Time: 15:10
 */
header('Access-Control-Allow-Origin: *');
require_once __DIR__ . "/../vendor/autoload.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$dotenv = new Dotenv\Dotenv(__DIR__ . "/../");
$dotenv->load();

$container = require __DIR__ . '/../app/bootstrap.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('POST', '/api/getFeeds', ['kymbrik\src\api\Api', 'getFeeds']);
    $r->addRoute('POST', '/api/deleteFeed', ['kymbrik\src\api\Api', 'deleteFeed']);
    $r->addRoute('POST', '/api/setFeedDict', ['kymbrik\src\api\Api', 'setFeedDict']);
    $r->addRoute('POST', '/api/updateFeedLink', ['kymbrik\src\api\Api', 'updateFeedLink']);
    $r->addRoute('POST', '/api/uploadDictionary', ['kymbrik\src\api\Api', 'uploadDictionary']);
    $r->addRoute('POST', '/api/getLanguageList', ['kymbrik\src\api\Api', 'getLanguageList']);
    $r->addRoute('POST', '/api/addFeed', ['kymbrik\src\api\Api', 'addFeed']);
    $r->addRoute('GET', '/translateFeeds', ['kymbrik\src\manager\AppManager', 'translateFeeds']);
    $r->addRoute('GET', '/test', ['kymbrik\src\manager\AppManager', 'test']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        // We could do $container->get($controller) but $container->call()
        // does that automatically
        $container->call($handler, $vars);
        break;
}