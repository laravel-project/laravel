<?php

class Create_Projects_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('projects', function($table)
    {
		  $table->create();
		  $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('key_id');
      $table->string('name');
      $table->integer('user_id')->unsigned();
      $table->integer('article_id')->unsigned();
      $table->timestamps();
      $table->index('key_id');
      $table->index('user_id');
      $table->index('article_id');
      //$table->foreign('user_id')->references('id')->on('users')->on_delete('cascade');
      //$table->foreign('article_id')->references('id')->on('articles')->on_delete('cascade');
	  });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('projects');
	}

}
