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
        if(! Schema::hasTable('cms_tag'))
        {
            Schema::create('cms_tag', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id')->unsigned();
                $table->string('lang_id', 2);
                $table->string('name')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->foreign('lang_id', 'fk01_cms_tag')
                    ->references('id')
                    ->on('admin_lang')
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
        Schema::dropIfExists('cms_tag');
    }
}