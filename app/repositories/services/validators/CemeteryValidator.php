<?php

namespace Repositories\Services\Validators;

class CemeteryValidator extends Validation{

    /**
    * Validation rules
    */
    public static $rules = array(
      'name'    => 'required',
      'location' => 'required'
    );
}