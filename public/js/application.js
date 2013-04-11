'use strict';
var m = angular.module('laravel', []);

//overide angular starting symbol and end symbol template tag
m.config(function($interpolateProvider) {
  $interpolateProvider.startSymbol('((');
  $interpolateProvider.endSymbol('))');
});

m.controller('ArtclCtrl', function($scope){

});

