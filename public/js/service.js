'use strict';

//bookService. m = angular app variable
m.service('bookService', function($http, $q){
  var books = [];
  return {
    fetchBooks: function(){
      var deferred = $q.defer();
      $http({method: 'GET', url: 'bookmark.json'})
      .success(function(data, status) {
        angular.copy(data, books);
        deferred.resolve();
      })
      .error(function(data, status) {
        deferred.reject();
      });
      return deferred.promise;
    },
    getBooks: function() {
      return books;
    }
  }
});

m.service('facebook', function(){
  return {
    postWall: function(linkUrl, img, title, desc) {
      FB.init({appId: facebook_app_id});
      FB.ui({
        method: 'stream.publish',
        link: linkUrl,
        display: 'popup',
        picture: img,
        name: title,
        description: desc,
      });
    }
  }
});

m.service('twitter', function($http){
  return {
    tweet: function(text) {
      var link = 'https://twitter.com/share';
      var t = encodeURIComponent(text);
      $http.post(link, {
        text: t
      }).success(function(data, status){
        alert('sukses'); 
      }).error(function(data, status){
        alert('gagal');
      })
    }
  }
})
