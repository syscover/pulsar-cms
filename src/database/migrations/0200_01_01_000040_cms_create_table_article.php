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
        if(! Schema::hasTable('cms_article'))
        {
            Schema::create('cms_article', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('ix');
                $table->integer('id')->unsigned();
                $table->string('lang_id', 2);
                $table->string('name');                                                     // name of the article
                $table->integer('parent_id')->unsigned()->nullable();                       // set parent article if you need group articles
                $table->integer('author_id')->unsigned();
                $table->string('section_id', 30);
                $table->integer('family_id')->unsigned()->nullable();                       // element to set default article configuration
                $table->tinyInteger('status_id')->unsigned();                               // 0 = draft 1 = publish
                $table->timestamp('publish')->default(DB::raw('CURRENT_TIMESTAMP'));        // date when will be publish
                $table->timestamp('date')->nullable();                                      // date of article
                $table->string('title', 510)->nullable();
                $table->string('slug')->nullable();
                $table->string('link')->nullable();
                $table->boolean('blank')->default(false);
                $table->json('tags')->nullable();
                $table->integer('sort')->unsigned()->nullable();                            // article sort
                $table->text('excerpt')->nullable();
                $table->longText('article')->nullable();
                $table->json('data_lang')->nullable();
                $table->json('data')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->index(['id', 'lang_id'], 'cms_article_id_lang_id_idx');
                $table->index('slug', 'cms_article_slug_idx');
                $table->unique(['lang_id', 'slug'], 'cms_article_lang_id_slug_uq');

                $table->foreign('lang_id', 'cms_article_lang_id_fk')
                    ->references('id')
                    ->on('admin_lang')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
                $table->foreign('author_id', 'cms_article_author_id_fk')
                    ->references('id')
                    ->on('admin_user')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
                $table->foreign('section_id', 'cms_article_section_id_fk')
                    ->references('id')
                    ->on('cms_section')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
                $table->foreign('family_id', 'cms_article_family_id_fk')
                    ->references('id')
                    ->on('cms_family')
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
        Schema::dropIfExists('cms_article');
    }
}
