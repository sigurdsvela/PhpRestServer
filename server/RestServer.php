<?php
namespace rest\server;

use std\io\File;
use std\json\JSON;
use std\URL;
use std\util\Str;

class RestServer {
	/**
	 * @var Config
	 */
	private $config;
	
	public function __construct(Config $config) {
		$this->config = $config;
	}
	
	/**
	 * Load the rest server.
	 * This should be called on every page load.
	 *
	 * @return void
	 */
	public function load() {
		$url = URL::getCurrentUrl();
		if (!Str::startsWithIgnoreCase($url->getPath(), $this->config->getBase())) return;
		
		$path = $url->getPath();
		$path = substr($path, strlen($this->config->getBase())); //Remove base from $path
		
		$controller = $this->config->getController($path);
		if ($controller === null) {
			$controller = $this->config->get404Controller();
		}
		
		$request = new RestRequest();
		$response = new RestResponse();
		switch ($_SERVER['REQUEST_METHOD']) {
			case "GET":
				$controller->doGet($request, $response);
				break;
			case "POST":
				$controller->doPost($request, $response);
				break;
			case "DELETE":
				$controller->doDelete($request, $response);
				break;
			case "PATCH":
				$controller->doPatch($request, $response);
				break;
		}
		$response->doHeader();
		$response->flush();
		die();
	}
	
}