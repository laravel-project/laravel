@layout('layouts/main')
@section('navigation')
<li><a href="{{ url('home')}}">Home</a></li>
<li><a href="{{ url('home/about') }}">About</a></li>
<li><a href="{{ url('login') }}">Login</a></li>
<li class='active'><a href="{{ url('sign_up') }}">Register</a></li>
@endsection
@section('content')
  <h2>Registration form</h2>
  {{ Form::open('users/create', 'POST', array('id' => 'registration_form')); }}
    {{ Form::label('name', 'Name :'); }}
    {{ Form::text('name'); }} <br/>
    {{ Form::label('email', 'Email :'); }}
    {{ Form::text('email'); }} <br/>
    {{ Form::label('password', 'Password :'); }}
    {{ Form::password('password'); }} <br/>
    {{ Form::label('confirmation_password', 'Confirmation Password :'); }}
    {{ Form::password('confirmation_password'); }} </br>
    {{ Form::hidden('recaptcha', base64_encode($captcha)); }}
    <img src="{{ $get_captcha }}" class='recaptcha-image img-rounded' /></br>
    {{ Form::text('recaptcha_field', '', array('placeholder' => 'please input text above..')); }} <br/>
    {{ Form::submit('Register!', array('class' => 'btn btn-primary')); }}
  {{ Form::close(); }}
@endsection
