<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>$_SERVER Variables</h2><pre>";
foreach ($_SERVER as $k => $v) {
    if (str_contains($k, 'KEY') || str_contains($k, 'APP') || str_contains($k, 'ENV') || str_contains($k, 'DB')) {
        echo "$k: " . var_export($v, true) . "\n";
    }
}
echo "</pre><h2>getenv() Variables</h2><pre>";
foreach (getenv() as $k => $v) {
    if (str_contains($k, 'KEY') || str_contains($k, 'APP') || str_contains($k, 'ENV') || str_contains($k, 'DB')) {
        echo "$k: " . var_export($v, true) . "\n";
    }
}
echo "</pre>";
