<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class CmsUpdateV5 extends Migration
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
        if(Schema::hasColumn('cms_articles_categories', 'article_id'))
        {
            Schema::table('cms_articles_categories', function (Blueprint $table) {
                $table->renameColumn('article_id', 'article_object_id');
                $table->renameColumn('category_id', 'category_object_id');
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