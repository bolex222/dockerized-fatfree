<?php
	//import $f3 and autoload
	require 'vendor/autoload.php';
	$f3 = \Base::instance();
	
	//initial road:  localhost:8080/ using fatfree template system
	$f3->route('GET /', function ($f3) {
		$f3->set('CONTENT', './src/home.html');
		echo \Template::instance()->render('./src/index.html');
	});
	
	//hello road with token localhost:8080/hello/myName using fatfree template system and params
	$f3->route('GET /hello/@name', function ($f3) {
		$f3->set('CONTENT', './src/name.html');
		echo \Template::instance()->render('./src/index.html');
		
	});
	
	//rerouting route : localhost:8080/reroute
	//it will reroute you to localhost:8080/
	$f3->route('GET /reroute', function ($f3) {
		$f3->reroute('/');
	});
	
	$f3->run();