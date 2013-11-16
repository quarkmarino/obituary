<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index');
});

Route::group(['prefix'=>'admin'], function(){
	Route::resource('plans', 'Controllers\Admin\PlansController');

	Route::resource('cemeteries', 'Controllers\Admin\CemeteriesController');

	Route::resource('deceased', 'Controllers\Admin\DeceasedController');

	Route::resource('users', 'Controllers\Admin\UsersController');

	Route::resource('mortuaries', 'Controllers\Admin\MortuariesController');
});

Route::get('login', function(){
	$roles = [
		'admin' => [
			'username' => 'admin',
			'password' => 'admin_password'
		],
		'promoter' => [
			'username' => 'promoter',
			'password' => 'promoter_password'
		],
		'owner' => [
			'username' => 'owner',
			'password' => 'owner_password'
		],
		'guest' => [
			'username' => 'guest',
			'password' => 'no_password'
		],
	];
	Auth::attempt($roles['admin']);
	echo 'Login';
});

Route::resource('obituaries', 'Controllers\ObituariesController');

Route::resource('obituaries.deceased', 'Controllers\ObituariesDeceasedController', ['except' => ['create', 'edit', 'destroy']]);

Route::resource('obituaries.events', 'Controllers\ObituariesEventsController', ['except' => ['create', 'edit']]);

Route::resource('obituaries.condolences', 'Controllers\ObituariesCondolencesController');

Route::resource('obituaries.memories', 'Controllers\ObituariesMemoriesController', ['except' => ['create', 'edit']]);
