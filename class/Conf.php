<?php 
namespace Ebip;

/**
* Fichier de configuration du site Ebip
*/
class Conf {

	/**
	* Mail vers lequel sont redirigés
	* les messages de la page contact
	*/
	static $mail = [
		'mail' => 'ch2kn@free.fr',
		'name' => 'ch2kn'
	];

	/**
	* Clé du widget "reCaptcha" de Google,
	* permet d'éviter les spams type robot
	*/
	static $reCaptcha = [
		'sitekey' => '6LeWAQQTAAAAAAdaNHOpUyV71ZqpqZ7dNSazCIFH',
		'secret'  => '6LeWAQQTAAAAAMgTivhPzoTYdnQbD7W5-ZWzP4x1'
	];

	/**
	* Images du slide de la pages index
	* @param bg       : nom fu fichier image
	* @param title    : Titre 
	* @param subtitle : Sous-titre
	*/
	static $imagesIndex = array(
		[
			'bg'       => 'test.jpg',
			'title'    => 'test',
			'subtitle' => 'Sous-titre'
		],
		[
			'bg'       => 'fils.jpg',
			'title'    => 'Habitat',
			'subtitle' => 'Sous-titre'
		],
		[
			'bg'       => 'industrie.jpg',
			'title'    => '',
			'subtitle' => ''
		]
	);

}