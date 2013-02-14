<?php

class Userlike extends Eloquent {
  public static $timestamps = true;

	public function article()
	{
		return $this->belongs_to('Article');
	}

	public function user()
	{
		return $this->belongs_to('User');
	}

}
