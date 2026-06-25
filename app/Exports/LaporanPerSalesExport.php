<?php

namespace App\Exports;

use App\Models\TableD;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class LaporanPerSalesExport implements
    FromCollection,
    WithHeadings,
    WithTitle,
    WithStyles,
    ShouldAutoSize
{
    public function collection(): Collection
    {
        return TableD::all()->map(function ($sales) {
            return [
                'kode_sales'      => $sales->kode_sales,
                'nama_sales'      => $sales->nama_sales,
                'area'            => 'Area ' . $sales->prefix_area,
                'jumlah_toko'     => $sales->toko->count(),
                'total_transaksi' => $sales->total_transaksi,
            ];
        });
    }

    public function headings(): array
    {
        return ['Kode Sales', 'Nama Sales', 'Area', 'Jumlah Toko', 'Total Transaksi'];
    }

    public function title(): string
    {
        return 'Laporan per Sales';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
