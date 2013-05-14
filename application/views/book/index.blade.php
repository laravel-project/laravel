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
<script>
  //PLEASE FIX ME
  //$('body').css('background','grey');
  $('#add-book').hide();
  $('#toggle-add-book').click(function(){
    $('#add-book').toggle();
    $('#add-book input').focus();
  })
  $('#submit-book').click(function(){
    var newBook = $('#new-book').val();
    if (newBook != ""){
      $.ajax({
        url: 'create_book.json?book_name='+newBook,
        method: 'POST',
        success: function(result){
          $('#list-books-first').append('<li><a href="#" id="'+result[0].key_id+'" class="listbooks">'+result[0].name+'</a></li>');
          $('#add-book').hide();
          $('#add-book input').val('').val();
          $('.listbooks').click(clickToShowBook);
        }
      })
    }
  })
  
  //load books first
  $.ajax({
    url: 'all_books.json',
    success: function(results){
      var ul = $('<ul></ul>').addClass('dropdown-menu').appendTo($('#dropdown-list-books'));
      for(i=0;i<results.length;i++){
        $('#list-books-first').append('<li><a href="#" id="'+results[i].key_id+'" class="listbooks">'+results[i].name+'</a></li>');
        $('<li><a href="#" class="move_to_book" id="book_'+results[i].id+'">'+results[i].name+'</a></li>').appendTo(ul);
      }
      //click book to show books
      $('.listbooks').click(clickToShowBook);
      $('.move_to_book').click(move_to);
    }
  })
  
  
  function move_to(){
    var book_id = $(this).attr('id').split('_')[1];
    var bookmark_ids = [];
    $('input:checkbox').each(function(){
      if ($(this).prop('checked') == true){
        bookmark_ids.push($(this).attr('id'));
      }
    })
    $.ajax({
      url: 'move_to_book.json?bookmark_ids='+bookmark_ids+'&book_id='+book_id,
      success: function(status){
        location.href = 'book'
      }
    })
  }
  function clickToShowBook(){
    var id = $(this).attr('id')
    $.ajax({
      url: 'show_book.json?book_id='+id,
      success: function(results){
        $('#listbookmarks').html("");
        for(i=0;i<results.length;i++){
          $('#listbookmarks').append('<li><input type="checkbox" id="'+results[i].key_id+
            '"/>'+results[i].title+'<div class="pright">'+results[i].book_name+'</div></li>')
        }
      }
    })
  }
  
  $.ajax({
    url: 'show_book.json?book_id=BookAll',
    success: function(results){
      $('#listbookmarks').html("");
      for(i=0;i<results.length;i++){
        $('#listbookmarks').append('<li><input type="checkbox" id="'+results[i].key_id+
          '"/>'+results[i].title+'<div class="pright">'+results[i].book_name+'</div></li>')
      }
    }
  })
</script>
