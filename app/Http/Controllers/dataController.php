<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use InfluxDB\Client;

class dataController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    function getTemperature(){

        $client = new Client("localhost", 8086);
        $database = $client->selectDB('piproject');

        try {
            $result = $database->query('select * from temperature ORDER BY time DESC LIMIT 20;');
            $points = $result->getPoints();

            $data = json_encode($points);

            return response($data,200);
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    function getSound(){

        $client = new Client("localhost", 8086);
        $database = $client->selectDB('piproject');

        try {
            $result = $database->query('select * from sound ORDER BY time DESC LIMIT 20;');
            $points = $result->getPoints();

            $data = json_encode($points);

            return response($data,200);
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    function getLight(){

        $client = new Client("localhost", 8086);
        $database = $client->selectDB('piproject');

        try {
            $result = $database->query('select * from light ORDER BY time DESC LIMIT 20;');
            $points = $result->getPoints();

            $data = json_encode($points);

            return response($data,200);
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }
}
