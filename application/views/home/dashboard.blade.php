@layout('layouts/main')
@section('navigation')
<li><a href="#">Manage Books</a></li>
<li><a href="{{ url('logout') }}">Logout</a></li>
<div id="searches-box">
  <div class="input-append">
    <input class="input-large" id="find_my_articles" type="text" size='12'>
    <button class="btn" type="submit" id="search_my_articles">Search</button>
  </div>
</div>
@endsection
@section('content')
  @include('home.content')
@endsection

