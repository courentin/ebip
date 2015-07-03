<?php 
require 'vendor/autoload.php';

$app = new \Slim\App();

$container = $app->getContainer();

$container->register(new \Slim\Views\Twig('public/view/', [
    'cache' => 'cache/',
]));




$app->get('/', function ($request,$response,$args) {
	$imgs = [

	];
    return $this->view->render($response, 'index.html', ['imgs', $imgs]);
})->setName("index");


$app->get('/habitat', function ($request,$response,$args) {
    return $this->view->render($response, 'habitat.html');
})->setName("habitat");


$app->get('/industrie', function ($request,$response,$args) {
    return $this->view->render($response, 'industrie.html');
})->setName("industrie");


$app->get('/contact/{type}', function ($request,$response,$args) {
    return $this->view->render($response, 'contact.html');
	})
	->setName("contact");

$app->post('/contact/{type}', function ($type = 'default') {
		echo $type;
	})
	->setName("contact_post");





$app->run();