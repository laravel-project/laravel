@layout('layouts/main')
@section('navigation')
<li><a href="{{ url('logout') }}">Logout</a></li>
@endsection
@section('content')
  @include('home.content')
@endsection

