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
function ArtclCtrl($scope){
  
 $scope.content = '';
 (function($){
    //blocksit define
  if ($scope.content.length == 0) {
  
    $.ajax({
      url: "content.json",
      dataType: 'json',
      success: function($data) {
        $scope.content = $data;
        setTimeout(function(){
          $scope.load_content($data)
        }, 2000); 
      },
      complete: function() {
        setTimeout(function(){
          $('.spinner').remove()
        }, 2000);
      }
    });
  }

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
