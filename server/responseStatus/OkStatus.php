<?php
namespace rest\server\responseStatus;

class OkStatus extends ResponseStatus{
	
	public function __construct() {
		parent::__construct("ok", "ok");
	}
	
} 