<?php
namespace rest\server\responseStatus;

abstract class ResponseStatus {
	private $code;
	private $slug;
	private $message;
	private $details;

	/**
	 * @param string $slug    The slug of this status. Example: missing_data
	 * @param string $message The status message
	 */
	public function __construct($slug, $message) {
		$this->code = hash("sha256", __CLASS__);
		$this->slug = $slug;
		$this->message = $message;
	}

	public final function getCode() {
		return $this->code;
	}

	public final function getSlug() {
		return $this->slug;
	}

	public final function getMessage() {
		return $this->message;
	}
}