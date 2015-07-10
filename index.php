<?php 
require 'vendor/autoload.php';

$app = new \Slim\App();


$container = $app->getContainer();

$container->register(new \Slim\Views\Twig('public/view/', [
	'debug' => true
   // 'cache' => 'cache/',
]));

/**
* Capture les pages inexistantes
*/
$container['notFoundHandler'] = function ($c) use ($app) {
    return function ($request, $response) use ($app,$c) {
    	$response->withStatus(404);
	    return $app->view->render($response, 'notFound.html', ['uri' => trim($request->getUri()->getPath(),'/')]);
    };
};




/**
* ROUTAGE
*/
$app->get('/', function ($request,$response,$args) {
	$imgs = [

	];
    return $this->view->render($response, 'index.html', ['imgs', $imgs]);
})->setName("index");


$app->get('/habitat', function ($request,$response,$args) {
    return $this->view->render($response, 'habitat.html');
})->setName("habitat");


$app->get('/industrie', function ($request,$response,$args) {
	$imgs = [
		[
			'bg'      => 'test.jpg',
			'title'    => 'test',
			'subtitle' =>'Sous-titre'
		],
		[
			'bg'      => 'fils.jpg',
			'title'    => 'Habitat',
			'subtitle' =>'Sous-titre'
		],
		[
			'bg'      => 'industrie.jpg',
			'title'    => '',
			'subtitle' =>''
		]
	];
    return $this->view->render($response, 'industrie.html', ['imgs' => $imgs]);
})->setName("industrie");


$app->get('/contact/{type:industrie|habitat|default}', function ($request,$response,$args) {
    return $this->view->render($response, 'contact.html');
})->setName("contact");


$app->post('/contact/{type:industrie|habitat|default}', function ($request,$response,$args) {

		$rules = array(
		    'nom' => array(
		        'required',
		        'alpha',
		        'max_length(50)'
		    ),
		    'prenom' => array(
		        'required',
		        'alpha',
		        'max_length(50)'
		    ),
		    'mail' => array(
		        'required',
		        'email'
		    )
		);
		$validation_result = SimpleValidator\Validator::validate($_POST, $rules);

		if ($validation_result->isSuccess() == true) {
		    echo "validation ok";
		} else {
		    echo "validation not ok";
		    var_dump($validation_result->getErrors());
		}

		$mail = new SimpleMail();
		$mail->setSubject('Contact via Ebip.fr')
			 ->setFrom('test@test.fr', 'test')
			 ->setTo('ch2kn@free.fr', 'ch2kn')
			 ->setMessage('test');

		$send = $mail->send();
		echo ($send) ? 'Email sent successfully' : 'Could not send email';
	})
	->setName("contact_post");


$app->run();