<?php

class CrawlCharacteristic extends Eloquent {
  public static $timestamps = true;
  public static $table = 'crawl_characteristics';

	public function characteristic()
	{
		return $this->belongs_to('Characteristic');
	}

	public function crawl_url()
	{
		return $this->belongs_to('CrawlUrl');
	}
  
  //this method to retrieve xpath specified url and characteristic
  public static function get_xpath_by_url_and_characteristic($url_id, $char_id)
  {
    return CrawlCharacteristic::with('crawl_url')
      ->where('crawl_url_id', '=', $url_id)
      ->where('characteristic_id', '=', $char_id)->select('xpath')->first()->xpath;
  }

}
