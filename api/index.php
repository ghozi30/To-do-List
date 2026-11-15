<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

try {
    define('LARAVEL_START', microtime(true));

    // Setup writable storage and cache directories in /tmp for Vercel Serverless environment
    $storagePath = '/tmp/storage';
    $dirs = [
        $storagePath,
        $storagePath.'/framework',
        $storagePath.'/framework/views',
        $storagePath.'/framework/cache',
        $storagePath.'/framework/cache/data',
        $storagePath.'/framework/sessions',
        $storagePath.'/logs',
        $storagePath.'/bootstrap',
        $storagePath.'/bootstrap/cache',
    ];

    foreach ($dirs as $dir) {
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    // Redirect all writable cache & compiled view paths to /tmp
    $envOverrides = [
        'VIEW_COMPILED_PATH' => $storagePath.'/framework/views',
        'APP_SERVICES_CACHE' => $storagePath.'/bootstrap/cache/services.php',
        'APP_PACKAGES_CACHE' => $storagePath.'/bootstrap/cache/packages.php',
        'APP_CONFIG_CACHE' => $storagePath.'/bootstrap/cache/config.php',
        'APP_ROUTES_CACHE' => $storagePath.'/bootstrap/cache/routes.php',
        'APP_EVENTS_CACHE' => $storagePath.'/bootstrap/cache/events.php',
    ];

    foreach ($envOverrides as $key => $value) {
        putenv("{$key}={$value}");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }

    require __DIR__.'/../vendor/autoload.php';

    /** @var Application $app */
    $app = require_once __DIR__.'/../bootstrap/app.php';

    $app->useStoragePath($storagePath);

    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    http_response_code(500);
    echo '<pre style="font-family: monospace; background: #1a1a1a; color: #ff6b6b; padding: 20px; border-radius: 8px; overflow: auto;">';
    echo '<strong>Error:</strong> '.htmlspecialchars($e->getMessage())."\n";
    echo '<strong>File:</strong> '.htmlspecialchars($e->getFile()).':'.$e->getLine()."\n\n";
    echo '<strong>Trace:</strong>'."\n".htmlspecialchars($e->getTraceAsString());
    echo '</pre>';
}
