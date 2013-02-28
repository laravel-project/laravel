<?php

class Base_Controller extends Controller {

  /**
   * Initialize constructor. 
   * reload all js and css. For improved performance
   * load css in header and js in footer
   */

  public function __construct()  
  {
    parent::__construct();
  }

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}

}
