<?php

class Article extends Eloquent {
  public static $timestamps = true;

	public function comments()
	{
		return $this->has_many('Comment');
	}

	public function category()
	{
		return $this->belongs_to('Category');
	}

	public function book()
	{
		return $this->has_one('Book');
	}

	public function user()
	{
		return $this->belongs_to('User');
	}

	public function userlikes()
	{
		return $this->has_many('Userlike');
	}

	public function projects()
	{
		return $this->has_many('Project');
	}

}
