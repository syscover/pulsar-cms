<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class CmsUpdateV6 extends Migration
{
    public function __construct()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('json', 'string');
    }

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if( ! Schema::hasColumn('cms_section', 'ix'))
        {
//            Schema::table('cms_article', function (Blueprint $table) {
//                $table->dropForeign('fk03_cms_article');
//            });

            Schema::table('cms_section', function (Blueprint $table) {
                $table->dropPrimary('PRIMARY');
            });

            Schema::table('cms_section', function (Blueprint $table) {
                $table->increments('ix')->first();
                $table->index('id', 'ix01_cms_section');

            });

//            Schema::table('cms_article', function (Blueprint $table) {
//                $table->foreign('section_id', 'fk03_cms_article')
//                    ->references('id')
//                    ->on('cms_section')
//                    ->onDelete('restrict')
//                    ->onUpdate('cascade');
//            });
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){}
}