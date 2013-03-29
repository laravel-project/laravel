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

  public function save_data()
  {
    $validation = $this->validates(Array('title' => $this->title, 
      'content' => $this->content));
    if ( !$validation->fails() )
    {
      //generate key_id
      $this->key_id = rand(268435456, 4294967295);
      $this->save();
    }
  }

  public function validates($input)
  {
    $rules = array('title' => 'required', 'content' => 'required');
    return Validator::make($input, $rules);
  }

}
