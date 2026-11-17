<?php

namespace Tests\Feature;

use App\Services\ModuleManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModuleToggleTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_lists_modules(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('AI Law Firm Intake');
        $response->assertSee('Conflict Check');
    }

    public function test_module_manager_can_toggle(): void
    {
        $manager = app(ModuleManager::class);
        $manager->toggle('billing_notes', false);

        $this->assertFalse($manager->enabled('billing_notes'));
    }
}