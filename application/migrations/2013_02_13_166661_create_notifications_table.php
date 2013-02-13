<?php

class Create_Notifications_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function($table)
    {
      $table->create();
      $table->increments('id');
      $table->string('key_id');
      $table->integer('user_id');
      $table->integer('comment_id');
      $table->foreign('user_id')->references('id')->on('users')->on_delete('cascade');
      $table->foreign('comment_id')->references('id')->on('comments')->on_delete('cascade');
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
		Schema::drop('notifications');
	}

}
