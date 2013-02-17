@layout('layouts/main')
@section('navigation')
<li class="active"><a href="{{ url('home')}}">Home</a></li>
<li><a href="{{ url('home/about') }}">About</a></li>
<li><a href="{{ url('login') }}">Login</a></li>
<li><a href="{{ url('sign_up') }}">Register</a></li>
@endsection
@section('content')
<div class="hero-unit">
    <div class="row">
        <div class="span6">
            <h1>Welcome to Instapics!</h1>
            <p>Instapics is a fun way to share photos with family and friends.</p>
            <p>Wow them with your photo-filtering abilities!</p>
            <p>Let them see what a great photographer you are!</p>
            <p><a href="about" class="btn btn-primary btn-large">Learn more &raquo;</a></p>
        </div>
      </div>
</div>
<!-- Example row of columns -->
<div class="row">
    <div class="span3">
        &nbsp;
    </div>
   </div>
@endsection
