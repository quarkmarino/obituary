<?php

namespace Repositories\Services\Validators;

class DeceasedValidator extends Validation{

    /**
    * Validation rules
    */
    public static $rules = array(
        'name' => 'required|alpha|max:12',
    	'last_name' => 'required|alpha|max:12',
    	'date' => 'required|date',
        'age' => 'integer|between:0,120',
    	'cause' => 'max:128',
    	'appelation' => 'max:45',
        'mortuary_id'   => 'required|integer',
        'cemetery_id'   => 'integer',
    );
}