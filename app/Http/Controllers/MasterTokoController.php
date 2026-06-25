<?php

namespace App\Http\Controllers;

use App\Exports\Templates\TokoTemplateExport;
use App\Imports\TokoImport;
use App\Models\TableA;
use App\Models\TableC;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class MasterTokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TableA::with('area')->get()->map(function ($toko) {
            return [
                'kode_toko_baru' => $toko->kode_toko_baru,
                'kode_toko_lama' => $toko->kode_toko_lama,
                'area_sales'     => $toko->area_sales,
            ];
        });
        return view('master-toko.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = TableC::select('area_sales')
            ->distinct()
            ->pluck('area_sales');

        return view('master-toko.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_toko_baru' => 'required|integer|unique:table_a,kode_toko_baru',
            'kode_toko_lama' => 'nullable|integer',
            'area_sales'     => 'required|string|max:10',
        ]);

        DB::beginTransaction();

        try {
            // simpan ke table_a
            TableA::create([
                'kode_toko_baru' => $request->kode_toko_baru,
                'kode_toko_lama' => $request->kode_toko_lama,
            ]);

            // simpan ke table_c
            TableC::create([
                'kode_toko'  => $request->kode_toko_baru,
                'area_sales' => $request->area_sales,
            ]);

            DB::commit();

            return redirect()
                ->route('master-toko.index')
                ->with('success', 'Data toko berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $toko       = TableA::with('area')->findOrFail($id);
        $transaksi  = $toko->semuaTransaksi();
        $sales      = $toko->sales;

        return view('master-toko.show', compact('toko', 'transaksi', 'sales'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $toko  = TableA::with('area')->findOrFail($id);
        $areas = TableC::select('area_sales')
            ->distinct()
            ->pluck('area_sales');

        return view('master-toko.edit', compact('toko', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_toko_lama' => 'nullable|integer',
            'area_sales'     => 'required|string|max:10',
        ]);

        $toko = TableA::findOrFail($id);

        DB::beginTransaction();

        try {
            // update table_a
            $toko->update([
                'kode_toko_lama' => $request->kode_toko_lama,
            ]);

            // update table_c
            TableC::where('kode_toko', $id)->update([
                'area_sales' => $request->area_sales,
            ]);

            DB::commit();

            return redirect()
                ->route('master-toko.index')
                ->with('success', 'Data toko berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // cek apakah toko punya transaksi
        $toko           = TableA::findOrFail($id);
        $adaTransaksi   = $toko->semuaTransaksi()->isNotEmpty();

        if ($adaTransaksi) {
            return back()->with(
                'error',
                'Toko tidak bisa dihapus karena masih memiliki data transaksi.'
            );
        }

        DB::beginTransaction();

        try {
            // hapus dari table_c dulu (child)
            TableC::where('kode_toko', $id)->delete();

            // hapus dari table_a (parent)
            $toko->delete();

            DB::commit();

            return redirect()
                ->route('master-toko.index')
                ->with('success', 'Data toko berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    // upload Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        try {
            Excel::import(new TokoImport, $request->file('file'));

            return redirect()
                ->route('master-toko.index')
                ->with('success', 'Import data toko berhasil.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    // template Excel
    public function downloadTemplate()
    {
        return Excel::download(
            new TokoTemplateExport,
            'template_master_toko.xlsx'
        );
    }

    public function exportPdf()
    {
        $data = TableA::with('area')
            ->get()
            ->map(function ($toko) {
                return [
                    'kode_toko_baru' => $toko->kode_toko_baru,
                    'kode_toko_lama' => $toko->kode_toko_lama,
                    'area_sales'     => $toko->area_sales,
                ];
            });

        $pdf = Pdf::loadView('master-toko.pdf', compact('data'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont'          => 'Arial',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => false,
                'dpi'                  => 150,
            ]);

        return $pdf->download('master_toko_' . now()->format('Ymd_His') . '.pdf');
    }
}
