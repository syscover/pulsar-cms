<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CmsCreateTableArticle extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            
            $table->integer('id')->unsigned();
            $table->string('lang_id', 2);
            $table->string('name'); // name of the article
            $table->integer('parent_article_id')->unsigned()->nullable(); // set parent article if you need group articles
            $table->integer('author_id')->unsigned();
            $table->string('section_id', 30);
            $table->integer('family_id')->unsigned()->nullable(); // element to set default article configuration
            $table->tinyInteger('status_id')->unsigned();  // 0 = draft 1 = publish
            $table->timestamp('publish');     // date when will be publish
            $table->timestamp('date')->nullable(); // date of article
            $table->string('title', 510)->nullable();
            $table->string('slug')->nullable();
            $table->string('link')->nullable();
            $table->boolean('blank')->nullable();
            $table->integer('sort')->unsigned()->nullable(); // article sort
            $table->longText('article')->nullable();
            $table->json('data_lang')->nullable();
            $table->json('data')->nullable();

            $table->foreign('lang_id', 'fk01_article')
                ->references('id')
                ->on('lang')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('author_id', 'fk02_article')
                ->references('id')
                ->on('user')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('section_id', 'fk03_article')
                ->references('id')
                ->on('section')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('family_id', 'fk04_article')
                ->references('id')
                ->on('article_family')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->primary(['id', 'lang_id'], 'pk01_article');
            $table->unique(['lang_id','slug'], 'uk01_article');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
}