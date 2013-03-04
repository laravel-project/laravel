<?php

//this is function for showing bootsrap popup modal
//only use on javascript
//when process failed it's will be show the modal
class Modal {

  public static function show_after_failed($name){
    if (URL::full() == URL::base()."/?".$name){
      return "$('#$name-modal').modal('show')";
    }
  }
}

?>
