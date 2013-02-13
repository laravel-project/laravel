<?php

class Create_Books_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
    //create book table
    Schema::create('books', function($table)
    {
      $table->create();
      $table->increments('id');
      $table->string('key_id');
      $table->string('name');
      $table->integer('user_id');
      $table->integer('article_id');
      $table->foreign('user_id')->references('id')->on('users')->on_delete('cascade');
      $table->foreign('article_id')->references('id')->on('articles')->on_delete('cascade');
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
		//
    Schema::drop('books');
	}

}
