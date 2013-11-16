<?php

namespace Controllers;

use Input;
use View;
use Redirect;
use Authority;
use Repositories\Interfaces\DeceasedInterface;
use Repositories\Errors\Exceptions\NotAllowedException as NotAllowedException;

class ObituariesDeceasedController extends BaseController {

	protected $deceased;

	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'layouts.master';

	/**
   * We will use Laravel's dependency injection to auto-magically
   * "inject" our repository instance into our controller
   */
  public function __construct(DeceasedInterface $deceased){
    $this->deceased = $deceased;

    //$this->beforeFilter('auth', array('except' => 'login'));
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		if( Authority::can('index', 'Deceased') ){
			$deceased = $this->deceased->findAll();
			$this->layout->content = View::make('deceased.index')->with(compact('deceased'));
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
		if( Authority::can('create', 'Deceased') ){
			$input = Input::all();
			$deceased = $this->deceased->store($input);
			return Redirect::route('deceased.show', $deceased->id);//->with('success', 'The new deceased has been created');
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
		if( Authority::can('read', 'Deceased') ){
			$deceased = $this->deceased->findById($id);
			$this->layout->content = View::make('deceased.show', compact('deceased'));
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
		if( Authority::can('update', 'Deceased') ){
			$input = Input::all();
			$deceased = $this->deceased->update($id, $input);
			return Redirect::route('deceased.show', $deceased->id);//->with('success', 'The new deceased has been created');
		}
    throw new NotAllowedException();
	}

}
