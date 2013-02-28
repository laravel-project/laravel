@layout('layouts/main')
@section('content')
  <h2>Login form</h2>
  {{ Form::open('sessions/create', 'POST', array('id' => 'login_form')); }}
    {{ Form::label('email', 'Email :'); }}
    {{ Form::text('email'); }} <br/>
    {{ Form::label('password', 'Password :'); }}
    {{ Form::password('password'); }} <br/>
    <span>
      <input id="remember" type="checkbox" name="remember" style="float:left">      
      {{ Form::label('remember', 'Remember Me'); }}
    </span>
    </br class="clear-fix">
    <a href='{{ url('forgot_password') }}'>forgot your password?</a></br>
    {{ Form::submit('Login', array('class' => 'btn btn-primary')); }}
  {{ Form::close(); }}
@endsection
