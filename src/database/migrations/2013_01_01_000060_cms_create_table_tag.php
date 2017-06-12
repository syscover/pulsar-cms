<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CmsCreateTableTag extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('id')->unsigned();
            $table->string('lang_id', 2);
            $table->string('name')->nullable();

            $table->foreign('lang_id', 'fk01_tag')
                ->references('id')
                ->on('lang')
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
        Schema::dropIfExists('tag');
    }
}