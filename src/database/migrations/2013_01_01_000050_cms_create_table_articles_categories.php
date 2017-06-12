<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CmsCreateTableArticlesCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('articles_categories', function(Blueprint $table){
            $table->engine = 'InnoDB';
			
            $table->integer('article_id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->primary(['article_id', 'category_id'], 'pk01_articles_categories');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('articles_categories');
	}
}