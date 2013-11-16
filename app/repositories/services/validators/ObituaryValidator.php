<?php

namespace Repositories\Services\Validators;

class ObituaryValidator extends Validation{

    /**
    * Validation rules
    */
    public static $rules = array(
    	'title' => 'required|alpha',
    	'article' => 'required',
        'religion' => 'integer|between:-1,-5',
    	'style' => 'integer|between:0,5',
    	'status' => 'integer|between:-1,1',
        'deceased_id'   => 'required|integer',
        'promoter_id'   => 'required|integer',
    );
}