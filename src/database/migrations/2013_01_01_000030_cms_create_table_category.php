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
        Schema::create('category', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            
            $table->integer('id')->unsigned();
            $table->string('lang_id', 2);
            $table->string('name');
            $table->string('slug')->nullable();
            $table->integer('sort')->unsigned()->nullable();
            $table->json('data_lang')->nullable();
            $table->json('data')->nullable();
            
            $table->foreign('lang_id', 'fk01_category')
                ->references('id')
                ->on('lang')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            
            $table->primary(['id', 'lang_id'], 'pk01_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }

}
