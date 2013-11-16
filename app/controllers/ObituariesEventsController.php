<?php

namespace Controllers;

use Input;
use View;
use Redirect;
use Authority;
use Repositories\Interfaces\EventsInterface;
use Repositories\Errors\Exceptions\NotAllowedException as NotAllowedException;

class ObituariesEventsController extends BaseController {

	protected $event;

	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'layouts.master';

	/**
   * We will use Laravel's dependency injection to auto-magically
   * "inject" our repository instance into our controller
   */
  public function __construct(EventsInterface $event){
    $this->event = $event;

    //$this->beforeFilter('auth', array('except' => 'login'));
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		if( Authority::can('index', 'Event') ){
			$events = $this->event->findAll();
			$this->layout->content = View::make('events.index')->with(compact('events'));
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
			$event = $this->event->store($input);
			return Redirect::route('events.show', $event->id);//->with('success', 'The new event has been created');
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
			$event = $this->event->findById($id);
			$this->layout->content = View::make('events.show', compact('event'));
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
			$event = $this->event->update($id, $input);
			return Redirect::route('events.show', $event->id);//->with('success', 'The new deceased has been created');
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
			$this->event->destroy($id);
			return Redirect::route('events.index');//->with('success', 'The event has been deleted');
		}
    throw new NotAllowedException();
	}

}
