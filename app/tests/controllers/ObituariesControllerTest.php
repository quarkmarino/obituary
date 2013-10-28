<?php

use Repositories\Errors\Exceptions\ValidationException as ValidationException;
use Repositories\Errors\Exceptions\NotFoundException as NotFoundException;

class ObituariesControllerTest extends TestCase {

  protected $mockClass = 'Repositories\Interfaces\ObituaryInterface';

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
    $this->mock->shouldReceive('findAll')->once()->andReturn('foo');
    $response = $this->get(route('obituaries.index'));

    $this->assertResponseOk();
    $this->assertViewHas('obituaries');
  }

  /**
   * Test Create
   */
  public function testCreateShouldCallInstanceMethod(){
    $this->mock->shouldReceive('instance')->once()->andReturn([]);
    $response = $this->get(route('obituaries.create'));

    $this->assertResponseOk();
    $this->assertViewHas('obituary');
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
    $this->mock->shouldReceive('store')
      ->once()
      ->andThrow(new ValidationException('{"name":["The name field is required."], "location":["The location field is required."]}', 400));
    $response = $this->post(route('obituaries.store'), ['name' => '', 'location' => '']);

    /**
     * Next lines are for http view response
     */
    $this->assertResponseStatus(302);
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
  }

  /**
   * Test Store success
   */
  public function testStoreShouldCallStoreMethodAndSuccess(){
    $this->mock->shouldReceive('store')->once();
    $response = $this->post(route('obituaries.store'), ['name' => 'Foo Name', 'location' => 'Bar Location']);

    //$this->assertResponseOk();
    /**
     * Next lines are for http view response
     */
    $this->assertResponseStatus(302);
    $this->assertRedirectedToRoute('obituaries.index');
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
      ->with(2)
      ->andThrow(new NotFoundException());
    $response = $this->get(route('obituaries.show', [2]));

    $this->assertResponseStatus(404);
    //$this->fail('NotFoundException was not raised');
  }

  /**
   * Test Show
   */
  public function testShowShouldCallFindByIdMethodAndSuccess(){
    $this->mock->shouldReceive('findById')->once()->with(1)->andReturn('foo');
    $response = $this->get(route('obituaries.show', [1]));

    $this->assertResponseOk();
    $this->assertViewHas('obituary');
  }

    /**
   * Test Edit
   */
  public function testEditShouldCallFindByIdMethod(){
    $this->mock->shouldReceive('findById')->once()->andReturn([]);
    $response = $this->get(route('obituaries.edit', [1]));

    $this->assertResponseOk();
    $this->assertViewHas('obituary');
  }

  /**
   * Test Update
   */
  public function testUpdateShouldCallUpdateMethod(){
    $input = ['title' => 'Bar Title', 'author_name' => 'Foo Author'];
    $this->mock->shouldReceive('update')->once();
    $response = $this->put(route('obituaries.update', 1), $input);

    //$this->assertResponseOk();
    /**
     * Next lines are for http view response
     */
    $this->assertResponseStatus(302);
    $this->assertRedirectedToRoute('obituaries.show', 1);

  }

  /**
   * Test Delete
   */
  public function testDestroyShouldCallDestroyMethod(){
    $this->mock->shouldReceive('destroy')->once()->andReturn(true);
 
    $response = $this->delete( route('obituaries.destroy', array(1)));
    $this->assertTrue( empty($response->original) );
  }
}
