<?php

class Create_Bookmarks_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bookmarks', function($table)
    {
		  $table->create();
		  $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('key_id');
      $table->integer('user_id');
      $table->integer('article_id');
      $table->timestamps();
      $table->index('key_id');
	  });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bookmarks');
	}

}
