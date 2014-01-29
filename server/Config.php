<?php
namespace rest\server;

use rest\server\controller\Controller;
use rest\server\controller\Controller404;
use std\json\JSON;
use std\URL;
use std\util\Str;

class Config {
	/**
	 * @var \std\json\JSON
	 */
	private $config;

	/**
	 * @var
	 */
	private $version;
	
	/**
	 * @param JSON $pconfig
	 *
	 * @throws MalformedRestConfigException
	 */
	public function __construct(JSON $pconfig) {
		$this->config = $pconfig->toArray();

		$this->initValue("version", "1.0");
		$this->initValue("base", "/");
		$this->initValue("host", null);
		$this->initValue("urlMapping", array());
		$this->initValue("debug", false);
		$this->config["controllers"] = array();

		foreach ($pconfig["controllers"] as $key => $controller) {
			$this->config["controllers"][$key] = new ConfigController($controller);
		}

		if ($this->config["debug"] === true) { //We should use json schemas
			
		}
	}

	/**
	 * Set the config valut of $key to $value
	 * if it is not already set.
	 *
	 * @param $key
	 * @param $value
	 *
	 * @return void
	 */
	private function initValue($key, $value) {
		$this->config[$key] = isset($this->config[$key]) ? $this->config[$key] : $value; 
	}

	/**
	 * Get the base path that this server should respond to
	 *
	 * @return string
	 */
	public function getBase() {
		return $this->config["base"];
	}

	/**
	 * Get the host name that this server should
	 * respond to, or null if any
	 *
	 * @return string|null
	 */
	public function getHost() {
		return $this->config["host"];
	}

	/**
	 * Get all url mappings
	 *
	 * @return mixed
	 */
	public function getUrlMapping() {
		return $this->config['urlMapping'];
	}

	/**
	 * Get all controllers.
	 *
	 * @return ConfigController[]
	 */
	public function getControllers() {
		return $this->config['controllers'];
	}

	/**
	 * Get a controller for a specified URL, or null if none is specified.
	 *
	 * @param $url
	 *
	 * @return ConfigController
	 */
	public function getController($url) {
		foreach($this->getUrlMapping() as $map => $controller) {
			if (preg_match("/^" . $map . "/", $url)) {
				$controller = $this->getControllers()[$controller];
				return $controller;
			}
		}
		return null;
	}
	
	/**
	 * Get the controller that handles 404's
	 * 
	 * @return ConfigController
	 */
	public function get404Controller() {
		if (isset($this->config["404"])) {
			$controller = $this->config["404"]();
			return $this->getControllers()[$controller]["class"];
		} else {
			return new ConfigController(array(
				"class" => "rest\\server\\controller\\Controller404"
			));
		}
	}
}