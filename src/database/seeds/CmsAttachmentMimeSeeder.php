<?php

use Illuminate\Database\Seeder;
use Syscover\Admin\Models\AttachmentMime;

class CmsAttachmentMimeSeeder extends Seeder
{
    public function run()
    {
        AttachmentMime::insert([
            ['resource_id' => 'cms-article', 'mime' => 'image/jpeg'],
            ['resource_id' => 'cms-article', 'mime' => 'image/png'],
            ['resource_id' => 'cms-article', 'mime' => 'application/pdf'],
        ]);
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="CmsAttachmentMimeSeeder"
 */