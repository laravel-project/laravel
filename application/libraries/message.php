<?php

class Message {
  
  public static function success_or_not_message($flag, $message){
    return Session::flash($flag, $message.' '.$flag);
  }
  
  public static function invalid_message($message){
    return Session::flash('failed', $message.' is invalid');
  }
  
  public static function confirmation_message(){
    return Session::flash('failed', 'please confirmation your email');
  }
  
  public static function password_error(){
    return Session::flash('failed', 'password must then 6 character and password and confirmation password not match');
  }
}

?>
