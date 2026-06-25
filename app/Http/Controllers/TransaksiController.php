<?php

namespace App\Http\Controllers;

use App\Exports\Templates\TransaksiTemplateExport;
use App\Imports\TransaksiImport;
use App\Models\TableA;
use App\Models\TableB;
use App\Models\TableC;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TableB::query();

        // filter by area (opsional)
        if ($request->filled('area')) {
            $query->byArea($request->area);
        }

        $data  = $query->get()->map(function ($transaksi) {
            return [
                'kode_toko'         => $transaksi->kode_toko,
                'nominal_transaksi' => $transaksi->nominal_transaksi,
                'area_sales'        => $transaksi->area_sales,
                'sales'             => $transaksi->sales->pluck('nama_sales'),
            ];
        });

        $areas = TableC::select('area_sales')->distinct()->pluck('area_sales');

        return view('transaksi.index', compact('data', 'areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tokoList = TableA::with('area')->get()->map(function ($toko) {
            return [
                'kode'  => $toko->kode_toko_baru,
                'label' => $toko->kode_toko_baru . ' — Area ' . $toko->area_sales,
            ];
        });

        return view('transaksi.create', compact('tokoList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_toko'         => 'required|integer',
            'nominal_transaksi' => 'required|numeric|min:0|max:999999.99',
        ]);

        // validasi kode_toko harus ada di table_a (baru atau lama)
        $tokoAda = TableA::where('kode_toko_baru', $request->kode_toko)
            ->orWhere('kode_toko_lama', $request->kode_toko)
            ->exists();

        if (!$tokoAda) {
            return back()->with('error', 'Kode toko tidak ditemukan.');
        }

        TableB::create($request->only('kode_toko', 'nominal_transaksi'));

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $kode_toko)
    {
        $transaksi  = TableB::where('kode_toko', $kode_toko)->firstOrFail();
        $toko       = $transaksi->toko();
        $sales      = $transaksi->sales;

        return view('transaksi.show', compact('transaksi', 'toko', 'sales'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $kode_toko)
    {
        $transaksi = TableB::where('kode_toko', $kode_toko)->firstOrFail();
        $tokoList  = TableA::with('area')->get()->map(function ($toko) {
            return [
                'kode'  => $toko->kode_toko_baru,
                'label' => $toko->kode_toko_baru . ' — Area ' . $toko->area_sales,
            ];
        });

        return view('transaksi.edit', compact('transaksi', 'tokoList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $kode_toko)
    {
        $request->validate([
            'nominal_transaksi' => 'required|numeric|min:0|max:999999.99',
        ]);

        TableB::where('kode_toko', $kode_toko)->update([
            'nominal_transaksi' => $request->nominal_transaksi,
        ]);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $kode_toko)
    {
        TableB::where('kode_toko', $kode_toko)->delete();

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    // upload Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        try {
            Excel::import(new TransaksiImport, $request->file('file'));

            return redirect()
                ->route('transaksi.index')
                ->with('success', 'Import transaksi berhasil.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    // template Excel
    public function downloadTemplate()
    {
        return Excel::download(
            new TransaksiTemplateExport,
            'template_transaksi.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $query = TableB::query();

        // ikuti filter area jika ada
        if ($request->filled('area')) {
            $query->byArea($request->area);
        }

        $data = $query->get()->map(function ($transaksi) {
            return [
                'kode_toko'         => $transaksi->kode_toko,
                'nominal_transaksi' => $transaksi->nominal_transaksi,
                'area_sales'        => $transaksi->area_sales,
                'sales'             => $transaksi->sales->pluck('nama_sales'),
            ];
        });

        $area = $request->area;   // diteruskan ke view untuk info filter

        $pdf = Pdf::loadView('transaksi.pdf', compact('data', 'area'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont'          => 'Arial',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => false,
                'dpi'                  => 150,
            ]);

        return $pdf->download('transaksi_' . now()->format('Ymd_His') . '.pdf');
    }
}
