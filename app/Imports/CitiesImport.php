<?php

namespace App\Imports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\ToModel;

class CitiesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new City([
            'city' => $row[0],
            'city_ascii' => $row[1],
            'lat' => $row[2],
            'lng' => $row[3],
            'country' => $row[4],
            'iso2' => $row[5],
            'iso3' => $row[6],
            'admin_name' => $row[7],
            'capital' => $row[8],
            'population' => $row[9],
        ]);

    }
    public function chunkSize(): int
    {
        return 100; // Number of records to process at a time
    }

    public function batchSize(): int
    {
        return 100; // Number of records to insert at a time
    }
}
