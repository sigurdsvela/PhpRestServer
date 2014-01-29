<?php
/**
 * User: sigurdbergsvela
 * Date: 20.01.14
 * Time: 19:55
 */

namespace rest\server\controller;

use rest\server\RestResponse;
use rest\server\RestRequest;

class Controller {
	
	public function doGet(RestRequest $request, RestResponse $response) {
		$response->header()->setStatus(405);
		$response->data()["message"] = $response->header()->getStatusMessage();
	}
	public function doPost(RestRequest $request, RestResponse $response) {
		$this->doGet($request, $response);
	}
	public function doDelete(RestRequest $request, RestResponse $response) {
		$this->doGet($request, $response);
	}
	public function doPatch(RestRequest $request, RestResponse $response) {
		$this->doGet($request, $response);
	}
	
} 