<?php

namespace Models;

use Eloquent;

class Mortuary extends Eloquent {
	protected $guarded = [];

	public static $rules = [];

	public function owner(){
		return $this->belongsTo('Models\User', 'owner_id');
	}

	public function deceased(){
		return $this->hasMany('Models\Deceased');
	}
}
