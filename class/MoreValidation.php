<?php 
namespace Ebip;
use SimpleValidator;

/**
* Extension de la classe SImpleValidator,
* rajout de quelques features, notamment la
* validation reCaptcha
*/
class MoreValidation extends SimpleValidator\Validator {

	public static function re_captcha($input, $secret) {
		$params = [
		'secret'   => $secret,
		'response' => $input
		];

		$url = "https://www.google.com/recaptcha/api/siteverify?" . http_build_query($params);
		if (function_exists('curl_version')) {
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_TIMEOUT, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$response = curl_exec($curl);
		}
		else $response = file_get_contents($url);

		if (empty($response) || is_null($response)) return false;

		$json = json_decode($response);
		return $json->success;
	}

	public static function code_postal($input) {
        return (preg_match("#^[0-9]{5}$#", $input) == 1);
	}

	/**
	* Permet de savoir si une valeur est
	* dans une liste de valeurs
	* @param value : la valeur à tester
	* @param list  : à la suite toute les valeurs
	* @exemple     : in('abc','abc','def')
	*                retourne true
	*/
	public static function in($value, $list) {
		return in_array($value,$list);
	}

	public static function lower($input, $max) {
		return floatval($input) < floatval($max);
	}

	public static function upper($input, $min) {
		return floatval($input) > floatval($max);
	}
}