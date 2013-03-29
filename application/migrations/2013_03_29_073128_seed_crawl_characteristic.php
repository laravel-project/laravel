<?php

class Seed_Crawl_Characteristic {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
    //
    //
    $now = date('Y-m-d H:i:s');
    DB::table('crawl_characteristics')->insert(
      array(
        array(
          'crawl_url_id' => '1',
          'characteristic_id' => '1',
          'key_id' => rand(268435456, 4294967295),
          'xpath' => '//h1',
          'created_at' => $now,
          'updated_at' => $now
        ),
        array(
          'crawl_url_id' => '1',
          'characteristic_id' => '2',
          'key_id' => rand(268435456, 4294967295),
          'xpath' => '//*[contains(concat( " ", @class, " " ), concat( " ", "isi_artikel", " " ))]',
          'created_at' => $now,
          'updated_at' => $now
        ),
        array(
          'crawl_url_id' => '1',
          'characteristic_id' => '4',
          'key_id' => rand(268435456, 4294967295),
          'xpath' => '//*[contains(concat( " ", @class, " " ), concat( " ", "content_in", " " ))]',
          'created_at' => $now,
          'updated_at' => $now
        )
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
    DB::table('crawl_characteristics')->delete();
	}

}
