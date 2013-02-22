<?php

// library for date extentions will be overide
class Date {

  public static function mysql_format(){
    return date('Y-m-d H:i:s');
  }
  
  public static function sum_of_date($num){
    return date('Y-m-d H:i:s', strtotime('+'.$num));
  }
}

?>
