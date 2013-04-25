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

}
