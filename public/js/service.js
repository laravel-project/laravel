'use strict';

//bookService. m = angular app variable
m.service('bookService', function($http, $q){
  var books = [];
  var bookmarks = [];
  return {
    fetchData: function(){
      var deferred = $q.defer();
      var bookXhr = $http({method: 'GET', url: 'all_books.json'});
      
      var bookmarkXhr = $http({method: 'GET', url: 'show_book.json?book_id=BookAll'});

      $q.all([bookXhr, bookmarkXhr]).then(function(results){
        if (typeof results[0] == 'undefined' || typeof results[1] == 'undefined')
          deferred.reject();
        else {
          angular.copy(results[0].data, books);
          angular.copy(results[1].data, bookmarks);
          deferred.resolve();
        }
      });
       
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

m.service('regexChecker', function(){
  return {
    email: function(val) {
      var regex = /^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i; 
      return regex.test(val);
    }
  }
});
