<div id="registration-modal" class="modal hide fade" tabindex="-1">
  <div class="modal-body" style='max-height: 500px'>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h2>Registration form</h2>
    {{ Form::open('users/create', 'POST', array('id' => 'registration_form')); }}
      {{ Form::label('name', 'Name :'); }}
      {{ Form::text('name', $name); }} <br/>
      {{ Form::label('email', 'Email :'); }}
      {{ Form::text('email', $email); }} <br/>
      {{ Form::label('password', 'Password :'); }}
      {{ Form::password('password'); }} <br/>
      {{ Form::label('confirmation_password', 'Confirmation Password :'); }}
      {{ Form::password('confirmation_password'); }} </br>
      <div id='add_captcha'></div>
      {{ Form::submit('Register!', array('class' => 'btn btn-primary')); }}
    {{ Form::close(); }}
  </div>
</div>
@section('javascript_tag')
  <script>
    $.ajax({
    url: "{{ url('get_captcha') }}",
      success: function(captcha){
        $('#add_captcha').append(captcha)
      }
    });
  </script>
@endsection
