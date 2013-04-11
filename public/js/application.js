'use strict';
$(document).ready(function(){
  
  //this is function for showing bootsrap popup modal
  //when process failed it's will be show the modal
  modalShowAfterFailed('login');
  modalShowAfterFailed('forgot_password');
  modalShowAfterFailed('resend_confirmation');
  modalShowAfterFailed('registration');
  
  $('#forgot_password_link, #resend_confirmation_link').click(function(){ 
    $('#login-modal').modal('hide'); 
  });
})

function modalShowAfterFailed(modal_name){
  if (location.href == "http://"+location.host+"/?"+modal_name){
    return $('#'+modal_name+'-modal').modal('show');
  }
}
