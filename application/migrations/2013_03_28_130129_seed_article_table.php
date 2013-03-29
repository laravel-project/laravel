<?php

class Seed_Article_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
#		//seed for article
#    $now = date('Y-m-d H:i:s');
#    $titles = array('test 1', 'test 2', 'test 3', 'test 4');
#    $user_ids = count(User::all());
#    for($i=1; $i<=$user_ids; $i++){
#      foreach( $titles as $title ){
#        DB::table('articles')->insert(    
#          array(
#            'key_id' => rand(268435456, 4294967295),
#            'title' => $title,
#            'content' => 'artikel content '.$title,
#            'image' => 'http://t3.gstatic.com/images?q=tbn:ANd9GcR9fjPFssChwESaRPlbt984nBX3BzuPVE_Jn3UtfxYMKWXbkX73',
#            'status' => '',
#            'article_url' => '',
#            'user_id' => $i,
#            'created_at' => $now,
#            'updated_at' => $now
#          )
#        );
#      }
#    }
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
#		DB::table('articles')->delete();
	}

}
