<?php

namespace Controllers\Admin;
 
//import classes that are not in this new namespace
use Controllers\BaseController;
use Input;
use View;
use Redirect;
use Authority;
use Repositories\Interfaces\PlanInterface;
use Repositories\Exceptions\ValidationException as ValidationException;

class PlansController extends BaseController {

	protected $plan;

	/**
   * We will use Laravel's dependency injection to auto-magically
   * "inject" our repository instance into our controller
   */
  public function __construct(PlanInterface $plan){
    $this->plan = $plan;
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$plans = $this->plan->findAll();
    return View::make('admin.plans.index', compact('plans'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$plan = $this->plan->instance();
		return View::make('admin.plans.create', compact('plan'));
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
			$this->plan->store($input);
			return Redirect::route('admin.plans.index')
      	->with('success', 'The new plan has been created');
		}
		catch(ValidationException $e){
			return Redirect::route('admin.plans.create')
		    ->withInput()
		    ->withErrors($e->getErrors())
		    ->with('error', 'The plan was not saved.');
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
			$plan = $this->plan->findById($id);
			return View::make('admin.plans.edit', compact('plan'));
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
			$plan = $this->plan->findById($id);
			return View::make('admin.plans.edit', compact('plan'));
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
			$this->plan->update($id, $input);
			return Redirect::route('admin.plans.show', $id)
				->with('success', 'The new plan has been created');
		}
		catch(ValidationException $e){
			return Redirect::route('admin.plans.create')
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
			$this->plan->destroy($id);
			return Redirect::route('admin.plans.index')->with('success', 'The plan has been deleted');
		}
		catch(NotFoundException $e){
			App::abort(404, 'Page not found');
		}
	}

}
