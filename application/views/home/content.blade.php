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
        <h4>Category</h4>
        <ul>
          <li>
            <a href="#">Music</a>
          </li>
          <li>  
            <a href="#">Film</a>
          </li>
          <li> 
             <a href="#">Teknologi</a>
          </li>
        </ul>
        <hr> 
        <h4> My Books</h4>
        <ul id='my_books'>
          <li ng-repeat="book in books">
            <a href="#" ng-click="loadBookmarkedArticle($event)" data-id="((book.id))">(( book.name ))</a>
          </li>
        </ul>
      </div>
    </div>  
  </div>
</div> 



