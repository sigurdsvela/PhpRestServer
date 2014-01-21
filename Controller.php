<?php
/**
 * User: sigurdbergsvela
 * Date: 20.01.14
 * Time: 19:55
 */

namespace rest;
class Controller {
	
	public function doGet(RestRequest $request, RestResponse $response) {
		$response->setStatusCode(405);
		$response->setStatusMessage("Verb not allowed");
		$response->json()["message"] = "This verb is not allowed here.";
		$response->flush();
		die();
	}
	public function doPost(RestRequest $request, RestResponse $response) {
		$response->setStatusCode(405);
		$response->setStatusMessage("Verb not allowed");
		$response->json()["message"] = "This verb is not allowed here.";
		$response->flush();
		die();
	}
	public function doDelete(RestRequest $request, RestResponse $response) {
		$response->setStatusCode(405);
		$response->setStatusMessage("Verb not allowed");
		$response->json()["message"] = "This verb is not allowed here.";
		$response->flush();
		die();
	}
	public function doPatch(RestRequest $request, RestResponse $response) {
		$response->setStatusCode(405);
		$response->setStatusMessage("Verb not allowed");
		$response->json()["message"] = "This verb is not allowed here.";
		$response->flush();
		die();
	}
	
} 