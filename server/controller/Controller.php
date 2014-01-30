<?php
/**
 * User: sigurdbergsvela
 * Date: 20.01.14
 * Time: 19:55
 */

namespace rest\server\controller;

use rest\server\RestResponse;
use rest\server\RestRequest;
use std\http\HttpController;
use std\http\HttpRequest;
use std\http\HttpResponse;

class Controller extends HttpController{
	
	public function doNotImplemented(RestRequest $request, RestResponse $response) {
		$response->header()->setStatus(405);
		$response->data()["message"] = $response->header()->getStatusMessage();
	}


} 