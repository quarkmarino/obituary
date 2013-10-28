<?php

namespace Repositories\Services\Validators;

class CondolenceValidator extends Validation{

    /**
    * Validation rules
    */
    public static $rules = array(
      'post_id'   => 'required|numeric',
	    'content'   => 'required',
	    'author_name' => 'required'
    );
}