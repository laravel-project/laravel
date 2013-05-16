<div class="container-logged container-fluid default-color">
  <div class="row-fluid">
    <div class="span2 with-border-left">
      <br/>
      <ul class='table'>
        <li>
          My Books
          <div class='pright'>
            <a href="#" id='toggle-add-book'> + </a>
          </div>
        </li>
        <li id='add-book'>
          <div class="input-append">
            <input class="input-medium" type="text" id='new-book'>
            <a href="#" class='btn' id='submit-book'><img src='/img/done.png'></a>
          </div>
        </li>
      </ul>
      <div id='list-books'>
        <ul id='list-books-first' class="nav nav-pills nav-stacked">
          <li>
            <a href='#' id='BookAll' class="listbooks" ng-click="clickToShowBook($event)">All</a>
          </li>
          <li ng-repeat="book in books">
            <a href="#" id="((book.key_id))" class="listbooks" ng-click="clickToShowBook($event)">((book.name))</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="pright books-list with-border-left">
      <ul>
        <li class='td-parent'>
          <div class='pright'>
            <div class="btn-group" id='dropdown-list-books'>
              <button class="btn dropdown-toggle" data-toggle="dropdown">
                Move to
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li ng-repeat="book in books">
                  <a href="#" class="move_to_book" id="(('book_'+ book.id))" ng-click="move_to($event)">((book.name))</a>
                </li>
              </ul>
            </div>
            <a class="btn" href="#"><img src='/img/delete.png' width='12px'></a>
          </div>
        </li>
      </ul>
      <ul id='listbookmarks' class="nav nav-pills nav-stacked">
        <li ng-repeat="bookmark in bookmarks">
          <input type="checkbox" id="((bookmark.key_id))"/>((bookmark.title))<div class="pright">((bookmark.book_name))</div>
        </li>
      </ul>
    </div>
  </div>
</div>
