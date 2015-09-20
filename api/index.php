<?php
require 'vendor/autoload.php';
require 'includes/initialize.php';

$app = new \Slim\Slim(array(
	'debug' => true
	));
$app->response->headers->set('Content-Type', 'application/json');

$routeFiles = (array) glob('routes/*.php');
foreach($routeFiles as $routeFile) {
    require $routeFile;
}

$app->run();

?>