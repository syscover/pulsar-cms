<?php

use Illuminate\Database\Seeder;
use Syscover\Admin\Models\Package;

class CmsPackageSeeder extends Seeder
{
    public function run()
    {
        Package::insert([
            ['id' => 200, 'name' => 'CMS Package', 'root' => 'cms', 'sort' => 200, 'active' => true]
        ]);
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="CmsPackageSeeder"
 */
