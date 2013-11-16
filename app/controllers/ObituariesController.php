<?php

namespace Controllers;

use Input;
use View;
use Redirect;
use Authority;
use Repositories\Interfaces\ObituaryInterface;
use Repositories\Errors\Exceptions\NotAllowedException as NotAllowedException;

class ObituariesController extends BaseController {

	protected $obituary;

	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'layouts.master';

	/**
   * We will use Laravel's dependency injection to auto-magically
   * "inject" our repository instance into our controller
   */
  public function __construct(ObituaryInterface $obituary){
    $this->obituary = $obituary;

    $this->beforeFilter('auth', array('except' => 'login'));
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		if( Authority::can('index', 'Obituary') ){
			$obituaries = $this->obituary->findAll();
			$this->layout->content = View::make('obituaries.index')->with(compact('obituaries'));;
			return $this->layout;
		}
		throw new NotAllowedException();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
		if( Authority::can('create', 'Obituary') ){
			$obituary = $this->obituary->instance();
			$this->layout->content = View::make('obituaries.create')->with(compact('obituary'));
			return $this->layout;
		}
    throw new NotAllowedException();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
		if( Authority::can('create', 'Obituary') ){
			$input = Input::all();
			$obituary = $this->obituary->store($input);
			return Redirect::route('obituaries.show', $obituary->id);//->with('success', 'The new obituary has been created');
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
		$obituary = $this->obituary->findById($id);
		//return $this->layout->nest('content', 'obituaries.show', compact('obituary'));
		$this->layout->content = View::make('obituaries.show')->with(compact('obituary'));
		return $this->layout;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
		$obituary = $this->obituary->findById($id);
		if( Authority::can('update', $obituary) ){
			$this->layout->content = View::make('obituaries.edit')->with(compact('obituary'));
			return $this->layout;
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
		if( Authority::can('update', 'Obituary') ){
			$input = Input::all();
			$obituary = $this->obituary->update($id, $input);
			return Redirect::route('obituaries.show', $obituary->id);//->with('success', 'The new obituary has been created');
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
		if( Authority::can('delete', 'Obituary') ){
			$this->obituary->destroy($id);
			return Redirect::route('obituaries.index');//->with('success', 'The obituary has been deleted');
		}
    throw new NotAllowedException();
	}

}
