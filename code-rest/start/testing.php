<?php

require __DIR__.'/vendor/autoload.php';

use Guzzle\Http\Client;


//$request = $client->get('/api/programmers/'.$nickname);
//$response = $request->send();

// 3) GET a list of all programmers
$request = $client->get('/api/programmers');
$response = $request->send();

echo $response;
echo "\n\n";

