<?php

class Seed_Books_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//seed for article
    $now = date('Y-m-d H:i:s');
    $article_ids = count(Article::all());
    for($i=1; $i<=$article_ids; $i++){
      DB::table('books')->insert(    
        array(
          'key_id' => rand(268435456, 4294967295),
          'name' => 'book '.$i,
          'user_id' => rand(1,4),
          'article_id' => $i,
          'created_at' => $now,
          'updated_at' => $now
        )
      );
    }
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('books')->delete();
	}

}
