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
    	$response = $response->withStatus(404);
	    return $app->view->render($response, 'notFound.html', ['uri' => trim($request->getUri()->getPath(),'/')]);
    };
};



/**
* ROUTAGE
*/
$app->get('/', function ($request,$response,$args) {
    return $this->view->render($response, 'index.html', ['imgs', Ebip\Conf::$imagesIndex]);
})->setName("index");


$app->get('/habitat', function ($request,$response,$args) {
    return $this->view->render($response, 'habitat.html');
})->setName("habitat");


$app->get('/industrie', function ($request,$response,$args) {
	$imgs = [

	];
    return $this->view->render($response, 'industrie.html', ['imgs' => $imgs]);
})->setName("industrie");


$app->get('/contact/{type:industrie|habitat|default}', function ($request,$response,$args) {
    return $this->view->render($response, 'contact.html', ['siteKey' => Ebip\Conf::$reCaptcha['sitekey'] ]);
})->setName("contact");


$app->post('/contact/{type:industrie|habitat|default}', function ($request,$response,$args) {

		/**
		* VALIDATION DU FORMULAIRE
		*/
		$rules = array(
		    'nom' => [
		        'required',
		        'alpha',
		        'max_length(50)'
		    ],
		    'prenom' => [
		        'required',
		        'alpha',
		        'max_length(50)'
		    ],
		    'mail' => [
		        'required',
		        'email'
		    ],
		    'message' => [
		    	'required',
		    	'min_length(20)'
		    ],
		    'captcha' => [
		    	're_captcha(' . Ebip\Conf::$reCaptcha['secret'] . ')'
		    ]
		);
		$validation_result = Ebip\MoreValidation::validate($_POST, $rules);
		$validation_result->customErrors([
			'recaptcha' => 'Le code de vérification est incorrect'
		]);
		if ($validation_result->isSuccess() == true) {
			
			// ENVOI DU MAIL
			$mail = new SimpleMail();
			$mail->setSubject('Contact via Ebip.fr')
				 ->setFrom('test@test.fr', 'test')
				 ->setTo('ch2kn@free.fr', 'ch2kn')
				 ->setMessage('test');

			$send = $mail->send();
			echo ($send) ? 'Email sent successfully' : 'Could not send email';
			die();
			$jsonContent = json_encode('{ "success" : true }');

		} else {
			$errorsJson = json_encode($validation_result->getErrors('fr'));
			$jsonContent = json_encode('{ "succes" : false, "err" : '.$errorsJson.' }');
		}

		$response = $response->withHeader('Content-type','application/json');
		echo $jsonContent;
	})
	->setName("contact_post");


$app->run();