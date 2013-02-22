<?php

//send email using SMTP
class Mailer {

  public static function send_activation_email($user_id){
    $user = User::find($user_id);
    $mail = new SMTP();
    $mail->to($user->email);
    $mail->from('developer.laravel@gmail.com', 'Developer');
    $mail->subject('Hello World');
    $mail->body('This is a example of activation email 
    <a href='.URL::to('confirmation_password').'?confirmation_token='
      .$user->confirmation_token.'&key_id='.$user->key_id.'>
      click in here to activation your email
    </a>');
    $mail->send();
  }
  
  public static function send_forgot_password($user_id){
    $user = User::find($user_id);
    $mail = new SMTP();
    $mail->to($user->email);
    $mail->from('developer.laravel@gmail.com', 'Developer');
    $mail->subject('Hello World');
    $mail->body('This is a example of link to reset password 
    <a href='.URL::to('reset_password').'?key_id='
      .$user->key_id.'&can_reset_password='.$user->can_reset_password.'&expired_at='.$user->expired_at'>
      click in here to reset your password
    </a>');
    $mail->send();
  }
}

?>
