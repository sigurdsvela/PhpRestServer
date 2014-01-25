<?php
namespace rest\server;



use std\io\Flushable;
use std\io\Writable;
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
		$this->statusCode = $code;
	}
	
	public function setStatusMessage($msg) {
		$this->statusMessage = $msg;
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
	 * Set the json response.
	 *
	 * @param array $json
	 *
	 * @return void
	 */
	public function setJson(array $json) {
		$this->json = new JSON($json);
	}
	
	public function doHeader() {
		header("HTTP/1.1 " . $this->statusCode . " " . $this->statusMessage);
		header("Content-Type: application/json; charset=utf-8");
	}

	/**
	 * Write the JSON response body to a Writable of your choice
	 *
	 * @param \std\io\Writable $writable
	 *
	 * @return void
	 */
	public function write(Writable $writable) {
		$this->json->write($writable);	
	}

	/**
	 * Print the json response.
	 * After this is ran, you may no longer set the status code, set cookies
	 * or any thing that modifies the header.
	 * 
	 * @return void
	 */
	public function flush() {
		$this->json->write(Writer::out());
		flush();
	}

}