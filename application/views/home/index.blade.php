@layout('layouts/main')
@section('content')
  <div id='home' class="container frontend-layer">
    <div class="hero-unit">
      @include('home/home')
    </div>
    <hr>
  </div>
  <div id='about' class="container frontend-layer">
    <div class="hero-unit">
      @include('home/about')
    </div>
    <hr>
  </div>
  <div id='watch' class="container frontend-layer">
    <div class="hero-unit">
      @include('home/watch')
    </div>
    <hr>
  </div>
  @include('home/login-modal')
  @include('home/forgot_password-modal')
  @include('home/resend_confirmation-modal')
  @include('home/registration-modal')
@endsection
