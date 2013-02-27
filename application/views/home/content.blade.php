<div class="am-container" id="am-container">
  <?php
    $value = 30;
    for ($i=1; $i<=$value; $i++)
    {
  ?>
	<a href="#" >
	  <img src="/img/img{{ rand(1,9) }}.jpg" />
	  <div class="img-info">
      <p>A description about the image</p>
    </div>
	</a>
	<?php
    }
  ?>
</div>
@section('javascript_tag')
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.montage.min.js"></script>
<script>
	$(function() {
		var $container 	= $('#am-container'),
			$imgs		= $container.find('img').hide(),
			totalImgs	= $imgs.length,
			cnt			= 0;
		
		$imgs.each(function(i) {
			var $img	= $(this);
			$('<img/>').load(function() {
				++cnt;
				if( cnt === totalImgs ) {
					$imgs.show();
					$container.montage({
						minw : 200,
						alternateHeight : true,
						alternateHeightRange : {
							min	: 100,
							max	: 200
						},
						margin : 8,
						fillLastRow : true
					});
					
					/* 
					 * just for this demo:
					 */
					$('#overlay').fadeIn(500);
					var imgarr	= new Array();
					for( var i = 1; i <= 73; ++i ) {
						imgarr.push( i );
					}
					$('#loadmore').show().bind('click', function() {
						var len = imgarr.length;
						for( var i = 0, newimgs = ''; i < 15; ++i ) {
							var pos = Math.floor( Math.random() * len ),
								src	= imgarr[pos];
							newimgs	+= '<a href="#"><img src="/img/' + src + '.jpg"/></a>';
						}
						
						var $newimages = $( newimgs );
						$newimages.imagesLoaded( function(){
							$container.append( $newimages ).montage( 'add', $newimages );
						});
					});
				}
			}).attr('src',$img.attr('src'));
		});	
		
	});
</script>
@endsection
