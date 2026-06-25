<?php

namespace App\Imports;

use App\Models\TableA;
use App\Models\TableC;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class TokoImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();

        try {
            foreach ($rows as $row) {
                TableA::create([
                    'kode_toko_baru' => $row['kode_toko_baru'],
                    'kode_toko_lama' => $row['kode_toko_lama'] ?? null,
                ]);

                TableC::create([
                    'kode_toko'  => $row['kode_toko_baru'],
                    'area_sales' => $row['area_sales'],
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
