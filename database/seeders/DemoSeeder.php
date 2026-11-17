<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\BillingNote;
use App\Models\Client;
use App\Models\ConflictCheck;
use App\Models\LegalDocument;
use App\Models\Matter;
use App\Models\ModuleSetting;
use App\Models\PortalMessage;
use App\Models\SignaturePacket;
use App\Models\User;
use App\Services\ConflictCheckService;
use App\Services\DocumentAiService;
use App\Services\EsignReadinessService;
use App\Services\MatterIntakeService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('modules') as $key => $module) {
            ModuleSetting::query()->updateOrCreate(
                ['key' => $key],
                ['enabled' => (bool) ($module['enabled'] ?? true), 'meta' => ['label' => $module['label'] ?? $key]]
            );
        }

        $super = User::query()->updateOrCreate(
            ['email' => 'superadmin@lexintake.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => UserRole::SuperAdmin,
                'title' => 'Managing Partner',
                'is_active' => true,
            ]
        );

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@lexintake.test'],
            [
                'name' => 'Firm Admin',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'title' => 'Firm Administrator',
                'is_active' => true,
            ]
        );

        $manager = User::query()->updateOrCreate(
            ['email' => 'manager@lexintake.test'],
            [
                'name' => 'Practice Manager',
                'password' => Hash::make('password'),
                'role' => UserRole::Manager,
                'title' => 'Practice Manager',
                'is_active' => true,
            ]
        );

        $staff = User::query()->updateOrCreate(
            ['email' => 'staff@lexintake.test'],
            [
                'name' => 'Intake Paralegal',
                'password' => Hash::make('password'),
                'role' => UserRole::Staff,
                'title' => 'Paralegal',
                'is_active' => true,
            ]
        );

        $demo = User::query()->updateOrCreate(
            ['email' => 'demo@lexintake.test'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
                'role' => UserRole::Demo,
                'title' => 'Demo Attorney',
                'is_demo' => true,
                'is_active' => true,
            ]
        );

        $clientUser = User::query()->updateOrCreate(
            ['email' => 'client@lexintake.test'],
            [
                'name' => 'Avery Client',
                'password' => Hash::make('password'),
                'role' => UserRole::Client,
                'title' => 'Client',
                'is_active' => true,
            ]
        );

        $existing = Client::query()->updateOrCreate(
            ['email' => 'ops@northwind.example'],
            [
                'name' => 'Northwind Holdings',
                'slug' => 'northwind-holdings',
                'company' => 'Northwind Holdings LLC',
                'type' => 'organization',
                'aliases' => ['Northwind', 'NW Holdings'],
            ]
        );

        $intake = app(MatterIntakeService::class);
        $matter = $intake->intake([
            'client_name' => 'Avery Client',
            'client_email' => 'client@lexintake.test',
            'client_phone' => '+1-555-0100',
            'client_company' => 'Avery Ventures',
            'client_type' => 'organization',
            'aliases' => ['Avery Ventures'],
            'title' => 'Avery Ventures — Series Seed Counsel',
            'practice_area' => 'corporate',
            'summary' => 'Preferred counsel for seed financing documents and investor NDAs.',
            'estimated_value' => 45000,
            'assigned_attorney_id' => $demo->id,
        ], $staff);

        $matter->client->update(['portal_user_id' => $clientUser->id]);

        $conflict = app(ConflictCheckService::class)->run(
            $matter,
            ['Northwind Holdings', 'Contoso Litigation Trust'],
            $staff
        );

        $docService = app(DocumentAiService::class);
        $engagement = $docService->draft($matter, 'engagement_letter', 'Draft engagement letter for seed financing counsel.', $demo);
        $nda = $docService->draft($matter, 'nda', 'Mutual NDA for investor diligence.', $demo);
        $docService->analyze($engagement);

        $packet = app(EsignReadinessService::class)->prepare($engagement, [
            ['name' => 'Avery Client', 'email' => 'client@lexintake.test', 'role' => 'client'],
            ['name' => 'Demo User', 'email' => 'demo@lexintake.test', 'role' => 'attorney'],
        ]);

        BillingNote::query()->create([
            'matter_id' => $matter->id,
            'user_id' => $staff->id,
            'worked_on' => now()->toDateString(),
            'hours' => 1.5,
            'activity' => 'intake',
            'narrative' => 'Completed conflict screen and prepared engagement letter AI draft for attorney review.',
            'billable' => true,
            'status' => 'submitted',
        ]);

        PortalMessage::query()->create([
            'matter_id' => $matter->id,
            'client_id' => $matter->client_id,
            'user_id' => $clientUser->id,
            'subject' => 'Documents for review',
            'body' => 'Please upload the prior NDA and cap table when convenient.',
            'direction' => 'outbound',
            'is_read' => false,
        ]);

        // Extra sample matters for dashboard density
        foreach ([
            ['Acme Robotics', 'employment', 'Employment Dispute — Noncompete'],
            ['Beacon IP Labs', 'ip', 'IP Licensing — Patent Portfolio'],
        ] as [$name, $area, $title]) {
            $intake->intake([
                'client_name' => $name,
                'client_email' => Str::slug($name).'@example.test',
                'title' => $title,
                'practice_area' => $area,
                'summary' => 'Demo seeded matter for '.$title,
                'assigned_attorney_id' => $manager->id,
            ], $admin);
        }

        unset($super, $existing, $conflict, $nda, $packet);
    }
}