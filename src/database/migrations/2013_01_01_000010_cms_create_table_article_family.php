<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CmsCreateTableArticleFamily extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_family', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('id')->unsigned();
            $table->string('name');

            // 1 - Wysiwyg
            // 2 - Contentbuilder
            // 3 - TextArea
            $table->tinyInteger('editor_id')->unsigned()->nullable();
            $table->integer('field_group_id')->unsigned()->nullable();
            $table->boolean('date')->default(false);
            $table->boolean('title')->default(false);
            $table->boolean('slug')->default(false);
            $table->boolean('link')->default(false);
            $table->boolean('categories')->default(false);
            $table->boolean('sort')->default(false);
            $table->boolean('tags')->default(false);
            $table->boolean('article_parent')->default(false);
            $table->boolean('attachments')->default(false);
            $table->json('data')->nullable();

            $table->foreign('field_group_id', 'fk01_article_family')
                ->references('id')
                ->on('field_group')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_family');
    }
}