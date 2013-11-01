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

}
