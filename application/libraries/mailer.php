<?php

//send email using SMTP
class Mailer {

  public static function send_activation_email($user_id, $url_base){
    $user = User::find($user_id);
    $mail = new SMTP();
    $mail->to($user->email);
    $mail->from('developer.laravel@gmail.com', 'Developer');
    $mail->subject('Hello World');
    $mail->body('This is a example of activation email 
    <a href='.$url_base.'?confirmation_token='
      .$user->confirmation_token.'&key_id='.$user->key_id.'>
      click in here to activation your email
    </a>');
    $mail->send();
  }
  
  public static function send_forgot_password($user_id, $url_base){
    $user = User::find($user_id);
    $mail = new SMTP();
    $mail->to($user->email);
    $mail->from('developer.laravel@gmail.com', 'Developer');
    $mail->subject('Hello World');
    $mail->body('This is a example of link to reset password 
    <a href='.$url_base.'?key_id='
      .$user->key_id.'&can_reset_password='.$user->can_reset_password.'&expired_at='.$user->expired_at.'>
      click in here to reset your password
    </a>');
    $mail->send();
  }
  
  public static function send_welcome_email($user_id, $url_base){
    $user = User::find($user_id);
    $mail = new SMTP();
    $mail->to($user->email);
    $mail->from('developer.laravel@gmail.com', 'Developer');
    $mail->subject('Hello World');
    $mail->body('Welcome '.$user->name.'
    <a href='.$url_base.'>
      click in here to visit your dashboard
    </a>');
    $mail->send();
  }

  public static function send_article($article_keyid, $email) {
    $article = Article::where('key_id', '=', $article_keyid)->first();
    $mail = new SMTP();
    $mail->to($email);
    $mail->from('bacayuks.com');
    $mail->subject($article->title);
    $mail->body($article->content);
    $mail->send();
  }
}

?>
