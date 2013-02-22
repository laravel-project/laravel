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
        ->update(array('confirmation_token' => substr(md5(rand()), 0, 25), 'confirmated_at' => null ) );
      Mailer::send_forgot_password($user->id);
      Message::success_or_not_message('success', 'send password');
      return Redirect::to('/');
    }else{
      Message::success_or_not_message('failed', 'send password');
      return Redirect::to('forgot_password');
    }
  }
}
