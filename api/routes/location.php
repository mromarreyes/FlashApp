<?php
global $session;
$locationClass = new Location();

$app->group('/location', function() use($app, $locationClass, $session) {

	$app->get('/location/:locationid/', function($locationid) use($app, $locationClass) {

	    $json = $locationClass->getLocation($locationid);
	    echo $json;
	});

	$app->post('/addLocation/', function() use($app, $locationClass) {

		$address = $app->request->post('address');
		$latitude = $app->request->post('latitude');
		$longitude = $app->request->post('longitude');

	    $json = $locationClass->addLocation($_SESSION['userid'], $address, $latitude, $longitude);
	    echo $json;
	});

});

?>