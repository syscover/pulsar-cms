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
            $table->tinyInteger('editor_id')->unsigned();
            $table->integer('field_group_id')->unsigned()->nullable();
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