<div id="resend_confirmation-modal" class="modal hide fade" tabindex="-1">
  <div class="modal-body">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h2>Resend Confirmation</h2>
      {{ Form::open('process_resend_confirmation', 'POST') }}
        {{ Form::label('email', 'Email :'); }}
        {{ Form::text('email'); }} <br/>
        {{ Form::submit('send', array('class' => 'btn btn-primary')); }}
      {{ Form::close(); }}
  </div>
</div>
