<?php

class Book_Controller extends Base_Controller {
 
  public function __construct()
  {
    $this->filter('before', 'auth');
  }


	public function action_index()
	{
		return View::make('home.dashboard', array('layout' => 'book'));
	}

  public function action_bookmark()
  {
    $data = array();
    $user_id = Auth::User()->id;
    $bookmarks = Bookmark::where('user_id', '=', $user_id)->get();
    foreach($bookmarks as $bookmark){
      array_push($data, array(
        'key_id' => $bookmark->key_id,
        'title' => $bookmark->article->title
      ));
    }
    return Response::json($data);
 
  }

  private function action_auth()
  {
    if (!Auth::check())
    {
      return Redirect::to('login');
    }
  }


}
