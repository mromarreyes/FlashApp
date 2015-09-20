<?php
global $session;
$userClass = new User();

$app->group('/user', function() use($app, $userClass, $session) {

	$app->post('/login/', function() use($app, $userClass) {

		$user = $app->request->post('user');
		$pass = $app->request->post('pass');

	    $json = $userClass->login($user, $pass);
	    echo $json;
	});

	$app->get('/getUserid/', $session->slimCheck(), function() use($app, $userClass) {
	    $arr = array('userid' => $_SESSION['userid']);

	    echo json_encode($arr);
	});

	$app->get('/logout/', $session->slimCheck(), function() use($app, $userClass) {
	    $userClass->logout();
	});

	$app->post('/register/', function() use($app, $userClass) {

		$user = $app->request->post('user');
		$pass = $app->request->post('pass');
		$pass2 = $app->request->post('pass2');

	    $json = $userClass->register($user, $pass, $pass2);

	    echo $json;
	});

	

});

?>