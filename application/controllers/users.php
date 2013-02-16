<?php

class Users_Controller extends Base_Controller {

	public function action_index()
	{
		// code here..

		return View::make('users.index');
	}

  public function action_new()
  {
    return View::make('users.new');
  }
  
  public function post_create()
  {
    //erroor;
    $input = Input::all();
    //var_dump $input
  }
}
