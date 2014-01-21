<?php
namespace rest;

use std\io\File;
use std\json\JSON;
use std\URL;

class Rest {

	/**
	 * Load the rest server.
	 * This should be called on every page load.
	 *
	 * @param $config JSON|File|Array
	 *
	 * @return void
	 */
	public static function load($config) {
		$url = URL::getCurrentUrl();
	}
	
}