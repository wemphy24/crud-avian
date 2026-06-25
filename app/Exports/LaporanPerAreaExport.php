<?php

namespace App\Exports;

use App\Models\TableA;
use App\Models\TableB;
use App\Models\TableC;
use App\Models\TableD;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class LaporanPerAreaExport implements
    FromCollection,
    WithHeadings,
    WithTitle,
    WithStyles,
    ShouldAutoSize
{
    public function collection(): Collection
    {
        return TableC::select('area_sales')
            ->distinct()
            ->get()
            ->map(function ($item) {
                $area     = $item->area_sales;
                $kodeToko = TableC::where('area_sales', $area)->pluck('kode_toko');
                $kodeLama = TableA::whereIn('kode_toko_baru', $kodeToko)
                    ->whereNotNull('kode_toko_lama')
                    ->pluck('kode_toko_lama');
                $total    = TableB::whereIn('kode_toko', $kodeToko->merge($kodeLama))
                    ->sum('nominal_transaksi');
                $sales    = TableD::byArea($area)->pluck('nama_sales')->implode(', ');

                return [
                    'area'         => 'Area ' . $area,
                    'jumlah_toko'  => $kodeToko->count(),
                    'sales'        => $sales,
                    'total'        => $total,
                ];
            });
    }

    public function headings(): array
    {
        return ['Area', 'Jumlah Toko', 'Sales', 'Total Transaksi'];
    }

    public function title(): string
    {
        return 'Laporan per Area';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
