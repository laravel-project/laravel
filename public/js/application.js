'use strict';

var facebook_app_id = '604721692878709';
var baseUrl = location.host;

var m = angular.module('laravel', []);

//overide angular starting symbol and end symbol template tag
m.config(function($interpolateProvider, $routeProvider, $locationProvider) {
  $locationProvider.html5Mode(true);
  $interpolateProvider.startSymbol('((');
  $interpolateProvider.endSymbol('))');
  
  $routeProvider.when('/dashboard', {templateUrl: "/content", controller: "ArtclCtrl"});
  
  $routeProvider.when('/book', 
    {
      templateUrl: "/book_content", 
      controller: "BookCtrl", 
      resolve: bookCtrl.resolve    
    });
  
  $routeProvider.when('/logout', 
    {
      redirectTo: function(routeParams, path, search) {
        window.location.href = path;
      }
    });
  
  $routeProvider.otherwise({
      template: "this doesn't exist"
  });
});



//this function is used to improve performance using memoization
Function.prototype.memoized = function(key)
{
  this._values = this._values || {};
  return this._values[key] !== undefined ?
    this._values[key] :
    this._values[key] = this.apply(this, arguments);
}

Function.prototype.memoize = function(){
  var fn = this;
  return function(){
    return fn.memoized.apply( fn, arguments );
  };
};



//this is function for showing bootsrap popup modal
//when process failed it's will be show the modal
modalShowAfterFailed('login');
modalShowAfterFailed('forgot_password');
modalShowAfterFailed('resend_confirmation');
modalShowAfterFailed('registration');

$('#forgot_password_link, #resend_confirmation_link').click(function(){ 
  $('#login-modal').modal('hide'); 
});

function modalShowAfterFailed(modal_name){
  if (location.href == "http://"+location.host+"/?"+modal_name){
    return $('#'+modal_name+'-modal').modal('show');
  }
}

