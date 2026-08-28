<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Ensure sqlite database exists on any boot
$dbDir = dirname(__DIR__) . '/database';
$dbFile = $dbDir . '/database.sqlite';
if (!is_dir($dbDir)) {
    @mkdir($dbDir, 0777, true);
}
if (!file_exists($dbFile)) {
    @touch($dbFile);
    @chmod($dbFile, 0777);
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
