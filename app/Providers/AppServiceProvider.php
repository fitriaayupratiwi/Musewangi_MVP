<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

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
                    } elseif (!Schema::hasTable('collections')) {
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
