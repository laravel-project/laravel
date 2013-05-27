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
    $book_id = Input::get('book_id');    
    $bookmark_ids = explode(',', Input::get('bookmark_ids'));
    $user_id = Auth::User()->id;
    Bookmark::update_bookmarks($bookmark_ids, $book_id);
    $book_key_id = Input::get('latest_page');
    return Bookmark::show_bookmarks_of_book($book_key_id, $user_id);
  }
  
  //this method use to delete bookmarks
  public function action_delete_bookmark(){
    $bookmark_ids = explode(',', Input::get('bookmark_ids'));
    $user_id = Auth::User()->id;
    $book_key_id = Input::get('latest_page');
    if($book_key_id == "BookAll"){
      Bookmark::delete_bookmarks($bookmark_ids);
    }else{
      Bookmark::update_bookmarks($bookmark_ids, 0);
    }
    return Bookmark::show_bookmarks_of_book($book_key_id, $user_id);
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
    $book_id = Input::get('book_id');
    $user_id = Auth::User()->id;
    return Bookmark::show_bookmarks_of_book($book_id, $user_id);
  }
  
  //this method is used to create book in manage book menu
  public function action_create_book()
  {
    $name = Input::get('book_name');
    $user_id = Auth::User()->id;
    return Book::save_data($name, $user_id);
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
        Bookmark::save_data($article->id, $user_id);
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
  
  public function action_delete_book(){
    $book_key_id = Input::get('book_id');
    return Book::delete_data($book_key_id);
  }
}
