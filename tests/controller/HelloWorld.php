<?php
namespace rest\tests\controller;

use rest\server\controller\Controller;
use rest\server\RestRequest;
use rest\server\RestResponse;

class HelloWorld extends Controller {
	
	public function doGet(RestRequest $request, RestResponse $response) {
		$response->data()["message"] = "Hello World!";
		$response->data()["method"] = "GET";
	}

	public function doPost(RestRequest $request, RestResponse $response) {
		$response->data()["message"] = "Hello World!";
		$response->data()["method"] = "POST";
	}

	public function doDelete(RestRequest $request, RestResponse $response) {
		$response->data()["message"] = "Hello World!";
		$response->data()["method"] = "DELETE";
	}

	public function doPatch(RestRequest $request, RestResponse $response) {
		$response->data()["message"] = "Hello World!";
		$response->data()["method"] = "PATCH";
	}


} 