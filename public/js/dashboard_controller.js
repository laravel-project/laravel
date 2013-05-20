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
function ArtclCtrl($scope, $http, $compile, facebook, twitter, regexChecker){

  $scope.count_article = 0;
  $scope.total_article = 0;

  var connectTry = 0;
  var dataShare;
  //ini buat counter dr isi artikel. setiap isi artikel jsonny disalin ke
  //variabel dan untuk pembeda antara content satu dengan lainny digunakan variabel counter
  var counter = 0;
  //ini buat isi kontentny
  var contents = {}; 
  //ini buat title
  var titles = {};
  //ini buat gambarny
  var images = {};
  //ini untuk artikel id
  var article_id = {};
  //ini untuk mengecek artikel sudah di bookmark atau belum
  var bookmarked = {};
  // (function($){
   
   $('#articles').after($compile('<spinner></spinner>')($scope));
   
   //describe function to fetch data
   $scope.fetch = function(url, success_condition) {
      $http({method: 'GET', url: url}).
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
         connectTry = connectTry + 1;
         if (connectTry <= 3) {
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

   };

   //search my articles function
   $scope.fetch('content.json', 'remove spinner');

   
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

   $scope.addBookmark = function(e) {
     $http({method: 'POST', url: angular.element(e.target).attr('data-url')})
     .success(function(data, status) {
       if(data[0].status == 'failed'){
          $().toastmessage('showErrorToast', data[0].message);
        }
        else {
          $().toastmessage('showSuccessToast', data[0].message);
          angular.element(e.target).parent().html('article has been bookmarked');
        }
      });
   };
   
   //show popup mailer
   $scope.showMailer = function(){
     var $this = angular.element('.mail-icon');
     var articleid = $this.attr('id');
     var html = $compile('<email article="'+articleid+'" send="sendMail(event)"></email>')($scope);
     $this.popover({
       placement: 'right',
       title: 'send article to:', 
       html: 'true',
       content: html
     });
   }

   //function for posting to facebook
   $scope.facebookPost = function() {
     facebook.postWall('', baseUrl + picture_link(images[dataShare], 'thumbs'), 
         titles[dataShare], contents[dataShare]);
   }

   //function for tweet to twitter
   $scope.tweet = function() {
     twitter.tweet(titles[dataShare]);
   }

   //function to send email article content
   $scope.sendMail = function(e) {
     var form = angular.element('#frm_send_artcl');
     var email = form.find('input#email').val();
     var article = form.find('input#articleid').val();
     $http({method: 'POST', url: 'send_article?article='+article+'&email='+email}).
       success(function(data, status) {
         console.log(status);
         if(status != 200){
            $().toastmessage('showErrorToast', 'Email failed to send');
          }
          else {
            $().toastmessage('showSuccessToast', 'Email has successfully send');
          }
       }).
       error(function(data, status){
         $().toastmessage('showErrorToast', 'Error Connection');
       });
      
     e.preventDefault();
   }
   
   //fungsi untuk menampilkan pop up
   $scope.show = function(e){
     dataShare = angular.element(e.target).attr('data');

     $('body').css('overflow-y', 'hidden'); 
     var $modal = $($compile('<modal title="'+ titles[dataShare]
           +'" modalid="mymodal" bookmarked="'+ bookmarked[dataShare]
           +'" articleid="'+article_id[dataShare]+
           '"><div id="imgpopup"> <img src="'+ picture_link(images[dataShare], 'origins') +'"/></div><div class="content_popup">'+
       contents[dataShare]
     +'</div></modal>')($scope)).appendTo('body');
     $('.content_popup').text().split('.').join('.<br/>');
     $modal.modal('show');

     $scope.showMailer();

     $('.modal-backdrop, .modal-header > .close').bind('click', function(){
       setTimeout(function(){ 
         angular.element('#mymodal').remove();
         $('body').css('overflow-y', 'visible');
       }, 500);
     });

     $('#scrollbox4').enscroll({
       verticalTrackClass: 'track4',
       verticalHandleClass: 'handle4',
       minScrollbarLength: 28
     });
     
     //check email regex in email field when user type
     angular.element(document).on('keyup', '#email', function(){
       var elm = angular.element(this);
       var val = elm.val();
       var form_btn = elm.parent().find('button');
       var check_mail = regexChecker.email(val); 
       if (val.length > 0 && check_mail) {
         form_btn.prop('disabled', false);
       }
       else {
         form_btn.prop('disabled', true);
       }
     });
    
     e.preventDefault();
   };

   $scope.mouseover = function(e) {
     var $elmnt = angular.element(e.target);
     if ($elmnt.hasClass('mosaic-overlay')) {
       $elmnt = $elmnt.find('div');
     }
     var title = titles[$elmnt.attr('data')];
     $elmnt.html(title);
   }

   $scope.mouseout = function(e) {
     var $elmnt = angular.element(e.target);
     if ($elmnt.hasClass('mosaic-overlay')) {
       $elmnt = $elmnt.find('div');
     }
     var title = $elmnt.text().substring(0,35) + '...';
     $elmnt.html(title);
   }

  //describe function to display content on blocksit
   $scope.load_content = function($data) {
    var colors = ['green','yellow','orange','orangered']
    if($data.length > 0) {
      for (var i = 0; i < $data.length; i++) { 

        //menyalin data ke variabel2 di bawah utnuk ditampilkan di popup modal
        contents['data-'+ counter] = $data[i].content;
        titles['data-' + counter] = $data[i].title.replace(/\"|\'/g, "");
        images['data-' + counter] = $data[i].picture;
        article_id['data-' + counter] = $data[i].key_id;
        bookmarked['data-' + counter] = $data[i].bookmarked;
        
        var $grid = $('<div></div>').addClass('grid mosaic-block bar2').appendTo('#articles');
        var $link = $($compile('<a class="mosaic-overlay" href="#"' +
              'ng-click="show($event)" ng-mouseout="mouseout($event)"' + 
              'ng-mouseover="mouseover($event)" data=data-'+ 
              counter +'></a>')($scope)).appendTo($grid);
        $($compile('<div class="details" ng-mouseleave="mouseout($event)"' +
              'ng-mouseenter="mouseover($event)" data=data-' + 
              counter +'>' + $data[i].title.substring(0,35)+'...</div>')($scope))
          .appendTo($link);

        //increment counter
        counter++;
        
        //PLEASE FIX ME
        $('.mosaic-overlay').each(function(){
          $(this).mouseover(function(){
            var ran = Math.floor((Math.random()*5)+1);
             $(this).css('background-color', colors[ran])
          }).mouseout(function(){
             $(this).css('background-color', '#111')
          })
        })
    
        $('<img src="' + picture_link($data[i].picture, 'thumbs') + '"/>').appendTo($grid);
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
    
    
    $('.bar2').mosaic({
			animation	:	'slide'		//fade or slide
		});
  }

//  })(jQuery);
   
  //this function is return the link of picture
  var picture_link = function(img_name, type) {
    var link;
    switch(type) {
      case 'thumbs':
        if (img_name == 'no_photo.png') 
        {
          link = '/img/no_photo_thumb.png';
        }
        else 
        {
          link = '/img/articles/thumbs/' + img_name;
        }
        break;
      case 'origins':
        if (img_name == 'no_photo.png') 
        {
          link = '/img/no_photo.png';
        }
        else 
        {
          link = '/img/articles/origins/' + img_name;
        }
        break;
    }
    return link;
  }
}
