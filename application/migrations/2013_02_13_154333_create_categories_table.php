<?php

class Create_Categories_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
	  Schema::table('categories', function($table)
    {
		  $table->create();
      $table->increments('id');
      $table->string('key_id');
      $table->string('name');
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
		Schema::drop('categories');
	}

}
