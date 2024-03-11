<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\DataUf;

class DataController extends Controller
{
    // Get data from database and return as JSON response in the date provided by the user
    public function getData(Request $request){
        $from = $request->from;
        $to = $request->to;

        //convert date to the correct format
        $from = date('Y-m-d', strtotime($from));
        $to = date('Y-m-d', strtotime($to));

        //get year and month from  '$from' and '$to'
        $fromYear = date('Y', strtotime($from));
        $toYear = date('Y', strtotime($to));
        $fromMonth = date('m', strtotime($from));
        $toMonth = date('m', strtotime($to));

        //get data from the database from year and month
        $dataFrom = DataUf::whereYear('date', $fromYear)->whereMonth('date', $fromMonth)->get();
        $dataTo = DataUf::whereYear('date', $toYear)->whereMonth('date', $toMonth)->get();

        //if dataFrom, get data from the API
        if($dataFrom->isEmpty()){
            $dataFrom = $this->getDataFromApi($fromYear, $fromMonth);
            foreach($dataFrom as $data){
                DataUf::create([
                    'date' => $data['Fecha'],
                    'value' => $data['Valor']
                ]);
            }
            $dataFrom = DataUf::whereYear('date', $fromYear)->whereMonth('date', $fromMonth)->get();
        }
        if($dataTo->isEmpty()){
            $dataTo = $this->getDataFromApi($toYear, $toMonth);
            foreach($dataTo as $data){
                DataUf::create([
                    'date' => $data['Fecha'],
                    'value' => $data['Valor']
                ]);
            }
            $dataTo = DataUf::whereYear('date', $toYear)->whereMonth('date', $toMonth)->get();
        }

        //get data from database between the dates $from and $to
        $data = DataUf::whereBetween('date', [$from, $to])->get();

        return response()->json($data);
    }
    // Get data from the API
    public function getDataFromApi($year, $month){
        //import env variables
        $APP_API_UF = env('APP_API_UF');
        //get data from the API
        $response = Http::get('//api.cmfchile.cl/api-sbifv3/recursos_api/uf/'.$year.'/'.$month.'?apikey='.$APP_API_UF.'&formato=json');

        if($response->failed()){
            return response()->json(['error' => 'Error al obtener datos de la API'], 500);
        }
        //if response is not 200
        if($response->status() != 200){
            return response()->json(['error' => 'Error al obtener datos de la API'], 500);
        }
        //acceder al body de la respuesta
        $data = $response->body();
        //convert to json
        $data = json_decode($data, true);
        //check if key 'UFs' exists
        if(!array_key_exists('UFs', $data)){
            return response()->json(['error' => 'Error al obtener datos de la API'], 500);
        }
        $UFs = $data['UFs'];
        return $UFs;
    }
}
