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

  // check if session still active or not
  // if not then check cookies remember me
  // if remember me valid then user will login
  // automatically
  if (!Auth::check()) {
    $remember_encrypt = Cookie::get('_letsread_me');
    if ($remember_encrypt != null) {
      $remember_decrypt = Crypter::decrypt($remember_encrypt);
      $credentials = explode('||', $remember_decrypt);
      //check browser, if the browser is same when user use remember me feature 
      //for the first time then continue to next step
      if ($credentials[0] == $_SERVER['HTTP_USER_AGENT']) {
        //check credential email, key_id, and remember me
        $user = User::where_email_and_key_id_and_remember_token($credentials[1], 
          $credentials[2], $credentials[3])->first();
        if ($user) {
          $user->update_attribute('remember_token', rand(123456789, 999999999));
          Cookie::forget('_letsread_me');
          Cookie::put('_letsread_me', 
            Crypter::encrypt($_SERVER['HTTP_USER_AGENT'].'||'.$user->email.
            '||'.$user->key_id.'||'.$user->remember_token), 4320);
          Message::success_or_not_message('success', 'login');
          Auth::login($user->id);
          return Redirect::to('home/dashboard');
        }
        else {
          //check credential, if remember token wrong but email and key_id is 
          //right then the cookie login has been sniffed by hacker
          $user_with_wrong_remember_token = User::where_email_and_key_id($credentials[1],
            $credentials[2])->first();
          if ($user_with_wrong_remember_token) {
            Message::invalid_message('Your remember cookie has been used');
          }
        }
      }
    }
  }
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
	if (Auth::guest()) return Redirect::to('/?login');
});

// Route for Users_Controller
Route::controller('users');

Route::controller('session');

View::composer(array('layouts/main'), function($view)
{
  #load css
  Asset::add('bootstrap.min','css/bootstrap.min.css');
  Asset::add('bootsrap.responsive',
    'css/bootstrap-responsive.min.css');
  Asset::add('style','css/style.css');
  Asset::add('jquery.toastmessage','css/jquery.toastmessage.css');
  
  #load js
  Asset::add('jquery', 
    'http://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js');
  Asset::add('angular', 
    'https://ajax.googleapis.com/ajax/libs/angularjs/1.0.5/angular.min.js');
  Asset::add('bootstrap', 
    'http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.0/js/bootstrap.min.js');
  Asset::add('jquery.toastmessage','js/jquery.toastmessage.js');
  Asset::add('blocksit','js/blocksit.min.js');
  Asset::add('application', 'js/application.js');
});


Route::get('about',function()
{
  return View::make('home.about');
});

// Route for Sessions_Controller
Route::controller('sessions');

Route::get('login', function()
{
  return View::make('sessions.index');
});

Route::get('sign_up', 'users@new');

//here is the logout routes and 
//function to destroy session
Route::any('logout', function() {
	Auth::logout();
	Session::flush();
  Cookie::forget('_letsread_me');
  Cookie::forget('laravel_session');
	return Redirect::to('/');
});

Route::get('php_info', function(){
  return phpinfo();
});

Route::get('forgot_password', 'passwords@new');
Route::post('process_forgot_password', 'passwords@create');

Route::get('reset_password', 'passwords@reset_password');
Route::post('process_reset_password','passwords@process_reset_password');

Route::get('resend_confirmation', 'passwords@resend_confirmation');
Route::post('process_resend_confirmation', 'passwords@process_resend_confirmation');

Route::get('confirmation_password', function(){
  $confirmation_token = Input::get('confirmation_token');
  $key_id = Input::get('key_id');
  $user = User::where_key_id_and_confirmation_token($key_id, $confirmation_token)->first();
  if($confirmation_token != "" && $user ){
    Message::success_or_not_message('success', 'confirmation password');
    DB::table('users')->where('id', '=', $user->id)->update(array('confirmation_token' => null, 'confirmated_at' => Date::mysql_format() ));
    Auth::login($user->id);
    return Redirect::to('home/dashboard');
  }
  else{
    Message::success_or_not_message('failed', 'confirmation password');
    return Redirect::to('/');
  }
});

$providers = array(
	'facebook/(:any?)',
);

Route::get($providers, array('as' => '', function() {
	Laravel\IoC::resolve('opauth');
}));

Route::post('login_with_facebook', 'sessions@login_with_facebook');

Route::get('get_captcha', function()
{
  return Captcha::generate_view(); 
});


Route::get('home/content.json', 'home@content');

Route::get('home', 'home@index');

Route::get('home/dashboard', 'home@dashboard');
