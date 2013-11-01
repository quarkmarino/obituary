<?php

use Repositories\Errors\Exceptions\ValidationException as ValidationException;
use Repositories\Errors\Exceptions\NotAllowedException as NotAllowedException;
use Repositories\Errors\Exceptions\NotFoundException as NotFoundException;
use Models\Condolence as Condolence;

class CondolencesControllerTest extends TestCase {

  protected $mockClass = 'Repositories\Interfaces\CondolenceInterface';

  /**
   * Set up
   */
  public function setUp(){
    parent::setUp();
    $this->mock = $this->mock($this->mockClass);
  }

  /**
   * Test that Index fails due to not enough permission to list condolences
   * @expectedException Repositories\Errors\Exceptions\NotAllowedException
   * @expectedException NotAllowedExceptionMessage Action not allowed
   * @expectedException NotAllowedExceptionCode 403
   */
  public function testIndexShouldFailDueToPermission(){
    Auth::attempt(['username' => 'guest', 'password' => 'no_password']);
    Authority::shouldReceive('can')->once()->with('manage', 'Condolences')->andReturn(false);

    $this->get(route('obituaries.condolences.index', 1));

    $this->assertResponseStatus(403);
  }

  /**
   * Test that Index succeed
   */
  public function testIndexShouldCallFindAllMethod(){
    Auth::attempt(['username' => 'admin', 'password' => 'admin_password']);
    Authority::shouldReceive('can')->once()->with('manage', 'Condolences')->andReturn(true);

    $this->mock->shouldReceive('findAll')->once()->with(1)->andReturn(new Condolence);
    $this->get(route('obituaries.condolences.index', 1));

    $this->assertResponseOk();
    $this->assertViewHas('condolences');
  }

  /**
   * Test that Create fails due to not enough permission to get condolences form
   * @expectedException Repositories\Errors\Exceptions\NotAllowedException
   * @expectedException NotAllowedExceptionMessage Action not allowed
   * @expectedException NotAllowedExceptionCode 403
   */
  public function testCreateShouldFailDueToPermission(){
    Auth::attempt(['username' => 'guest', 'password' => 'no_password']);
    Authority::shouldReceive('can')->once()->with('manage', 'Condolences')->andReturn(false);

    $this->get(route('obituaries.condolences.create', 1));

    $this->assertResponseStatus(403);
  }

  /**
   * Test that Create succeed
   */
  public function testCreateShouldCallInstanceMethod(){
    Auth::attempt(['username' => 'admin', 'password' => 'admin_password']);
    Authority::shouldReceive('can')->once()->with('manage', 'Condolences')->andReturn(true);

    $this->mock->shouldReceive('instance')->once()->andReturn(new Condolence);
    $this->get(route('obituaries.condolences.create', 1));

    $this->assertResponseOk();
  }

  /**
   * Test Store Fail
   * @expectedException Repositories\Errors\Exceptions\ValidationException
   * @expectedException ValidationExceptionMessage {"name":["The name field is required."], "location":["The location field is required."]}
   * @expectedException ValidationExceptionCode 400
   */
  // public function testStoreShouldCallStoreMethodAndFailDueToValidationAsGuest(){
  //   // Set stage for a failed validation
  //   //Input::replace(['title' => '', 'author_name' => '']);
  //   $input = ['name' => '', 'email' => '', 'message' => ''];
  //   $this->mock->shouldReceive('store')
  //     ->once()
  //     ->andThrow(new ValidationException('{"name":["The name field is required."], "email":["The email field is required."], "message":["The message field is required."]}', 400));
  //   $this->post(route('obituaries.condolences.store', 1), $input);
    /**
     * This shouldn't be tested this on the controller, this should be tested by the model test.
     * Next lines are for http view response
     */
    // $this->assertResponseStatus(302);
    // // Failed validation should reload the create form
    // $this->assertRedirectedToRoute('obituaries.condolences.create');
    // // The errors should be sent to the view
    // $this->assertSessionHasErrors(['name', 'location']);
    // $this->assertSessionHas(['error']);
    /**
     * Next lines are for json api response
     */
    /*try{
      $this->post(route('obituaries.condolences.store'), ['title' => '', 'author_name' => '']);
    }
    catch(ValidationException $expected)  {
      return;
    }*/
  //}

