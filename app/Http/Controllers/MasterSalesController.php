<?php

namespace App\Http\Controllers;

use App\Exports\Templates\SalesTemplateExport;
use App\Imports\SalesImport;
use App\Models\TableC;
use App\Models\TableD;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MasterSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TableD::all()->map(function ($sales) {
            return [
                'kode_sales'      => $sales->kode_sales,
                'nama_sales'      => $sales->nama_sales,
                'area'            => $sales->prefix_area,
                'jumlah_toko'     => $sales->toko->count(),
                'total_transaksi' => $sales->total_transaksi,
            ];
        });

        return view('master-sales.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = TableC::select('area_sales')
            ->distinct()
            ->pluck('area_sales');

        return view('master-sales.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_sales' => 'required|string|max:255|unique:table_d,kode_sales',
            'nama_sales' => 'required|string|max:20',
        ]);

        // validasi format kode_sales harus diawali huruf area yang valid
        $areaValid = TableC::select('area_sales')
            ->distinct()
            ->pluck('area_sales')
            ->toArray();

        $prefix = strtoupper(substr($request->kode_sales, 0, 1));

        if (!in_array($prefix, $areaValid)) {
            return back()->with(
                'error',
                "Kode sales harus diawali dengan area yang valid: " . implode(', ', $areaValid)
            );
        }

        TableD::create($request->only('kode_sales', 'nama_sales'));

        return redirect()
            ->route('master-sales.index')
            ->with('success', 'Data sales berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sales  = TableD::findOrFail($id);
        $toko   = $sales->toko;
        $area   = $sales->areaToko();

        return view('master-sales.show', compact('sales', 'toko', 'area'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sales = TableD::findOrFail($id);
        return view('master-sales.edit', compact('sales'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_sales' => 'required|string|max:20',
        ]);

        TableD::findOrFail($id)->update([
            'nama_sales' => $request->nama_sales,
        ]);

        return redirect()
            ->route('master-sales.index')
            ->with('success', 'Data sales berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sales = TableD::findOrFail($id);

        // cek apakah masih ada toko aktif di sales area ini
        $adaToko = $sales->toko->isNotEmpty();

        if ($adaToko) {
            return back()->with(
                'error',
                'Sales tidak bisa dihapus karena masih memiliki toko aktif di areanya.'
            );
        }

        $sales->delete();

        return redirect()
            ->route('master-sales.index')
            ->with('success', 'Data sales berhasil dihapus.');
    }

    // upload Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        try {
            Excel::import(new SalesImport, $request->file('file'));

            return redirect()
                ->route('master-sales.index')
                ->with('success', 'Import data sales berhasil.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    // template Excel
    public function downloadTemplate()
    {
        return Excel::download(
            new SalesTemplateExport,
            'template_master_sales.xlsx'
        );
    }

    public function exportPdf()
    {
        $data = TableD::all()->map(function ($sales) {
            return [
                'kode_sales'      => $sales->kode_sales,
                'nama_sales'      => $sales->nama_sales,
                'area'            => $sales->prefix_area,
                'jumlah_toko'     => $sales->toko->count(),
                'total_transaksi' => $sales->total_transaksi,
            ];
        });

        $pdf = Pdf::loadView('master-sales.pdf', compact('data'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont'          => 'Arial',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => false,
                'dpi'                  => 150,
            ]);

        return $pdf->download('master_sales_' . now()->format('Ymd_His') . '.pdf');
    }
}
