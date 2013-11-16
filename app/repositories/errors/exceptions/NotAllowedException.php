<?php

namespace Repositories\Errors\Exceptions;

use Illuminate\Validation\Validator as Validator;
use Exception;

class NotAllowedException extends Exception{

	public function __construct($message = null, $code = 403){
		parent::__construct($message ?: 'Action not allowed', $code);
	}
}