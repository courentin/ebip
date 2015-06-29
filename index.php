<?php 
require 'vendor/autoload.php';


$app = new \Slim\Slim();

$app->get('/', function () {

})->name("home");

$app->get('/habitat', function () {

})->name("habitat");

$app->get('/industrie', function () {

})->name("industrie");


$app->get('/contact/(:type)', function ($type = 'default') {
		echo $type;
	})
	->name("contact")
	->conditions(['type' => '(default|industrie|habitat)']);

$app->run();