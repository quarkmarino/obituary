<?php

namespace Models;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'users';

	protected $guarded = [];

	public static $rules = [];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('id', 'password', 'role');

  /**
   * Get the unique identifier for the user.
   *
   * @return mixed
   */
  public function getAuthIdentifier()
  {
    return $this->getKey();
  }

  /**
   * Get the password for the user.
   *
   * @return string
   */
  public function getAuthPassword()
  {
    return $this->password;
  }

  /**
   * Get the e-mail address where password reminders are sent.
   *
   * @return string
   */
  public function getReminderEmail()
  {
    return $this->email;
  }

  /**
   * The owned mortuaries by the user, just in case it is a promoter
   */
  public function mortuaries() {
    return $this->hasMany('Models\Mortuary', 'owner_id');
  }

  /**
   * The promoted obituaries, those that are not managed by a direct client
   */
  public function promotedObituaries() {
    return $this->hasMany('Models\Obituary', 'promoter_id');
  }

  /**
   * The owned obituaries, those managed by the client
   */
  public function ownedObituaries() {
    return $this->hasMany('Models\Obituary', 'owner_id');
  }

  /**
   * The plan this user has purchased
   */
  public function plan() {
    return $this->belongsTo('Models\Plan');
  }

  /**
   * The roles that this user handles
   */
	public function roles() {
    return $this->belongsToMany('Models\Role');
  }

  /**
   * 
   */
  public function permissions() {
    return $this->hasMany('Models\Permission');
  }

  /**
   * 
   */
  public function hasRole($key) {
    //return $key === 'admin';
    $roles = ['guest' => 0, 'owner' => 1, 'promoter' => 2, 'admin' => 3];
    return $roles[$key] == $this->role;
    /*foreach($this->roles as $role){
      if($role->name === $key)
      {
        return true;
      }
    }
    return false;*/
  }
}