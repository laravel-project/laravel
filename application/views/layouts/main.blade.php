<!DOCTYPE html>
<html ng-app="laravel">
    <head>
        <meta charset="utf-8">
        <title>Instapics</title>
        {{ Asset::styles() }}
    </head>
    @if (Auth::check()) <body style="background:#212121;"> @else <body> @endif
      <div class="navbar navbar-fixed-top">
          <div class="navbar-inner">
              <div class="container">
                   <div class="nav-collapse">
                      <ul class="nav">
                        @section('navigation')
                          <li><a id='scrolltoHome' class="brand" href="javascript:void(0);">Instapics</a></li>
                          <li><a id='scrolltoAbout' href='javascript:void(0);'>About</a></li>
                          <li><a id='scrolltoWatch' href='javascript:void(0);'>Watch</a></li>
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
          @if (Auth::User()->topics == null)
            <div class='layer-overflow'>
              <div class='modal-dialog-created'>
                <h2>hello {{ Auth::User()->name }}</h2>
                <p> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque a</p>
                <p> please add topic the topic article you want to read</p>
                <div ng-controller="TodoCtrl">
                  <span>(( remaining() )) of (( todos.length )) remaining</span>
                  [ <a href="" ng-click="archive()">remove</a> ]
                  <form action="{{ url('home/create_topic') }}" method="POST">
                    <ul class="unstyled">
                      <li ng-repeat="todo in todos">
                        <input type="checkbox" ng-model="todo.done">
                        <span class="done-(( todo.done ))">(( todo.text ))</span>
                        <input type="hidden" name="topics[]" value="(( todo.text ))">
                      </li>
                    </ul>
                    <input type="text" ng-model="todoText" size="30" placeholder="add new todo here">
                    <input class="btn-primary" type="button" value="add" ng-disabled="!todoText" ng-click="addTodo()"></br>
                    {{ Form::submit('Submit Topic', array('class' => 'btn btn-primary')); }}
                  </form>
                </div>
              </div>
            </div>
          @else
            @yield('content')
          @endif
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
