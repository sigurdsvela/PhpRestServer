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
	public function __construct() {
		parent::__construct(true);
	}

	/**
	 * Get the matches of the url match regex.
	 *
	 * @return array
	 */
	public function getUrlCaptures() {
		return $this->getParameter("@captures");
	}
	
} 