<?php

namespace Models;

use Eloquent;

class Deceased extends Eloquent {

	/**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'deceased';

  public function getFullNameAttribute(){
		return $this->name.' '.$this->last_name;
	}

	protected $guarded = array();

	public static $rules = array();

	public function obituaries(){
		return $this->hasMany('Models\Obituary');
	}

	public function mortuary(){
		return $this->belongsTo('Models\Mortuary');
	}

	public function cemetery(){
		return $this->belongsTo('Models\Cemetery');
	}
}
