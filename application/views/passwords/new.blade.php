@layout('layouts/main')
@section('content')
  <h2>Login form</h2>
  {{ Form::open('sessions/create', 'POST', array('id' => 'login_form')); }}
    {{ Form::label('email', 'Email :'); }}
    {{ Form::text('email'); }} <br/>
    {{ Form::label('password', 'Password :'); }}
    {{ Form::password('password'); }} <br/>
    <a href='{{ url('forgot_password') }}'>forgot your password?</a></br>
    {{ Form::submit('Login', array('class' => 'btn btn-primary')); }}
  {{ Form::close(); }}
@endsection
