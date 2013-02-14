<?php

class Notification extends Eloquent {
  public static $timestamps = true;

	public function user()
	{
		return $this->belongs_to('User');
	}

	public function comment()
	{
		return $this->belongs_to('Comment');
	}

}
