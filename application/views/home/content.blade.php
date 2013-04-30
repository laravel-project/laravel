<div class="container-logged container-fluid">
  <div class="row-fluid">
    <div class="span10">
      <div class="am-container">
        <div id='articles' scroll="loadMore()">
        </div> 
        </div>
        </div>
        <div class="span2 sidebar-content">
        <div style="position: fixed;">
        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. <hr> 
         <h4> My Books</h4>
         <ul id='my_books'>
           @foreach( $books as $book )
             <li><a href="#{{ $book->nanme }}">{{ $book->name }}</a></li>
           @endforeach
         </ul>
      </div>
    </div>  
  </div>
</div>

