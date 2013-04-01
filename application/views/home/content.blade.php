<div class="am-container">
  <div id='articles'>
    <?php
       if (count($articles) > 0 ){
         foreach( $articles as $article){
           if ($article->id % 3){
             $v = 1;
           }else{
             $v = 2;
           }
    ?>
    <div class="grid" data-size="{{ $v }}">
		  <div class="imgholder">
			  <img src="{{ $article->image }}" />
		  </div>
		  <strong>{{ $article->title }}</strong>
	  </div>
	  <?php
        }
      }
    ?>
  </div>
</div>
@section('javascript_tag')
<script type="text/javascript" src="/js/blocksit.min.js"></script>
<script>
$(document).ready(function() {
	//blocksit define
	$(window).load( function() {
		$('#articles').BlocksIt({
			numOfCol: 4,
			offsetX: 8,
			offsetY: 8
		});
	});
	
	$('.grid').each(function(){
    if($(this).attr('data-size') == 1){
      $(this).css('height',"160px");
    }else{
      $(this).css('height',"320px");
    }
  })
    
	//window resize
	var currentWidth = 1100;
	$(window).resize(function() {
		var winWidth = $(window).width();
		var conWidth;
		if(winWidth < 660) {
			conWidth = 440;
			col = 2
		} else if(winWidth < 880) {
			conWidth = 660;
			col = 3
		} else if(winWidth < 1100) {
			conWidth = 880;
			col = 4;
		} else {
			conWidth = 1100;
			col = 5;
		}
		
		if(conWidth != currentWidth) {
			currentWidth = conWidth;
			$('#articles').width(conWidth);
			$('#articles').BlocksIt({
				numOfCol: col,
				offsetX: 8,
				offsetY: 8
			});
		}
	});
});
</script>
@endsection
