<?php 

/**
* 
*/
class RouterException extends \Exception
{
	public function __construct($msg = null) {
		header('HTTP/1.0 404 Not Found');
		exit;
	}
}