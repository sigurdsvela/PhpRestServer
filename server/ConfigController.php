<?php
namespace rest\server;

/**
 * Used to represent a controller in the config
 * 
 * Class ConfigController
 * @package rest\server
 */
class ConfigController {
	private $class;
	private $optionalParameters;
	private $requiresParameters;
	private $urlCaptures;
	
	public function __construct(array $rawController) {
		$this->class = $rawController["class"];
		
		if (isset($rawController["parameters"])) {
			$params = $rawController["parameters"];
			$this->optionalParameters = isset($params["optional"]) ? $params["optional"] : array();	
			$this->requiredParameters = isset($params["required"]) ? $params["required"] : array();	
		} else {
			$this->requiredParameters = array();
			$this->optionalParameters = array();
		}
		
		$this->urlCaptures = isset($rawController["capture"]) ? $rawController["capture"] : array();
	}
	
	public function getClass() {
		return $this->class;
	}

	/**
	 * Get required parameters.
	 * array[] with {name, match} in them
	 *
	 * @return array[]
	 */
	public function getRequiredParameters() {
		return $this->requiredParameters;
	}

	/**
	 * Get optional parameters
	 * array[] with {name, match, default} in them
	 *
	 * @return array[]
	 */
	public function getOptionalParameters() {
		return $this->optionalParameters;
	}

	/**
	 * Array of what to call the url captures
	 *
	 * @return string[]
	 */
	public function getUrlCaptures() {
		return $this->urlCaptures;
	}
} 