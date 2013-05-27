<?php

class Book extends Eloquent {
  public static $timestamps = true;

	public function user()
	{
		return $this->belongs_to('User');
	}

	public function bookmarks()
	{
		return $this->has_many('Bookmark');
	}
	
	public static function save_data($name, $user_id)
	{
	  $datas = array();
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
	
	public static function delete_data($book_key_id)
	{
	  $book = Book::where_key_id($book_key_id)->first();
    if($book){
      DB::table('books')->where('key_id', '=', $book_key_id)->delete();
      DB::table('bookmarks')->where('book_id', '=', $book->id)->update(array( 'book_id' => 0 ));
      return Response::json('success'); 
    }else{
      return Response::json('failed'); 
    }
	}
}
