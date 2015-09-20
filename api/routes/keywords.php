<?php
global $session;
$keywordsClass = new Keywords();

$app->group('/keywords', function() use($app, $keywordsClass, $session) {

	$app->post('/addUserKeyword/', function() use($app, $keywordsClass) {

		$keyword = $app->request->post('keyword');

	    $json = $keywordsClass->addUserKeyword($_SESSION['userid'], $keyword);
	    
	    echo $json;
	});

	$app->post('/addJobKeyword/', function() use($app, $keywordsClass) {

		$jobid = $app->request->post('jobid');
		$keyword = $app->request->post('keyword');

	    $json = $keywordsClass->addJobKeyword($jobid, $keyword);
	    
	    echo $json;
	});

	$app->get('/user/', function() use($app, $keywordsClass) {

	    $json = $keywordsClass->getUserKeywords($_SESSION['userid']);
	    echo $json;
	});

	$app->get('/job/:jobid/', function($jobid) use($app, $keywordsClass) {

	    $json = $keywordsClass->getJobKeywords($jobid);
	    echo $json;
	});
});

?>