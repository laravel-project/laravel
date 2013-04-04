'use strict';

(function($){
  $(document).ready(function() {
	  //blocksit define
		
    $.ajax({
      url: "content",
      dataType: 'json',
      success: function($data) {
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

        $('#articles').BlocksIt({
			    numOfCol: 4,
			    offsetX: 8,
			    offsetY: 8
		    });
	
        $('.grid').each(function(){
          if($(this).attr('data-size') == 1){
            $(this).css('height',"160px");
          } 
          else{
            $(this).css('height',"320px");
          };
        });
      },
      complete: function() {
        $('.spinner').remove();
      }
    });

  });

})(jQuery);
