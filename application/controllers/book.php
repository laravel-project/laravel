<?php

class Book_Controller extends Base_Controller {
 
  public function __construct()
  {
    parent::__construct();
    $this->filter('before', 'auth');
  }


	public function action_index()
	{
    if ( Request::ajax() ) {
      return View::make('book.index');
    }
    else {
      //return Redirect::to('book');
      return View::make('home.dashboard', array('layout' => 'book'));
    }
		
	}

  //this method is called when article has already bookmarked was move to book
  public function action_move_to_book()
  {
    $bookmark_ids = explode(',', Input::get('bookmark_ids'));
    $book_id = Input::get('book_id');
    foreach($bookmark_ids as $bookmark_id)
    {
      DB::table('bookmarks')->where('key_id', '=', $bookmark_id)->update(array( 'book_id' => $book_id ));
    }
    
    return Response::json('success');
  }
  
  //retrieve all books tha user created
  public function action_all_books()
  {
    $user_id = Auth::User()->id;
    $datas = array();
    $books = Book::where_user_id($user_id)->get();
    foreach($books as $book){
      array_push($datas, array(
        'id' => $book->id,
        'key_id' => $book->key_id,
        'name' => $book->name,
      ));
    }
    return Response::json($datas);
  }
  
  //this method will show all bokmarked article based on book id
  public function action_show_bookmarked() {
    $datas = array();
    $book_id = Input::get('book_id');
    $user_id = Auth::User()->id;
    
    if ($book_id == "BookAll"){
      $bookmarks = Bookmark::where('user_id', '=', $user_id)->get();
    }else{
      $book = Book::where_key_id($book_id)->first();
      $bookmarks = $book->bookmarks;
    }
    foreach($bookmarks as $bookmark){
      if ($bookmark->book_id == 0){
        $book_name = "unbookmarked";
      }else{
        $book_name = $bookmark->book->name;
      }
      array_push($datas, array(
        'key_id' => $bookmark->key_id,
        'title' => $bookmark->article->title,
        'book_name' => $book_name
      )); 
    }
    return Response::json($datas);
  }
  
  //this method is used to create book in manage book menu
  public function action_create_book()
  {
    $datas = array();
    $name = Input::get('book_name');
    $user_id = Auth::User()->id;
    if(Book::where_name($name)->first()){
    }
    else{
      $book = new Book();
      $book->name = $name;
      $book->user_id = $user_id;
      $book->key_id = rand(268435456, 4294967295);
      $book->save();
      array_push($datas, array(
        'key_id' => $book->key_id,
        'name' => $name
      ));
    }
    return Response::json($datas);
  }
  
  //this method is used when user try to bookmarked an article
  public function action_add_bookmark()
  {
    $status = array();
    $article_id = Input::get('article_id');
    $article = Article::where_key_id($article_id)->first();
    $user_id = Auth::User()->id;
    if($article_id != ""){
      $bookmark = Bookmark::where_article_id_and_user_id($article->id, $user_id)->first();
      if($bookmark){
        array_push($status, array(
          'status' => 'failed',
          'message' => 'this article has already bookmark',
        ));
      }else{
        $new_bookmark = new Bookmark();
        $new_bookmark->article_id = $article->id;
        $new_bookmark->user_id = $user_id;
        $new_bookmark->key_id = rand(268435456, 4294967295);
        $new_bookmark->save();
        array_push($status, array(
          'status' => 'success',
          'message' => 'this article success to bookmark',
        ));
      }
    }else{
      array_push($status, array(
        'status' => 'failed',
        'message' => 'failed to bookmark this article',
      ));
    }
    return Response::json($status);
  }
}
