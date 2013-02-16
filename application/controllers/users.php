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

}
