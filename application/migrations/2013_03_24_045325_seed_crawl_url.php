<?php

class Seed_Crawl_Url {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
    $now = date('Y-m-d H:i:s');
    DB::table('crawl_urls')->insert(
      array(
        'url' => 'http://tekno.kompas.com/',
        'category_id' => '1',
        'key_id' => rand(268435456, 4294967295),
        'created_at' => $now,
        'updated_at' => $now
      )
    );

	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
    DB::table('crawl_urls')->delete();
	}

}
