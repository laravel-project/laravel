<div id="forgot_password-modal" class="modal hide fade" tabindex="-1">
  <div class="modal-body">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h2>Forgot Password</h2>
    {{ Form::open('process_forgot_password', 'POST') }}
      {{ Form::label('email', 'Email :'); }}
      {{ Form::text('email'); }} <br/>
      {{ Form::submit('send', array('class' => 'btn btn-primary')); }}
    {{ Form::close(); }}
  </div>
</div>
