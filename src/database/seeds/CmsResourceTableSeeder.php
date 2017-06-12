<?php

use Illuminate\Database\Seeder;
use Syscover\Admin\Models\Resource;

class CmsResourceTableSeeder extends Seeder {

    public function run()
    {
        Resource::insert([
            ['id' => 'cms',                 'name' => 'CMS Package',        'package_id' => 13],
            ['id' => 'cms-article',         'name' => 'Articles',           'package_id' => 13],
            ['id' => 'cms-article-family',  'name' => 'Article families',   'package_id' => 13],
            ['id' => 'cms-category',        'name' => 'Categories',         'package_id' => 13],
            ['id' => 'cms-section',         'name' => 'Sections',           'package_id' => 13]
        ]);
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="CmsResourceTableSeeder"
 */