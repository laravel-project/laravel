<?php

class Sessions_Controller extends Base_Controller {

  public function action_create()
  {
    $credentials = array('username' => Input::get('email'),
      'password' => Input::get('password'));
    if (Auth::attempt($credentials)) 
    {
      return Redirect::to('home/dashboard');;
    }
    else 
    {
      return Redirect::to('login');
    } 
  }

}
