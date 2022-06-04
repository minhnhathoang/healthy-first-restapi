<?php

namespace App\Imports;

use App\Models\Province;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProvinceImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Province([
            "id" => $row['id'],
            "name" => $row['name'],
            "level" => $row['level']
        ]);
    }
}
