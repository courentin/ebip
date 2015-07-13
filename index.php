<?php 
require 'vendor/autoload.php';

$app = new \Slim\App();


$container = $app->getContainer();

$container->register(new \Slim\Views\Twig('view/', [
	'debug' => true
   // 'cache' => 'view/cache/',
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
	$imgs =  Ebip\Conf::$imagesIndex;
    return $this->view->render($response, 'industrie.html', ['imgs' => $imgs]);
})->setName("industrie");


$app->get('/contact/{type:industrie|habitat|default}', function ($request,$response,$args) {
    return $this->view->render($response, 'contact.html', ['siteKey' => Ebip\Conf::$reCaptcha['sitekey'] ]);
})->setName("contact");


$app->post('/contact/{type:industrie|habitat|default}', function ($request,$response,$args) {

		/**
		* Validation du formulaire
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
		    	'min_length(15)'
		    ],
		    'captcha' => [
		    	'required',
		    	're_captcha(' . Ebip\Conf::$reCaptcha['secret'] . ')'
		    ]
		);
		$validation_result = Ebip\MoreValidation::validate($_POST, $rules);
		$validation_result->customErrors([
			're_captcha' => 'Le code de vérification est incorrect',
			'in' => 'La valeur du champ :attribute est inconnu',
			'upper' => 'La valeur du champ :attribute doit être supérieur à :params(0)',
			'lower' => 'La valeur du champ :attribute doit être inférieur à :params(0)'
		]);
		if ($validation_result->isSuccess()) {
			
			$mail_content = '<h1>Via la page ' . ($args['type']== 'default' ? 'par défaut' : $args['type'] ) . '</h1><br/><br/>'
						  . htmlentities($_POST['message']);
			$name_from = strtoupper($_POST['nom']) . ' ' . ucfirst($_POST['prenom']);

			/**
			* Envoi du mail
			*/
			$mail = new SimpleMail();
			$mail->setSubject('Contact via Ebip.fr')
				 ->setFrom($_POST['mail'], $name_from)
				 ->setTo(Ebip\Conf::$mail['mail'], Ebip\Conf::$mail['name'])
				 ->addMailHeader('Reply-To', $_POST['mail'], $name_from)
				 ->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
				 ->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
				 ->setMessage($mail_content);
			$send = $mail->send();

			if($send) {
				$jsonContent = json_encode('{ "success" : true }');
			} else {
				$jsonContent = json_encode('{ "success" : false, "err" : "Impossible d\'envoyer le message" }');
			}

		} else {
			$errorsJson = json_encode($validation_result->getErrors('fr'));
			$jsonContent = json_encode('{ "succes" : false, "err" : '.$errorsJson.' }');
		}

		/**
		* Retourne la réponse
		*/
		$response = $response->withHeader('Content-type','application/json');
		echo $jsonContent;
	})
	->setName("contact_post");


$app->run();