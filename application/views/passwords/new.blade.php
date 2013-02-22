@layout('layouts/main')
@section('content')
  <h2>Forgot Password</h2>
  {{ Form::open('passwords/create', 'POST') }}
    {{ Form::label('email', 'Email :'); }}
    {{ Form::text('email'); }} <br/>
    {{ Form::submit('send', array('class' => 'btn btn-primary')); }}
  {{ Form::close(); }}
@endsection
