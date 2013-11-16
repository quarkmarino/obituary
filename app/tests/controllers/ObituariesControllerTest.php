<?php

use Repositories\Errors\Exceptions\ValidationException as ValidationException;
use Repositories\Errors\Exceptions\NotAllowedException as NotAllowedException;
use Repositories\Errors\Exceptions\NotFoundException   as NotFoundException;
use Models\Obituary as Obituary;

class ObituaryControllerTest extends TestCase {

  protected $mockClass = 'Repositories\Interfaces\ObituaryInterface';

  /**
   * Set up
   */
  public function setUp(){
    parent::setUp();
    $this->mock = $this->mock($this->mockClass);
  }

  /**
   * Test that Index fails due to not enough permission to list obituaries
   * @expectedException Repositories\Errors\Exceptions\NotAllowedException
   * @expectedException NotAllowedExceptionMessage Action not allowed
   * @expectedException NotAllowedExceptionCode 403
   */
  public function testIndexShouldFailDueToPermission(){
    Auth::attempt(['username' => 'guest', 'password' => 'no_password']);
    Authority::shouldReceive('can')->once()->with('index', 'Obituary')->andReturn(false);

    $this->get(route('obituaries.index'));

    $this->assertResponseStatus(403);
  }

  /**
   * Test Index Success
   */
  public function testIndexShouldCallFindAllMethodAndSuccess(){
    Auth::attempt(['username' => 'admin', 'password' => 'admin_password']);
    Authority::shouldReceive('can')->once()->with('index', 'Obituary')->andReturn(true);

    $this->mock->shouldReceive('findAll')->once()->andReturn(new Obituary);
    $this->registerNestedView('obituaries.index');
    $this->get(route('obituaries.index'));

    $this->assertResponseOk();
    $this->assertNestedViewHas('obituaries.index', 'obituaries');
  }

  /**
   * Test that Create fails due to not enough permission to get condolences form
   * @expectedException Repositories\Errors\Exceptions\NotAllowedException
   * @expectedException NotAllowedExceptionMessage Action not allowed
   * @expectedException NotAllowedExceptionCode 403
   */
  public function testCreateShouldFailDueToPermission(){
    Auth::attempt(['username' => 'guest', 'password' => 'no_password']);
    Authority::shouldReceive('can')->once()->with('create', 'Obituary')->andReturn(false);

    $this->get(route('obituaries.create'));

    $this->assertResponseStatus(403);
  }

  /**
   * Test Create
   */
  public function testCreateShouldCallInstanceMethodAndSuccess(){
    Auth::attempt(['username' => 'admin', 'password' => 'admin_password']);
    Authority::shouldReceive('can')->once()->with('create', 'Obituary')->andReturn(true);

    $this->mock->shouldReceive('instance')->once()->andReturn(new Obituary);
    $this->registerNestedView('obituaries.create');
    $this->get(route('obituaries.create'));

    $this->assertResponseOk();
    $this->assertNestedViewHas('obituaries.create', 'obituary');
  }

  /**
   * Test Store Fail
   * @expectedException Repositories\Errors\Exceptions\ValidationException
   * @expectedException ValidationExceptionMessage {"name":["The name field is required."], "location":["The location field is required."]}
   * @expectedException ValidationExceptionCode 400
   *
   */
  /*public function testStoreShouldCallStoreMethodAndFail(){
    // Set stage for a failed validation
    //Input::replace(['title' => '', 'author_name' => '']);
    $this->mock->shouldReceive('store')
      ->once()
      ->andThrow(new ValidationException('{"name":["The name field is required."], "location":["The location field is required."]}', 400));
    $response = $this->post(route('obituaries.store'), ['name' => '', 'location' => '']);

    /**
     * Next lines are for http view response
     */
    /*$this->assertResponseStatus(302);
    // Failed validation should reload the create form
    $this->assertRedirectedToRoute('obituaries.create');
    // The errors should be sent to the view
    $this->assertSessionHasErrors(['name', 'location']);
    $this->assertSessionHas(['error']);
    /**
     * Next lines are for json api response
     */
    /*try{
      $response = $this->post(route('obituaries.store'), ['title' => '', 'author_name' => '']);
    }
    catch(ValidationException $expected)  {
      return;
    }*/
  /*}*/

  /**
   * Test that Store fails due to not enough permission to get obituaries form
   * @expectedException Repositories\Errors\Exceptions\NotAllowedException
   * @expectedException NotAllowedExceptionMessage Action not allowed
   * @expectedException NotAllowedExceptionCode 403
   */
  public function testStoreShouldFailDueToPermission(){
    Auth::attempt(['username' => 'guest', 'password' => 'no_password']);
    Authority::shouldReceive('can')->once()->with('create', 'Obituary')->andReturn(false);

    $input = ['title' => 'Foo Title', 'article' => 'Bar Article'];

    $this->post(route('obituaries.store'), $input);

    $this->assertResponseStatus(403);
  }

  /**
   * Test Store success
   */
  public function testStoreShouldCallStoreMethodAndSuccess(){
    Auth::attempt(['username' => 'promoter', 'password' => 'promoter_password']);
    Authority::shouldReceive('can')->once()->with('create', 'Obituary')->andReturn(true);

    $input = ['title' => 'Foo Title', 'article' => 'Bar Article'];
    $this->mock->shouldReceive('store')->once()->andReturn(new Obituary(['id' => 1]));

    $this->post(route('obituaries.store'), $input);

    $this->assertResponseStatus(302);
    $this->assertRedirectedToRoute('obituaries.show', 1);
    //$this->assertSessionHas(['success']);
  }

