<?php

class Passwords_Controller extends Base_Controller {

	public function action_new()
	{
		return View::make('passwords.new', array(
		  'confirmation_token' => Input::get('confirmation_token'),
		));
	}

}
