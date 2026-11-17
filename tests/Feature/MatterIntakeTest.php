<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use App\Services\MatterIntakeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatterIntakeTest extends TestCase
{
    use RefreshDatabase;

    public function test_intake_creates_matter_and_client(): void
    {
        $user = User::factory()->create(['role' => UserRole::Staff]);

        $matter = app(MatterIntakeService::class)->intake([
            'client_name' => 'Test Client LLC',
            'client_email' => 'test.client@example.test',
            'title' => 'Test Matter',
            'practice_area' => 'corporate',
            'summary' => 'Unit test matter',
        ], $user);

        $this->assertDatabaseHas('matters', ['matter_number' => $matter->matter_number]);
        $this->assertDatabaseHas('clients', ['email' => 'test.client@example.test']);
    }
}