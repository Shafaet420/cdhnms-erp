<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Part-9.3: bind our reusable Engines as shared singletons so the same
        // Number Generator / Workflow / QR / Document engine instance is reused
        // wherever it's injected across modules.
        $this->app->singleton(\App\Engines\NumberGeneratorEngine::class);
        $this->app->singleton(\App\Engines\WorkflowEngine::class);
        $this->app->singleton(\App\Engines\QrEngine::class);
        $this->app->singleton(\App\Engines\DocumentEngine::class);
    }
}
