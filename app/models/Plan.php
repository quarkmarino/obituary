<?php

namespace Models;

use Eloquent;

class Plan extends Eloquent {
	protected $guarded = [];

	public static $rules = [];

	public function users(){
		return $this->hasMany('Models\User');
	}
}
