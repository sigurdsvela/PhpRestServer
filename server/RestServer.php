<?php
namespace rest\server;

use rest\server\controller\Controller;
use std\io\File;
use std\json\JSON;
use std\URL;
use std\util\Str;

class RestServer {
	/**
	 * @var Config
	 */
	private $config;
	
	private $apiUrl;
	
	private $matchedPattern;
	
	private $patternMatches;
	
	public function __construct(Config $config) {
		$this->config = $config;
		$this->apiUrl = substr(URL::getCurrentUrl()->getPath(), strlen($config->getBase()));
		foreach ($this->config->getUrlMapping() as $map => $url) {
			$matches = array();
			if (preg_match_all("/^" . $map . "/", $this->apiUrl, $matches) > 0) {
				$this->matchedPattern = $map;
				$this->patternMatches = $matches;
			}
		}
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
		
		$controller = $this->getController($path);
		if ($controller === null) {
			$controller = $this->config->get404Controller();
		}
		
		$request = new RestRequest($this->patternMatches);
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

	/**
	 * Get a controller for a specified URL, or null if none is spesified.
	 *
	 * @param $url
	 *
	 * @return Controller
	 */
	public function getController($url) {
		foreach($this->config->getUrlMapping() as $map => $controller) {
			$matches = array();
			if (preg_match("/^" . $map . "/", $url, $matches)) {
				$controller = $this->config->getControllers()[$controller];
				/**
				 * @var $c Controller
				 */
				$c = new $controller();
				return $c;
			}
		}
		return null;
	}
	
}