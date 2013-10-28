<?php

namespace Repositories\ORM\Eloquent;

use Repositories\Interfaces\UserInterface;
use Repositories\Services\Validators\UserValidator;
use Repositories\Exceptions\Errors\NotFoundException as NotFoundException;
 
class User implements UserInterface {

  protected $validator;

  public function __construct(UserValidator $validator){
    $this->validator = $validator;
  }

  public function findById($id){
    $user = \Models\User::with([
        'comments' => function($q){
          $q->orderBy('created_at', 'desc');
        }
      ])
      ->where('id', $id)
      ->first();
    if(!$user) throw new NotFoundException('User Not Found');
    return $user;
  }

  public function findAll(){
    return \Models\User::with([
        'comments' => function($q){
          $q->orderBy('created_at', 'desc');
        }
      ])
      ->orderBy('created_at', 'desc')
      ->get();
  }

  public function paginate($limit = null){
    return \Models\User::paginate($limit);
  }

  /**
   * Validates and create the user resource
   * @param array $data the data with which the model will be populated
   * @return the created user model
  */

  public function store($data){
    $this->validation($data);
    return \Models\User::create($data);
  }

  /**
   * Finds the the user resource by id, validates the data, the fills the model ands save it
   * @param integer $id the id of the resource
   * @param array $data the data with which the model will be filled
   * @return the updated user model 
  */

  public function update($id, $data){
    $user = $this->findById($id);
    $this->validation($data);
    $user->fill($data);
    $user->save();
    return $user;
  }

  /**
   * Finds the the user resource by id and deletes it
   * @param integer $id the id of the resource
   * @return the updated user model 
  */

  public function destroy($id){
    $user = $this->findById($id);
    return $user->delete();
  }

  public function validation($data){
    return $this->validator->validate($data); 
  }

  public function instance($data = array()){
    return new \Models\User($data);
  }
  
}