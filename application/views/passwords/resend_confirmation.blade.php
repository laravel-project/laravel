@layout('layouts/main')
@section('content')
  <h2>Resend Confirmation</h2>
  {{ Form::open('process_resend_confirmation', 'POST') }}
    {{ Form::label('email', 'Email :'); }}
    {{ Form::text('email'); }} <br/>
    {{ Form::submit('send', array('class' => 'btn btn-primary')); }}
  {{ Form::close(); }}
@endsection
