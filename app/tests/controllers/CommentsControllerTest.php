<?php
 
class CommentsControllerTest extends TestCase {

  protected $mockClass = 'Repositories\Interfaces\CommentInterface';

  /**
   * Set up
   */
  public function setUp(){
    parent::setUp();
    $this->mock = $this->mock($this->mockClass);
  }

  /**
   ************************************************************************
   * Basic Route Tests
   * notice that we can use our route() helper here!
   ************************************************************************
   */
 
  //test that GET /v1/posts/1/comments returns HTTP 200
  /*public function testIndex(){
    $response = $this->get(route('v1.posts.comments.index', [1]) );
    $this->assertTrue($response->isOk());
  }
 
  //test that GET /v1/posts/1/comments/1 returns HTTP 200
  public function testShow(){
    $response = $this->get(route('v1.posts.comments.show', [1,1]) );
    $this->assertTrue($response->isOk());
  }
 
  //test that GET /v1/posts/1/comments/create returns HTTP 200
  public function testCreate(){
    $response = $this->get(route('v1.posts.comments.create', [1]) );
    $this->assertTrue($response->isOk());
  }
 
  //test that GET /v1/posts/1/comments/1/edit returns HTTP 200
  public function testEdit(){
    $response = $this->get(route('v1.posts.comments.edit', [1,1]) );
    $this->assertTrue($response->isOk());
  }*/
 
  /**
   *************************************************************************
   * Tests to ensure that the controller calls the repo as we expect
   * notice we are "Mocking" our repository
   *
   * also notice that we do not really care about the data or interactions
   * we merely care that the controller is doing what we are going to want
   * it to do, which is reach out to our repository for more information
   *************************************************************************
   */
 
  //ensure that the index function calls our repository's "findAll" method
  public function testIndexShouldCallFindAllMethod(){
    //create our new Mockery object with a name of Repositories\\Interfaces\\CommentInterface
    $this->mock->shouldReceive('findAll')->once()->andReturn('foo');
    $response = $this->get(route('v1.posts.comments.index', [1]));
 
    $this->assertResponseOk();
    $this->assertViewHas('comments');
  }
 
  //ensure that the show method calls our repository's "findById" method
  public function testShowShouldCallFindById(){
    $this->mock->shouldReceive('findById')->once()->andReturn('foo');
    $response = $this->get(route('v1.posts.comments.show', [1,1]));

    $this->assertResponseOk();
    $this->assertViewHas('comment');
  }
 
  //ensure that our create method calls the "instance" method on the repository
  public function testCreateShouldCallInstanceMethod(){
    $this->mock->shouldReceive('instance')->once()->andReturn([]);
    $response = $this->get(route('v1.posts.comments.create', [1]));

    $this->assertResponseOk();
    $this->assertViewHas('comment');
  }
 
  //ensure that the edit method calls our repository's "findById" method
  public function testEditShouldCallFindByIdMethod(){
    $this->mock->shouldReceive('findById')->once()->andReturn([]);
    $response = $this->get(route('v1.posts.comments.edit', [1,1]));

    $this->assertViewHas('comment');
  }
 
  //ensure that the store method should call the repository's "store" method
  public function testStoreShouldCallStoreMethod(){
    $this->mock->shouldReceive('store')->once()->andReturn('foo');
    $response = $this->post(route('v1.posts.comments.store', [1]));

    $this->assertResponseOk();
    /*$this->assertTrue(!! $response->original);
    $this->assertResponseStatus(302);*/
  }
 
  //ensure that the update method should call the repository's "update" method
  public function testUpdateShouldCallUpdateMethod(){
    $this->mock->shouldReceive('update')->once()->andReturn('foo');
    $response = $this->put(route('v1.posts.comments.update', [1,1]));

    $this->assertResponseOk();
    /*$this->assertTrue(!! $response->original);
    $this->assertResponseStatus(302);*/
  }
 
  //ensure that the destroy method should call the repositories "destroy" method
  public function testDestroyShouldCallDestroyMethod(){
    $this->mock->shouldReceive('destroy')->once()->andReturn(true);
    $response = $this->delete(route('v1.posts.comments.destroy', [1,1]));

    $this->assertTrue( empty($response->original) );
  }
}