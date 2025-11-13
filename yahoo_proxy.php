<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');


if (!isset($_GET['ticker']) || empty($_GET['ticker'])) {
    echo json_encode(["error" => "Ticker not specified"]);
    exit;
}

$ticker = urlencode($_GET['ticker']);
$url = "https://query1.finance.yahoo.com/v8/finance/chart/$ticker?interval=1d&range=5d";

$options = [
    'http' => [
        'method' => 'GET',
        'header' => "User-Agent: Mozilla/5.0"
    ]
];
$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === FALSE) {
    error_log("Yahoo API fetch failed for ticker: $ticker");
    echo json_encode(["error" => "Failed to fetch data"]);
    exit;
}

// ✅ Return the full JSON as expected by dashboard.php
echo $response;
?>
