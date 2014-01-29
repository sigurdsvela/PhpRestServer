<?php
namespace rest\server\responseStatus;

class MethodNotImplementedStatus extends ResponseStatus{
	
	public function __construct($method) {
		parent::__construct("method_not_implemented", "The method " . $method . " is not implemented on this rest server.");
	}
	
} 