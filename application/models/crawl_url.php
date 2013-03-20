<?php

class Crawl_Url extends Eloquent {
  public static $timestamps = true;
  
  public function crawl_characteristics()
	{
		return $this->has_many('Crawl_Characteristic');
	}

}
