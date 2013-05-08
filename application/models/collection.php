<?php

class Collection extends Eloquent {
  public static $timestamps = true;

	public function user()
	{
		return $this->belongs_to('User');
	}

	public function books()
	{
		return $this->has_many('Book');
	}

}
