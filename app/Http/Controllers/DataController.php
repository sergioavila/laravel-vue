<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{
    // Get data from database and return as JSON response in the date provided by the user
    public function getData(Request $request){
        // Get date from the request
        // $date = $request->input('date');

        // // Get data from the database
        // $data = Data::where('date', $date)->get();

        // //if data is empty create data from api and save to database
        // if($data->isEmpty()){
        //     $data = $this->createData($date);
        // }
        $data = $request;

        // Return data as JSON response
        return response()->json($data);
    }
    //create data from api and save to database
    public function createData($date){
        $data = $this->getDataFromApi($date);
        $data = Data::create($data);
        return $data;
    }

    // Get data from the API
    public function getDataFromApi($date = null)
    {
        // Make a GET request to the API
        $response = Http::get('//api.cmfchile.cl/api-sbifv3/recursos_api/uf/2024/01?apikey=362a6f81aff703b99126bdc0b11c78983c390356&formato=json');

        // Return the data from the API
        return $response->json();
    }
}
