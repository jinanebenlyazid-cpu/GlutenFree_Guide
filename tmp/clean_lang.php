<?php

$files = [
    'lang/ar.json',
    'lang/en.json',
    'lang/es.json',
    'lang/fr.json'
];

$projet_base = 'c:/Users/DELL 7400/Documents/projet/GuideGlutenFree/';

// 1. Load all keys
$all_keys = [];
$data_map = [];

foreach ($files as $file) {
    $path = $projet_base . $file;
    if (!file_exists($path)) continue;
    $data = json_decode(file_get_contents($path), true);
    if ($data) {
        $data_map[$file] = $data;
        $all_keys = array_unique(array_merge($all_keys, array_keys($data)));
    }
}

// 2. Harmonize
foreach ($files as $file) {
    $path = $projet_base . $file;
    $existing_data = $data_map[$file] ?? [];
    $new_data = [];
    
    foreach ($all_keys as $key) {
        // If key exists in this file, use it.
        // Otherwise, if it exists in fr.json (often the key itself), use that as fallback if it's the key.
        // Or just use the key itself.
        if (isset($existing_data[$key])) {
            $new_data[$key] = $existing_data[$key];
        } else {
            $new_data[$key] = $key; // Fallback to key itself
        }
    }
    
    ksort($new_data);
    $new_content = json_encode($new_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    file_put_contents($path, $new_content);
    echo "Harmonized $file. Total keys: " . count($new_data) . "\n";
}
