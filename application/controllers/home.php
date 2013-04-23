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
      'books' => Book::where_user_id(Auth::User()->id)->take(5)->get(),
    ));
  }


  //this method is used to reload data content through ajax process
  public function action_content()
  {
    
    $data = array('counter', 'content'); 
    $data['content'] = array();

    $topic = $this->get_topic();

    if(Input::get('p') != "") {
      $articles = Article::get_articles($topic, Input::get('p'));
      $counter = 0;
    }
    else if(Input::get('q') != "" ){
      $string = Input::get('q');
      $articles = Article::get_articles($topic, null, true);
      $counter = Article::$count_article;
    }
    else {
      $articles = Article::get_articles($topic, null, true);
      $counter = Article::$count_article;
    }
    
    $data['counter'] = $counter;
    foreach($articles as $article){
      array_push($data['content'], array(
        'key_id' => $article->key_id,
        'title' => $article->title,
        'picture' => $article->image,
        'url' => $article->article_url,
        'source' => $article->crawlurl->url,
        'content' => $article->content
      ));
    }
    return Response::json($data);
  }

  public function action_create_topic()
  {
    $string = "";
    $sparator = "";
    $articles = array();
    $my_topics = Auth::User()->topics;
    if(!empty($my_topics)){
      foreach($my_topics as $topic){
        if($string != ""){
          $sparator = "|";
        }
        $string = $string.$sparator.$topic->names;
      }
      
      $articles = Article::with('crawlurl')->where('content','REGEXP',$string)->get();
    }
    
    $topics = Input::get('topics'); 
    if (!empty($topics)){
      foreach($topics as $name)
      {
        $topic = new Topic();
        $topic->names = $name;
        $topic->user_id = Auth::User()->id;
        $topic->key_id = rand(268435456, 4294967295);
        
        if ($topic->save()){
        }
      }
      if(!empty($articles) && count($articles) >= 23){
        DB::table('users')->where('id', '=', Auth::User()->id)->update(array('sign_in_count' => 1) );
      }else{
        Message::another_message('failed','total article minimal 23, please add new topic your article result '.count($articles).' articles');
      }
      return Redirect::to('home/dashboard');
    }else{
      Message::another_message('failed','please input any topic, to complete your article');
      return Redirect::to('home/dashboard');
    }
  }
  
  private function action_auth()
  {
    if (!Auth::check())
    {
      return Redirect::to('login');
    }
  }

  private function get_topic()
  {
    $string = "";
    $sparator = "";
    
    $topics = Auth::User()->topics;
    foreach($topics as $topic){
      if($string != ""){
        $sparator = "|";
      }
      $string = $string.$sparator.$topic->names;
    }
    
    return $string;
  }
}
