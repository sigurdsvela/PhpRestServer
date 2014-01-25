<?php
namespace rest\server;

use std\io\File;
use std\io\IOException;
use std\json\JSON;

class Cache {

	private function getFileName($resource, $params) {
		return __DIR__ . "/cache/" . hash("sha256", $resource . implode("", array_keys($params)) . implode("", $params));
	}
	
	/**
	 * Check if we have a cache for $resource and $params
	 *
	 * @param string $resource The resource
	 * @param string $params The parameters
	 *
	 * @return bool
	 */
	public function hasCacheFor($resource, $params) {
		return is_file($this->getFileName($resource, $params));
	}

	/**
	 * Get the cache for $resource and $params
	 *
	 * @param string $resource The resource
	 * @param string $params The parameters
	 *
	 * @throws IOException
	 * @return JSON
	 */
	public function getCache($resource, $params) {
		$file = new File($this->getFileName($resource, $params));
		$file->open();
		$json = new JSON();
		$json->parse($file);
		$file->close();
		return $json;
	}

	/**
	 * Delete the cache for $resource and $params
	 *
	 * @param string $resource The resource
	 * @param string $params The parameters
	 *
	 * @throws IOException
	 * @return void
	 */
	public function deleteCache($resource, $params) {
		$file = new File($this->getFileName($resource, $params));
		$file->open();
		$file->delete();
		$file->close();
	}

	/**
	 * Delete the cache for $resource and $params
	 *
	 * @param string         $resource The resource
	 * @param string         $params   The parameters
	 *
	 * @param \std\json\JSON $data
	 * @throws IOException
	 * @return void
	 */
	public function setCache($resource, $params, JSON $data) {
		$file = new File($this->getFileName($resource, $params));
		$file->create();
		$file->emptyFile();
		$file->open();
		$data->write($file);
		$file->close();
	}
	
} 