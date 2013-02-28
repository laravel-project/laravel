@layout('layouts/main')
@section('content')
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
    {{ Captcha::generate_view($captcha, $get_captcha) }}
    {{ Form::submit('Register!', array('class' => 'btn btn-primary')); }}
  {{ Form::close(); }}
@endsection
