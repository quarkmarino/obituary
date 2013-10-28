<?php

namespace Repositories\ORM\Eloquent;

use Repositories\Interfaces\MortuaryInterface;
use Repositories\Services\Validators\MortuaryValidator;
use Repositories\Errors\Exceptions\NotFoundException as NotFoundException;
 
class Mortuary implements MortuaryInterface {

  protected $validator;

  public function __construct(MortuaryValidator $validator){
    $this->validator = $validator;
  }

  public function findById($id){
    $mortuary = \Models\Mortuary::with([
        'comments' => function($q){
          $q->orderBy('created_at', 'desc');
        }
      ])
      ->where('id', $id)
      ->first();
    if(!$mortuary) throw new NotFoundException('Mortuary Not Found');
    return $mortuary;
  }

  public function findAll(){
    return \Models\Mortuary::with([
        'comments' => function($q){
          $q->orderBy('created_at', 'desc');
        }
      ])
      ->orderBy('created_at', 'desc')
      ->get();
  }

  public function paginate($limit = null){
    return \Models\Mortuary::paginate($limit);
  }

  /**
   * Validates and create the mortuary resource
   * @param array $data the data with which the model will be populated
   * @return the created mortuary model
  */

  public function store($data){
    $this->validation($data);
    return \Models\Mortuary::create($data);
  }

  /**
   * Finds the the mortuary resource by id, validates the data, the fills the model ands save it
   * @param integer $id the id of the resource
   * @param array $data the data with which the model will be filled
   * @return the updated mortuary model 
  */

  public function update($id, $data){
    $mortuary = $this->findById($id);
    $this->validation($data);
    $mortuary->fill($data);
    $mortuary->save();
    return $mortuary;
  }

  /**
   * Finds the the mortuary resource by id and deletes it
   * @param integer $id the id of the resource
   * @return the updated mortuary model 
  */

  public function destroy($id){
    $mortuary = $this->findById($id);
    return $mortuary->delete();
  }

  public function validation($data){
    return $this->validator->validate($data); 
  }

  public function instance($data = array()){
    return new \Models\Mortuary($data);
  }
  
}