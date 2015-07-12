<?php 
namespace Ebip;
use SimpleValidator;

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

	public static function in() {
		$args = func_get_args();
		return in_array($args[0],array_slice($args,1));
	}

	public static function lower($input, $max) {
		return floatval($input) < floatval($max);
	}

	public static function upper($input, $min) {
		return floatval($input) > floatval($max);
	}
}