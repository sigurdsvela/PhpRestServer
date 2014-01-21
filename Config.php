<?php
namespace rest;

use std\json\JSON;

class Config {
	private $config;
	
	/**
	 * @param JSON $config
	 */
	public function __construct(JSON $config) {
		$this->config = $config;
	}
	
	public function getBase() {
		
	}
	
	public function getControllers() {
		return $this->config['controllers'];
	}
	
	public function getUrlMapping() {
		return $this->config['urlMapping'];
	}

	/**
	 * Get a controller for a specified URL
	 *
	 * @param $url
	 *
	 * @return Controller
	 */
	public function getController($url) {
		
	}
	
} 