@layout('layouts/main')
@section('navigation')
<li><a href="{{ url('home')}}">Home</a></li>
<li class='active'><a href="{{ url('home/about') }}">About</a></li>
<li><a href="{{ url('login') }}">Login</a></li>
<li><a href="{{ url('sign_up') }}">Register</a></li>
@endsection
@section('content')
<div class="hero-unit">
  <div>This about page</div>
</div>
@endsection
