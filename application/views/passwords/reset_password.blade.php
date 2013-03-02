@layout('layouts/main')
@section('navigation') 
@endsection
@section('content')
  <div id="reset_password-modal" class="modal hide fade" tabindex="-1" style='width: auto;'>
    <div class="modal-body">
      <h2>Reset Password</h2>
      {{ Form::open('process_reset_password', 'POST'); }}
        {{ Form::label('password', 'New password :'); }}
        {{ Form::password('password'); }} <br/>
        {{ Form::label('confirmation_password', 'New confirmation password :'); }}
        {{ Form::password('confirmation_password'); }} <br/>
        {{ Form::hidden('key_id', base64_encode(Input::get('key_id')) ); }}
        {{ Form::submit('reset password', array('class' => 'btn btn-primary')); }}
      {{ Form::close(); }}
    </div>
  </div>
  @section('javascript_tag')
    <script>
      $(document).ready(function(){
        $('#reset_password-modal').modal({
          show: true,
          backdrop: false
        })
      })
    </script>
  @endsection
@endsection
