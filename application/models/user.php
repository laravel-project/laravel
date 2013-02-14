<?php

class User extends Eloquent {
  public static $timestamps = true;

	public function books()
	{
		return $this->has_many('Book');
	}

	public function articles()
	{
		return $this->has_many('Article');
	}

	public function comments()
	{
		return $this->has_many('Comment');
	}

	public function projects()
	{
		return $this->has_many('Project');
	}

	public function userlikes()
	{
		return $this->has_many('Userlike');
	}

  public function notifications()
	{
		return $this->has_many('Notification');
	}


}
