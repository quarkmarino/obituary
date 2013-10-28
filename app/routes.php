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
	return View::make('hello');
});

Route::group(['prefix'=>'admin'], function(){
	Route::resource('plans', 'admin\PlansController');

	Route::resource('cemeteries', 'admin\CemeteriesController');

	Route::resource('deceaseds', 'admin\DeceasedsController');

	Route::resource('users', 'admin\UsersController');

	Route::resource('mortuaries', 'admin\MortuariesController');
});

Route::resource('obituaries', 'ObituariesController');

Route::resource('obituaries.events', 'ObituariesEventsController');

Route::resource('obituaries.condolences', 'ObituariesCondolencesController');

Route::resource('obituaries.images', 'ObituariesImagesController');
