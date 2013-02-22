<?php

class Users_Controller extends Base_Controller {
  
  public function action_index()
	{
		// code here..

		return View::make('users.index');
	}

  public function action_new()
  {
    $captcha = str_shuffle('1234567890');
    $get_captcha = system('curl http://api.img4me.com/?text='
      .$captcha.'&font=arial&fcolor=FFBF00&size=10&bcolor=FFFCFC&type=png');
    return View::make('users.new', array(
      'captcha' => $captcha,
      'get_captcha' => $get_captcha,
    ));
  }
  
  public function action_create()
  {
    $name = Input::get('name');
    $email = Input::get('email');
    $password = Input::get('password');
    $confirmation_password = Input::get('confirmation_password');
    $image_captcha = base64_encode(Input::get('recaptcha_field'));
    $text_captcha = Input::get('recaptcha');
    if($image_captcha == $text_captcha){
      //create object user if capcha has verified
      $user = new User();
      $user->name = $name;
      $user->email = $email;
      $user->password = $password;
      $user->set_confirmation_password($confirmation_password);
      $save = $user->save();
      
      if($save->success)
      {
        $user = User::where_email($email)->first();

        //send email using SMTP
        $args = array(
          'email' => $email,
          'key_id' => $user->key_id,
          'confirmation_token' => $user->confirmation_token
        ); 
        

        Mailer::send_activation_email($user->id);
        Resque::enqueue('Laravel', 'MailsWorker', $args);

        Message::success_or_not_message('success', 'registration');
        return Redirect::to('/');
      }
      else
      {
        Message::success_or_not_message('failed', 'registration');
        return Redirect::to('sign_up')->with_errors($save->errors);
      }
    }
    else
    {
      Message::invalid_message('captcha');
      return Redirect::to('sign_up');
    }
    
  }
  
 }
