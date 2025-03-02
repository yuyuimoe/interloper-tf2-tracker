<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Factory\AppFactory;

require_once(__DIR__ . '/../bootstrap.php');

CONST APP_DIR = "/var/www/src/";
CONST PUBLIC_DIR = "/var/www/public/";

$app = $container->get(App::class);

$app->get('/', function (Request $request, Response $response, $args) {
    $homePage = fopen(PUBLIC_DIR . "home.html", 'r');
    $response->getBody()->write(fread($homePage, filesize(PUBLIC_DIR . "home.html")));
    return $response;
});

$routes = require(APP_DIR   . "routes.php");
$routes($app);

$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->run();