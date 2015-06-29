<?php 
require 'vendor/autoload.php';

$app = new \Slim\App();

$container = $app->getContainer();

$container->register(new \Slim\Views\Twig('public/view/', [
    'cache' => 'cache/'
]));


$app->get('/', function ($reqquest,$response,$args) {
    return $this->view->render($response, 'index.html', ['test', 'oui']);
})->setName("index");

$app->get('/habitat', function () {

})->setName("habitat");

$app->get('/industrie', function () {

})->setName("industrie");


$app->get('/contact/(:type)', function ($type = 'default') {
		echo $type;
	})
	->setName("contact");

$app->post('/contact/(:type)', function ($type = 'default') {
		echo $type;
	})
	->setName("contact_post");

$app->run();