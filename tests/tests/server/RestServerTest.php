<?php
namespace rest\tests\server;

use rest\tests\RestTestCase;
use std\http\HttpRequestHeader;

class RestServerTest extends RestTestCase{

	/**
	 * @runInSeparateProcess
	 */
	public function testMethodNotAllowed() {
		$methods = array('GET', 'POST', 'DELETE', 'PATCH');
		
		foreach ($methods as $method) {
			$o = $this->sendRequest("notallowed", array(), $method, new HttpRequestHeader());
			$this->assertEquals("Method Not Allowed", $o->data()["message"]);
			$this->assertEquals(405, $o->header()->getStatusCode());
			$this->assertEquals("Method Not Allowed", $o->header()->getStatusMessage());
		}
	}
	
	public function testHelloWorld() {
		$methods = array('GET', 'POST', 'DELETE', 'PATCH');

		foreach ($methods as $method) {
			$o = $this->sendRequest("helloworld", array(), $method, new HttpRequestHeader());
			$this->assertEquals($o->data()->toArray(), array(
				"message" => "Hello World!",
				"method" => $method
			));
			$this->assertEquals(200, $o->header()->getStatusCode());
			$this->assertEquals("OK", $o->header()->getStatusMessage());
		}

	}
	
	public function test404() {
		$methods = array('GET', 'POST', 'DELETE', 'PATCH');

		foreach ($methods as $method) {
			$o = $this->sendRequest("doesnotexist", array(), $method, new HttpRequestHeader());
			$this->assertEquals($o->data()->toArray(), array(
				"message" => "Not Found",
			));
			$this->assertEquals(404, $o->header()->getStatusCode());
			$this->assertEquals("Not Found", $o->header()->getStatusMessage());
		}
	}
}
