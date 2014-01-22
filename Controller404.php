<?php
namespace rest;

class Controller404 extends Controller{
	public function doGet(RestRequest $request, RestResponse $response) {
		$response->json()["message"] = "Not Found";
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