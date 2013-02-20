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
    Session::put('recaptcha', $captcha);
    $get_captcha = system('curl http://api.img4me.com/?text='.$captcha.'&font=arial&fcolor=FFBF00&size=10&bcolor=FFFCFC&type=png');
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
    $image_captcha = Input::get('recaptcha_field');
    $text_captcha = Session::get('recaptcha');
    $user = new User();
    $user->name = $name;
    $user->email = $email;
    $user->password = $password;
    $user->set_confirmation_password($confirmation_password);
    $user->set_image_captcha($image_captcha);
    $user->set_text_captcha($text_captcha);
    $save = $user->save();
    if($image_captcha == $text_captcha){
      if($save->success)
      {
        Session::flash('success', 'registration success');
        return Redirect::to('/');
      }
      else
      {
        Session::flash('failed', 'registration failed');
        return Redirect::to('sign_up')->with_errors($save->errors);
      }
    }
    else
    {
      Session::flash('failed', 'captcha is invalid');
      return Redirect::to('sign_up')->with_errors($save->errors);
    }
    
    Session::flush();
  }
  
 }
