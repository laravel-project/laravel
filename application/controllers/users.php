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
    //Session::put('recaptcha', $captcha);
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
    $text_captcha = Input::get('recaptcha'); //Session::get('recaptcha');
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
        //send email using SMTP
        $mail = new SMTP();
        $mail->to($email);
        $mail->from('developer.laravel@gmail.com', 'Developer');
        $mail->subject('Hello World');
        $mail->body('This is a <b>HTML</b> email.');
        $mail->send();
        
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
    
    //Session::flush();
  }
  
 }
