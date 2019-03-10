<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Syscover\Core\Services\SchemaService;

class CmsUpdateV2 extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(Schema::hasColumn('cms_article', 'parent_article_id'))
        {
		    SchemaService::renameColumn('cms_article', 'parent_article_id', 'parent_id', 'INT', 10, true, true);
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){}
}
