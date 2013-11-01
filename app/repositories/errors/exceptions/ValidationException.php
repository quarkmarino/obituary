<?php

namespace Repositories\Errors\Exceptions;

use Illuminate\Validation\Validator as Validator;
use Exception;

class ValidationException extends Exception{
  
  /**
  * Errors object.
  *
  * @var Laravel\Messages
  */
  private $errors;

  /**
  * Create a new validate exception instance.
  *
  * @param  Laravel\Validator|Laravel\Messages  $validator
  * @return void
  */
  public function __construct($validator, $code = 400){
    $this->errors = ($validator instanceof Validator) ? $validator->messages() : $validator;
    parent::__construct($this->errors, 400);
  }

  /**
  * Gets the errors object.
  *
  * @return Laravel\Messages
  */
  public function getErrors(){
    return is_string($this->errors) ? json_decode( $this->errors ) : $this->errors;
  }

}