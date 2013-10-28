<?php

namespace Repositories\Interfaces;

interface CondolenceInterface {
  public function findById($obituary_id, $id);
  public function findAll($obituary_id);
  public function store($obituary_id, $data);
  public function update($obituary_id, $id, $data);
  public function destroy($obituary_id, $id);
  public function validation($data);
  public function instance();
}