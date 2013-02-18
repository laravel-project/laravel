<?php

class User extends Eloquent {
  public static $timestamps = true; 
  private $confirmation_password;
  private $recaptcha;



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

  public function save()
  {
    //before save
    $validation = $this->validates(Array('name' => $this->name, 
      'email' => $this->email, 'password' => $this->password, 
      'confirmation_password' => $this->confirmation_password));
    if ($validation->fails())
    {
      $cond = Array('success' => false, 'errors' => $validation->errors);
      return (Object)$cond;     
    }
    else 
    { 
      //generate key_id
      $this->key_id = rand(268435456, 4294967295);
      //generate token
      $this->confirmation_token = substr(md5(rand()), 0, 25);
      //encrypt password using md5
      $this->password = Hash::make($this->password);
      //get client ip address
      $this->last_sign_in_ip = $_SERVER['REMOTE_ADDR'];

      parent::save();
      $cond = Array('success' => true);
      return (Object)$cond;
    }
    
    //after save
  }

  public function validates($input)
  {
    $rules =  array(
      'name' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required|same:confirmation_password|min:6',
    );
    return Validator::make($input, $rules);
  }

  public function set_confirmation_password($pass)
  {
    $this->confirmation_password = $pass;
  }

  public function get_confirmation_password()
  {
    return $this->confirmation_password;
  }

}
