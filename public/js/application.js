'use strict';

var m = angular.module('laravel', []);

//overide angular starting symbol and end symbol template tag
m.config(function($interpolateProvider) {
  $interpolateProvider.startSymbol('((');
  $interpolateProvider.endSymbol('))');
});

m.directive('spinner', function(){
  return {
    restrict: "E",
    template: "<img class='spinner' src='../img/spinner_loading.gif' alt='spinner'/>"
  }
});

/*m.directive('article', function(){*/
  //return {
    //restrict: "E"
    //template: 
  //}
/*});*/






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

