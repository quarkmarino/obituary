<?php

namespace Models;

use Eloquent;

class User extends Eloquent {
	protected $guarded = array();

	public static $rules = array();
}
