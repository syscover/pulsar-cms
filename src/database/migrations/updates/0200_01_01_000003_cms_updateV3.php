<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class CmsUpdateV3 extends Migration
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
        if( ! Schema::hasColumn('cms_category', 'obj_id'))
        {
            Schema::table('cms_category', function (Blueprint $table) {
                $table->dropPrimary('PRIMARY');
                $table->renameColumn('id', 'obj_id');
            });

            Schema::table('cms_category', function (Blueprint $table) {
                $table->increments('id')->first();
                $table->index(['obj_id', 'lang_id'], 'ix01_cms_category');
            });
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){}
}