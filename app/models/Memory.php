<?php

namespace Models;

use Eloquent;

class Memory extends Eloquent {
	protected $guarded = [];

	public static $rules = [];

	public function obituary(){
		return $this->belongsTo('Models\Obituary');
	}
}
