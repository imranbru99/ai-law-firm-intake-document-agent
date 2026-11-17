<?php

namespace App\Providers;

use App\Models\ConflictCheck;
use App\Models\LegalDocument;
use App\Models\Matter;
use App\Policies\ConflictCheckPolicy;
use App\Policies\LegalDocumentPolicy;
use App\Policies\MatterPolicy;
use App\Services\ModuleManager;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ModuleManager::class);
    }

    public function boot(): void
    {
        Gate::policy(Matter::class, MatterPolicy::class);
        Gate::policy(ConflictCheck::class, ConflictCheckPolicy::class);
        Gate::policy(LegalDocument::class, LegalDocumentPolicy::class);
    }
}