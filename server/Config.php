<?php
namespace rest\server;

use rest\server\controller\Controller;
use std\json\JSON;
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
	 * @param JSON $config
	 *
	 * @throws MalformedRestConfigException
	 */
	public function __construct(JSON $config) {
		$this->config = $config;
		$this->initValue("version", "1.0");
		$this->initValue("base", "/");
		$this->initValue("host", null);
		$this->initValue("controllers", array());
		$this->initValue("urlMapping", array());
		$this->initValue("debug", false);
		if ($this->config["debug"] === true) {
			$config = $this->config;
			if (!Str::startsWith($config["base"], "/") || !Str::endsWith($config["base"], "/")) {
				throw new MalformedRestConfigException("The base key should start with and end with a slash(/). Example: /this/is/a/base/");
			}
			foreach ($config["controllers"] as  $name => $class) {
				try {
					if (@!(new $class()) instanceof Controller) {
						throw new MalformedRestConfigException("The class($class) specified for the \"$name\" controller does not extend Controller.");
					}
				} catch (\Exception $e) {}
				try {
					if (!class_exists($class)) {
						throw new MalformedRestConfigException("The class($class) specified for the \"$name\" controller does not exist.");
					}
				} catch (\Exception $e) {
					throw new MalformedRestConfigException("The class($class) specified for the \"$name\" controller does not exist.");
				}
			}
			foreach ($config["urlMapping"] as  $regex => $controller) {
				if (@preg_match("/^" . $regex . "/", "") === false) {
					throw new MalformedRestConfigException("UrlMapping: The regex($regex) specified for controller \"$controller\" is invalid. Remember, it should NOT start and end with the start and ending delimiter of php regexs.");
				}
				if (!isset($config["controllers"][$controller])) {
					throw new MalformedRestConfigException("UrlMapping: The controller($controller) for mapping \"$regex\" was never specified the \"controllers\" section.");
				}
			}
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