<?php

use Repositories\Errors\Exceptions\ValidationException as ValidationException;
use Repositories\Errors\Exceptions\NotFoundException as NotFoundException;

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
   * Test that controller calls repo as we expect
   */

  /**
   * Test Index
   */
  public function testIndexShouldCallFindAllMethod(){
    $this->mock->shouldReceive('findAll')->once()->with(1)->andReturn('foo');
    $response = $this->get(route('obituaries.condolences.index', 1));

    $this->assertResponseOk();
    $this->assertViewHas('condolences');
  }

  /**
   * Test Create
   */
  public function testCreateShouldCallInstanceMethod(){
    $this->mock->shouldReceive('instance')->once()->andReturn([]);
    $response = $this->get(route('obituaries.condolences.create', 1));

    $this->assertResponseOk();
    $this->assertViewHas('condolence');
  }

  /**
   * Test Store Fail
   * @expectedException Repositories\Errors\Exceptions\ValidationException
   * @expectedException ValidationExceptionMessage {"name":["The name field is required."], "location":["The location field is required."]}
   * @expectedException ValidationExceptionCode 400
   *
   */
  public function testStoreShouldCallStoreMethodAndFail(){
    // Set stage for a failed validation
    //Input::replace(['title' => '', 'author_name' => '']);
    $input = ['name' => '', 'email' => '', 'message' => ''];
    $this->mock->shouldReceive('store')
      ->once()
      ->andThrow(new ValidationException('{"name":["The name field is required."], "location":["The location field is required."]}', 400));
    $response = $this->post(route('obituaries.condolences.store', 1), $input);

    /**
     * Next lines are for http view response
     */
    $this->assertResponseStatus(302);
    // Failed validation should reload the create form
    $this->assertRedirectedToRoute('obituaries.condolences.create');
    // The errors should be sent to the view
    $this->assertSessionHasErrors(['name', 'location']);
    $this->assertSessionHas(['error']);
    /**
     * Next lines are for json api response
     */
    /*try{
      $response = $this->post(route('obituaries.condolences.store'), ['title' => '', 'author_name' => '']);
    }
    catch(ValidationException $expected)  {
      return;
    }*/
  }

  /**
   * Test Store success
   */
  public function testStoreShouldCallStoreMethodAndSuccess(){
    $input = ['name' => 'Foo Name', 'email' => 'Bar Email', 'message' => 'Baz Message'];
    $this->mock->shouldReceive('store')->once();
    $response = $this->post(route('obituaries.condolences.store', 1), $input);

    //$this->assertResponseOk();
    /**
     * Next lines are for http view response
     */
    $this->assertResponseStatus(302);
    $this->assertRedirectedToRoute('obituaries.condolences.index');
    $this->assertSessionHas(['success']);
  }

  /**
   * Test Show Fail
   * @expectedException Repositories\Errors\Exceptions\NotFoundException
   * @expectedException NotFoundExceptionMessage {"name":["The name field is required."], "location":["The location field is required."]}
   * @expectedException NotFoundExceptionCode 404
   *
   */
  public function testShowShouldCallFindByIdMethodAndFail(){
    $this->mock->shouldReceive('findById')->once()
      ->with(1, 2)
      ->andThrow(new NotFoundException());
    $response = $this->get(route('obituaries.condolences.show', [1, 2]));

    $this->assertResponseStatus(404);
    //$this->fail('NotFoundException was not raised');
  }

  /**
   * Test Show
   */
  public function testShowShouldCallFindByIdMethodAndSuccess(){
    $this->mock->shouldReceive('findById')->once()->with(1, 2)->andReturn('foo');
    $response = $this->get(route('obituaries.condolences.show', [1, 2]));

    $this->assertResponseOk();
    $this->assertViewHas('condolence');
  }

    /**
   * Test Edit
   */
  public function testEditShouldCallFindByIdMethod(){
    $this->mock->shouldReceive('findById')->once()->with(1, 2)->andReturn([]);
    $response = $this->get(route('obituaries.condolences.edit', [1, 2]));
    
    $this->assertResponseOk();
    $this->assertViewHas('condolence');
  }

  /**
   * Test Update
   */
  public function testUpdateShouldCallUpdateMethod(){
    $input = ['name' => 'Foo Name', 'email' => 'Bar Email', 'message' => 'Baz Message'];
    $this->mock->shouldReceive('update')->once();
    $response = $this->put(route('obituaries.condolences.update', [1, 2]), $input);

    //$this->assertResponseOk();
    /**
     * Next lines are for http view response
     */
    $this->assertResponseStatus(302);
    $this->assertRedirectedToRoute('obituaries.condolences.show', [1, 2]);

  }

  /**
   * Test Delete
   */
  public function testDestroyShouldCallDestroyMethod(){
    $this->mock->shouldReceive('destroy')->once()->with(1, 2)->andReturn(true);
 
    $response = $this->delete( route('obituaries.condolences.destroy', [1, 2]));
    $this->assertTrue( empty($response->original) );
  }
}
