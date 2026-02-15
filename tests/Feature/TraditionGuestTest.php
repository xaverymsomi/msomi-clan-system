<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TraditionGuestTest extends TestCase
{
    use RefreshDatabase;

    public function test_traditions_page_is_accessible_by_guests(): void
    {
        $response = $this->get('/traditions');

        $response->assertStatus(200);
        $response->assertSee(__('traditions.customs_and_traditions'));
        $response->assertSee(__('auth.login'));
        $response->assertDontSee('Log Out');
    }
}
