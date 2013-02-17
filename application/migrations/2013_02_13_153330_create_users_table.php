<?php

class Create_Users_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
    {
        $table->create();
        $table->engine = 'InnoDB';
        $table->increments('id');
        $table->string('key_id');
        $table->string('name');
        $table->string('email');
        $table->string('password');
        $table->string('confirmation_token');
        $table->date('confirmated_at');
        $table->date('last_sign_in_at');
        $table->integer('sign_in_count');
        $table->string('last_sign_in_ip');
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
		Schema::drop('users');
		//$table->drop_column(array('name', 'email'));
	}

}
