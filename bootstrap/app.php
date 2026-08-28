<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// 1. Ensure SQLite database file exists in multiple locations
$dbFiles = [
    dirname(__DIR__) . '/database/database.sqlite',
    '/var/www/html/database/database.sqlite',
    '/tmp/database.sqlite',
];

foreach ($dbFiles as $file) {
    $dir = dirname($file);
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    if (!file_exists($file)) {
        @touch($file);
        @chmod($file, 0777);
    }
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
