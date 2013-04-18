'use strict';

//--angular
function TodoCtrl($scope) {
  $scope.todos = [];
   
  $scope.addTodo = function() {
    $scope.todos.push({text:$scope.todoText, done:false});
    $scope.todoText = '';
  };
   
  $scope.remaining = function() {
    var count = 0;
    angular.forEach($scope.todos, function(todo) {
    count += todo.done ? 0 : 1;
    });
    return count;
  };
   
  $scope.archive = function() {
    var oldTodos = $scope.todos;
    $scope.todos = [];
    angular.forEach(oldTodos, function(todo) {
      if (!todo.done) $scope.todos.push(todo);
    });
  };
}

//--ini buat artikel di content.blade.php
function ArtclCtrl($scope, $http, $compile){
  
 $scope.content = '';
 $scope.count_article = 0;
 $scope.connectTry = 0;

 (function($){
   
   $('#articles').after($compile('<spinner></spinner>')($scope));
   
   $scope.article_fetch = function(url) {
     return $http({method: 'GET', url: url, cache: true})
            .error(function(data, status) {
              $scope.connectTry = $scope.connectTry + 1;
                if ($scope.connectTry <= 3) {
                  $scope.article_fetch(url);
                }
                else {
                  $().toastmessage('showErrorToast', "error connection");
                }
            });
   }
   //describe functionto fetch data
   $scope.fetch = function(url) {
      $http({method: 'GET', url: url, cache: true}).
       success(function(data, status) {
         $scope.count_article = $scope.count_article + data.length;
         setTimeout(function(){
           $scope.load_content(data);
           $('spinner').remove();
         }, 2000)       
       }).
       error(function(data, status) {
         $scope.connectTry = $scope.connectTry + 1;
         if ($scope.connectTry <= 3) {
           $scope.fetch(url);
         }
         else {
           $().toastmessage('showErrorToast', "error connection");
         }
       });
   }

   //describe function to load more data
   $scope.loadMore = function() {
     $('body').css('overflow-y', 'hidden'); 
     $('body').append($compile('<lightbox><spinner></spinner></lightbox>')($scope));
     
     $scope.article_fetch('content.json?p='+$scope.count_article).success(function(data, status) {
       $scope.count_article = $scope.count_article + data.length;
       setTimeout(function(){
         $scope.load_content(data);
         $('body').css('overflow-y', 'visible'); 
         $('lightbox').remove();
       }, 2000)
     });

   }



   //search my articles function
   $scope.fetch('content.json');

   $('#search_my_articles').on('click',function(){
     $('#articles').after($compile('<spinner></spinner>')($scope));
     $scope.fetch('content.json?search='+$('#find_my_articles').val());
     $('.grid').remove()
   })
   
//   $('#find_my_articles').keyup(function(){
//     $('.grid').each(function(){
//        var re = new RegExp($('#find_my_articles').val(), 'i')
//        if($(this).children('strong')[0].innerHTML.match(re)){
//          $(this).show();
//        }else{
//          $(this).remove();
//        };
//     });
//   });
//
   
  //describe function to display content on blocksit
   $scope.load_content = function($data) {
    var $v;
    if($data.length > 0) {
      for (var i = 0; i < $data.length; i++) { 
        if ((i+1) % 3) {
          $v = 1;
        }
        else {
          $v = 2;
        }
        var $grid = $('<div></div>').addClass('grid')
          .attr('data-size', $v).appendTo('#articles');
        var $imgHolder = $('<div></div>').addClass('imgholder').appendTo($grid);
        $('<img/>').attr('src', $data[i].picture).appendTo($imgHolder);
        $('<strong></strong>').text($data[i].title).appendTo($grid);
      }
    };
    
    $('.grid').each(function(){
      if($(this).attr('data-size') == 1){
        $(this).css('height',"160px");
        $(this).children('.imgholder').children('img').css('height',"120px")
        $(this).children('.imgholder').children('img').css('width',"250px")
      }else{
        $(this).css('height',"342px");
        $(this).children('.imgholder').children('img').css('height',"300px")
        $(this).children('.imgholder').children('img').css('width',"525px")
      }
    })
      
    //blocksit define
    $('#articles').BlocksIt({
      numOfCol: 4,
      offsetX: 0,
      offsetY: 0
    });

  }

})(jQuery);
}
