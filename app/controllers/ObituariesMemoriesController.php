<?php

namespace Controllers;

use Input;
use View;
use Redirect;
use Authority;
use Repositories\Interfaces\MemoriesInterface;
use Repositories\Errors\Exceptions\NotAllowedException as NotAllowedException;

class ObituariesMemoriesController extends BaseController {

	protected $memory;

	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'layouts.master';

	/**
   * We will use Laravel's dependency injection to auto-magically
   * "inject" our repository instance into our controller
   */
  public function __construct(MemoriesInterface $memory){
    $this->memory = $memory;

    //$this->beforeFilter('auth', array('except' => 'login'));
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		if( Authority::can('index', 'Event') ){
			$memories = $this->memory->findAll();
			$this->layout->content = View::make('memories.index')->with(compact('memories'));
			return $this->layout->render();
		}
		throw new NotAllowedException();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
		if( Authority::can('create', 'Event') ){
			$input = Input::all();
			$memory = $this->memory->store($input);
			return Redirect::route('memories.show', $memory->id);//->with('success', 'The new memory has been created');
		}
    throw new NotAllowedException();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id){
		if( Authority::can('read', 'Event') ){
			$memory = $this->memory->findById($id);
			$this->layout->content = View::make('memories.show', compact('memory'));
			return $this->layout->render();
		}
		throw new NotAllowedException();
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
		if( Authority::can('update', 'Event') ){
			$input = Input::all();
			$memory = $this->memory->update($id, $input);
			return Redirect::route('memories.show', $memory->id);//->with('success', 'The new deceased has been created');
		}
    throw new NotAllowedException();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){
		if( Authority::can('delete', 'Event') ){
			$this->memory->destroy($id);
			return Redirect::route('memories.index');//->with('success', 'The memory has been deleted');
		}
    throw new NotAllowedException();
	}

}
