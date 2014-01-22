<?php
namespace rest;

use std\json\JSON;

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
	 * @param JSON $config
	 */
	public function __construct(JSON $config) {
		$this->config = $config;
		$this->initValue("version", "1.0");
		$this->initValue("base", "/");
		$this->initValue("host", null);
		$this->initValue("controllers", array());
		$this->initValue("urlMapping", array());
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
	
	public function getControllers() {
		return $this->config['controllers'];
	}
	
	public function getUrlMapping() {
		return $this->config['urlMapping'];
	}

	/**
	 * Get a controller for a specified URL, or null if none is spesified.
	 *
	 * @param $url
	 *
	 * @return Controller
	 */
	public function getController($url) {
		foreach($this->getUrlMapping() as $map => $controller) {
			$matches = array();
			if (preg_match("/^" . $map . "/", $url, $matches)) {
				$controller = $this->getControllers()[$controller];
				/**
				 * @var $c Controller
				 */
				$c = new $controller();
				return $c;
			}
		}
		return null;
	}
	
	public function get404Controller() {
		if (isset($this->config["404"])) {
			$controller = $this->config["404"]();
			return new $controller();
		} else {
			return new Controller404();
		}
	}
}