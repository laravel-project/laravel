<?php

class Sessions_Controller extends Base_Controller {

  public function action_create()
  {
    $credentials = array('username' => Input::get('email'),
      'password' => Input::get('password'));
    $check_user = User::where_email(Input::get('email'))->first();
    
    if(!$check_user){
      Message::invalid_message('email or password');
      return Redirect::to('login'); 
    }
    if($check_user->confirmation_token != null){
      Message::confirmation_message();
      return Redirect::to('login'); 
    }
    if (Auth::attempt($credentials)) 
    {
      Message::success_or_not_message('success', 'login');
      return Redirect::to('home/dashboard');;
    }
    else 
    {
      Message::invalid_message('email or password');
      return Redirect::to('login');
    } 
  }

}
