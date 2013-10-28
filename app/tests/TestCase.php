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
			return $this->call($method, $args[0]);
		}

		throw new BadMethodCallException;
	}
}
