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
    $name = Input::get('name');
    $email = Input::get('email');
    $password = Input::get('password');
    $confirmation_password = Input::get('confirmation_password');

    $user = new User();
    $user->name = $name;
    $user->email = $email;
    $user->password = $password;
    $user->set_confirmation_password($confirmation_password);
    $save = $user->save();
    if($save->success)
    {
      Session::flash('success', 'registration success');
      return Redirect::to('/');
    }
    else
    {
      Session::flash('failed', 'registration failed');
      return Redirect::to('users/new')->with_errors($save->errors);
    }
  }


 }
