<?php
namespace rest\server\controller;

use rest\server\responseStatus\NotFoundStatus;
use rest\server\RestRequest;
use rest\server\RestResponse;

class Controller404 extends Controller{
	public function doGet(RestRequest $request, RestResponse $response) {
		$response->data()["message"] = "Not Found";
		$response->header()->setStatus(404);
		$response->header()->setHeader("X-Hey-Ya", "Heeeeyaaa");
		$response->setStatus(new NotFoundStatus());
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