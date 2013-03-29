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
        $table->string('password')->nullable();
        $table->string('confirmation_token')->nullable();
        $table->date('confirmated_at')->nullable();
        $table->date('last_sign_in_at')->nullable();
        $table->integer('sign_in_count');
        $table->string('last_sign_in_ip');
        $table->boolean('can_reset_password');
        $table->date('expired_at')->nullable();
        $table->timestamps();
        $table->index('key_id');
        $table->integer('remember_token')->nullable();
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
