@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

    <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
        <h1 class="text-xl font-semibold text-gray-800">Laporan Transaksi</h1>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
            <a href="{{ route('laporan.export.area') }}"
                class="inline-flex items-center justify-center text-sm px-3 py-2 rounded-lg border border-green-300 text-green-700 hover:bg-green-50 transition">
                Export per Area
            </a>
            <a href="{{ route('laporan.export.sales') }}"
                class="inline-flex items-center justify-center text-sm px-3 py-2 rounded-lg border border-green-300 text-green-700 hover:bg-green-50 transition">
                Export per Sales
            </a>
            <a href="{{ route('laporan.export.semua') }}"
                class="inline-flex items-center justify-center text-sm px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition">
                Export Semua
            </a>

            <a href="{{ route('laporan.export.pdf') }}"
                class="inline-flex items-center justify-center text-sm px-3 py-2 rounded-lg border border-red-300 text-red-600 hover:bg-red-50 transition">
                Export PDF
            </a>
        </div>
    </div>

    <div class="space-y-6">

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-700">Rekapitulasi per Area</h2>
                <a href="{{ route('laporan.export.area') }}" class="text-xs text-green-600 hover:text-green-800 transition">
                    &#8659; Export
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-5 py-3">Area</th>
                            <th class="px-5 py-3">Jumlah Toko</th>
                            <th class="px-5 py-3">Sales</th>
                            <th class="px-5 py-3">Total Transaksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($perArea as $row)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-3">
                                    <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-sm">
                                        Area {{ $row['area'] }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-gray-600">{{ $row['jumlahToko'] }} toko</td>
                                <td class="px-5 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($row['sales'] as $s)
                                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-sm">
                                                {{ $s }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-green-600 font-semibold">
                                    Rp {{ number_format($row['total'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-gray-400">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-5 py-3 text-right text-sm font-semibold text-gray-700">
                                Grand Total
                            </td>
                            <td class="px-5 py-3 text-green-600 font-bold">
                                Rp {{ number_format($perArea->sum('total'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-700">Rekapitulasi per Sales</h2>
                <a href="{{ route('laporan.export.sales') }}"
                    class="text-xs text-green-600 hover:text-green-800 transition">
                    &#8659; Export
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-5 py-3">Kode Sales</th>
                            <th class="px-5 py-3">Nama Sales</th>
                            <th class="px-5 py-3">Area</th>
                            <th class="px-5 py-3">Jumlah Toko</th>
                            <th class="px-5 py-3">Total Transaksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($perSales as $row)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-3">
                                    <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2.5 py-1 rounded-sm">
                                        {{ $row['kode_sales'] }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 font-medium text-gray-800">{{ $row['nama_sales'] }}</td>
                                <td class="px-5 py-3">
                                    <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-sm">
                                        Area {{ $row['area'] }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-gray-600">{{ $row['jumlah_toko'] }} toko</td>
                                <td class="px-5 py-3 text-green-600 font-semibold">
                                    Rp {{ number_format($row['total_transaksi'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-gray-400">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="4" class="px-5 py-3 text-right text-sm font-semibold text-gray-700">
                                Grand Total
                            </td>
                            <td class="px-5 py-3 text-green-600 font-bold">
                                Rp {{ number_format($perSales->sum('total_transaksi'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

@endsection
