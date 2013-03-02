<?php

class Sessions_Controller extends Base_Controller {

  public function action_create()
  {
    $credentials = array('username' => Input::get('email'),
      'password' => Input::get('password'));
    $check_user = User::where_email(Input::get('email'))->first();
    
    if(!$check_user){
      Message::invalid_message('email or password');
      return Redirect::to('/?login'); 
    }
    if($check_user->confirmation_token != null){
      Message::confirmation_message();
      return Redirect::to('/?login'); 
    }

    if (Auth::attempt($credentials)) 
    {
      //check if remember active, then generate cookies, the cookies
      //is combination of random character(A-Z) + separator + key_id + separator +
      //random alphanumeric

      if (Input::get('remember') != null) {
                Cookie::put('_letsread_me', 
          Crypter::encrypt($check_user->email.'||'.$check_user->key_id), 4320);
      }

      Message::success_or_not_message('success', 'login');
      return Redirect::to('home/dashboard');;
    }
    else 
    {
      Message::invalid_message('email or password');
      return Redirect::to('/?login');
    } 
  }
  
  public function action_login_with_facebook()
  {
    $response = unserialize(base64_decode( $_POST['opauth'] ));
    $email = $response['auth']['info']['email'];
    $name = $response['auth']['info']['name'];
    $user = User::where_email($email)->first();
    if($user){
      Message::success_or_not_message('success', 'login');
      Auth::login($user->id);
      return Redirect::to('home/dashboard');
    }else{
      $user = new User();
      $user->facebook_save($email, $name);
      $new_user = User::where_email($email)->first();
      Message::success_or_not_message('success', 'login');
      Auth::login($new_user->id);
      return Redirect::to('home/dashboard');
    }
  }

}
