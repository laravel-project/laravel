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

}
