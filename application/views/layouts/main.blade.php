<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Instapics</title>
        {{ Asset::styles() }}
    </head>
    @if (Auth::check()) <body style="background:#000;"> @else <body> @endif
      <div class="navbar navbar-fixed-top">
          <div class="navbar-inner">
              <div class="container">
                  <a class="brand" href="/">Instapics</a>
                   <div class="nav-collapse">
                      <ul class="nav">
                        @section('navigation')
                          <li><a href='#home'>Home</a></li>
                          <li><a href='#about'>About</a></li>
                          <li><a href='#watch'>Watch</a></li>
                          <li><a href="#login-modal" data-toggle="modal">Login</a></li>
                          <li><a id="registration_captcha" href="#registration-modal" data-toggle="modal">Sign up</a></li>
                          {{ Navigation::menu('Login with facebook', URL::current(), URL::to('facebook')); }}
                        @endsection
                        @yield('navigation')
                      </ul>
                  </div><!--/.nav-collapse -->
              </div>
          </div>
        </div>
        <div class='clear'></div>
        @if (!Auth::check())
          @yield('content')
          <footer>
            <p>&copy; Instapics 2013</p>
          </footer>
          <div class='clear'></div>
        @else
          <div class="container-logged container-fluid">
            <div class="row-fluid">
              <div class="span10">
                @yield('content')
              </div>
              <div class="span2 sidebar-content">
                <div style="position: fixed;">
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. <hr> 
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. 
                </div>
              </div>
            </div>
          </div>
        @endif
        {{ Asset::scripts() }}
       
        @yield('javascript_tag')
        <script>
        
          //this is function for showing bootsrap popup modal
          //only use on javascript
          {{ Modal::show_after_failed('login') }}
          {{ Modal::show_after_failed('forgot_password') }}
          {{ Modal::show_after_failed('resend_confirmation') }}
          {{ Modal::show_after_failed('registration') }}
          
          $('#forgot_password_link, #resend_confirmation_link').click(function(){ $('#login-modal').modal('hide') })
          @if (count($errors->all() > 1))
            @foreach ($errors->all() as $error)
              $().toastmessage('showErrorToast', "{{ $error }}");
            @endforeach
          @endif
          @if (Session::get('failed'))
            $().toastmessage('showErrorToast', "{{ Session::get('failed') }}")
          @endif
          @if (Session::get('success'))
            $().toastmessage('showSuccessToast', "{{ Session::get('success') }}")
          @endif
        </script>
    </body>
</html>
