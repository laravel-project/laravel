<div id="login-modal" class="modal hide fade" tabindex="-1">
  <div class="modal-body">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h2>Login form</h2>
      {{ Form::open('sessions/create', 'POST', array('id' => 'login_form')); }}
        {{ Form::label('email', 'Email :'); }}
        {{ Form::text('email'); }} <br/>
        {{ Form::label('password', 'Password :'); }}
        {{ Form::password('password'); }} <br/>
        <span>
          <input id="remember" type="checkbox" name="remember">      
          {{ Form::label('remember', 'Remember Me'); }}
        </span>
        </br class="clear-fix">
        <a id="forgot_password_link" href='#forgot_password-modal' data-toggle="modal">forgot your password?</a><br/>
        <a id="resend_confirmation_link" href='#resend_confirmation-modal' data-toggle="modal">resend confirmation password?</a><br/><br/>
        {{ Form::submit('Login', array('class' => 'btn btn-primary')); }}
      {{ Form::close(); }}
  </div>
</div>
