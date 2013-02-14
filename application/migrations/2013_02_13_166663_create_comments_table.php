<?php

class Create_Comments_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('comments', function($table)
    {
      $table->create();
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('key_id');
      $table->string('content');
      $table->integer('user_id')->unsigned();
      $table->integer('article_id')->unsigned();
      $table->integer('comment_id')->unsigned();
      $table->timestamps();
      $table->index('key_id');
      $table->foreign('user_id')->references('id')->on('users')->on_delete('cascade');
      $table->foreign('comment_id')->references('id')->on('comments');
      $table->foreign('article_id')->references('id')->on('articles')->on_delete('cascade');
    });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comments');
	}

}
