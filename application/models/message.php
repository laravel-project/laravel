<?php

class Message {
  
  public static function success_or_not_message($flag, $message){
    return Session::flash($flag, $message.' '.$flag);
  }
  
  public static function invalid_message($message){
    return Session::flash('failed', 'invalid '.$message);
  }
  
  public static function confirmation_message(){
    return Session::flash('failed', 'please confirmation your email');
  }
}

?>
