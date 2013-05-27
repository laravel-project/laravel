'use strict';

var bookCtrl = m.controller("BookCtrl", function($scope, $http, bookService, $route) {
   
  $scope.books = bookService.getBooks();
  
  $scope.bookmarks = bookService.getBookmarks();
  
  var i;
  
  //book paginations
  $scope.bookCurrentPage = 0;
  $scope.bookPageSize = 5;
  $scope.bookNumberOfPages = function(){
    return Math.ceil($scope.books.length/$scope.bookPageSize);                
  }
    
  //bookmark pagination
  $scope.bookmarkCurrentPage = 0;
  $scope.bookmarkPageSize = 10;
  $scope.bookmarkNumberOfPages = function(){
    return Math.ceil($scope.bookmarks.length/$scope.bookmarkPageSize);                
  }
  
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
//          $('#list-books-first').append('<li><a href="#" id="'+result[0].key_id+
//            '" class="listbooks">'+result[0].name+'</a></li>'+
//            '<div class="pright delete_book_button">'+
//              '<a href="#" id="delbook_((book.key_id))" ng-click="deleteBook($event)">'+
//              '<img src="/img/delete.png" width="12px"></a>'+
//            '</div>');
//          $('#add-book').hide();
//          $('#add-book input').val('').val();
//          $('.listbooks').click($scope.clickToShowBook);
          $route.reload();
          $().toastmessage('showSuccessToast', "successfully added new book");
//          var c = $scope.numberOfPages();
//          setTimeout(function(){
//            for(i=1;i<c;i++){
//              $('.next_book').click();
//            }
//          },1)
        }
      )
    }
  })
  
  //this function use to move bookmark from any book to another book
  $scope.move_to = function(e){
    var book_id = angular.element(e.target).attr('id').split('_')[1];
    var bookmark_ids = [];
    var latest_page = $('.latest_page:first').attr('latest_page');

    $('input:checkbox').each(function(){
      if ($(this).prop('checked') == true){
        bookmark_ids.push($(this).attr('id'));
      }
    })
    $http({method: 'POST', url: 'move_to_book.json?bookmark_ids='+bookmark_ids+'&book_id='+book_id+'&latest_page='+latest_page}).
      success(function(results){
//        $('#listbookmarks').html("");
//        $scope.showBookmarkAfterSuccess(results, latest_page)
        $route.reload();
        $().toastmessage('showSuccessToast', "successfully moved articles");
      }
    )
  }
  
  //this function use to show bookmarks after click book
  $scope.clickToShowBook = function(e){
    var id = angular.element(e.target).attr('id');
    $http({method: 'GET', url: 'show_book.json?book_id='+id}).
      success(function(results){
        $('#listbookmarks').html("");
        for(i=0;i<results.length;i++){
          $('#listbookmarks').append('<li><input type="checkbox" id="'+results[i].key_id+
            '" class="latest_page" latest_page="'+results[i].book_key_id+
            '"/>'+results[i].title+'<div class="pright">'+results[i].book_name+'</div></li>')
        }
      }
    )
  }
  
  //this function use to delete bookmarks
  $scope.deleteBookmark = function(){
    var bookmark_ids = [];
    var latest_page = $('.latest_page:first').attr('latest_page');

    $('input:checkbox').each(function(){
      if ($(this).prop('checked') == true){
        bookmark_ids.push($(this).attr('id'));
      }
    })
    $http({method: 'POST', url: 'delete_bookmark.json?bookmark_ids='+bookmark_ids+'&latest_page='+latest_page}).
      success(function(results){
        $('#listbookmarks').html("");
        $scope.showBookmarkAfterSuccess(results, latest_page)
        $().toastmessage('showSuccessToast', "successfully deleted bookmark");
      }
    )
  }
  
  //this function use to show all bookmarks after results
  $scope.showBookmarkAfterSuccess = function (results, latest_page){
    for(i=0;i<results.length;i++){
      $('#listbookmarks').append('<li><input type="checkbox" id="'+results[i].key_id+
        '" class="latest_page" latest_page="'+latest_page+
        '"/>'+results[i].title+'<div class="pright">'+results[i].book_name+'</div></li>')
    }
  }

  $scope.deleteBook = function(e){
    var key_id = angular.element(e.target).parent().attr('id').split('_')[1];
    var id = angular.element(e.target).parent().attr('id').split('_')[0];
    $http({method: 'POST', url: 'delete_book.json?book_id='+key_id}).
      success(function(status){
//        $('#'+key_id).parent().remove();
//        $('#book_'+id).parent().remove();
        $().toastmessage('showSuccessToast', "successfully deleted book");
        $route.reload();
      }
    )
  }
});

bookCtrl.resolve = {
  bookmarks: function(bookService) {
    bookService.fetchData(); 
  }
}


