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
          return Redirect::to('dashboard');
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

#Route::get('blocked', array('before' => 'filter', function()
#	{
#	  var_dump('fffff'); exit;
##		if(Request::ajax()) return "<script>location.href = '?login' </script>";
#	}
#));

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
  //if (Auth::guest()) return Redirect::to('/?login');
  if (Auth::guest())
  {
    if ( Request::ajax() ) {
      //return View::make('/?login');
      //return "<script language='javascript'>location.href = '/?login' </script>";  
      //return Response::make('javascript.auth', 200, array('content-type' => 'application/javascript'));
      //return Respond::to()->js( function(){
       //return View::make('sessions.auth', array('content-type' => 'text/javascript'));
      //});
      return HTML::entities('<script>alert(\'hi\');</script>');
    }
    else {
      return Redirect::to('/?login');
    }
  }
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
  Asset::add('mosaic','css/mosaic.css');
  
  #load js
  Asset::add('jquery', 
    'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
  Asset::add('angular', 
    'https://ajax.googleapis.com/ajax/libs/angularjs/1.0.6/angular.min.js');
  Asset::add('bootstrap', 
    'http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js');
  Asset::add('jquery.toastmessage','js/jquery.toastmessage.js');
  Asset::add('blocksit','js/blocksit.min.js');
  Asset::add('mosaic','js/mosaic.1.0.1.min.js');
  Asset::add('angular.application', 'js/application.js');
  Asset::add('angular.directive', 'js/directive.js');
  Asset::add('angular.service', 'js/service.js');
  Asset::add('angular.dashbord_controller', 'js/dashboard_controller.js');
  Asset::add('angular.book_controller', 'js/book_controller.js');
  Asset::add('underscore',
    'http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.4.4/underscore-min.js');
  Asset::add('enscroll', 'js/enscroll-0.4.0.min.js');
  Asset::add('facebook', 'https://connect.facebook.net/en_US/all.js');
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
    return Redirect::to('dashboard');
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


Route::get('content.json', 'home@content');


Route::get(array('home','/'), 'home@index');

Route::get('content', function()
{
  if ( Request::ajax() ) { 
    return View::make('home.content', array( 
      'books' => Book::where_user_id(Auth::User()->id)->take(5)->get()));
  }
  else {
    return Redirect::to('dashboard');
  }
});

Route::get('book', 'book@index');

Route::get('dashboard', 'home@dashboard');

Route::post('home/create_topic', 'home@create_topic');

Route::post('add_bookmark.json', 'book@add_bookmark');


// Route for Book_Controller
Route::controller('book');

Route::post('send_article', function(){
  //send email using SMTP
  $args = array(
    'article_keyid' => Input::get('article'),
    'email' => Input::get('email'),
    'use_to' => 'send_article'
  ); 
  
  Resque::enqueue('Laravel', 'MailsWorker', $args);

});

Route::post('create_book.json', 'book@create_book');

Route::get('all_books.json', 'book@all_books');

Route::get('show_book.json', 'book@show_bookmarked');

Route::post('move_to_book.json', 'book@move_to_book');

Route::get('twitter', function(){
  $twitter = new Twitter();
  $url = $twitter->request_authorization();
  Session::put('tweet', Input::get('t'));
  return Redirect::to($url);
});

Route::get('twitter_oauth', function(){
  $m = Session::get('tweet');
  $twitter = new Twitter();
  $twitter->set_oauth_token(Session::get('oauth_token'));
  $twitter->set_oauth_token_secret(Session::get('oauth_token_secret'));
  $twitter->set_oauth_verifier(Input::get('oauth_verifier'));
  $s = $twitter->request_access_token();
  if ($s == true) {
    $twitter->update_tweet(array('status' => $m));
    Session::forget('tweet');
    $url = 'https://twitter.com/' . $twitter->get_username();
    return Redirect::to($url);
  }
  else {
    return Redirect::to('twitter');
  }
});
