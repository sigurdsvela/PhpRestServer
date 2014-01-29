<?php
/**
 * User: sigurdbergsvela
 * Date: 20.01.14
 * Time: 20:12
 */

namespace rest\server;

use std\http\HttpRequest;
use std\URL;

/**
 * Reperesent the request that is being made.
 * 
 * Class RestRequest
 * @package rest\server
 */
class RestRequest extends HttpRequest{
	private $urlCaptures;

	/**
	 * Get the url matches
	 *
	 * @param array $urlCaptures
	 */
	public function __construct(array $urlCaptures) {
		parent::__construct(true);
		$this->urlCaptures = $urlCaptures;
	}

	/**
	 * Get the matches of the url match regex.
	 *
	 * @return array
	 */
	public function getUrlCaptures() {
		return $this->urlCaptures;
	}
	
} 