  /**
   * Test Store success
   */
  public function testStoreShouldCallStoreMethodAndSaveItForAuthorization(){
    Auth::attempt(['username' => 'guest', 'password' => 'no_password']);
    Authority::shouldReceive('can')->once()->with('moderate', Mockery::type('Models\Condolence'))->andReturn(false);

    $input = ['name' => 'Foo Name', 'email' => 'Bar Email', 'message' => 'Baz Message'];
    $this->mock->shouldReceive('store')->once()->andReturn(new Condolence);

    $this->post(route('obituaries.condolences.store', 1), $input);

    /**
     * Next lines are for http view response
     */
    $this->assertResponseOk();
    $this->assertResponseContentEqualsJson(json_encode(['message' => 'The condolence has been submited to review.']));
  }

  /**
   * Test Store success
   */
  public function testStoreShouldCallStoreMethodAndSaveAsIs(){
    Auth::attempt(['username' => 'client', 'password' => 'client_password']);
    Authority::shouldReceive('can')->once()->with('moderate', Mockery::type('Models\Condolence'))->andReturn(true);

    $input = ['name' => 'Foo Name', 'email' => 'Bar Email', 'message' => 'Baz Message'];
    $this->mock->shouldReceive('store')->once()->andReturn(new Condolence(['id' => 2]));
    //Redirect::shouldReceive('route')->once()->with('obituaries.condolence.show', [1,2])->andReturn('foo');

    $this->post(route('obituaries.condolences.store', 1), $input);

    $this->assertResponseStatus(302);
    $this->assertRedirectedToRoute('obituaries.condolences.show', [1, 2]);
  }

  /**
   * Test Show Fail
   * @expectedException Repositories\Errors\Exceptions\NotAllowedException
   * @expectedException NotAllowedExceptionMessage Action not allowed
   * @expectedException NotAllowedExceptionCode 403
   *
   */
  public function testShowShouldFailDueToPermission(){
    Auth::attempt(['username' => 'guest', 'password' => 'no_password']);
    Authority::shouldReceive('can')->once()->with('moderate', 'Condolences')->andReturn(false);

    //$this->mock->shouldReceive('findById')->once()->with(1, 2)->andThrow(new NotFoundException());
    $this->get(route('obituaries.condolences.show', [1, 2]));

    $this->assertResponseStatus(403);
    //$this->fail('NotFoundException was not raised');
  }

  /**
   * Test Show Fail
   */
  public function testShowByAjaxShouldCallFindByIdMethodAndSuccess(){
    Auth::attempt(['username' => 'client', 'password' => 'client_password']);
    Authority::shouldReceive('can')->once()->with('moderate', 'Condolences')->andReturn(true);

    $condolence = new Condolence(['id' => 2]);
    $this->mock->shouldReceive('findById')->once()->with(1, 2)->andReturn($condolence);
    
    $this->get(route('obituaries.condolences.show', [1, 2]), [], [], ["HTTP_X-Requested-With"=>"XMLHttpRequest"]);

    $this->assertResponseOk();
    $this->assertResponseContentEqualsJson($condolence->toJson());
  }

  /**
   * Test Show Success
   */
  public function testShowShouldCallFindByIdMethodAndSuccess(){
    Auth::attempt(['username' => 'client', 'password' => 'client_password']);
    Authority::shouldReceive('can')->once()->with('moderate', 'Condolences')->andReturn(true);

    $this->mock->shouldReceive('findById')->once()->with(1, 2)->andReturn(new Condolence(['id' => 2]));
    $this->get(route('obituaries.condolences.show', [1, 2]));

    $this->assertResponseOk();
    $this->assertViewHas('condolence');
  }

  /**
   * Test Edit Fail
   * @expectedException Repositories\Errors\Exceptions\NotAllowedException
   * @expectedException NotAllowedExceptionMessage Action not allowed
   * @expectedException NotAllowedExceptionCode 403
   *
   */
  public function testEditShouldFailDueToPermission(){
    Auth::attempt(['username' => 'guest', 'password' => 'no_password']);
    Authority::shouldReceive('can')->once()->with('manage', 'Condolences')->andReturn(false);

    $this->get(route('obituaries.condolences.edit', [1, 2]));
    
    $this->assertResponseStatus(403);
  }

