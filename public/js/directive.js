//this directive is used to adding spinner image
m.directive('spinner', function(){
  return {
    restrict: "E",
    template: "<img class='spinner' src='../img/spinner_loading.gif' alt='spinner'/>"
  }
});

//this directive is used to describe scroll function
m.directive('scroll', function() {
  return function(scope, elm, attrs){
    var windowElmnt = jQuery(window);
    var docElmnt = jQuery(document);

    windowElmnt.bind("scroll", function(){
      if (windowElmnt.scrollTop() + windowElmnt.height() >= docElmnt.height()) {
        scope.$apply(attrs.scroll);
      }
    });
  }
});

//directive to created lightbox
m.directive('lightbox', function() {
  return {
    restrict: "E",
    template: '<div id="lightbox" style=((lightBoxStyle)) ng-transclude></div>',
    transclude: true,
    link: function(scope) {
      scope.lightBoxStyle = 'position: absolute; left: 0px; top:' + 
        jQuery(document).scrollTop() + 'px; opacity:0.5; height: 100%;' +
        'width: 100%; background-color:black; z-index: 99999;'
    }
  }
});

//this directive is used to create link bookmark in article popup show modal
m.directive('bookmark', function(){
  return {
    restrict: 'E',
    replace: 'true',
    template: '<a class="add_bookmark" href="javascript:void(0);" ng-show="true"'+
              'data-url="/add_bookmark.json?article_id=((article))"'+
              'ng-click="addBookmark($event);">bookmark this article</a>',
    link: function(scope, elmnst, args) {
      scope.article = args.article;
    }
  }
});

//this directive is used to show email pop up
m.directive('email', function($compile) {
  return {
    restrict: "E",
    replace: true,
    template: '<div class="autohide-mail"><form id="frm_send_artcl">'+
       '<input type="text" id="email"/>'+
       '<input type="hidden" id="articleid" value="((article))"/>'+
       '<button ng-click="send({event: $event})" class="btn" disabled="true">send</button></form></div>',
    scope: {
      article: '@',
      send: '&'
    }
  }
});

//this directive is used to show article in the modal dialog boostrap
m.directive('modal', function($compile) {
  return {
    restrict: "E",
    transclude: true,
    replace: true,
    template: '<div id="((modalid))" class="modal hide fade" tabindex="-1"' +
                'role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
               '<div class="modal-header">' +
                 '<button type="button" class="close" data-dismiss="modal"' + 
                   'aria-hidden="true">×</button>' +
                  '<h3 id="myModalLabel">((title))</h3>' +
               '</div>' +
               '<div class="modal-body" ng-transclude id="scrollbox4"></div>' +
               '<div class="modal-footer">'+
                 '<div class="facebook-icon" ng-click="facebookPost()"></div>'+
                 '<div class="twitter-icon" ng-click="tweet()"></div>'+
                 '<div class="mail-icon" id="((articleid))" ng-click="showMailer()"></div><span></span>'+
               '</div>'+
              '</div>',
    link: function(scope, element, args) {
      scope.title = args.title;
      scope.modalid = args.modalid;
      scope.articleid = args.articleid;
      scope.bookmarked = args.bookmarked;
      var $footerSpan = element.find('.modal-footer').find('span');
      if (args.bookmarked == 'true') {
        $footerSpan.html('article has been bookmarked');
      }
      else {
        $footerSpan.html($compile('<bookmark article="'+args.articleid+'"></bookmark>')(scope));
      };
    }
  }
});
