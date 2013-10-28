<?php

namespace Admin;
 
//import classes that are not in this new namespace
use BaseController;
use Input;
use View;
use Redirect;
use Repositories\Interfaces\UserInterface;
use Repositories\Exceptions\ValidationException as ValidationException;

class UsersController extends BaseController {

	protected $user;

	/**
   * We will use Laravel's dependency injection to auto-magically
   * "inject" our repository instance into our controller
   */
  public function __construct(UserInterface $user){
    $this->user = $user;
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = $this->user->findAll();
    return View::make('admin.users.index', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$user = $this->user->instance();
		return View::make('admin.users.create', compact('user'));
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
			$this->user->store($input);
			return Redirect::route('admin.users.index')
      	->with('success', 'The new user has been created');
		}
		catch(ValidationException $e){
			return Redirect::route('admin.users.create')
		    ->withInput()
		    ->withErrors($e->getErrors())
		    ->with('error', 'The user was not saved.');
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
			$user = $this->user->findById($id);
			return View::make('admin.users.edit', compact('user'));
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
			$user = $this->user->findById($id);
			return View::make('admin.users.edit', compact('user'));
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
			$this->user->update($id, $input);
			return Redirect::route('admin.users.show', $id)
				->with('success', 'The new user has been created');
		}
		catch(ValidationException $e){
			return Redirect::route('admin.users.create')
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
			$this->user->destroy($id);
			return Redirect::route('admin.users.index')->with('success', 'The user has been deleted');
		}
		catch(NotFoundException $e){
			App::abort(404, 'Page not found');
		}
	}

}
