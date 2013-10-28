<?php

namespace Repositories\ORM\Eloquent;

use Repositories\Interfaces\CemeteryInterface;
use Repositories\Services\Validators\CemeteryValidator;
use Repositories\Exceptions\Errors\NotFoundException as NotFoundException;
 
class Cemetery implements CemeteryInterface {

  protected $validator;

  public function __construct(CemeteryValidator $validator){
    $this->validator = $validator;
  }

  public function findById($id){
    $cemetery = \Models\Cemetery::with([
        'comments' => function($q){
          $q->orderBy('created_at', 'desc');
        }
      ])
      ->where('id', $id)
      ->first();
    if(!$cemetery) throw new NotFoundException('Cemetery Not Found');
    return $cemetery;
  }

  public function findAll(){
    return \Models\Cemetery::with([
        'comments' => function($q){
          $q->orderBy('created_at', 'desc');
        }
      ])
      ->orderBy('created_at', 'desc')
      ->get();
  }

  public function paginate($limit = null){
    return \Models\Cemetery::paginate($limit);
  }

  /**
   * Validates and create the cemetery resource
   * @param array $data the data with which the model will be populated
   * @return the created cemetery model
  */

  public function store($data){
    $this->validation($data);
    return \Models\Cemetery::create($data);
  }

  /**
   * Finds the the cemetery resource by id, validates the data, the fills the model ands save it
   * @param integer $id the id of the resource
   * @param array $data the data with which the model will be filled
   * @return the updated cemetery model 
  */

  public function update($id, $data){
    $cemetery = $this->findById($id);
    $this->validation($data);
    $cemetery->fill($data);
    $cemetery->save();
    return $cemetery;
  }

  /**
   * Finds the the cemetery resource by id and deletes it
   * @param integer $id the id of the resource
   * @return the updated cemetery model 
  */

  public function destroy($id){
    $cemetery = $this->findById($id);
    return $cemetery->delete();
  }

  public function validation($data){
    return $this->validator->validate($data); 
  }

  public function instance($data = array()){
    return new \Models\Cemetery($data);
  }
  
}