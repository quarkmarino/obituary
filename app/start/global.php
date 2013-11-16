<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a rotating log file setup which creates a new file each day.
|
*/

$logFile = 'log-'.php_sapi_name().'.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenace mode is in effect for this application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';



// Define the Basset collection
/*Basset::collection('application', function($collection){
	// Switch to the css directory and require the "less" directory.
	// These directories both have a filter applied to them so that the built
	// collection will contain valid CSS.
	$stylesheets = $collection->directory('assets/css', function($collection){
		$collection->requireDirectory('vendor/bootstrap');
		//$collection->requireDirectory('vendor/fuelux');
		$collection->stylesheet('vendor/fuelux/fuelux.css');
		$collection->stylesheet('vendor/fuelux/fuelux-responsive.css');
		$collection->stylesheet('//fonts.googleapis.com/css?family=Open+Sans:400,600|PT+Serif:400,400italic');
		$collection->requireDirectory('vendor/font-awesome');
		$collection->stylesheet('styles-bluegreen.css');
		$collection->stylesheet('settings-panel.css');
		//$collection->requireDirectory();
	});

	$stylesheets->apply('CssMin');
	//$stylesheets->apply('UriRewriteFilter');

	// Switch to the js directory.
	$javascripts = $collection->directory('assets/js', function($collection){
		$collection->requireDirectory('vendor/jquery');
		//$collection->requireDirectory('vendor/fuelux');
		//$collection->javascript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
		$collection->javascript('settings-panel.js');
		$collection->javascript('vendor/fuelux/loader.js');
	});

	$javascripts->apply('JsMin');
});

// Define the Basset collection
Basset::collection('post_page', function($collection){
	$javascripts = $collection->directory('assets/js', function($collection){
		$collection->requireDirectory('vendor/bootstrap');
		$collection->requireDirectory('vendor/modernizr');
	});

	$javascripts->apply('JsMin');
});

Basset::collection('ie8', function($collection){
	$stylesheets = $collection->directory('assets/css', function($collection){
		$collection->stylesheet('ie8.css');
	});

	$stylesheets->apply('CssMin');
	//$stylesheets->apply('UriRewriteFilter');

	$javascripts = $collection->directory('assets/js', function($collection){
		$collection->requireDirectory('vendor/google');
	});

	$javascripts->apply('JsMin');
});*/