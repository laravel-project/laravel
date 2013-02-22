<?php

// library for date extentions will be overide
class Date {

  public static function mysql_format(){
    return date('Y-m-d H:i:s');
  }
}

?>
