<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production / Railway proxy (kecuali jika dijalankan di localhost / 127.0.0.1)
        if (!app()->runningInConsole()) {
            $host = request()->getHost();
            $isLocal = in_array($host, ['localhost', '127.0.0.1', '::1']) || str_ends_with($host, '.test') || str_ends_with($host, '.local');
            if (!$isLocal && (config('app.env') === 'production' || request()->header('X-Forwarded-Proto') === 'https')) {
                URL::forceScheme('https');
            }
        }
        // Auto-initialize SQLite database file if it doesn't exist
        try {
            $defaultConnection = config('database.default', 'sqlite');
            if ($defaultConnection === 'sqlite') {
                $dbPath = config('database.connections.sqlite.database');
                if ($dbPath && !str_starts_with($dbPath, ':memory:')) {
                    $dir = dirname($dbPath);
                    if (!is_dir($dir)) {
                        @mkdir($dir, 0777, true);
                    }
                    if (!file_exists($dbPath)) {
                        @touch($dbPath);
                        @chmod($dbPath, 0777);
                        Artisan::call('migrate', ['--force' => true]);
                        Artisan::call('db:seed', ['--force' => true]);
                    } elseif (!Schema::hasTable('collections') || \App\Models\Collection::count() === 0) {
                        Artisan::call('migrate', ['--force' => true]);
                        Artisan::call('db:seed', ['--force' => true]);
                    }
                }
            }
        } catch (\Throwable $e) {
            // Log or ignore to prevent boot crashing
        }
    }
}
