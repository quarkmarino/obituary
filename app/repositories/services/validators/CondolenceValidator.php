<?php

namespace Repositories\Services\Validators;

class CondolenceValidator extends Validation{

    /**
    * Validation rules
    */
    public static $rules = array(
    	'name' => 'required|alpha',
    	'email' => 'required|email',
    	'message' => 'required',
    	'offering' => 'integer|between:0,4',
    	'status' => 'integer|between:-1,1',
      'obituary_id'   => 'required|numeric',
    );
}