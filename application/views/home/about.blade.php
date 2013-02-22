@layout('layouts/main')
@section('navigation')
<li><a href="{{ url('home')}}">Home</a></li>
<li class='active'><a href="{{ url('about') }}">About</a></li>
<li><a href="{{ url('login') }}">Login</a></li>
<li><a href="{{ url('sign_up') }}">Register</a></li>
@endsection
@section('content')
  <div>
  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMake
  </div>
@endsection
