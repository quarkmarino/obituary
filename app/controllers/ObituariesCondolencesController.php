<?php

namespace Controllers;

use Input;
use View;
use Redirect;
use Authority;
use Repositories\Interfaces\CondolenceInterface;
use Repositories\Errors\Exceptions\NotAllowedException as NotAllowedException;

class ObituariesCondolencesController extends BaseController {

	protected $condolences;

	/**
   * We will use Laravel's dependency injection to auto-magically
   * "inject" our repository instance into our controller
   */
  public function __construct(CondolenceInterface $condolence){
    $this->condolence = $condolence;
  }

	/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index($obituary_id){
    if( Authority::can('admin', 'Condolences') ){
      $condolences = $this->condolence->findAll($obituary_id);
      $this->layout->content = View::make('condolences.index', compact('condolences'));
      return $this->layout->render();
    }
    throw new NotAllowedException();
  }

	/**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create($obituary_id){
    if( Authority::can('admin', 'Condolences') ){
      $condolence = $this->condolence->instance(['obituary_id' => $obituary_id]);
      $this->layout->content = View::make('condolences._form', compact('condolence'));
      return $this->layout->render();
    }
    throw new NotAllowedException();
  }

	/**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store($obituary_id){
    $input = Input::all();
    $condolence = $this->condolence->store($obituary_id, $input);
    return Authority::can('moderate', $condolence) ?
      Redirect::route('obituaries.condolences.show', [$obituary_id, $condolence->id]) :
      Response::json(['message' => 'The condolence has been submited to review.']);
  }

	/**
   * Display the specified resource.
   *
   * @param int $id
   * @return Response
   */
  public function show($obituary_id, $id){
    $condolence = $this->condolence->findById($obituary_id, $id);
    if( Authority::can('moderate', $condolence) ){
      return Request::ajax() ?
        Response::json($condolence) :
        View::make('condolences.show', compact('condolence'));
    }
    throw new NotAllowedException;
  }

	/**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return Response
   */
  public function edit($obituary_id, $id){
    $condolence = $this->condolence->findById($obituary_id, $id);
    if( Authority::can('admin', $condolence) ){
      $this->layout->content = View::make('condolences._form', compact('condolence'));
      return $this->layout->render();
    }
    throw new NotAllowedException;
  }

	/**
   * Update the specified resource in storage.
   * 
   * @param int $id
   * @return Response
   */
  public function update($obituary_id, $id){
    $input = Input::all();
    if( Authority::can('update', 'Condolences') ){
      $condolence = $this->condolence->update($obituary_id, $id, $input);
      if( Authority::cannot('manage', 'Condolences') ){//this is intendet to allow the users that just can update condolence status
        $response = ['message' => 'The condolence status has been updated.', 'condolence_status' => $condolence->status];
        return Response::json($response);
      }
      return Redirect::route('obituaries.condolences.show', [$obituary_id, $id]);
    }
    throw new NotAllowedException;
  }

	/**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return Response
   */
  public function destroy($obituary_id, $id){
    if( Authority::can('delete', 'Condolences') ){
      $this->condolence->destroy($obituary_id, $id);
      return Response::json(['message' => 'The condolence has been deleted.']);
    }
    throw new NotAllowedException;
  }

}
