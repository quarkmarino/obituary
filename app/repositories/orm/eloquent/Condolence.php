<?php
 
namespace Repositories\ORM\Eloquent;

use Repositories\Interfaces\CondolenceInterface;
use Repositories\Services\Validators\CondolenceValidator;
use Repositories\Exceptions\NotFoundException;

class Condolence implements CondolenceInterface {

  protected $validator;

  public function __construct(CondolenceValidator $validator){
    $this->validator = $validator;
  }
 
  public function findById($obituary_id, $id){
    $condolence = \Models\Condolence::find($id);
    if(!$condolence || $condolence->obituary_id != $obituary_id) throw new NotFoundException('Condolence Not Found');
    return $condolence;
  }
 
  public function findAll($obituary_id){
    return \Models\Condolence::where('obituary_id', $obituary_id)
      ->orderBy('created_at', 'desc')
      ->get();
  }
 
  public function store($obituary_id, $data){
    if( Authority::can('create', 'Condolence') ){
      $data['obituary_id'] = $obituary_id;
      $this->validation($data);
      return \Models\Condolence::create($data);
    }
  }
 
  public function update($obituary_id, $id, $data){
    $condolence = $this->findById($obituary_id, $id);
    $condolence->fill($data);
    $this->validation($condolence->toArray());
    $condolence->save();
    return $condolence;
  }
 
  public function destroy($obituary_id, $id){
    $condolence = $this->findById($obituary_id, $id);
    $condolence->delete();
    return true;
  }
 
  public function validation($data){
    return $this->validator->validate($data);
  }
 
  public function instance($data = array()){
    return new \Models\Condolence($data);
  }
 
}