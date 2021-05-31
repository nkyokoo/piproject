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
    function getTemperature(Request $request){

        $client = new Client("localhost", 8086);
        $database = $client->selectDB('piproject');

        $type = $request->input("scale");
      try {
            $result = $database->query('select * from temperature WHERE time > now() - '.$type);
            $points = $result->getPoints();

            $data = json_encode($points);
            if(sizeof($points) == 0){

                $responseData = Array(
                    "response"=>"no data",
                );
                return response(json_encode($responseData),404);

            }else{
                return response($data,200);
            }
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    /**
     * gets sound data
     * @return Response json data
     * @throws \Exception
     */
    function getSound(Request $request){

        $client = new Client("localhost", 8086); // create new influx client and connect it
        $database = $client->selectDB('piproject');
        $type = $request->input("scale");
        try {
            // call sql query to influx get data
            $result = $database->query('select * from sound WHERE time > now() - '.$type);
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
    function getLight(Request $request){

        $client = new Client("localhost", 8086);
        $database = $client->selectDB('piproject');
        $type = $request->input("scale");
        try {
            $result = $database->query('select * from light WHERE time > now() - '.$type);
            $points = $result->getPoints();

            $data = json_encode($points);

            return response($data,200);
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }
}
