<?php
namespace rest\server\responseStatus;

class NotFoundStatus extends ResponseStatus{
	
	public function __construct($message = "Not Found") {
		parent::__construct("not_found", $message);
	}
	
}