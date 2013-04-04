<?php

class Home_Controller extends Base_Controller {

	/*
	|--------------------------------------------------------------------------
	| The Default Controller
	|--------------------------------------------------------------------------
	|
	| Instead of using RESTful routes and anonymous functions, you might wish
	| to use controllers to organize your application API. You'll love them.
	|
	| This controller responds to URIs beginning with "home", and it also
	| serves as the default controller for the application, meaning it
	| handles requests to the root of the application.
	|
	| You can respond to GET requests to "/home/profile" like so:
	|
	|		public function action_profile()
	|		{
	|			return "This is your profile!";
	|		}
	|
	| Any extra segments are passed to the method as parameters:
	|
	|		public function action_profile($id)
	|		{
	|			return "This is the profile for user {$id}.";
	|		}
	|
	*/
  public function __construct()
  {
    $this->filter('before', 'auth')->except(array('index'));
  }
  
  public function action_index()
	{
	  if (Auth::check()) return Redirect::to('home/dashboard');
    return View::make('home.index', array(
      'name' => Input::old('name'),
      'email' => Input::old('email'),
    ));
  }

  public function action_dashboard()
  {

    //return View::make('home.dashboard', array(
      //'articles' => Article::all(),
      //'books' => Book::where_user_id(Auth::User()->id)->get(),
    //));
    return View::make('home.dashboard', array(
      'books' => Book::where_user_id(Auth::User()->id)->get(),
    ));
  }

  //this method is used to reload data content through ajax process
  public function action_content()
  {
    if (Request::ajax())
    {
      $articles =  Article::with('crawlurl')->order_by('created_at', 'desc')
        ->take(50)->get(array('articles.key_id', 'articles.title', 
        'articles.image', 'articles.content', 'articles.article_url', 
        'articles.crawl_url_id'));
      $data = Array(); 
        
      foreach($articles as $article){
        array_push($data, array(
          'key_id' => $article->key_id,
          'title' => $article->title,
          'picture' => $article->image,
          'url' => $article->article_url,
          'source' => $article->crawlurl->url
        ));
      }
      return Response::json($data);
    }
  }

  private function action_auth()
  {
    if (!Auth::check())
    {
      return Redirect::to('login');
    }
  }


}
