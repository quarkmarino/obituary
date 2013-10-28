<?php

namespace Repositories\Interfaces;
 
interface PlanInterface {
  public function findById($id);
  public function findAll();
  public function paginate($limit = null);
  public function store($data);
  public function update($id, $data);
  public function destroy($id);
  public function validation($data);
  public function instance();
}