<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Exports\LaporanPerAreaExport;
use App\Exports\LaporanPerSalesExport;
use App\Models\TableA;
use App\Models\TableB;
use App\Models\TableC;
use App\Models\TableD;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        $perArea = TableC::select('area_sales')
            ->distinct()
            ->get()
            ->map(function ($item) {
                $area       = $item->area_sales;
                $kodeToko   = TableC::where('area_sales', $area)->pluck('kode_toko');
                $kodeLama   = TableA::whereIn('kode_toko_baru', $kodeToko)
                    ->whereNotNull('kode_toko_lama')
                    ->pluck('kode_toko_lama');
                $total      = TableB::whereIn('kode_toko', $kodeToko->merge($kodeLama))
                    ->sum('nominal_transaksi');
                $jumlahToko = $kodeToko->count();
                $sales      = TableD::byArea($area)->pluck('nama_sales');

                return compact('area', 'total', 'jumlahToko', 'sales');
            });

        $perSales = TableD::all()->map(function ($sales) {
            return [
                'kode_sales'      => $sales->kode_sales,
                'nama_sales'      => $sales->nama_sales,
                'area'            => $sales->prefix_area,
                'jumlah_toko'     => $sales->toko->count(),
                'total_transaksi' => $sales->total_transaksi,
            ];
        });

        return view('laporan.index', compact('perArea', 'perSales'));
    }

    public function exportSemua()
    {
        $filename = 'laporan_transaksi_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new LaporanExport, $filename);
    }

    public function exportPerArea()
    {
        $filename = 'laporan_per_area_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new LaporanPerAreaExport, $filename);
    }

    public function exportPerSales()
    {
        $filename = 'laporan_per_sales_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new LaporanPerSalesExport, $filename);
    }

    public function exportPdf()
    {
        ['perArea' => $perArea, 'perSales' => $perSales] = $this->index();

        $pdf = Pdf::loadView('laporan.pdf', compact('perArea', 'perSales'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont'   => 'Arial',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => false,
                'dpi'                  => 150,
            ]);

        $filename = 'laporan_transaksi_' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }
}
