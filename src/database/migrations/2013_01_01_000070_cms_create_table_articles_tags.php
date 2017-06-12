<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CmsCreateTableArticlesTags extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('articles_tags', function(Blueprint $table){
            $table->engine = 'InnoDB';
			
            $table->integer('article_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->primary(['article_id', 'tag_id'], 'pk01_articles_tags');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('articles_tags');
	}
}