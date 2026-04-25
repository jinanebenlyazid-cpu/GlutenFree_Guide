<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;
use App\Models\Location;
use App\Models\Recipe;

$data = [];

// Products
foreach (Product::all() as $p) {
    if ($p->name) $data[$p->name] = $p->name;
    if ($p->description) $data[$p->description] = $p->description;
    if ($p->ingredients) $data[$p->ingredients] = $p->ingredients;
}

// Locations
foreach (Location::all() as $l) {
    if ($l->name) $data[$l->name] = $l->name;
    if ($l->address) $data[$l->address] = $l->address;
    if ($l->description) $data[$l->description] = $l->description;
}

// Recipes
foreach (Recipe::all() as $r) {
    if ($r->name) $data[$r->name] = $r->name;
    if (is_array($r->ingredients)) {
        foreach ($r->ingredients as $i) $data[$i] = $i;
    }
    if (is_array($r->steps)) {
        foreach ($r->steps as $s) $data[$s] = $s;
    }
}

echo json_encode(array_values(array_filter(array_unique($data))), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
