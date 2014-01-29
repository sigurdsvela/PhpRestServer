<?php
namespace rest\server;

use rest\server\controller\Controller;
use rest\server\controller\MethodNotImplementedController;
use rest\server\controller\MissingParametersController;
use rest\server\responseStatus\OkStatus;
use std\http\HttpRequest;
use std\io\File;
use std\json\JSON;
use std\URL;
use std\util\Str;

class RestServer {
	/**
	 * @var Config
	 */
	private $config;

	/**
	 * @var string The url without the hostname, and without the API base.
	 */
	private $apiUrl;
	
	private $matchedPattern;
	
	private $urlCaptures = array();
	
	public function __construct(Config $config) {
		$this->config = $config;
		$this->apiUrl = substr(URL::getCurrentUrl()->getPath(), strlen($config->getBase()));
		foreach ($this->config->getUrlMapping() as $map => $url) {
			$matches = array();
			if (preg_match_all("/^" . $map . "/", $this->apiUrl, $matches) > 0) {
				$this->matchedPattern = $map;
				$this->urlCaptures = $matches;
			}
		}
	}
	
	/**
	 * Load the rest server.
	 * This should be called on every page load.
	 *
	 * @return RestResponse|null
	 */
	public function load() {
		if (!Str::startsWithIgnoreCase(URL::getCurrentUrl()->getPath(), $this->config->getBase())) return null;
		
		$configController = $this->config->getController($this->apiUrl);
		if ($configController === null) { //If no controller, get 404 controller
			$configController = $this->config->get404Controller();
		}

		//Extract the captures
		$captures = array();
		for ($i = 1; $i < count($this->urlCaptures); $i++) {
			$captures[$configController->getUrlCaptures()[$i-1]] = $this->urlCaptures[$i][0];
		}
		
		//Check if any parameters are missing
		$className = $configController->getClass();
		/** @var Controller $controller */
		$controller = new $className();
		
		$missing = array();
		foreach ($configController->getRequiredParameters() as $parameter) {
			if (HttpRequest::parameter($parameter["name"]) === null) {
				$missing[] = $parameter;
			}
		}

		//If we are missing parameters, set the controller to the one that handles that shit
		if (!empty($missing)) {
			$controller = new MissingParametersController($missing);
		}
	
		$method = strtoupper($_SERVER['REQUEST_METHOD']);
		$request = new RestRequest($captures);
		$response = new RestResponse();
		$response->header()->setStatus(200); //Default status
		$response->setStatus(new OkStatus()); //Default Status
		
		switch ($method) {
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
			default:
				$controller = new MethodNotImplementedController();
				$controller->doGet($request, $response);
		}
		
		$response->header()->setContentType("application/json"); //Always json :)
		return $response;
	}
	
}