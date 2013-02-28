<?php

class Users_Controller extends Base_Controller {
  
  public function action_index()
	{
		// code here..

		return View::make('users.index');
	}

  public function action_new()
  {
    $c = Captcha::generate();
    return View::make('users.new', array(
      'captcha' => $c['captcha'],
      'get_captcha' => $c['get_captcha'],
      'name' => Input::old('name'),
      'email' => Input::old('email'),
    ));
  }
  
  public function action_create()
  {
    $name = Input::get('name');
    $email = Input::get('email');
    $password = Input::get('password');
    $confirmation_password = Input::get('confirmation_password');
    $image_captcha = Input::get('recaptcha_field');
    $text_captcha = Input::get('recaptcha');
    
    if( Captcha::valid($image_captcha, $text_captcha) ){
      //create object user if capcha has verified
      $user = new User();
      $user->name = $name;
      $user->email = $email;
      $user->password = $password;
      $user->set_confirmation_password($confirmation_password);
      $save = $user->vaild_save();
      
      if($save->success)
      {
        $user = User::where_email($email)->first();

        //send email using SMTP
        $args = array(
          'user_id'  => $user->id,
          'url_base' => URL::to('confirmation_password'),
          'use_to'   => 'confirmation_password'
        ); 
        
        Resque::enqueue('Laravel', 'MailsWorker', $args);

        Message::success_or_not_message('success', 'registration');
        return Redirect::to('/');
      }
      else
      {
        Message::success_or_not_message('failed', 'registration');
        return Redirect::to('sign_up')->with_input()->with_errors($save->errors);
      }
    }
    else
    {
      Message::invalid_message('captcha');
      return Redirect::to('sign_up')->with_input();
    }
    
  }
  
 }
