<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CmsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetProfiles()
    {

        $response = $this->json('GET', route('profile'));

        $response->assertStatus(200);
    }
}
