<?php
namespace rest\tests;

use rest\server\RestResponse;
use rest\server\RestServer;
use std\http\HttpRequestHeader;
use std\json\JSON;

class RestTestCase extends \PHPUnit_Framework_TestCase {
	/**
	 * @var Config $config
	 */
	private static $config;



	public function setUp() {
		$json = new JSON();
		$json->parse(__DIR__ . "/rest.json");
		self::$config = new Config($json);
	}

	/**
	 * Send a "fake" API request
	 *
	 * @param string               $resource   The resource
	 * @param string               $parameters The parameter
	 *
	 * @param string               $method
	 * @param \std\http\HttpRequestHeader $header
	 *
	 * @return RestResponse
	 */
	protected function sendRequest($resource, $parameters, $method = "GET", HttpRequestHeader $header) {
		//Back up the super global variables
		$server = $_SERVER;
		$post = $_POST;
		$get = $_GET;
		$request = $_REQUEST;
		$cookie = $_COOKIE;
		$env = $_ENV;
		$session = isset($_SESSION) ? $_SESSION : null;
		
		//Set Server
		$_SERVER = array(
			'HTTP_USER_AGENT' => $header->getUserAgent(),
			'PHP_SELF' => $_SERVER['PHP_SELF'],
			'REQUEST_URI' => self::$config->getBase() . $resource,
			//'GATEWAY_INTERFACE' => $_SERVER['GATEWAY_INTERFACE'],
			'SERVER_ADDR' => "127.0.0.1",
			'SERVER_NAME' => "www.example.com",
			//'SERVER_SOFTWARE' => $_SERVER['SERVER_SOFTWARE'],
			'SERVER_PROTOCOL' => "HTTP/1.1",
			'REQUEST_METHOD' => $method,
			'REQUEST_TIME' => $_SERVER['REQUEST_TIME'],
			'QUERY_STRING' => "",
			'HTTP_ACCEPT_CHARSET' => $header->getAcceptCharset(),
			//'HTTP_HOST' => $_SERVER['HTTP_HOST'],
			//'HTTP_REFERER' => $_SERVER['HTTP_REFERER'],
			//'HTTPS' => $_SERVER['HTTPS'],
			'REMOTE_ADDR' => "127.0.0.1",
			//'REMOTE_HOST' => $_SERVER['REMOTE_HOST'],
			//'REMOTE_PORT' => $_SERVER['REMOTE_PORT'],
			'SERVER_PORT' => isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : 80,
			'SCRIPT_FILENAME' => $_SERVER['SCRIPT_FILENAME'],
			//'SERVER_ADMIN' => $_SERVER['SERVER_ADMIN'],
			//'SERVER_SIGNATURE' => $_SERVER['SERVER_SIGNATURE'],
			'PATH_TRANSLATED' => $_SERVER['PATH_TRANSLATED'],
			'HTTP_ACCEPT' => $header->getAccept(),
			'SCRIPT_NAME' => $_SERVER['SCRIPT_NAME'],
			//'SCRIPT_URI' => $_SERVER['SCRIPT_URI']
		);
		
		$_POST = array();
		$_GET = array();
		$_REQUEST = array();
		
		if ($method === "POST") {
			$_POST = $parameters;
		} else if ($method === "GET") {
			$_GET = $parameters;
		}
		
		$_COOKIE = $header->getCookies();
		$_REQUEST = $_POST + $_GET;
		
		$result = (new RestServer(self::$config))->load();
		
		//Restore Globals
		$_SERVER = $server;
		$_POST = $post;
		$_GET = $get;
		$_REQUEST = $request;
		$_COOKIE = $cookie;
		$_ENV = $env;
		$_SESSION = $session;
		if ($_SESSION === null) {
			unset($_SESSION);
		}
		
		return $result; //Return the output
	}
	
}