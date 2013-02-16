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
                            <li class="active"><a href="{{ url('home')}}">Home</a></li>
                            <li><a href="{{ url('home/about') }}">About</a></li>
                            <li><a href="{{ url('login') }}">Login</a></li>
                            <li><a href="{{ url('sign_up') }}">Register</a></li>

                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container">
          @yield('content')
		      {{ Session::get('success') }}
          <hr>
          <footer>
          <p>&copy; Instapics 2012</p>
          </footer>
        </div> <!-- /container -->
        {{ Asset::scripts() }}
        <script>
          @if (count($errors->all() > 1))
            @foreach ($errors->all() as $error)
              $().toastmessage('showErrorToast', "{{ $error }}");
            @endforeach
          @endif
        </script>
    </body>
</html>
