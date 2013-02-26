<?php

class Passwords_Controller extends Base_Controller {

	public function action_new()
	{
		return View::make('passwords.new');
	}

  public function action_create()
  {
    $email = Input::get('email');
    $user = User::where_email($email)->first();
    if($user){
      DB::table('users')->where('id', '=', $user_id)
        ->update(array('can_reset_password' => true, 'expired_at' => Date::sum_of_date('1 day') ));
      $args = array(
        'user_id'  => $user->id,
        'url_base' => URL::to('reset_password'),
        'use_to'   => 'send_forgot_password'
      ); 
      
      Resque::enqueue('Laravel', 'MailsWorker', $args);
      
      Message::success_or_not_message('success', 'send password');
      return Redirect::to('/');
    }else{
      Message::success_or_not_message('failed', 'send password');
      return Redirect::to('forgot_password');
    }
  }
  
  public function action_reset_password(){
    $key_id = Input::get('key_id');
    $user = User::where_key_id($key_id)->first();
    if($user && $user->can_reset_password == true && $user->expired_at > Date::mysql_format()){
      return View::make('passwords.reset_password');
    }else{
      Message::success_or_not_message('failed', 'reset password');
      return Redirect::to('/');
    }
  }
  
  public function action_process_reset_password(){
    $key_id = base64_decode(Input::get('key_id'));
    $password = Input::get('password');
    $confirmation_password = Input::get('confirmation_password');
    if (strlen($password) > 5 && $password == $confirmation_password){
      $user = User::where_key_id($key_id)->first();
      DB::table('users')->where('id', '=', $user_id)
        ->update(array('can_reset_password' => false));
      Message::success_or_not_message('success', 'reset password');
      return Redirect::to('/');
    }else{
      Message::password_error();
      return Redirect::to('reset_password?key_id='.$key_id);
    }
  }
}
