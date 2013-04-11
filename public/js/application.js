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






