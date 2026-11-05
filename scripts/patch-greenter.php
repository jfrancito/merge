<?php

$source = __DIR__ . '/../resources/greenter/despatch2022.xml.twig';
$target = __DIR__ . '/../vendor/greenter/greenter/packages/xml/src/Xml/Templates/despatch2022.xml.twig';

if (!file_exists($source)) {
    echo "Error: Source template file not found in: $source\n";
    exit(1);
}

$targetDir = dirname($target);
if (!is_dir($targetDir)) {
    echo "Warning: Target directory does not exist: $targetDir. Make sure composer install has completed.\n";
    exit(0);
}

if (copy($source, $target)) {
    echo "Successfully patched Greenter XML template.\n";
    exit(0);
}

echo "Error: Failed to copy template to: $target\n";
exit(1);
