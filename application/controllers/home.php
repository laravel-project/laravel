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
    parent::__construct();
    $this->filter('before', 'auth')->except(array('index'));
  }
  
  public function action_index()
	{
	  if (Auth::check()) return Redirect::to('dashboard');
    return View::make('home.index', array(
      'name' => Input::old('name'),
      'email' => Input::old('email'),
    ));
  }

  public function action_dashboard()
  {
    return View::make('home.dashboard');
  }


  //this method is used to reload data content through ajax process
  public function action_content()
  {
    
    $data = array('counter', 'content'); 
    $data['content'] = array();

    $topic = $this->get_topic();

    //p variable for load more article
    if(Input::get('p') != "") {
      $articles = Article::get_articles($topic, Input::get('p'));
      $counter = 0;
    }
    else if(Input::get('q') != "" ){ 
      //this is for search
      $string = Input::get('q');
      $articles = Article::get_articles($topic, null, true);
      $counter = Article::$count_article;
    }
    else if(Input::get('w') != "") { 
      //w is varible to load all item with limit set is not use default limit
      //it is used when user have already load a lot of article the user switch 
      //to menu manage(book/article) when user back to article then user does 
      //not to load again the article from the start
      $articles = Article::get_articles($topic, null, true, Input::get('w'));
      $counter = Article::$count_article;
    }
    else if(Input::get('b') != "") {
      //b is used to load content article by book(filter by book)
      $book = Book::find( Input::get('b') );
      $bookmarks = $book->bookmarks;
      $article_ids = BaseUtil::collect($bookmarks, 'article_id');
      $articles = Article::get_articles(null, null, true, null, $article_ids);
      $counter = Article::$count_article;
    }
    else {
      //this is normal for loading content article
      $articles = Article::get_articles($topic, null, true);
      $counter = Article::$count_article;
    }
    
    $data['counter'] = $counter;
    foreach($articles as $article){
      $bookmarked = Bookmark::is_bookmarked($article->id, Auth::User()->id);
      array_push($data['content'], array(
        'key_id' => $article->key_id,
        'title' => $article->title,
        'picture' => $article->image,
        'url' => $article->article_url,
        'source' => $article->crawlurl->url,
        'content' => $article->content,
        'bookmarked' => $bookmarked 
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
      
      //$articles = Article::with('crawlurl')->where('content','REGEXP',$string)->get();
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

      return Redirect::to('dashboard');
    }else{
      Message::another_message('failed','please input any topic, to complete your article');
      return Redirect::to('dashboard');
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
