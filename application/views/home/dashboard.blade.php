@layout('layouts/main')
@section('navigation')
<li><a href="#">Manage Books</a></li>
<li><a href="{{ url('logout') }}">Logout</a></li>
<div id="searches-box">
  <div class="input-append">
    <input class="input-large" id="appendedInputButtons" type="text" size='12'>
    <button class="btn" type="button">Search</button>
  </div>
</div>
@endsection
@section('content')
  @include('home.content')
  <?php 
   //$dom = SimpleHtmlDom::url('http://news.okezone.com/read/2013/02/27/339/768611/beredar-dokumen-bukti-ibas-terima-usd900-ribu');
   //$href = $dom->get('article p')->first();
   
   //echo $href;
   ?>
@endsection

