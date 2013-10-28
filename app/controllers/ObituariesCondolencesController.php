<?php

use Repositories\Interfaces\CondolenceInterface;
use Repositories\Exceptions\ValidationException as ValidationException;

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
  /*public function index($obituary_id){
    $condolences = $this->condolences->findAll($obituary_id);
    return View::make('condolences.index', compact('condolences'));
  }*/
 

	/**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  /*public function create($obituary_id){
    $condolence = $this->condolences->instance(array(
      'obituary_id' => $obituary_id
    ));
 
    return View::make('condolences._form', compact('condolence'));
  }*/

	/**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store($obituary_id){
    $input = Input::all();
    try{
        $condolence = $this->condolences->store( $obituary_id, $input );
        if( Authority::can('manage', $condolence) ){
          return Redirect::route('obituaries.show', [$obituary_id, $condolence->id]);
        }
        return Response::json(array('message' => 'The condolence has been submited to review.'));
      }
    }
    catch(NotAllowedException $e){
      return Response::json($e->getMessage(), 403);
    }
    catch(ValidationException $e){
      return Response::json($e->getErrors()->toArray(), 400);
    }
  }

	/**
   * Display the specified resource.
   *
   * @param int $id
   * @return Response
   */
  public function show($obituary_id, $id){
    $condolence = $this->condolences->findById($obituary_id, $id);
    return Response::json($condolence);
  }

	/**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return Response
   */
  /*public function edit($obituary_id, $id){
    $condolence = $this->condolences->findById($obituary_id, $id);

    return View::make('condolences._form', compact('condolence'));
  }*/

	/**
   * Update the specified resource in storage.
   *
   * @param int $id
   * @return Response
   */
  public function update($obituary_id, $id){
    if( Authority::can('manage', 'Condolences') ){
      return Redirect::route('obituaries.show', $condolence->id);
    }
    elseif( Authority::can('create', 'Condolences') ){
      return Response::json(array('status' => 'success', 'message' => 'The condolence has been submited to review.'));
    }
  }

	/**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return Response
   */
  public function destroy($obituary_id, $id){
    $this->condolences->destroy($obituary_id, $id);
    return '';
  }

}
