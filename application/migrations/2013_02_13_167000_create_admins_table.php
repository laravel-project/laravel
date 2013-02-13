<?php

class Create_Admins_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('admins', function($table)
    {
      $table->create();
      $table->increments('id');
      $table->string('key_id');
      $table->string('email');
      $table->string('password');
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
		Schema::drop('admins');
	}

}