  /**
   * Test Show Fail
   * @expectedException Repositories\Errors\Exceptions\NotFoundException
   * @expectedException NotFoundExceptionMessage Resource Not Found
   * @expectedException NotFoundExceptionCode 404
   */
  /*public function testShowShouldCallFindByIdMethodAndFail(){
    $this->mock->shouldReceive('findById')->once()
      ->with(2)
      ->andThrow(new NotFoundException());
    $response = $this->get(route('obituaries.show', [2]));

    $this->assertResponseStatus(404);
    //$this->fail('NotFoundException was not raised');
  }*/

  /**
   * Test Show
   */
  public function testShowShouldCallFindByIdMethodAndSuccess(){
    $obituary = json_decode(
        json_encode(
          [
            'id' => 1,
            'title' => 'foo',
            'article' => 'bar',
            'deceased' => [
              'full_name' => 'foo name',
              'date' => '2013-04-05'
            ],
            'condolences' => [
              [
                'name' => 'bar name',
                'message' => 'baz message'
              ]
            ]
          ]
        ),
        FALSE
      );
    $this->mock->shouldReceive('findById')->once()->with(1)->andReturn($obituary);
    $this->registerNestedView('obituaries.show');
    $this->get(route('obituaries.show', 1));

    $this->assertResponseOk();
    $this->assertNestedViewHas('obituaries.show', 'obituary');
  }

  /**
   * Test Edit Fail
   * @expectedException Repositories\Errors\Exceptions\NotAllowedException
   * @expectedException NotAllowedExceptionMessage Action not allowed
   * @expectedException NotAllowedExceptionCode 403
   */
  public function testEditShouldFailDueToPermission(){
    Auth::attempt(['username' => 'guest', 'password' => 'no_password']);
    Authority::shouldReceive('can')->once()->with('update', Mockery::type('Models\Obituary'))->andReturn(false);

    $this->mock->shouldReceive('findById')->once()->andReturn(new Obituary(['id' => 1]));
    $this->get(route('obituaries.edit', 1));

    $this->assertResponseStatus(403);
  }

  /**
   * Test Edit
   */
  public function testEditShouldCallFindByIdMethodAndSuccess(){
    Auth::attempt(['username' => 'promoter', 'password' => 'promoter_password']);
    Authority::shouldReceive('can')->once()->with('update', Mockery::type('Models\Obituary'))->andReturn(true);

    $this->mock->shouldReceive('findById')->once()->andReturn(new Obituary(['id' => 1]));
    $this->registerNestedView('obituaries.edit');
    $this->get(route('obituaries.edit', 1));

    $this->assertResponseOk();
    $this->assertNestedViewHas('obituaries.edit', 'obituary');
  }

  /**
   * Test Update Fail
   * @expectedException Repositories\Errors\Exceptions\NotAllowedException
   * @expectedException NotAllowedExceptionMessage Action not allowed
   * @expectedException NotAllowedExceptionCode 403
   */
  public function testUpdateShouldFailDueToPermission(){
    Auth::attempt(['username' => 'guest', 'password' => 'no_password']);
    Authority::shouldReceive('can')->once()->with('update', 'Obituary')->andReturn(false);

    $input = ['title' => 'Bar Title', 'article' => 'Foo Article'];

    $this->put(route('obituaries.update', 1), $input);

    $this->assertResponseStatus(403);
  }

  /**
   * Test Update
   */
  public function testUpdateShouldCallUpdateMethodAndSuccess(){
    Auth::attempt(['username' => 'promoter', 'password' => 'promoter_password']);
    Authority::shouldReceive('can')->once()->with('update', 'Obituary')->andReturn(true);

    $input = ['title' => 'Bar Title', 'author_name' => 'Foo Author'];
    $this->mock->shouldReceive('update')->once()->with(1, $input)->andReturn(new Obituary(['id' => 1]));

    $this->put(route('obituaries.update', 1), $input);

    $this->assertResponseStatus(302);
    $this->assertRedirectedToRoute('obituaries.show', 1);
  }

  /**
   * Test Delete Fail
   * @expectedException Repositories\Errors\Exceptions\NotAllowedException
   * @expectedException NotAllowedExceptionMessage Action not allowed
   * @expectedException NotAllowedExceptionCode 403
   */
  public function testDestroyShouldFailDueToPermission(){
    Auth::attempt(['username' => 'promoter', 'password' => 'promoter_password']);
    Authority::shouldReceive('can')->once()->with('delete', 'Obituary')->andReturn(false);
 
    $this->delete( route('obituaries.destroy', array(1)));
    
    $this->assertResponseStatus(403);
  }

  /**
   * Test Delete
   */
  public function testDestroyShouldCallDestroyMethod(){
    Auth::attempt(['username' => 'admin', 'password' => 'admin_password']);
    Authority::shouldReceive('can')->once()->with('delete', 'Obituary')->andReturn(true);

    $this->mock->shouldReceive('destroy')->once()->andReturn(true);
 
    $response = $this->delete( route('obituaries.destroy', array(1)));
    $this->assertTrue( empty($response->original) );
  }
}
