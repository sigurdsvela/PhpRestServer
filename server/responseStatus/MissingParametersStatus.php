<?php
namespace rest\server\responseStatus;

class MissingParametersStatus extends ResponseStatus{
	
	public function __construct(array $missingParameters) {
		$message = "Missing parameters ";
		foreach ($missingParameters as $p) {
			$message .= $p["name"] . " " . "[" . $p["match"] . "] ";
		}
		parent::__construct("missing_parameters", $message);
	}
	
} 