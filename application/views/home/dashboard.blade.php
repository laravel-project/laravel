@layout('layouts/main')
@section('navigation')
<li><a href="{{ url('logout') }}">Logout</a></li>
@endsection
@section('content')
<div>This is a dashboard</div>
@endsection

