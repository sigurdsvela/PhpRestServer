<?php
namespace rest\server;

use rest\server\responseStatus\OkStatus;
use std\http\HttpConfig;
use std\http\HttpController;
use std\http\HttpServer;
use std\URL;
use std\util\Str;

class RestServer extends HttpServer{
	
	public function __construct(HttpConfig $config) {
		parent::__construct($config);
	}
	
	/**
	 * Load the rest server.
	 * This should be called on every page load.
	 *
	 * @return RestResponse
	 */
	public function run() {
		$url = URL::getCurrentUrl();

		if (!$this->isServerURL($url)) {
			return null;
		}

		$path = Str::subString($url->getPath(), Str::length($this->config->getBase())); //Remove the base from the

		/** @var HttpController $controller */
		$controller = null;
		$configController = null;

		$rawCaptures = array();
		foreach ($this->config->getMappings() as $match => $controllerName) {
			if (preg_match_all("/^" . $match . "\\/$/", $path, $rawCaptures) > 0) {
				$configController = $this->config->getController($controllerName);
				$c = $configController->getClass();
				$controller = new $c();
				break;
			}
		}
		array_shift($rawCaptures); //Remove the first, as this is just the entire string.

		/*
		 * Create an associative array with the names specified in the config json file 
		 */
		$captures = array();
		$rawCapturesLength = count($rawCaptures);
		for ($i = 0; $i < $rawCapturesLength; $i++) {
			$c = $rawCaptures[$i];
			$captures[$configController->getCaptures()[$i]] = $c[0];
		}
		
		
		if ($controller === null) {
			$controller = $this->config->get404Controller();
			if ($controller === null) {
				echo "404";
				die();
			}
		}

		$request = new RestRequest();
		$response= new RestResponse(true);
		
		$request->setParameter("@captures", $captures);

		$response->header()->setStatus(200);
		$response->setStatus(new OkStatus());
		
		$controller->doCurrent($request, $response);

		$response->header()->setContentType("application/json"); //Always json :)
		
		return $response;
	}
	
}