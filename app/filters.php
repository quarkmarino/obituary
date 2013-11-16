<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

// App::error(function(Exception $e, $code){
//   return $code == 500 ?
//     Response::make(View::make('errors.500'), 500) :
//     Response::make(View::make('errors.default'), $code);
// });

/**
 * Validation Exception Handler for json API
 */
App::error(function(Repositories\Errors\Exceptions\ValidationException $e, $code){
  return Request::ajax() ?
    Response::json($e->getErrors()->toArray(), $code) :
    Response::make(View::make('errors.400'), $code);
});

/**
 * Not Found Exception Handler for web site
 */

App::error(function(Repositories\Errors\Exceptions\NotFoundException $e, $code){
  return Request::ajax() ?
    Response::json($e->getMessage(), $code) :
    (
      Request::is('admin/*') ?
        Response::make(View::make('admin.errors.404'), $code) :
        Response::make(View::make('errors.404'), $code)
    );
});

/**
 * Not Allowed Exception Handler for json API
 */
App::error(function(Repositories\Errors\Exceptions\NotAllowedException $e, $code){
  return Request::ajax() ?
    Response::json($e->getMessage(), $code) :
    Response::make(View::make('errors.403'), $code);
});