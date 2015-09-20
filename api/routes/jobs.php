<?php
global $session;
$jobsClass = new Jobs();

$app->group('/jobs', function() use($app, $jobsClass, $session) {

	$app->post('/addJob/', function() use($app, $jobsClass) {

		$name = $app->request->post('name');
		$about = $app->request->post('about');

	    $json = $jobsClass->addJob($_SESSION['userid'], $name, $about);
	    
	    echo $json;
	});

	$app->get('/getJobs/', $session->slimCheck(), function() use($app, $jobsClass) {
		$json = $jobsClass->getJobs($_SESSION['userid']);

	    echo $json;
	});

});

?>