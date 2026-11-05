<?php
define('LARAVEL_START', microtime(true));
$_ENV['APP_ENV'] = 'production';
$_SERVER['APP_ENV'] = 'production';
putenv('APP_ENV=production');

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "config('app.key'): " . var_export(config('app.key'), true) . "\n";
echo "config('app.env'): " . var_export(config('app.env'), true) . "\n";
echo "env('APP_KEY'): " . var_export(env('APP_KEY'), true) . "\n";
echo "app()->environmentFilePath(): " . var_export($app->environmentFilePath(), true) . "\n";
echo "app()->environmentFile(): " . var_export($app->environmentFile(), true) . "\n";
