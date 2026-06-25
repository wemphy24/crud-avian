<?php

namespace App\Imports;

use App\Models\TableD;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            TableD::create([
                'kode_sales' => $row['kode_sales'],
                'nama_sales' => $row['nama_sales'],
            ]);
        }
    }
}
