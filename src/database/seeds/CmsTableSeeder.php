<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CmsTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->call(CmsPackageSeeder::class);
        $this->call(CmsResourceSeeder::class);
        $this->call(CmsAttachmentMimeSeeder::class);

        Model::reguard();
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="CmsTableSeeder"
 */
