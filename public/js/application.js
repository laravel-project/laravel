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

//this directive is used to describe scroll function
m.directive('scroll', function() {
  return function(scope, elm, attrs){
    var windowElmnt = jQuery(window);
    var docElmnt = jQuery(document);

    windowElmnt.bind("scroll", function(){
      if (windowElmnt.scrollTop() + windowElmnt.height() >= docElmnt.height()) {
        scope.$apply(attrs.scroll);
      }
    });
  }
});
//directive to created lightbox
m.directive('lightbox', function() {
  return {
    restrict: "E",
    template: '<div id="lightbox" style=((lightBoxStyle)) ng-transclude></div>',
    transclude: true,
    link: function(scope) {
      scope.lightBoxStyle = 'position: absolute; left: 0px; top:' + 
        jQuery(document).scrollTop() + 'px; opacity:0.5; height: 100%;' +
        'width: 100%; background-color:black'
    }
  }
});



m.directive('modal', function() {
  return {
    restrict: "E",
    transclude: true,
    replace: true,
    scope: {
      title: '@',
      modalid: '@'
    },
    template: '<div id="((modalid))" class="modal hide fade" tabindex="-1"' +
                'role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
               '<div class="modal-header">' +
                 '<button type="button" class="close" data-dismiss="modal"' + 
                   'aria-hidden="true">×</button>' +
                  '<h3 id="myModalLabel">((title))</h3>' +
               '</div>' +
               '<div class="modal-body">' +
                 '<p>ari</p>' +
               '</div>' +
              '</div>',
    link: function(scope, element, args) {
    }
  }
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
