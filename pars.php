<?php

$html = file_get_contents(__DIR__ . '/1.html');

$dom = new DOMDocument();

// Явно укажем кодировку в начале
libxml_use_internal_errors(true); // чтобы не показывать ворнинги
$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
libxml_clear_errors();

$xpath = new DOMXPath($dom);

$items = $xpath->query('//li[contains(@class,"select2-results__option")]');

$data = [];

foreach ($items as $item) {
    $data[] = trim($item->nodeValue);
}

// Запишем в UTF-8, массив уже в UTF-8
file_put_contents('components.csv', implode("\n", $data));

echo "Extracted " . count($data) . " components.\n";
