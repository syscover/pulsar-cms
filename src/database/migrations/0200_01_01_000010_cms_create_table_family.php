<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CmsCreateTableFamily extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('cms_family'))
        {
            Schema::create('cms_family', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id')->unsigned();
                $table->string('name');

                // 1 - Wysiwyg
                // 2 - ContentBuilder
                // 3 - TextArea
                $table->tinyInteger('excerpt_editor_id')->unsigned()->nullable();
                $table->tinyInteger('article_editor_id')->unsigned()->nullable();
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

                $table->timestamps();
                $table->softDeletes();

                $table->foreign('field_group_id', 'fk01_cms_family')
                    ->references('id')
                    ->on('admin_field_group')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
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
        Schema::dropIfExists('cms_family');
    }
}