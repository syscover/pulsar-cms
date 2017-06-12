<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CmsCreateTableSection extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            
            $table->string('id', 30);
            $table->string('name');
            $table->integer('article_family_id')->unsigned()->nullable();

            $table->foreign('article_family_id', 'fk01_section')
                ->references('id')
                ->on('article_family')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            
            $table->primary('id', 'pk01_section');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section');
    }
}