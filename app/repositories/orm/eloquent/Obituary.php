<?php

namespace Repositories\ORM\Eloquent;

use Repositories\Interfaces\ObituaryInterface;
use Repositories\Services\Validators\ObituaryValidator;
use Repositories\Errors\Exceptions\NotFoundException as NotFoundException;
use Authority\Authority as Authority;
 
class Obituary implements ObituaryInterface {

  protected $validator;

  public function __construct(ObituaryValidator $validator){
    $this->validator = $validator;
  }

  public function findById($id){
    $obituary = \Models\Obituary::where('id', $id)
    ->with([
      'condolences' => function($q){ $q->orderBy('created_at', 'desc'); },
      'events' => function($q){ $q->orderBy('created_at', 'desc'); },
      'memories' => function($q){ $q->orderBy('created_at', 'desc'); },
    ])
    ->first();
    if(!$obituary) throw new NotFoundException('Obituary Not Found');
    return $obituary;
  }

  public function findAll(){
    $authority = new Authority(\Auth::user());
    if( $authority->user()->hasRole('promoter') )
      $obituaries = \Models\Obituary::promoted();
    elseif( $authority->user()->hasRole('owner') )
      $obituaries = \Models\Obituary::owned();
    else
      $obituaries = new \Models\Obituary;

    return $obituaries->with([
      'condolences' => function($q){ $q->orderBy('created_at', 'desc'); },
      'events' => function($q){ $q->orderBy('created_at', 'desc'); },
      'memories' => function($q){ $q->orderBy('created_at', 'desc'); },
    ])
    ->orderBy('created_at', 'desc')
    ->get();
  }

  public function paginate($limit = null){
    return \Models\Obituary::paginate($limit);
  }

  /**
   * Validates and create the obituary resource
   * @param array $data the data with which the model will be populated
   * @return the created obituary model
  */

  public function store($data){
    $this->validation($data);
    return \Models\Obituary::create($data);
  }

  /**
   * Finds the the obituary resource by id, validates the data, the fills the model ands save it
   * @param integer $id the id of the resource
   * @param array $data the data with which the model will be filled
   * @return the updated obituary model 
  */

  public function update($id, $data){
    $obituary = $this->findById($id);
    $this->validation($data);
    $obituary->fill($data);
    $obituary->save();
    return $obituary;
  }

  /**
   * Finds the the obituary resource by id and deletes it
   * @param integer $id the id of the resource
   * @return the updated obituary model 
  */

  public function destroy($id){
    $obituary = $this->findById($id);
    return $obituary->delete();
  }

  public function validation($data){
    return $this->validator->validate($data); 
  }

  public function instance($data = array()){
    return new \Models\Obituary($data);
  }
  
}