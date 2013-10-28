<?php

namespace Repositories\Services\Validators;

class MortuaryValidator extends Validation{

    /**
    * Validation rules
    */
    public static $rules = array(
      'name'    => 'required',
      'location' => 'required'
    );
}