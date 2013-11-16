<?php

namespace Models;

use Eloquent;

class Cemetery extends Eloquent {
	protected $guarded = [];

	public static $rules = [];

	public function deceased(){
		return $this->hasMany('Models\Deceased', 'burial_id');
	}
}
