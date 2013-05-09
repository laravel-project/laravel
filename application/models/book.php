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
	
}
