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
    return View::make('home.dashboard', array(
      'books' => Book::where_user_id(Auth::User()->id)->get(),
    ));
  }

  //this method is used to reload data content through ajax process
  public function action_content()
  {
    $string = "";
    $sparator = "";
    $data = array(); 
    
    $topics = Auth::User()->topics;
    foreach($topics as $topic){
      if($string != ""){
        $sparator = "|";
      }
      $string = $string.$sparator.$topic->names;
    }
    
    $articles = Article::with('crawlurl')->where('content','REGEXP',$string)->order_by('created_at', 'desc')
        ->take(23)->get(array('articles.key_id', 'articles.title', 
        'articles.image', 'articles.content', 'articles.article_url', 
        'articles.crawl_url_id'));
    if(count($articles) <= 23 ){
      $sum_articles = 21 - count($articles);
      $articles = $articles + Article::take($sum_articles)->get();
    }    
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

  public function action_create_topic()
  {
    foreach(Input::get('topics') as $name)
    {
      $topic = new Topic();
      $topic->names = $name;
      $topic->user_id = Auth::User()->id;
      $topic->key_id = rand(268435456, 4294967295);
      
      if ($topic->save()){
      }
    }
    DB::table('users')->where('id', '=', Auth::User()->id)->update(array('sign_in_count' => 1) );
    return Redirect::to('home/dashboard');
  }
  
  private function action_auth()
  {
    if (!Auth::check())
    {
      return Redirect::to('login');
    }
  }


}
