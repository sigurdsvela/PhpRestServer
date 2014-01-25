<?php
/**
 * User: sigurdbergsvela
 * Date: 20.01.14
 * Time: 20:12
 */

namespace rest\server;

use std\URL;

class RestRequest {
	private $requestedURL;
	private $parameters;
	private $method;
	private $cookies;
	private $urlMatches;

	/**
	 * Get the url matches
	 * @param array $urlMatches
	 */
	public function __construct(array $urlMatches) {
		$this->urlMatches = $urlMatches;
	}
	
	/**
	 * Returns the requested url;
	 *
	 * @return URL a url object is returned. Check out the documentation, it has a bunch of awesome functions.
	 */
	public function getRequestedURL() {
		return $this->requestedURL;
	}

	/**
	 * Get the matches of the url match regex.
	 *
	 * @return array
	 */
	public function getUrlMatches() {
		return $this->urlMatches;
	}

	/**
	 * Return the query string, as a key=>value 
	 *
	 * @return void
	 */
	public function getQueryString() {
		
	}
	
	public function getParameters() {
		
	}
	
} 