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
        if(! Schema::hasTable('cms_section'))
        {
            Schema::create('cms_section', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('ix');
                $table->string('id', 30);
                $table->string('name');
                $table->integer('family_id')->unsigned()->nullable();
                $table->json('attachment_families')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->foreign('family_id', 'fk01_cms_section')
                    ->references('id')
                    ->on('cms_family')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->index('id', 'ix01_cms_section');
                $table->unique('id', 'ui01_cms_section');
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
        Schema::dropIfExists('cms_section');
    }
}