<?php


namespace Repositories\Services\Validators;

use Exception;
use Validator;
use Repositories\Errors\Exceptions\ValidationException as ValidationException;

abstract class Validation{

	public static $rules = array();

	public static $messages = array();

	/**
	 * Validator object.
	 *
	 * @var object
	 */
	protected $validator;

	/**
	 * Create a new validation service instance.
	 *
	 * @param  array  $input
	 * @return void
	 */
	/*public function __construct($input = NULL){
    $this->input = $input ?: \Input::all();
  }*/

  /**
	 * Validates the input.
	 *
	 * @throws ValidateException
	 * @return boolean true
	 */
	public function validate($data){
		$this->validator = Validator::make($data, static::$rules, static::$messages = array());

		if($this->validator->fails()){
			throw new ValidationException($this->validator);
		}
		return true;
	}

	/**
	 * Sets a data key/value on the service. (maybe a good practice)
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function __set($key, $value){
		$this->data[$key] = $value;
	}

	/**
	 * Gets a data key from the service. (maybe a good practice)
	 *
	 * @param  string  $key
	 * @throws Exception
	 * @return mixed
	 */
	public function __get($key){
	    if ( ! isset($this->data[$key]))
	    {
	        throw new Exception("Could not get [{$key}] from Repositories\Services\Validation data array.");
	    }

	    return $this->data[$key];
	}

}