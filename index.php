<?php
header('Content-Type: application/json');

// Функция для выполнения HTTP-запроса и получения содержимого страницы
function fetchPageContent($url) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}

// Функция для парсинга HTML и получения ссылки с нужным классом
function extractLink($htmlContent) {
    $dom = new DOMDocument();
    @$dom->loadHTML($htmlContent); // @ используется для подавления предупреждений об ошибках парсинга

    $xpath = new DOMXPath($dom);
    $link = $xpath->query("//a[contains(@class, 'day tinted')]")->item(0);

    return $link ? $link->getAttribute('href') : null;
}

$url = 'https://mrk-bsuir.by/ru/schedule/';
$htmlContent = fetchPageContent($url);
$link = extractLink($htmlContent);

$response = [
    'url' => 'https://mrk-bsuir.by/'.$link
];

echo json_encode($response);
