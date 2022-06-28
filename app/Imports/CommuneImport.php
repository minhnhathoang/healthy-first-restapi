<?php

namespace App\Imports;

use App\Models\Commune;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CommuneImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Commune([
            'id' => $row['id'],
            'name' => $row['name'],
            'level' => $row['level'],
            'district_id' => $row['district_id']
        ]);
    }
}
