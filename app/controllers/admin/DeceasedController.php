<?php

namespace Controllers\Admin;

//import classes that are not in this new namespace
use Controllers\BaseController;
use Input;
use View;
use Redirect;
use Authority;
use Repositories\Interfaces\DeceasedInterface;
use Repositories\Errors\Exceptions\NotAllowedException as NotAllowedException;

class DeceasedController extends BaseController {

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

    $this->beforeFilter('auth', array('except' => 'login'));
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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
		if( Authority::can('create', 'Deceased') ){
			$deceased = $this->deceased->instance();
			$this->layout->content = View::make('deceased.create', compact('deceased'));
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
		$deceased = $this->deceased->findById($id);
		if( Authority::can('update', $deceased) ){
			$this->layout->content = View::make('deceased.edit', compact('deceased'));
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

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){
		if( Authority::can('delete', 'Deceased') ){
			$this->deceased->destroy($id);
			return Redirect::route('deceased.index');//->with('success', 'The deceased has been deleted');
		}
    throw new NotAllowedException();
	}

}
