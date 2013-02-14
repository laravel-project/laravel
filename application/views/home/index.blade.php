@layout('layouts/main')
@section('navigation')
@parent
<li><a href="/about">About</a></li>
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
        <div class="span4">
            <img src="http://d2o0t5hpnwv4c1.cloudfront.net/2064_laravel/img/phones.png" alt="Instapics!" />
        </div>
    </div>
</div>
<!-- Example row of columns -->
<div class="row">
    <div class="span3">
        &nbsp;
    </div>
    <div class="span4">
        <a href="#"><img src="http://d2o0t5hpnwv4c1.cloudfront.net/2064_laravel/img/badge_ios.png" alt="Get it on iOS" /></a>
    </div>
    <div class="span4">
        <a href="#"><img src="http://d2o0t5hpnwv4c1.cloudfront.net/2064_laravel/img/badge_android.png" alt="Get it on Android" /></a>
    </div>
</div>
@endsection
