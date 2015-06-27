<?php 

require 'src/Autoloader.php';
Autoloader::register();

$router = new Router($_GET['url']); 
$router->get('/', function(){ echo "Bienvenue sur ma homepage !"; }); 
$router->get('/posts/:id', function($id){ echo "Voila l'article $id"; })->with('id','[0-9]+'); 
$router->run(); 