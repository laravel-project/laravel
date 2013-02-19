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
                          @yield('navigation')
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container">
          <div class="hero-unit">
            @yield('content')
		        {{ Session::get('success') }}
		      </div>
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
