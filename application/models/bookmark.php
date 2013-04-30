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

  public static function is_bookmarked($article_id, $user_id)
  {
    $bookmarked = Bookmark::where_article_id_and_user_id($article_id, $user_id)->get();
    if($bookmarked){ return true; } else { return false; }
  }
}
