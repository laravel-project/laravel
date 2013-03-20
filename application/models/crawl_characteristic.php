<?php

class Crawl_Characteristic extends Eloquent {

	public function characteristic()
	{
		return $this->belongs_to('Characteristic');
	}

	public function crawl_url()
	{
		return $this->belongs_to('Crawl_Url');
	}

}
