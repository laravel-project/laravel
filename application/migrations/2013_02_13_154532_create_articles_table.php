<?php

class Create_Articles_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('articles', function($table)
    {
        $table->create();
        $table->increments('id');
        $table->string('key_id');
        $table->string('title');
        $table->string('content');
        $table->string('image');
        $table->string('status');
        $table->integer('user_id');
        $table->integer('category_id');
        $table->timestamps();
        $table->index('key_id');
        $table->foreign('user_id')->references('id')->on('users')->on_delete('cascade');
        $table->foreign('category_id')->references('id')->on('categories');
    });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('articles');
	}

}
