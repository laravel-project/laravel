@layout('layouts/main')
@section('content')
  <h1>Login form</h1>
  {{ Form::open('sessions/create', 'POST', array('id' => 'login_form')); }}
    {{ Form::label('email', 'Email :'); }}
    {{ Form::text('email'); }} <br/>
    {{ Form::label('password', 'Password :'); }}
    {{ Form::password('password'); }} <br/>
    {{ Form::submit('Login', array('class' => 'btn btn-primary')); }}
  {{ Form::close(); }}
@endsection
