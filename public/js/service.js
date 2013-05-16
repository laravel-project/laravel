'use strict';

//bookService. m = angular app variable
m.service('bookService', function($http, $q){
  var books = [];
  var bookmarks = [];
  var s1,s2 = false;
  return {
    fetchData: function(){
      var deferred = $q.defer();
    /*  $http({method: 'GET', url: 'bookmark.json'})
      .success(function(data, status) {
        angular.copy(data, books);
        deferred.resolve();
      })
      .error(function(data, status) {
        deferred.reject();
      }); */
      $http({method: 'GET', url: 'all_books.json'}).
        success(function(data, status){
          angular.copy(data, books);
          s1 = true;
        })
        .error(function(data, status) {
          deferred.reject();
        });
      
      $http({method: 'GET', url: 'show_book.json?book_id=BookAll'}).
        success(function(data, status){
          angular.copy(data, bookmarks);
          s2 = true;
        })
        .error(function(data, status) {
          deferred.reject();
        });
      
      if(s1 == true && s2 == true) {
        deferred.resolve();
      }
      
      return deferred.promise;
    },
    getBooks: function() {
      return books;
    },
    getBookmarks: function() {
      return bookmarks;
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
      window.open('/twitter?t='+text,'','width=600,height=400');
    }
  }
})
