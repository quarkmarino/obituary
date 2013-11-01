<?php

use Repositories\Interfaces\CondolenceInterface;
use Repositories\Errors\Exceptions\ValidationException as ValidationException;
use Repositories\Errors\Exceptions\NotAllowedException as NotAllowedException;
use Repositories\Errors\Exceptions\NotFoundException as NotFoundException;

class ObituariesCondolencesController extends BaseController {

	protected $condolences;

	/**
   * We will use Laravel's dependency injection to auto-magically
   * "inject" our repository instance into our controller
   */
  public function __construct(CondolenceInterface $condolences){
    $this->condolences = $condolences;
  }

	/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index($obituary_id){
    if( Authority::can('manage', 'Condolences') ){
      $condolences = $this->condolences->findAll($obituary_id);
      return View::make('condolences.index', compact('condolences'));
    }
    throw new NotAllowedException();
  }

	/**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create($obituary_id){
    if( Authority::can('manage', 'Condolences') ){
      $condolence = $this->condolences->instance(['obituary_id' => $obituary_id]);
      return View::make('condolences._form', compact('condolence'));
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
    $condolence = $this->condolences->store($obituary_id, $input);
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
    if( Authority::can('moderate', 'Condolences') ){
      $condolence = $this->condolences->findById($obituary_id, $id);
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
    if( Authority::can('manage', 'Condolences') ){
      $condolence = $this->condolences->findById($obituary_id, $id);
      return View::make('condolences._form', compact('condolence'));
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
      $condolence = $this->condolences->update($obituary_id, $id, $input);
      if( Authority::cannot('manage', 'Condolences') ){
        $response = ['message' => 'The condolence has been updated.', 'condolence_status' => $condolence->status];
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
    if( Authority::can('manage', 'Condolences') ){
      $this->condolences->destroy($obituary_id, $id);
      return Response::json(['message' => 'The condolence has been deleted.']);
    }
    throw new NotAllowedException;
  }

}
