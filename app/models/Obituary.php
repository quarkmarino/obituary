<?php

namespace Models;

use Eloquent;

class Obituary extends Eloquent {
	protected $guarded = [];

	public static $rules = [];

	public function condolences(){
		return $this->hasMany('Models\Condolence');
	}

	public function events(){
		return $this->hasMany('Models\Event');
	}

	public function memories(){
		return $this->hasMany('Models\Memory');
	}

	public function deceased(){
		return $this->belongsTo('Models\Deceased');
	}

	public function promoter(){
		return $this->belongsTo('Models\User', 'promoter_id');
	}

	public function owner(){
		return $this->belongsTo('Models\User', 'user_id');
	}

	public function scopePromoted($query){
		$query->wherePromoterId(Auth::user()->id);
	}

	public function scopeOwned($query){
		$query->whereOwnerId(Auth::user()->id);
	}
}
