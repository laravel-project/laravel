@layout('layouts/main')
@section('navigation')
<li><a href="{{ url('home')}}">Home</a></li>
<li><a href="{{ url('about') }}">About</a></li>
<li class='active'><a href="{{ url('login') }}">Login</a></li>
<li><a href="{{ url('sign_up') }}">Register</a></li>
@endsection
@section('content')
  <h2>Login form</h2>
  {{ Form::open('sessions/create', 'POST', array('id' => 'login_form')); }}
    {{ Form::label('email', 'Email :'); }}
    {{ Form::text('email'); }} <br/>
    {{ Form::label('password', 'Password :'); }}
    {{ Form::password('password'); }} <br/>
    {{ Form::submit('Login', array('class' => 'btn btn-primary')); }}
  {{ Form::close(); }}
@endsection
