<?php
namespace rest\server;



use rest\server\responseStatus\ResponseStatus;
use std\http\HttpResponse;
use std\http\HttpResponseHeader;
use std\io\Flushable;
use std\io\Writer;
use std\json\JSON;

class RestResponse extends HttpResponse {
	/** @var JSON $json */
	private $json;
	
	private $responseHeader;
	
	public function __construct() {
		$this->json = new JSON();
		$this->json["data"] = array();
		$this->json["status"] = array();
		$this->responseHeader = new HttpResponseHeader();
	}

	/**
	 * Get the header for this responce
	 *
	 * @return HttpResponseHeader
	 */
	public function &header() {
		return $this->responseHeader;
	}

	/**
	 * Returns a pointer to the JSON object that will be returned in the response.
	 * Return the JSON response for manipulation
	 *
	 * @param string $data (optional) If set, set the data to $data
	 *
	 * @return \std\json\JSON
	 */
	public function &data($data = null) {
		if ($data !== null) {
			$this->json["data"] = $data;
		}
		return $this->json["data"];
	}

	/**
	 * Set the status
	 *
	 * @param ResponseStatus $status
	 *
	 * @return void
	 */
	public function setStatus(ResponseStatus $status) {
		$this->json["status"]["code"] = $status->getCode();
		$this->json["status"]["slug"] = $status->getSlug();
		$this->json["status"]["message"] = $status->getMessage();
	}
	
	/**
	 * Print the json response, and DIES.
	 * This also sets the Content-Length and does general housekeeping.
	 * 
	 * @return void
	 */
	public function flushDie() {
		ob_start();
		$this->json->write(Writer::out());
		$o = ob_get_clean();
		$this->responseHeader->setHeader("Content-Length", strlen($o));
		$this->responseHeader->applyHeaders();
		echo $o;
		die();
	}

}