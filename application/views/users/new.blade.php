@layout('layouts/main')
@section('content')
  <h1>Registration form</h1>
  {{ Form::open('users/create', 'POST', array('id' => 'registration_form')); }}
    {{ Form::label('name', 'Name :'); }}
    {{ Form::text('name'); }} <br/>
    {{ Form::label('email', 'Email :'); }}
    {{ Form::text('email'); }} <br/>
    {{ Form::label('password', 'Password :'); }}
    {{ Form::password('password'); }} <br/>
    {{ Form::label('confirmation_password', 'Confirmation Password :'); }}
    {{ Form::password('confirmation_password'); }} </br>
    {{ Form::submit('Register!'); }}
  {{ Form::close(); }}
@endsection
