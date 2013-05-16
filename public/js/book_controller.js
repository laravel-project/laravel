'use strict';

var bookCtrl = m.controller("BookCtrl", function($scope, $http, bookService) {
   
  $scope.books = bookService.getBooks();
  
  $scope.bookmarks = bookService.getBookmarks();
  
  var i;
  
  $scope.initialize = function(){
    $('#add-book').hide();
    $('#toggle-add-book').click(function(){
      $('#add-book').toggle();
      $('#add-book input').focus();
    });
    //destroy event scroll from article controller
    jQuery(window).unbind( "scroll" );
  }
  
  $scope.initialize();
  
  $('#submit-book').click(function(){
    var newBook = $('#new-book').val();
    if (newBook != ""){
      $http({method: 'POST', url: 'create_book.json?book_name='+newBook}).
        success(function(result){
          $('#list-books-first').append('<li><a href="#" id="'+result[0].key_id+'" class="listbooks">'+result[0].name+'</a></li>');
          $('#add-book').hide();
          $('#add-book input').val('').val();
          $('.listbooks').click($scope.clickToShowBook);
        }
      )
    }
  })
  
  $scope.move_to = function(e){
    var book_id = angular.element(e.target).attr('id').split('_')[1];
    var bookmark_ids = [];
    $('input:checkbox').each(function(){
      if ($(this).prop('checked') == true){
        bookmark_ids.push($(this).attr('id'));
      }
    })
    $http({method: 'POST', url: 'move_to_book.json?bookmark_ids='+bookmark_ids+'&book_id='+book_id}).
      success(function(status){
        location.href = 'book'
      }
    )
  }
  
  $scope.clickToShowBook = function(e){
    var id = angular.element(e.target).attr('id');
    $http({method: 'GET', url: 'show_book.json?book_id='+id}).
      success(function(results){
        $('#listbookmarks').html("");
        for(i=0;i<results.length;i++){
          $('#listbookmarks').append('<li><input type="checkbox" id="'+results[i].key_id+
            '"/>'+results[i].title+'<div class="pright">'+results[i].book_name+'</div></li>')
        }
      }
    )
  }
});


bookCtrl.resolve = {
  bookmarks: function(bookService) {
    bookService.fetchData(); 
  }
}


