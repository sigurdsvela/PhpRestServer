<?php
namespace rest;



use std\io\Flushable;
use std\io\Writer;
use std\json\JSON;

class RestResponse implements Flushable{
	/**
	 * @var JSON $json
	 */
	private $json;
	
	private $statusCode;
	private $statusMessage;
	
	public function __construct() {
		$this->json = new JSON();
	}
	
	public function setStatusCode($code) {
		$this->statusCode;
	}
	
	public function setStatusMessage($msg) {
		$this->statusMessage;
	}
	
	/**
	 * Returns a pointer to the JSON object that will be returned in the response.
	 * Return the JSON reponse for manipulation
	 *
	 * @return \std\json\JSON
	 */
	public function &json() {
		return $this->json;
	}

	/**
	 * Print the json response.
	 * After this is ran, you may no longer set the status code, set cookies
	 * or any thing that modifies the header.
	 * 
	 * @return void
	 */
	public function flush() {
		header("HTTP/1.1 " . $this->statusCode . " " . $this->statusMessage);
		$this->json->write(Writer::out());
		flush();
	}

}