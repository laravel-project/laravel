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
            <a href='#' id='BookAll' class="listbooks">All</a>
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
            </div>
            <a class="btn" href="#"><img src='/img/delete.png' width='12px'></a>
          </div>
        </li>
      </ul>
      <ul>
        <li id='listbookmarks' class="nav nav-pills nav-stacked">
        </li>
      </ul>
    </div>
  </div>
</div>
