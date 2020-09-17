<?php

use InfluxDB\Client;
require '../vendor/autoload.php';

$client = new Client("localhost", 8086);
$database = $client->selectDB('piproject');

try {
    $result = $database->query('select * from temperature ORDER BY time DESC ');
    $points = $result->getPoints();

    $data = json_encode($points);

    echo $data;
} catch (Exception $e) {
    echo $e;
}



