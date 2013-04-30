@layout('layouts/main')
@section('content')
  <div id='home' class="container frontend-layer">
    <div class="hero-unit">
      @include('content/home')
    </div>
    <hr>
  </div>
  <div id='about' class="container frontend-layer">
    <div class="hero-unit">
      @include('content/about')
    </div>
    <hr>
  </div>
  <div id='watch' class="container frontend-layer">
    <div class="hero-unit">
      @include('content/watch')
    </div>
    <hr>
  </div>
  @include('modal/login-modal')
  @include('modal/forgot_password-modal')
  @include('modal/resend_confirmation-modal')
  @include('modal/registration-modal')
@endsection
