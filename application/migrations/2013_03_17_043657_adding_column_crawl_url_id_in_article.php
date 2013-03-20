<?php

class Adding_Column_Crawl_Url_Id_In_Article {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
    //
    Schema::table('articles', function($table)
    {
      $table->integer('crawl_url_id')->unsigned();
      $table->foreign('crawl_url_id')->references('id')->on('crawl_urls');
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
    	Schema::table('articles', function($table)
    {
      $table->drop_column('crawl_url_id');
    });
	}

}
