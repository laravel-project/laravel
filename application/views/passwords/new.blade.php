@layout('layouts/main')
@section('content')
  <h2>Forgot Password</h2>
  {{ Form::open('process_forgot_password', 'POST') }}
    {{ Form::label('email', 'Email :'); }}
    {{ Form::text('email'); }} <br/>
    {{ Form::submit('send', array('class' => 'btn btn-primary')); }}
  {{ Form::close(); }}
@endsection
