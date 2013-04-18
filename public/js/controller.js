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
 $scope.content={}; 
 $scope.count_article = 0;
 $scope.connectTry = 0;
 $scope.total_article = 0;


 (function($){
   
   $('#articles').after($compile('<spinner></spinner>')($scope));
   
   //describe function to fetch data
   $scope.fetch = function(url, success_condition) {
      $http({method: 'GET', url: url, cache: true}).
       success(function(data, status) {
         $scope.count_article = $scope.count_article + data['content'].length;
         if (data['counter'] > 0) {
           $scope.total_article = data['counter'];
         }
         setTimeout(function(){
           $scope.load_content(data['content']);

           if (success_condition == 'remove spinner')
             $('spinner').remove();
           else if (success_condition == 'remove lightbox')
           {
             $('body').css('overflow-y', 'visible'); 
             $('lightbox').remove();
           }
             
         }, 2000)       
       }).
       error(function(data, status) {
         $scope.connectTry = $scope.connectTry + 1;
         if ($scope.connectTry <= 3) {
           $scope.fetch(url, success_condition);
         }
         else {
           $().toastmessage('showErrorToast', "error connection");
         }
       });
   }

   //describe function to load more data
   $scope.loadMore = function() {
     if ($scope.count_article < $scope.total_article)
     {
       $('body').css('overflow-y', 'hidden'); 
       $('body').append($compile('<lightbox><spinner></spinner></lightbox>')($scope));
       $scope.fetch('content.json?p='+$scope.count_article, 'remove lightbox');
     }

   }

   //search my articles function
   $scope.fetch('content.json', 'remove spinner');

//   $('#search_my_articles').on('click',function(){
//     $('#articles').after($compile('<spinner></spinner>')($scope));
//     $scope.fetch('content.json?q='+$('#find_my_articles').val(), 'remove spinner');
//     $('.grid').remove();
//   })
   
   $('#find_my_articles').keyup(function(){
     $('.grid').each(function(){
        var re = new RegExp($('#find_my_articles').val(), 'i')
        if($(this).children('strong')[0].innerHTML.match(re)){
          $(this).show();
        }else{
          $(this).hide();
        };
     });
   });

   $scope.show = function(e){
     alert($scope.content[angular.element(e.target).attr('data')]);
   };
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
          $v = 1;
        }
        var $grid = $('<div></div>').addClass('grid mosaic-block bar2').appendTo('#articles');
        var $link = $('<a class="mosaic-overlay" href="#"></a>').appendTo($grid);
        $('<div class="details">'+$data[i].title.substring(0,35)+'...</div>').appendTo($link);
        $('.mosaic-overlay').hover(function(){
         // $(this).attr('style','background-color: green')
        })
        $('<img/>').attr('src', $data[i].picture).appendTo($grid);
      }
    };
    
    $('.grid').each(function(grid){
        var img = $(this).children('img')
        img.css('height',"200px")
        img.css('width',"275px")
        img.css('cursor','pointer')
    })
      
    //blocksit define
    $('#articles').BlocksIt({
      numOfCol: 4,
      offsetX: 0,
      offsetY: 0
    });
    
    //------------------------
    colors = ['green','yellow','orange','blue','navy']

    $('.mosaic-overlay').each(function(){
      $(this).mouseover(function(){
        ran = Math.floor((Math.random()*5)+1);
        console.log($(this).attr('class'))
         $(this).css('background-color', colors[ran])
      }).mouseout(function(){
         $(this).css('background-color', '#111')
      })
    })
    
    $('.bar2').mosaic({
			animation	:	'slide'		//fade or slide
		});
  }

})(jQuery);
}
