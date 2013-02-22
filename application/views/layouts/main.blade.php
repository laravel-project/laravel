<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Instapics</title>
        {{ Asset::styles() }}
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
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
                          @endsection
                          @yield('navigation')
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container">
          <div class="hero-unit">
            @yield('content') 
		      </div>
          <hr>
          <footer>
          <p>&copy; Instapics 2013</p>
          </footer>
        </div> <!-- /container -->
        {{ Asset::scripts() }}
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
