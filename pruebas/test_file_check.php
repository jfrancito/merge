<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$request = Illuminate\Http\Request::capture();

use Illuminate\Http\UploadedFile;

// Test if $file is null or UploadedFile
$emptyFile = null;
echo "empty(\$emptyFile): " . (empty($emptyFile) ? 'yes' : 'no') . "\n";
echo "is_null(\$emptyFile): " . (is_null($emptyFile) ? 'yes' : 'no') . "\n";

$reflection = new ReflectionClass('Illuminate\Http\UploadedFile');
echo "Has isValid: " . ($reflection->hasMethod('isValid') ? 'yes' : 'no') . "\n";
echo "Has getClientOriginalName: " . ($reflection->hasMethod('getClientOriginalName') ? 'yes' : 'no') . "\n";