  /**
   * Test Edit Success
   */
  public function testEditShouldCallFindByIdMethodAndSuccess(){
    Auth::attempt(['username' => 'admin', 'password' => 'admin_password']);
    Authority::shouldReceive('can')->once()->with('manage', 'Condolences')->andReturn(true);

    $this->mock->shouldReceive('findById')->once()->with(1, 2)->andReturn(new Condolence(['id' => 2]));
    $this->get(route('obituaries.condolences.edit', [1, 2]));
    
    $this->assertResponseOk();
    $this->assertViewHas('condolence');
  }

  /**
   * Test Update Fail
   * @expectedException Repositories\Errors\Exceptions\NotAllowedException
   * @expectedException NotAllowedExceptionMessage Action not allowed
   * @expectedException NotAllowedExceptionCode 403
   */
  public function testUpdateShouldFaildDueToPermission(){
    Auth::attempt(['username' => 'guest', 'password' => 'no_password']);
    Authority::shouldReceive('can')->once()->with('update', 'Condolences')->andReturn(false);

    $input = ['name' => 'Foo Name', 'email' => 'Bar Email', 'message' => 'Baz Message'];
    $this->put(route('obituaries.condolences.update', [1, 2]), $input);

    $this->assertResponseStatus(403);
  }

  /**
   * Test Update
   */
  public function testUpdateForModerationShouldCallUpdateMethodAndSuccess(){
    Auth::attempt(['username' => 'promoter', 'password' => 'promoter_password']);
    Authority::shouldReceive('can')->once()->with('update', 'Condolences')->andReturn(true);
    Authority::shouldReceive('cannot')->once()->with('manage', 'Condolences')->andReturn(true);

    $input = ['status' => 1];
    $this->mock->shouldReceive('update')->once()->with(1, 2, $input)->andReturn(new Condolence(['id' => 2, 'status' => 1]));
    $this->put(route('obituaries.condolences.update', [1, 2]), $input);

    $response = ['message' => 'The condolence has been updated.', 'condolence_status' => 1];
    $this->assertResponseOk();
    $this->assertResponseContentEqualsJson(json_encode($response));
  }

  /**
   * Test Update
   */
  public function testUpdateShouldCallUpdateMethodAndSuccess(){
    Auth::attempt(['username' => 'admin', 'password' => 'admin_password']);
    Authority::shouldReceive('can')->once()->with('update', 'Condolences')->andReturn(true);
    Authority::shouldReceive('cannot')->once()->with('manage', 'Condolences')->andReturn(false);

    $input = ['name' => 'Foo Name', 'email' => 'Bar Email', 'message' => 'Baz Message'];
    $this->mock->shouldReceive('update')->once()->with(1, 2, $input)->andReturn(new Condolence(['id' => 2]));
    $this->put(route('obituaries.condolences.update', [1, 2]), $input);

    $this->assertResponseStatus(302);
    $this->assertRedirectedToRoute('obituaries.condolences.show', [1, 2]);
  }

  /**
   * Test Delete Fail
   * @expectedException Repositories\Errors\Exceptions\NotAllowedException
   * @expectedException NotAllowedExceptionMessage Action not allowed
   * @expectedException NotAllowedExceptionCode 403
   */
  public function testDestroyShouldFailDueToPermission(){
    Auth::attempt(['username' => 'promoter', 'password' => 'promoter_password']);
    Authority::shouldReceive('can')->once()->with('manage', 'Condolences')->andReturn(false);

    $this->delete( route('obituaries.condolences.destroy', [1, 2]));
 
    $this->assertResponseStatus(403);
  }

  /**
   * Test Delete
   */
  public function testDestroyShouldCallDestroyMethod(){
    Auth::attempt(['username' => 'promoter', 'password' => 'promoter_password']);
    Authority::shouldReceive('can')->once()->with('manage', 'Condolences')->andReturn(true);

    $this->mock->shouldReceive('destroy')->once()->with(1, 2)->andReturn(true);
 
    $this->delete( route('obituaries.condolences.destroy', [1, 2]));

    $response = ['message' => 'The condolence has been deleted.'];
    $this->assertResponseOk();
    $this->assertResponseContentEqualsJson(json_encode($response));
  }
}
