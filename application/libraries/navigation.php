<?php

class Navigation {
    public static function menu($name, $current_url, $url){
    if($current_url == $url){
      return "<li class='active'><a href='".$url."'>".$name."</a></li>";
    }else{
      return "<li><a href='".$url."'>".$name."</a></li>";
    }
  }
}

?>
