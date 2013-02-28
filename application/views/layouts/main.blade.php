<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Instapics</title>
        {{ Asset::styles() }}
    </head>
    @if (Auth::check()) <body style="background:#000;"> @else <body> @endif
      <div class="navbar navbar-fixed-top ">
          <div class="navbar-inner">
              <div class="container">
                  <a class="brand" href="/">Instapics</a>
                   <div class="nav-collapse">
                      <ul class="nav">
                        @section('navigation')
                          {{ Navigation::menu('Home', URL::current(), url('home')); }}
                          {{ Navigation::menu('About', URL::current(), url('about')); }}
                          {{ Navigation::menu('Login', URL::current(), url('login')); }}
                          {{ Navigation::menu('Register', URL::current(), url('sign_up')); }}
                          {{ Navigation::menu('Login with facebook', URL::current(), URL::to('facebook')); }}
                        @endsection
                        @yield('navigation')
                      </ul>
                  </div><!--/.nav-collapse -->
              </div>
          </div>
        </div>
        @if (!Auth::check())
        <div class="container">
          <div class="hero-unit">
            @yield('content')
		      </div>
          <hr>
        </div> <!-- /container -->
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
                  <div class="input-append">
                  <input class="input-small" id="appendedInputButtons" type="text" size='12'>
                  <button class="btn" type="button">Search</button>
                  </div> <hr>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. <hr> 
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. 
                </div>
              </div>
            </div>
          </div>
          <footer>
          <p>&copy; Instapics 2013</p>
        </footer>
        @endif
         
        {{ Asset::scripts() }}
       
        @yield('javascript_tag')
        <script>
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
