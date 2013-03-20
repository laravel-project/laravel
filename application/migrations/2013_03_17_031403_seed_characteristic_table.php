<?php

class Seed_Characteristic_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
    //seed for characteristic
    $now = date('Y-m-d H:i:s');
    DB::table('characteristics')->insert(
      array(
        array(
          'name' => 'category',
          'key_id' => rand(268435456, 4294967295),
          'created_at' => $now,
          'updated_at' => $now
        ),
        array(
          'name' => 'title',
          'key_id' => rand(268435456, 4294967295),
          'created_at' => $now,
          'updated_at' => $now
        ),
        array(
          'name' => 'article',
          'key_id' => rand(268435456, 4294967295),
          'created_at' => $now,
          'updated_at' => $now
        ),
        array(
          'name' => 'picture',
          'key_id' => rand(268435456, 4294967295),
          'created_at' => $now,
          'updated_at' => $now
        ),
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
    DB::table('characteristics')->delete();
	}

}
