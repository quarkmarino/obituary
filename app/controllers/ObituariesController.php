<?php

use Repositories\Interfaces\UserInterface;
use Repositories\Exceptions\ValidationException as ValidationException;

class ObituariesController extends BaseController {

	protected $obituary;

	/**
   * We will use Laravel's dependency injection to auto-magically
   * "inject" our repository instance into our controller
   */
  public function __construct(UserInterface $obituary){
    $this->obituary = $obituary;
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$obituaries = $this->obituary->findAll();
    return View::make('obituaries.index', compact('obituaries'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$obituary = $this->obituary->instance();
		return View::make('obituaries.create', compact('obituary'));
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
			$this->obituary->store($input);
			return Redirect::route('obituaries.index')
      	->with('success', 'The new obituary has been created');
		}
		catch(ValidationException $e){
			return Redirect::route('obituaries.create')
		    ->withInput()
		    ->withErrors($e->getErrors())
		    ->with('error', 'The obituary was not saved.');
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
			$obituary = $this->obituary->findById($id);
			return View::make('obituaries.edit', compact('obituary'));
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
			$obituary = $this->obituary->findById($id);
			return View::make('obituaries.edit', compact('obituary'));
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
			$this->obituary->update($id, $input);
			return Redirect::route('obituaries.show', $id)
				->with('success', 'The new obituary has been created');
		}
		catch(ValidationException $e){
			return Redirect::route('obituaries.create')
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
			$this->obituary->destroy($id);
			return Redirect::route('obituaries.index')->with('success', 'The obituary has been deleted');
		}
		catch(NotFoundException $e){
			App::abort(404, 'Page not found');
		}
	}

}
