<?php

namespace App\Imports;

use App\Models\TableB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransaksiImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            TableB::create([
                'kode_toko'         => $row['kode_toko'],
                'nominal_transaksi' => $row['nominal_transaksi'],
            ]);
        }
    }
}
