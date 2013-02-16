<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/


/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});

// Route for Users_Controller
Route::controller('users');

Route::controller('session');

View::composer(array('layouts/main', 'layouts/main_fluid'), function($view)
{
  #load css
  Asset::add('bootstrap.min','css/bootstrap.min.css');
  Asset::add('bootsrap.responsive',
    'css/bootstrap-responsive.min.css');
  Asset::add('style','css/style.css');
  
  #load js
  Asset::add('jquery', 
    'http://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js');
  Asset::add('underscore', 
    'http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.4.4/underscore-min.js');
  Asset::add('backbone', 
    'http://cdnjs.cloudflare.com/ajax/libs/backbone.js/0.9.10/backbone-min.js');
   Asset::add('bootstrap', 
    'http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.0/js/bootstrap.min.js');

});

Route::controller('home');

Route::get('home/about',function()
{
  return View::make('home.about');
});

// Route for Sessions_Controller
Route::controller('sessions');

Route::get('login', function()
{
  return View::make('sessions.index');
});
