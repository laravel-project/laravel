<?php

class Category extends Eloquent {
  public static $timestamps = true;

	public function articles()
	{
		return $this->has_many('Article');
	}

}
