<?php

namespace Repositories\ORM\Eloquent;

use Repositories\Interfaces\DeceasedInterface;
use Repositories\Services\Validators\DeceasedValidator;
use Repositories\Errors\Exceptions\NotFoundException as NotFoundException;
use Authority\Authority as Authority;
 
class Deceased implements DeceasedInterface {

  protected $validator;

  public function __construct(DeceasedValidator $validator){
    $this->validator = $validator;
  }

  public function findById($id){
    $obituary = \Models\Deceased::where('id', $id)
    ->with([
      'mortuary',
      'cemetery',
      'obituaries' => function($q){ $q->orderBy('created_at', 'desc'); },
    ])
    ->first();
    if(!$obituary) throw new NotFoundException('Deceased Not Found');
    return $obituary;
  }

  public function findAll(){
    $authority = new Authority(\Auth::user());
    $deceased = \Models\Deceased::with([
      'mortuary',
      'cemetery'
    ]);
    if( $authority->user()->hasRole('promoter') )
      $deceased->with(['obituaries' => function($q){ $q->wherePromoterId(Auth::user()->id)->orderBy('created_at', 'desc'); }]);
    elseif( $authority->user()->hasRole('owner') )
      $deceased->with(['obituaries' => function($q){ $q->whereOwnerId(Auth::user()->id)->orderBy('created_at', 'desc'); }]);
    else
      $deceased->with('obituaries');
    return $deceased->orderBy('created_at', 'desc')->get();
  }

  public function paginate($limit = null){
    return \Models\Deceased::paginate($limit);
  }

  /**
   * Validates and create the obituary resource
   * @param array $data the data with which the model will be populated
   * @return the created obituary model
  */

  public function store($data){
    $this->validation($data);
    return \Models\Deceased::create($data);
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
    return new \Models\Deceased($data);
  }
  
}