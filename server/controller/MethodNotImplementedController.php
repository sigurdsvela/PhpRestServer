<?php
namespace rest\server\controller;

use rest\server\responseStatus\MethodNotImplementedStatus;
use rest\server\RestRequest;
use rest\server\RestResponse;

class MethodNotImplementedController extends Controller{
	
	public function doGet(RestRequest $request, RestResponse $response) {
		$response->header()->setStatus(405);
		$response->setStatus(new MethodNotImplementedStatus($request->getMethod()));
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