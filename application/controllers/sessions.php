<?php

class Sessions_Controller extends Base_Controller {

	public function action_index()
	{
		// code here..

		return View::make('sessions.index');
	}

}
