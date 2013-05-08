<?php

class Create_Collections_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
    //create book table
    Schema::table('collections', function($table)
    {
      $table->create();
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('key_id');
      $table->string('name');
      $table->integer('user_id')->unsigned();
      $table->timestamps();
      $table->index('key_id');
      $table->index('user_id');
    });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
    Schema::drop('collections');
	}


}
