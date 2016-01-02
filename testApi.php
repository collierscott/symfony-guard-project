<?php

require __DIR__.'/vendor/autoload.php';

$client = new GuzzleHttp\Client();

$res = $client->get('http://localhost:8000/secure', [
    'allow_redirects' => false,
    'http_errors' => false,
    'headers' => [
        // token for user scott
        'X-AUTH-TOKEN' => 'DkE3KWIXPt6bnzZl6lcTt682WLhWYnLYjTeNyiZqgPJiHoEkjTtx03ECCnW1'
    ]
]);

//var_dump($res);

echo sprintf("Status Code: %s\n\n", $res->getStatusCode());
echo $res->getBody();
echo "\n\n";
