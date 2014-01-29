<?php
namespace rest\server\controller;

use rest\server\responseStatus\MissingParametersStatus;
use rest\server\RestRequest;
use rest\server\RestResponse;

class MissingParametersController extends Controller{
	private $data;

	/**
	 * @param array $data The parameters that is missing
	 */
	public function __construct(array $data) {
		$this->data = $data;
	}

	public function doGet(RestRequest $request, RestResponse $response) {
		$response->setStatus(new MissingParametersStatus($this->data)); 
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