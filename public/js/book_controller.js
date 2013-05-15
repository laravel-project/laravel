'use strict';

var bookCtrl = m.controller("BookCtrl", function($scope, $http, bookService) {
  $scope.books = bookService.getBooks();
  var i;
  
  $scope.initialize = function(){
    $('#add-book').hide();
    $('#toggle-add-book').click(function(){
      $('#add-book').toggle();
      $('#add-book input').focus();
    })
    
    //load books first
    $http({method: 'GET', url: 'all_books.json'}).
      success(function(results){
        var ul = $('<ul></ul>').addClass('dropdown-menu').appendTo($('#dropdown-list-books'));
        for(i=0;i<results.length;i++){
          $('#list-books-first').append('<li><a href="#" id="'+results[i].key_id+'" class="listbooks">'+results[i].name+'</a></li>');
          $('<li><a href="#" class="move_to_book" id="book_'+results[i].id+'">'+results[i].name+'</a></li>').appendTo(ul);
        }
        //click book to show books
        $('.listbooks').click($scope.clickToShowBook);
        $('.move_to_book').click($scope.move_to);
      }
    )
    
    $http({method: 'GET', url: 'show_book.json?book_id=BookAll'}).
      success(function(results){
        $('#listbookmarks').html("");
        for(i=0;i<results.length;i++){
          $('#listbookmarks').append('<li><input type="checkbox" id="'+results[i].key_id+
            '"/>'+results[i].title+'<div class="pright">'+results[i].book_name+'</div></li>')
        }
      }
    )
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
  
  $scope.move_to = function(){
    var book_id = $(this).attr('id').split('_')[1];
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
  
  $scope.clickToShowBook = function(){
    var id = $(this).attr('id');
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
    bookService.fetchBooks(); 
  }
}


