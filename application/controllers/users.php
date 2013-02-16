<?php

class Users_Controller extends Base_Controller {

	public function action_index()
	{
		// code here..

		return View::make('users.index');
	}

  public function action_new()
  {
    return View::make('users.new');
  }
  
  public function action_create()
  {
    //$input = Input::get('name');
    //var_dump($input);
    $name = Input::get('name');
    $email = Input::get('email');
    $password = Input::get('password');
    $confirmation_password = Input::get('confirmation_password');

    $validation = Validator::make(Input::get(), array(
      'name' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required|same:confirmation_password|min:6',
    ));

    if( $validation->fails() ) {
      Session::flash('failed', 'registration failed');
      return Redirect::to('users/new')->with_errors($validation);
    }
    $user = User::where_email($email)->first();
    if($user){
      Session::flash('failed', 'registration failed, email has been already exist');
      return Redirect::to('users/new');
    }else{
      $user = new User();
      $encrypted = Crypter::encrypt($password);
      $user->name = $name;
      $user->email = $email;
      $user->password = $encrypted;
      //generate key_id
      $user->key_id = rand(268435456, 4294967295);
      //generate token
      $user->confirmation_token = substr(md5(rand()), 0, 25);
      $save = $user->save();
      if($save){
        Session::flash('success', 'registration success');
        return Redirect::to('/');
      }else{
        Session::flash('failed', 'registration failed');
        return Redirect::to('users/new');
      }
    }
  }
}
