<?php

class Category extends Eloquent {
  public static $timestamps = true;

	public function crawl_urls()
	{
		return $this->has_many('CrawlUrl');
	}

}
