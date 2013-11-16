<?php

namespace Controllers\Admin;
 
//import classes that are not in this new namespace
use Controllers\BaseController;
use Input;
use View;
use Redirect;
use Authority;
use Repositories\Interfaces\CemeteryInterface;
use Repositories\Exceptions\ValidationException as ValidationException;

class CemeteriesController extends BaseController {

	protected $cemetery;

	/**
   * We will use Laravel's dependency injection to auto-magically
   * "inject" our repository instance into our controller
   */
  public function __construct(CemeteryInterface $cemetery){
    $this->cemetery = $cemetery;
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cemeteries = $this->cemetery->findAll();
    return View::make('admin.cemeteries.index', compact('cemeteries'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$cemetery = $this->cemetery->instance();
		return View::make('admin.cemeteries.create', compact('cemetery'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		try{
			$this->cemetery->store($input);
			return Redirect::route('admin.cemeteries.index')
      	->with('success', 'The new cemetery has been created');
		}
		catch(ValidationException $e){
			return Redirect::route('admin.cemeteries.create')
		    ->withInput()
		    ->withErrors($e->getErrors())
		    ->with('error', 'The cemetery was not saved.');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		try{
			$cemetery = $this->cemetery->findById($id);
			return View::make('admin.cemeteries.edit', compact('cemetery'));
		}
		catch(NotFoundException $e){
			App::abort(404, 'Page not found');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		try{
			$cemetery = $this->cemetery->findById($id);
			return View::make('admin.cemeteries.edit', compact('cemetery'));
		}
		catch(NotFoundException $e){
			App::abort(404, 'Page not found');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		try{
			$this->cemetery->update($id, $input);
			return Redirect::route('admin.cemeteries.show', $id)
				->with('success', 'The new cemetery has been created');
		}
		catch(ValidationException $e){
			return Redirect::route('admin.cemeteries.create')
			->withInput()
			->withErrors($e->getErrors())
			->with('error', 'there were validation errors');
		}
		catch(NotFoundException $e){
			App::abort(404, 'Page not found');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try{
			$this->cemetery->destroy($id);
			return Redirect::route('admin.cemeteries.index')->with('success', 'The cemetery has been deleted');
		}
		catch(NotFoundException $e){
			App::abort(404, 'Page not found');
		}
	}

}
