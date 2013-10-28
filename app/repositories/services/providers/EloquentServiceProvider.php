<?php

namespace Repositories\Services\Provider;
 
use Illuminate\Support\ServiceProvider;
 
class EloquentProvider extends ServiceProvider {

  public function register(){
    $this->app->bind( 'Repositories\\Interfaces\\CemeteryInterface', 'Repositories\\ORM\\Eloquent\\Cemetery' );
    $this->app->bind( 'Repositories\\Interfaces\\MortuaryInterface', 'Repositories\\ORM\\Eloquent\\Mortuary' );
    $this->app->bind( 'Repositories\\Interfaces\\CondolenceInterface', 'Repositories\\ORM\\Eloquent\\Condolence' );
  }
  
}