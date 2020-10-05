<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InfluxDB\Client;

class dataController extends Controller
{

    /**
     * gets temperature data
     * @return Response json data
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
     * gets sound data
     * @return Response json data
     * @throws \Exception
     */
    function getSound(){

        $client = new Client("localhost", 8086); // create new influx client and connect it
        $database = $client->selectDB('piproject');

        try {
            // call sql query to influx get data
            $result = $database->query('select * from sound ORDER BY time DESC LIMIT 20;');
            $points = $result->getPoints(); //get points out of data

            $data = json_encode($points);

            return response($data,200);
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    /**
     * gets light data
     * @return Response json data
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
