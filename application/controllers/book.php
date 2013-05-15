<?php

class Book_Controller extends Base_Controller {
 
  public function __construct()
  {
    $this->filter('before', 'auth');
  }


	public function action_index()
	{
		return View::make('home.dashboard', array('layout' => 'book'));
	}

  public function action_bookmark()
  {
    $data = array();
    $user_id = Auth::User()->id;
    $bookmarks = Bookmark::where('user_id', '=', $user_id)->get();
    foreach($bookmarks as $bookmark){
      array_push($data, array(
        'key_id' => $bookmark->key_id,
        'title' => $bookmark->article->title
      ));
    }
    return Response::json($data);
 
  }

  public function action_create_book(){
    $datas = array();
    $name = Input::get('book_name');
    $user_id = Auth::User()->id;
    if(Book::where_name($name)->first()){
    }else{
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
  
  public function action_all_book(){
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
  
  public function action_show_book(){
    $datas = array();
    $book_id = Input::get('book_id');
    
    if ($book_id == "BookAll"){
      $bookmarks = Bookmark::all();
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
  
  private function action_auth()
  {
    if (!Auth::check())
    {
      return Redirect::to('login');
    }
  }
}
