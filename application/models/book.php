<?php

class Book extends Eloquent {
  public static $timestamps = true;

	public function user()
	{
		return $this->belongs_to('User');
	}

	public function article()
	{
		return $this->belongs_to('Article');
	}
  public function collection()
	{
		return $this->belongs_to('Collection');
	}
}
