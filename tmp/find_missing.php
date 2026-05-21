<?php

function stripBOM($text) {
    $bom = pack('H*','EFBBBF');
    $text = preg_replace("/^$bom/", '', $text);
    return $text;
}

$keys_raw = stripBOM(file_get_contents('tmp/keys_utf8.json'));
$keys = json_decode($keys_raw, true);
if ($keys === null) {
    die("Error decoding keys: " . json_last_error_msg());
}

$en_raw = stripBOM(file_get_contents('lang/en.json'));
$en = json_decode($en_raw, true);
if ($en === null) {
    die("Error decoding en.json: " . json_last_error_msg());
}

$missing = [];
foreach ($keys as $k) {
    if (!isset($en[$k])) {
        $missing[] = $k;
    }
}

echo json_encode($missing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
