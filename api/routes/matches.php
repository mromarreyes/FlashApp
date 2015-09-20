<?php
global $session;
$matchesClass = new Matches();

$app->group('/matches', function() use($app, $matchesClass, $session) {

	$app->post('/addMatch/', function() use($app, $matchesClass) {

		$user1 = $app->request->post('user1');
		$user2 = $app->request->post('user2');

	    $json = $matchesClass->addMatch($user1, $user2);
	    
	    echo $json;
	});

	$app->get('/match/:userid', function($userid) use($app, $matchesClass) {

	    $json = $matchesClass->getMatch($userid);
	    echo $json;
	});

});

?>