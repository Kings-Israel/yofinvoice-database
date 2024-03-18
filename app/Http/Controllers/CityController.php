<?php

namespace App\Http\Controllers;

use App\Imports\CitiesImport;
use App\Models\Bank;
use App\Models\City;
use Maatwebsite\Excel\Facades\Excel;

class CityController extends Controller
{
    public function importCities()
    {
        $file = resource_path('excel/worldcities.xlsx');

        Excel::import(new CitiesImport, $file);

        return response()->json("Upload successful");
    }
    public function getCountries()
    {
        return response()->json(City::distinct('country')->pluck('country'));
    }
    public function getCounties($country)
    {
        return response()->json(City::whereCountry($country)->pluck('city'));
    }
    public function getCountryCities()
    {
        info(Bank::with('requiredDocuments')->toRawSql());
        return response()->json(Bank::select('id', 'name')->withCount('requiredDocuments')->get());
    }
}
