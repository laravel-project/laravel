<?php

class Comment extends Eloquent {
  public static $timestamps = true;

	public function notifications()
	{
		return $this->has_many('Notification');
	}

	public function user()
	{
		return $this->belongs_to('User');
	}

	public function article()
	{
		return $this->belongs_to('Article');
	}

}
