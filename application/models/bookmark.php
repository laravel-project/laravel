<?php

class Bookmark extends Eloquent {
  public static $timestamps = true;

	public function user()
	{
		return $this->belongs_to('User');
	}

	public function article()
	{
		return $this->belongs_to('Article');
	}

  public function book()
	{
		return $this->belongs_to('Book');
	}
  public static function is_bookmarked($article_id, $user_id)
  {
    $bookmarked = Bookmark::where_article_id_and_user_id($article_id, $user_id)->get();
    if($bookmarked){ return true; } else { return false; }
  }
  
  public static function update_bookmarks($bookmark_ids, $book_id)
  {
    foreach($bookmark_ids as $bookmark_id)
    {
      DB::table('bookmarks')->where('key_id', '=', $bookmark_id)->update(array( 'book_id' => $book_id ));
    }
  }
  
  public static function delete_bookmarks($bookmark_ids)
  {
    foreach($bookmark_ids as $bookmark_id)
      {
        DB::table('bookmarks')->where('key_id', '=', $bookmark_id)->delete();
      }
  }
  
  public static function save_data($article_id, $user_id)
  {
    $bookmark = new Bookmark();
    $bookmark->article_id = $article_id;
    $bookmark->user_id = $user_id;
    $bookmark->key_id = rand(268435456, 4294967295);
    $bookmark->save();
  }
  
  public static function show_bookmarks_of_book($book_id, $user_id)
  {
    $datas = array();
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
        'book_name' => $book_name,
        'book_key_id' => $book_id
      )); 
    }
    return Response::json($datas);
  }
}
