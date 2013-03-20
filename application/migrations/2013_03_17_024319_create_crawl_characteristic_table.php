<?php

class Create_Crawl_Characteristic_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::table('crawl_characteristics', function($table)
    {
      $table->create();
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('key_id');
      $table->integer('crawl_url_id')->unsigned();
      $table->integer('characteristic_id')->unsigned();
      $table->string('xpath');
      $table->foreign('crawl_url_id')->references('id')
        ->on('crawl_urls')->on_delete('cascade');
      $table->foreign('characteristic_id')->references('id')
        ->on('characteristics')->on_delete('cascade');
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
    Schema::drop('crawl_characteristics');
	}

}
