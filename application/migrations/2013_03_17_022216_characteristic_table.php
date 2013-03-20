<?php

class Characteristic_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('characteristics', function($table)
    {
      $table->create();
      $table->engine = 'InnoDB';
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
    Schema::drop('characteristics');
	}

}
