<?php

class CrawlUrl extends Eloquent {
  public static $timestamps = true;
  public static $table = 'crawl_urls';
  

  public function category()
  {
    return $this->belongs_to('Category');
  }
  
  public function crawl_characteristics()
	{
		return $this->has_many('CrawlCharacteristic', 'crawl_url_id');
	}

}
