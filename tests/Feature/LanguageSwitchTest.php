<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;

class LanguageSwitchTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_switch_language_and_it_persists_in_session(): void
    {
        // Initial locale should be default (en)
        $this->get('/')->assertStatus(200);
        $this->assertEquals('en', app()->getLocale());

        // Switch to Kiswahili
        $response = $this->get(route('language.switch', 'sw'));
        $response->assertRedirect();
        $response->assertSessionHas('locale', 'sw');

        // Follow redirect and check if locale is applied
        $this->get('/')->assertStatus(200);
        $this->assertEquals('sw', app()->getLocale());

        // Switch back to English
        $response = $this->get(route('language.switch', 'en'));
        $response->assertRedirect();
        $response->assertSessionHas('locale', 'en');

        // Follow redirect and check if locale is applied
        $this->get('/')->assertStatus(200);
        $this->assertEquals('en', app()->getLocale());
    }
}
