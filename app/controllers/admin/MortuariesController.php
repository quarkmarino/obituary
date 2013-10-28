<?php

namespace Admin;
 
//import classes that are not in this new namespace
use BaseController;
use Input;
use View;
use Redirect;
use Repositories\Interfaces\MortuaryInterface;
use Repositories\Exceptions\ValidationException as ValidationException;

class MortuariesController extends BaseController {

	protected $mortuary;

	/**
   * We will use Laravel's dependency injection to auto-magically
   * "inject" our repository instance into our controller
   */
  public function __construct(MortuaryInterface $mortuary){
    $this->mortuary = $mortuary;
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$mortuaries = $this->mortuary->findAll();
    return View::make('admin.mortuaries.index', compact('mortuaries'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$mortuary = $this->mortuary->instance();
		return View::make('admin.mortuaries.create', compact('mortuary'));
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
			$this->mortuary->store($input);
			return Redirect::route('admin.mortuaries.index')
      	->with('success', 'The new mortuary has been created');
		}
		catch(ValidationException $e){
			return Redirect::route('admin.mortuaries.create')
		    ->withInput()
		    ->withErrors($e->getErrors())
		    ->with('error', 'The mortuary was not saved.');
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
			$mortuary = $this->mortuary->findById($id);
			return View::make('admin.mortuaries.edit', compact('mortuary'));
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
			$mortuary = $this->mortuary->findById($id);
			return View::make('admin.mortuaries.edit', compact('mortuary'));
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
			$this->mortuary->update($id, $input);
			return Redirect::route('admin.mortuaries.show', $id)
				->with('success', 'The new mortuary has been created');
		}
		catch(ValidationException $e){
			return Redirect::route('admin.mortuaries.create')
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
			$this->mortuary->destroy($id);
			return Redirect::route('admin.mortuaries.index')->with('success', 'The mortuary has been deleted');
		}
		catch(NotFoundException $e){
			App::abort(404, 'Page not found');
		}
	}

}
