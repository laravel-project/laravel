<?php

class Seed_Category_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
    $now = date('Y-m-d H:i:s');
    DB::table('categories')->insert(
      array(
        array(
          'name' => 'Teknologi',
          'key_id' => rand(268435456, 4294967295),
          'created_at' => $now,
          'updated_at' => $now
        ),
        array(
          'name' => 'Musik',
          'key_id' => rand(268435456, 4294967295),
          'created_at' => $now,
          'updated_at' => $now
        ),
        array(
          'name' => 'Film',
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
    //
    DB::table('categories')->delete();
	}

}
