<?php

class Create_Topics_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
	  Schema::table('topics', function($table)
    {
		  $table->create();
		  $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('key_id');
      $table->string('names');
      $table->integer('user_id');
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
		Schema::drop('topics');
	}

}
