<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication(){
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}
	
	/**
	 * setUp is called prior to each test
	 */
	public function setUp(){
	  parent::setUp();
	  $this->prepareForTests();
	}

	/**
   * Migrate the database
   */
  private function prepareForTests(){
    Artisan::call('migrate', ['--seed' => 'true']);
    Artisan::call('migrate', ['--package' => 'machuga/authority-l4']);
    Mail::pretend(true);
  }

  /**
   * Mock
   */
  public function mock($class){
    $mock = Mockery::mock($class);
    App::instance($class, $mock);

    return $mock;
  }
	 
	/**
	 * tearDown is called after each test
	 * @return [type] [description]
	 */
	public function tearDown(){
	  Mockery::close();
	}

	/**
	 * Allowing for such methods as $this->get(), $this->post()
	 */

	public function __call($method, $args){
		if (in_array($method, ['get', 'post', 'put', 'patch', 'delete'])){
			array_unshift($args, $method);
			return call_user_func_array([$this, 'call'], $args);
		}
		throw new BadMethodCallException;
	}

	/**
   * Assert that the client response is equals to expected.
   *
   * @return void
   */
	public function assertResponseContentEquals($expected){
		$response = $this->client->getResponse();

		$content = $response->getContent();

		$this->assertEquals($expected, $content);
	}

	/**
   * Assert that the client response is in json format.
   *
   * @return void
   */
	public function assertResponseContentIsJson(){
		$response = $this->client->getResponse();

		$content = json_decode($response->getContent());

		//var_dump($content);
		$this->assertNotNull($content, 'Response content is not in json format.');
	}

	/**
   * Assert that the client response equals to expected json.
   *
   * @return void
   */
	public function assertResponseContentEqualsJson($json){
		$this->assertResponseContentIsJson();
		$this->assertJsonStringEqualsJsonString($json, $this->client->getResponse()->getContent());
	}

	/**
	 * Laravel Controller Layout testing
	 * URL http://stackoverflow.com/questions/16607310/laravel-controller-layout-testing
	 * Solution by neyl
	 */

	protected $nestedViewData = [];

  public function registerNestedView($view){
    View::composer($view, function($view){
      $this->nestedViewsData[$view->getName()] = $view->getData();
    }); 
  }

  /**
   * Assert that the given view has a given piece of bound data.
   *
   * @param  string|array  $key
   * @param  mixed  $value
   * @return void
   */
  public function assertNestedViewHas($view, $key, $value = null){
    if (is_array($key)) return $this->assertNestedViewHasAll($view, $key);

    if ( ! isset($this->nestedViewsData[$view]))
      return $this->assertTrue(false, 'The view was not called.');

    $data = $this->nestedViewsData[$view];

    if (is_null($value))
      $this->assertArrayHasKey($key, $data);
    else{
      if(isset($data[$key]))
        $this->assertEquals($value, $data[$key]);
      else 
        return $this->assertTrue(false, 'The View has no bound data with this key.');            
    }
  }

  /**
   * Assert that the view has a given list of bound data.
   *
   * @param  array  $bindings
   * @return void
   */
  public function assertNestedViewHasAll($view, array $bindings){
    foreach ($bindings as $key => $value)
      if (is_int($key))
        $this->assertNestedViewHas($view, $value);
      else
        $this->assertNestedViewHas($view, $key, $value);
  }

  public function assertNestedView($view){
    $this->assertArrayHasKey($view, $this->nestedViewsData);
  }

}
