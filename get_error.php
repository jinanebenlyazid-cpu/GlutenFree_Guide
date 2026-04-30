<?php
$lines = file('storage/logs/laravel.log');
$errorLines = [];
foreach ($lines as $line) {
    if (strpos($line, 'local.ERROR') !== false) {
        $errorLines[] = $line;
    }
}
echo array_pop($errorLines);
