<?php

use Illuminate\Database\Seeder;
use Syscover\Admin\Models\Package;

class CmsPackageTableSeeder extends Seeder
{
    public function run()
    {
        Package::insert([
            ['id' => 13, 'name' => 'CMS Package', 'root' => 'cms', 'sort' => 13, 'active' => true]
        ]);
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="CmsPackageTableSeeder"
 */