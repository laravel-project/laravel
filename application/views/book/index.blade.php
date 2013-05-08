<div class="container-logged container-fluid default-color">
  <div class="row-fluid">
    <div class="span2 with-border-left">
      <table class="table">
        <tr>
          <th>My Books</th>
          <td>
            <div class='pright'>
              <a href="#" id='toggle-add-book'><img src='/img/add.png'></a>
            </div>
          </td>
        </tr>
        <tr id='add-book'>
          <td colspan='2'>
            <div class="input-append">
            <input class="input-medium" type="text" id='new-book'>
            <a href="#" class='btn' id='submit-book'><img src='/img/done.png'></a>
          </div>
          <td>
        </tr>
      </table>
      <div id='list-books'>
        <ul>
          <li>test</li>
          <li>test</li>
          <li>test</li>
          <li>test</li>
        </ul>
      </div>
    </div>
    <div class="pright books-list with-border-left">
      <table class="table">
        <tr>
          <td colspan='2' class='td-parent'>
            <div class='pright'>
              <div class="btn-group">
                <button class="btn dropdown-toggle" data-toggle="dropdown">
                Move to
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li>bola</li>
                  <li>teknologi</li>
                  <li>komputer</li>
                </ul>
              </div>
              <a class="btn" href="#"><img src='/img/delete.png' width='12px'></a>
            </div>
          </td>
        </tr>
        <tr ng-repeat="book in books">
          <td width='20px'><input type="checkbox"></td>
          <td>((book.title))</td>
        </tr>
      </table>
    </div>
  </div>
</div>
<script>
  //PLEASE FIX ME
  $('body').css('background','grey');
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
        success: function(res){
          $('#list-books li:first').prepend('<li>'+res+'</li>');
          $('#add-book').hide();
          $('#add-book input').val('').val();
        }
      })
    }
  })
</script>
