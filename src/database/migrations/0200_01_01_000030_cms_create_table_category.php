<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CmsCreateTableCategory extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('cms_category'))
        {
            Schema::create('cms_category', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('ix');
                $table->integer('id')->unsigned();
                $table->string('lang_id', 2);
                $table->string('name');
                $table->string('slug')->nullable();
                $table->string('section_id', 30)->nullable();
                $table->integer('sort')->unsigned()->nullable();
                $table->json('data_lang')->nullable();
                $table->json('data')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->index(['id', 'lang_id'], 'cms_category_id_lang_id_idx');
                $table->index('slug', 'cms_category_slug_idx');

                $table->foreign('lang_id', 'cms_category_lang_id_fk')
                    ->references('id')
                    ->on('admin_lang')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
                $table->foreign('section_id', 'cms_category_section_id_fk')
                    ->references('id')
                    ->on('cms_section')
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
        Schema::dropIfExists('cms_category');
    }

}
