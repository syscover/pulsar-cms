<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;
use Syscover\Core\Services\SchemaService;

class CmsUpdateV9 extends Migration
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
        if (SchemaService::hasIndex('cms_category', 'fk01_cms_category'))
        {
            Schema::table('cms_category', function (Blueprint $table) {
                $table->renameIndex('ix02_cms_category', 'cms_category_slug_idx');
                $table->renameIndex('ix01_cms_category', 'cms_category_id_lang_id_idx');
                $table->renameIndex('fk02_cms_category', 'cms_category_section_id_fk');
                $table->dropForeign('fk01_cms_category');
            });

            \Syscover\Cms\Models\Category::where('lang_id', 'de')->update([
                'lang_id' => 1
            ]);
            \Syscover\Cms\Models\Category::where('lang_id', 'en')->update([
                'lang_id' => 2
            ]);
            \Syscover\Cms\Models\Category::where('lang_id', 'es')->update([
                'lang_id' => 3
            ]);
            \Syscover\Cms\Models\Category::where('lang_id', 'fr')->update([
                'lang_id' => 4
            ]);

            DB::select(DB::raw('UPDATE cms_category set data_lang = REPLACE(data_lang, \'"de"\', 1);'));
            DB::select(DB::raw('UPDATE cms_category set data_lang = REPLACE(data_lang, \'"en"\', 2);'));
            DB::select(DB::raw('UPDATE cms_category set data_lang = REPLACE(data_lang, \'"es"\', 3);'));
            DB::select(DB::raw('UPDATE cms_category set data_lang = REPLACE(data_lang, \'"fr"\', 4);'));

            Schema::table('cms_category', function (Blueprint $table) {
                $table->integer('lang_id')->unsigned()->change();
                $table->foreign('lang_id', 'cms_category_lang_id_fk')
                    ->references('id')
                    ->on('admin_lang')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
            });
        }

        if (SchemaService::hasIndex('cms_article', 'fk04_cms_article'))
        {
            Schema::table('cms_article', function (Blueprint $table) {
                $table->renameIndex('ix01_cms_article', 'cms_article_id_lang_id_idx');
                $table->renameIndex('ix02_cms_article', 'cms_article_slug_idx');
                $table->renameIndex('uk01_cms_article', 'cms_article_lang_id_slug_uq');

                $table->renameIndex('fk02_cms_article', 'cms_article_author_id_fk');
                $table->renameIndex('fk03_cms_article', 'cms_article_section_id_fk');
                $table->renameIndex('fk04_cms_article', 'cms_article_family_id_fk');

                $table->dropForeign('fk01_cms_article');
            });

            \Syscover\Cms\Models\Article::where('lang_id', 'de')->update([
                'lang_id' => 1
            ]);
            \Syscover\Cms\Models\Article::where('lang_id', 'en')->update([
                'lang_id' => 2
            ]);
            \Syscover\Cms\Models\Article::where('lang_id', 'es')->update([
                'lang_id' => 3
            ]);
            \Syscover\Cms\Models\Article::where('lang_id', 'fr')->update([
                'lang_id' => 4
            ]);

            DB::select(DB::raw('UPDATE cms_article set data_lang = REPLACE(data_lang, \'"de"\', 1);'));
            DB::select(DB::raw('UPDATE cms_article set data_lang = REPLACE(data_lang, \'"en"\', 2);'));
            DB::select(DB::raw('UPDATE cms_article set data_lang = REPLACE(data_lang, \'"es"\', 3);'));
            DB::select(DB::raw('UPDATE cms_article set data_lang = REPLACE(data_lang, \'"fr"\', 4);'));

            Schema::table('cms_article', function (Blueprint $table) {
                $table->integer('lang_id')->unsigned()->change();
                $table->foreign('lang_id', 'cms_article_lang_id_fk')
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
	public function down(){}
}
