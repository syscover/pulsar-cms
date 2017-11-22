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
        if(! Schema::hasTable('cms_articles_categories'))
        {
            Schema::create('cms_articles_categories', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->integer('article_id')->unsigned();
                $table->integer('category_id')->unsigned();

                $table->primary(['article_id', 'category_id']);
            });
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('cms_articles_categories');
	}
}